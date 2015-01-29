<?php

class CmsController extends Controller
{
	public function filters(){
		return array(
			array(
				'COutputCache',
				'duration'=>100,
				'varyByParam'=>array('id'),
			),
		);
	}
	public function actionContact(){
		$this->render('contact-us');	
	}
	public function actionContactUs(){
		$Cms = new Cms;
		$Cms->contactUs();
		$this->redirect(Yii::app()->getBaseUrl(true).'/contact-us');	
	}
	public function actionAboutUs(){
		$Cms = new Cms;
		$rsData = $Cms->getPage("about-us");
		$this->render('about-us',array("rsData"=>$rsData));	
	}
}
