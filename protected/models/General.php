<?php
class General extends CModel{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function addLog($Text){
		$FileContent = file_get_contents(Yii::app()->getBaseUrl(true)."/assets/logs/dec-2014.txt");
		$handle = fopen(Yii::getPathOfAlias('webroot')."/assets/logs/dec-2014.txt", "w+");
		fwrite($handle,$Text.$FileContent);
		fclose($handle);
	}
	public function attributeNames(){
        return array();
    }
	public function addNewsletter($EmailID,$Name=""){
		$config = Yii::app()->getComponents(false);
		$curl = curl_init();
       	curl_setopt($curl, CURLOPT_VERBOSE, 1);
       	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
       	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
       	curl_setopt($curl, CURLOPT_URL, 'https://api.sendgrid.com/api/newsletter/lists/email/add.json');
       	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       	curl_setopt($curl, CURLOPT_POSTFIELDS, 'api_user='.$config["sendgrid"]["username"].'&api_key='.$config["sendgrid"]["password"].'&list='.$config["sendgrid"]["lists"].'&data={"email":"'.$EmailID.'","name":"'.$Name.'"}');
		$resp = curl_exec($curl);
		curl_close($curl);
		$Result = json_decode($resp);
		if($Result->inserted==0):
			Yii::app()->session['UserError'] = "You have already subscribed for newsletter with this email.";
		else:
			Yii::app()->session['UserSuccess'] = "You have successfully subscribed for newsletter.";
		endif;
	}
}