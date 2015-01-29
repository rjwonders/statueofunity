<?php
class Testimonials extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{testimonials}}';
	}
	public function saveTestimonial(){
		if(Yii::app()->request->getPost( 'TestimonialID' )){
			foreach($_POST['UserName'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->condition	= "testimonialslug='".Yii::app()->request->getPost( 'TestimonialID' )."' AND languageid='".$Cats."'";
				$Pub = $this->find($criteria);
				if(!$Pub):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'testimonialid DESC';
					$Pub = $this->find($criteria);
					
					$NewAddID = $Pub->testimonialid + 1;
					
					$Languages = new Languages;
					$rsLangs = $Languages->find("isdefault=1");	
					
					$criteria = new CDbCriteria;
					$criteria->condition	= "testimonialslug='".Yii::app()->request->getPost( 'TestimonialID' )."' AND languageid=".$rsLangs->languageid;
					$MyPub = $this->find($criteria);
					
					$Pub = new Testimonials;
					$Pub->testimonialslug = Yii::app()->request->getPost( 'TestimonialID' );
				endif;
				$Pub->username = $value;
				$Pub->designation = $_POST['Designation'][$Cats];
				$Pub->testimonial = $_POST['Testimonial'][$Cats];
				$Pub->languageid = $Cats;
				$Pub->addeddate = date("Y-m-d H:i:s");
				$Pub->status = Yii::app()->request->getPost( 'Status' );
				$Pub->save();
			endforeach;
			
			if($Pub->testimonialid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/testimonial/")) {
					mkdir("assets/users/testimonial/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/testimonial/'.Yii::app()->request->getPost( 'TestimonialID' ).'.'.$ext);
				$criteria = new CDbCriteria;
				$criteria->condition = "testimonialslug='".Yii::app()->request->getPost( 'TestimonialID' )."'";
				$Testimon = new Testimonials;
				$Testimon->updateAll(array("userimage" => Yii::app()->request->getPost( 'TestimonialID' ).'.'.$ext),$criteria);
				
            }
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Testimonial from ".$_POST['UserName'][$rsLangs->languageid]." has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Testimonial has been updated successfully.";
		} else {
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");		
			
			$categoryslug = str_replace(" ", "-", $_POST['UserName'][$rsLangs->languageid]);
			$criteria = new CDbCriteria;
			$criteria->condition = "testimonialslug='".$categoryslug."'";
			$isSlug = $this->find($criteria);
			
			if($isSlug):
				$categoryslug = $categoryslug.rand(0,99);
			endif;
			
			foreach($_POST['UserName'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'testimonialid DESC';
				$Pub = $this->find($criteria);
				
				$NewAddID = $Pub->testimonialid + 1;
				
				$Testimonials = new Testimonials;
				$Testimonials->testimonialid = $NewAddID;
				$Testimonials->username = $value;
				$Testimonials->testimonialslug	 = $categoryslug;
				$Testimonials->designation = $_POST['Designation'][$Cats];
				$Testimonials->testimonial = $_POST['Testimonial'][$Cats];
				$Testimonials->languageid = $Cats;
				$Testimonials->addeddate = date("Y-m-d H:i:s");
				$Testimonials->status = Yii::app()->request->getPost( 'Status' );
				$Testimonials->save();
			endforeach;
			
			if($Testimonials->testimonialid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/testimonial/")) {
					mkdir("assets/users/testimonial/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/testimonial/'.$categoryslug.'.'.$ext);
				
				$criteria = new CDbCriteria;
				$criteria->condition = "testimonialslug='".$categoryslug."'";
				$Testimon = new Testimonials;
				$Testimon->updateAll(array("userimage" => $categoryslug.'.'.$ext),$criteria);
            }
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Testimonial from ".$_POST['UserName'][$rsLangs->languageid]." has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Testimonial has been added successfully.";
			return $NewAddID;
		}
	}
	
	public function findByDefaultLanguage(){
		$criteria = new CDbCriteria;
		$criteria->condition	= "isdefault=1";
		$Languages = new Languages;
		$Lamgs = $Languages->find($criteria);
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "languageid=".$Lamgs->languageid;
		$Data = $this->findAll($criteria);
		return $Data;
	}
	public function findByAllLanguage($TestimonialID){
		$Testimonials = $this->findAll("testimonialslug='".$TestimonialID."'");
		$MyTestimonial = array();
		$i= 0;
		foreach($Testimonials as $Testimonial):
			$MyTestimonial[$Testimonial->languageid]['testimonialid'] = $Testimonial->testimonialid;
			$MyTestimonial[$Testimonial->languageid]['username'] = $Testimonial->username;
			$MyTestimonial[$Testimonial->languageid]['testimonialslug'] = $Testimonial->testimonialslug;
			$MyTestimonial[$Testimonial->languageid]['designation'] = $Testimonial->designation;
			$MyTestimonial[$Testimonial->languageid]['testimonial'] = $Testimonial->testimonial;
			$MyTestimonial[$Testimonial->languageid]['userimage'] = $Testimonial->userimage;
			$MyTestimonial[$Testimonial->languageid]['status'] = $Testimonial->status;
			$i=$i+1;
		endforeach;
		return $MyTestimonial;
	}
	public function getData(){
		$criteria = new CDbCriteria;
		$Languages = new Languages;
		$Lamgs = $Languages->find("isdefault=1");
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "languageid=".Yii::app()->request->cookies['LanguageName']->value;
		else:
			$criteria->condition	= "languageid=".$Lamgs->languageid;
		endif;
		$result = $this->findAll($criteria);
		$rsData = array();
		$i = 0;
		foreach($result as $res):
			if(Yii::app()->request->cookies['LanguageName']):
				$criteria = new CDbCriteria;
				$criteria->condition	= "testimonialslug='".$res->testimonialslug."' AND languageid=".$Lamgs->languageid;
				$Defresult = $this->find($criteria);
				if(trim($res->username)!=''):
					$rsData[$i]['username'] = $res->username;
				else:
					$rsData[$i]['username'] = $Defresult->username;
				endif;
				$rsData[$i]['testimonialslug'] = $res->testimonialslug; 
				if(trim($res->designation)!=''):
					$rsData[$i]['designation'] = $res->designation;
				else:
					$rsData[$i]['designation'] = $Defresult->designation;
				endif;
				if(trim($res->testimonial)!=''):
					$rsData[$i]['testimonial'] = $res->testimonial;
				else:
					$rsData[$i]['testimonial'] = $Defresult->testimonial;
				endif;
				$rsData[$i]['userimage'] = $res->userimage;
			else:
				$rsData[$i]['username'] = $res->username;
				$rsData[$i]['testimonialslug'] = $res->testimonialslug;
				$rsData[$i]['designation'] = $res->designation;
				$rsData[$i]['testimonial'] = $res->testimonial;
				$rsData[$i]['userimage'] = $res->userimage;
			endif;
			$i = $i + 1;
		endforeach;
		return $rsData;
	}
}