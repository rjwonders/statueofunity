<?php
class Cms extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{cms}}';
	}
	
	public function contactUs(){
		$sg=Yii::app()->sendgrid;
		$message = $sg->createEmail();  
		$message  
			->setView('contact-us')  
			->setHtml(array(  
					'Name'=> Yii::app()->request->getPost( 'Name' ),
					'Email'=> Yii::app()->request->getPost( 'Email' ),
					'Phone'=> Yii::app()->request->getPost( 'Phone' ),
					'Subject'=> Yii::app()->request->getPost( 'Subject' ),
					'Comment'=> Yii::app()->request->getPost( 'Comment' ),
			));  
		$message->setSubject('Inquiry from Statue of Unity!')  
				->addTo(Yii::app()->vars->Settings['Office Email'])  
				->setFrom(Yii::app()->request->getPost( 'Email' ));
		$sg->send($message);
		
		Yii::app()->session['UserSuccess'] = "Your message has been successfully sent.";
	}
	
	public function findAllByLanguage(){
		$Languages = new Languages;
		$rsLangs = $Languages->find("isdefault=1");
		
		$Cmss = $this->findAll("languageid=".$rsLangs->languageid);
		$MyCMS = array();
		$i= 0;
		foreach($Cmss as $Cms):
			$MyCMS[$i]['cmsid'] = $Cms->cmsid;
			$MyCMS[$i]['pagename'] = $Cms->pagename;
			$MyCMS[$i]['pageslug'] = $Cms->pageslug;
			$MyCMS[$i]['languageid'] = $Cms->languageid;
			$MyCMS[$i]['pagecontent'] = $Cms->pagecontent;
			$MyCMS[$i]['status'] = $Cms->status;
			$i=$i+1;
		endforeach;
		return $MyCMS;
	}
	
	public function findByAllLanguage($CmsID){
		$Cmss = $this->findAll("pageslug='".$CmsID."'");
		print_r("pageslug='".$CmsID."'");
		$MyCMS = array();
		$i= 0;
		foreach($Cmss as $Cms):
			$MyCMS[$Cms->languageid]['cmsid'] = $Cms->cmsid;
			$MyCMS[$Cms->languageid]['pagename'] = $Cms->pagename;
			$MyCMS[$Cms->languageid]['pageslug'] = $Cms->pageslug;
			$MyCMS[$Cms->languageid]['languageid'] = $Cms->languageid;
			$MyCMS[$Cms->languageid]['pagecontent'] = $Cms->pagecontent;
			$MyCMS[$Cms->languageid]['status'] = $Cms->status;
			$i=$i+1;
		endforeach;
		return $MyCMS;
	}
	
	public function saveCms(){
		if(Yii::app()->request->getPost( 'CmsID' )){
			foreach($_POST['Page'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->condition	= "pageslug='".Yii::app()->request->getPost( 'CmsID' )."' AND languageid='".$Cats."'";
				$Pub = $this->find($criteria);
				if(!$Pub):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'cmsid DESC';
					$Pub = $this->find($criteria);
					
					$NewAddID = $Pub->cmsid + 1;
					
					$Languages = new Languages;
					$rsLangs = $Languages->find("isdefault=1");	
					
					$criteria = new CDbCriteria;
					$criteria->condition	= "pageslug='".Yii::app()->request->getPost( 'CmsID' )."' AND languageid=".$rsLangs->languageid;
					$MyPub = $this->find($criteria);
					
					$CMS = new Cms;
					$Pub->pageslug = $MyPub->pageslug;
				endif;
				$Pub->pagename = $value;
				$Pub->pagecontent = $_POST['Content'][$Cats];
				$Pub->languageid = $Cats;
				$Pub->status = Yii::app()->request->getPost( 'Status' );
				$Pub->save();
			endforeach;
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");	
			
			$Text = "CMS(".$_POST['Page'][$rsLangs->languageid].") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "CMS has been updated successfully.";
		} else {
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");		
			
			$categoryslug = str_replace(" ", "-", $_POST['Page'][$rsLangs->languageid]);
			//$categoryslug = preg_replace("/[^a-zA-Z]+/", "", $_POST['Category'][$rsLangs->languageid]);
			$criteria = new CDbCriteria;
			$criteria->condition = "pageslug='".$categoryslug."'";
			$isSlug = $this->find($criteria);
			
			if($isSlug):
				$categoryslug = $categoryslug.rand(0,99);
			endif;
				
			foreach($_POST['Page'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'cmsid DESC';
				$Pub = $this->find($criteria);
				
				$NewAddID = $Pub->cmsid + 1;
				
				$CMS = new Cms;
				$CMS->cmsid = $NewAddID;
				$CMS->pagename = $_POST['Page'][$Cats];
				$CMS->pageslug	 = $categoryslug;
				$CMS->languageid = $Cats;
				$CMS->pagecontent = $_POST['Content'][$Cats];
				$xCategory->status = Yii::app()->request->getPost( 'Status' );
				$xCategory->save();
			endforeach;
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "CMS(".$_POST['Page'][$rsLangs->languageid].") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "CMS has been added successfully.";
		}
	}
	public function getPage($CmsID){
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "pageslug='".$CmsID."' AND languageid=".Yii::app()->request->cookies['LanguageName']->value;
		else:
			$Languages = new Languages;
			$Lamgs = $Languages->find("isdefault=1");
			$criteria->condition	= "pageslug='".$CmsID."' AND languageid=".$Lamgs->languageid;
		endif;
		return $this->find($criteria);
	}
}