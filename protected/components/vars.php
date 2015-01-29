<?php
class vars extends CApplicationComponent {
	
	public $myLang = array();
	public $Settings = array();
	public function init(){
     	$Languages =  new Languages;
		$MyLanguage = $Languages->getLanguages();
		
		$rsLiner = file(Yii::app()->getBaseUrl(true)."/assets/translate/lang-".$MyLanguage['CurrentLanguage'].".txt", FILE_IGNORE_NEW_LINES);
		
		$LineCurrent = array();
		foreach($rsLiner as $MyLines):
			$Datas = explode("|",$MyLines);
			if(count($Datas)>1):
				$LineCurrent[$Datas[0]] = $Datas[1];
			else:
				$LineCurrent[$Datas[0]] = "";
			endif;
		endforeach;
		
		$rsLiner = file(Yii::app()->getBaseUrl(true)."/assets/translate/lang-".$MyLanguage['DefaultLanguage'].".txt", FILE_IGNORE_NEW_LINES);
		
		$LineDefault = array();
		foreach($rsLiner as $MyLines):
			$Datas = explode("|",$MyLines);
			if(count($Datas)>1):
				$LineDefault[$Datas[0]] = $Datas[1];
			else:
				$LineDefault[$Datas[0]] = "";
			endif;
		endforeach;
		
		$rsLine = file(Yii::app()->getBaseUrl(true)."/assets/translate/main.txt", FILE_IGNORE_NEW_LINES);
		foreach($rsLine as $MyLines):
			if(isset($LineCurrent[$MyLines]) && trim($LineCurrent[$MyLines])!=''):
				$this->myLang[$MyLines] = $LineCurrent[$MyLines];
			elseif(isset($LineDefault[$MyLines]) && trim($LineDefault[$MyLines])!=''):
				$this->myLang[$MyLines] = $LineDefault[$MyLines];
			else:
				$this->myLang[$MyLines] = $MyLines;
			endif;
		endforeach;
		
		$Settings =  new Settings;
		$this->Settings = $Settings->getSettingsArrayData();
	}
	
}
?>