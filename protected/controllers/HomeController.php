<?php

class HomeController extends Controller
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
	public function actionIndex(){
		$this->render('home');
	}
	
	
}
