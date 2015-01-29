<?php

class ProjectController extends Controller
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
	public function actionIndex($ProjectID){
		$Projects = new Project;
		$rsData = $Projects->getProjectBySlug($ProjectID);
		
		$ProjectFAQs = new ProjectFAQ;
		$rsFAQ = $ProjectFAQs->getProjectFAQBySlug($ProjectID);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "projectid='".$ProjectID."'";
		$criteria->order = "amounttoback ASC";	
		$ProjectReward = new ProjectReward;
		$rsProjectRewards = $ProjectReward->findAll($criteria);
				
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."' AND status=1";
		$criteria->order = "addeddate DESC";	
		$ProjectUpdates = new ProjectUpdate;
		$rsUpdates = $ProjectUpdates->findAll($criteria);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."' AND status=1";
		$criteria->order = "addeddate DESC";	
		$ProjectVideos = new ProjectVideo;
		$rsVideos = $ProjectVideos->findAll($criteria);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."' AND status=1";
		$criteria->order = "addeddate DESC";	
		$ProjectImagess = new ProjectImages;
		$rsImages = $ProjectImagess->findAll($criteria);
		
		$this->render('project',array("rsData"=>$rsData, "rsFAQ"=>$rsFAQ, "rsUpdates"=>$rsUpdates, "rsVideos"=>$rsVideos, "rsImages"=>$rsImages, "rsProjectRewards" => $rsProjectRewards));	
	}
	public function actionPledge($ProjectID,$Amount=0){
		$Projects = new Project;
		$rsData = $Projects->getProjectBySlug($ProjectID);
		
		$this->render('pledge',array("rsData"=>$rsData, "rsAmount"=>$Amount));	
	}
	public function actionContribute(){
		$Projects = new Project;
		$Redirects = $Projects->makePayment();
		$this->redirect($Redirects);
	}
	public function actionPayment(){
		$ErrorTx = isset($_POST['Error']) ? Yii::app()->request->getPost( 'Error' ) : '';//Error Number/message
		$ErrorResult = isset($_POST['ErrorText']) ? Yii::app()->request->getPost( 'ErrorText' ) : '';//Error Number/message
		$payID = isset($_POST['paymentid']) ? Yii::app()->request->getPost( 'ErrorText' ) : '';
		if ($ErrorTx == ''){
			print_r($_POST);
		} else {
			print_r($ErrorResult);
		}
	}
	public function actionPaymentError(){
		print_r($_REQUEST);
	}
}
