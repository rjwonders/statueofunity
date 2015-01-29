<?php

class GeneralController extends Controller
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
	public function actionChangeLanguage(){
		//print_r();exit;
		Yii::app()->request->cookies['LanguageName'] = new CHttpCookie('LanguageName', Yii::app()->request->getParam( 'LanguageName' ));
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	public function actionaddNewsletter(){
		$General =  new General;
		$General->addNewsletter(Yii::app()->request->getPost( 'NewsEmail' ));
		$this->redirect(Yii::app()->getBaseUrl(true));
	}
	public function action404(){
		$this->render('404');
	}
}
