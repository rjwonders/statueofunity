<?php
class Settings extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{settings}}';
	}
	
	public function saveSettings(){
		$Languages = new Languages;
		$rsLanguages = $Languages->findAll();
		
		foreach($rsLanguages as $Languages):
			$Settings = new Settings;
			$Datas = $Settings->find();
			$field = "lang".$Languages->languageid;
			foreach($_POST['Settings'][$Languages->languageid] as $key => $value):
				$Settings = new Settings;
				$Data = $Settings->findByPk($key);
				$Data->settingid = $key;
				$Data->$field = $value;
				$Data->save();
			endforeach;
		endforeach;
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
		$Admin = new Admin;
		$Admins = $Admin->find($criteria);
		
			
		$Text = "Settings has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
		$General = new General;
		$General->addLog($Text);
		
		Yii::app()->session['AdminSuccess'] = "Settings has been updated successfully.";
	}
	public function getSettingsArrayData(){
			$Data = $this->findAll();
			
			$Languages = new Languages;
			$Lamgs = $Languages->find($criteria);
			if(Yii::app()->request->cookies['LanguageName']):
				$CurrentLanguage = "lang".Yii::app()->request->cookies['LanguageName']->value;
				$DefaultLanguage = "lang".$Lamgs->languageid;
			else:
				$CurrentLanguage = "lang".$Lamgs->languageid;
				$DefaultLanguage = "lang".$Lamgs->languageid;
			endif;
		
			$MySettings = array();
			foreach($Data as $MData):
				if(trim($MData->$CurrentLanguage)!=''):
					$MySettings[$MData->settingname] = $MData->$CurrentLanguage;
				else:
					$MySettings[$MData->settingname] = $MData->$DefaultLanguage;
				endif;
				
			endforeach;
			return $MySettings;
	}
}