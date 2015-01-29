<?php
class Languages extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{languages}}';
	}
	public function saveLanguages(){
		if(Yii::app()->request->getPost( 'LanguageID' )){
			$criteria = new CDbCriteria;
			$criteria->condition	= "languageid=".Yii::app()->request->getPost( 'LanguageID' );
			$Pub = $this->find($criteria);
			$Pub->languageid = Yii::app()->request->getPost( 'LanguageID' );
			$Pub->language = Yii::app()->request->getPost( 'Language' );
			$Pub->status = Yii::app()->request->getPost( 'Status' );
			$Pub->save();
			
			$FieldName = "lang".$Pub->languageid;
			$table = Yii::app()->db->schema->getTable('settings');
			if(!isset($table->columns[$FieldName])) {
				Yii::app()->db->createCommand()->addColumn('settings', $FieldName, 'text CHARACTER SET utf8 COLLATE utf8_bin');
			}
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Language(".Yii::app()->request->getPost( 'Language' ).") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Language has been updated successfully.";
		} else {
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'languageid DESC';
			$Pub = $this->find($criteria);
			
			$NewAddID = $Pub->languageid + 1;
			
			$this->languageid = $NewAddID;
			$this->language = Yii::app()->request->getPost( 'Language' );
			$this->status = Yii::app()->request->getPost( 'Status' );
			$this->save();
			
			$FieldName = "lang".$this->languageid;
			$table = Yii::app()->db->schema->getTable('settings');
			if(!isset($table->columns[$FieldName])) {
				Yii::app()->db->createCommand()->addColumn('settings', $FieldName, 'text CHARACTER SET utf8 COLLATE utf8_bin');
			}
		
			$FileContent = file_get_contents(Yii::app()->getBaseUrl(true)."/assets/translate/main.txt");
			$handle = fopen(Yii::getPathOfAlias('webroot')."/assets/translate/lang-".$this->languageid.".txt", "w+");
			fwrite($handle,$FileContent);
			fclose($handle);
		
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Language(".Yii::app()->request->getPost( 'Language' ).") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Language has been added successfully.";
			return $NewAddID;
		}
	}
	public function setDefaultLanguage(){
		$this->updateAll(array("isdefault" => 0));
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "languageid=".Yii::app()->request->getPost( 'LanguageID' );
		$Pub = $this->find($criteria);
		$Pub->languageid = Yii::app()->request->getPost( 'LanguageID' );
		$Pub->isdefault = 1;
		$Pub->save();
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
		$Admin = new Admin;
		$Admins = $Admin->find($criteria);
			
		$Text = "Language(".$Pub->language.") has been set as default language by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
		$General = new General;
		$General->addLog($Text);
		
		return $Pub->language;
	}
	public function saveText(){
		$FileContent = "";
		foreach($_POST['Language'] as $key=>$value):
			$FileContent.= $key."|".$value."\n";
		endforeach;
		$handle = fopen(Yii::getPathOfAlias('webroot')."/assets/translate/lang-".Yii::app()->request->getPost( 'LanguageID' ).".txt", "w");
		fwrite($handle,$FileContent);
		fclose($handle);
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
		$Admin = new Admin;
		$Admins = $Admin->find($criteria);
		
		$Languages = new Languages;
		$MyLang = $Languages->findByPk(Yii::app()->request->getPost( 'LanguageID' ));
			
		$Text = "Language(".$MyLang->language.") Texts has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
		$General = new General;
		$General->addLog($Text);
		
		Yii::app()->session['AdminSuccess'] = "Language Texts has been updated successfully.";
	}
	public function getLanguages(){
		$criteria = new CDbCriteria;
		$criteria->condition	= "isdefault=1";
		$Languages = new Languages;
		$Lamgs = $Languages->find($criteria);
		if(Yii::app()->request->cookies['LanguageName']):
			$Langs['CurrentLanguage'] = Yii::app()->request->cookies['LanguageName']->value;
			$Langs['DefaultLanguage'] = $Lamgs->languageid;
		else:
			$Langs['CurrentLanguage'] = $Lamgs->languageid;
			$Langs['DefaultLanguage'] = $Lamgs->languageid;
		endif;
		return $Langs;
	}
}