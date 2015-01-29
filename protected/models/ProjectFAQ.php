<?php
class ProjectFAQ extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{projectfaq}}';
	}
	public function saveFAQ(){
		if(Yii::app()->request->getPost( 'ProjectFAQID' )){
			$criteria = new CDbCriteria;
			$criteria->condition = "projectfaqid=".Yii::app()->request->getPost( 'ProjectFAQID' );
			$Adm = $this->find($criteria);
			
			$Adm->faq = Yii::app()->request->getPost( 'FAQ' );
			$Adm->answer = Yii::app()->request->getPost( 'Answer' );
			$Adm->save();
		} else {
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'projectfaqid DESC';
			$Adm = $this->find($criteria);
				
			$NewAddID = $Adm->projectfaqid + 1;
			
			$ProjectFAQ = new ProjectFAQ;
			$ProjectFAQ->projectfaqid = $NewAddID ;
			$ProjectFAQ->projectslug = Yii::app()->request->getPost( 'ProjectID' );
			$ProjectFAQ->faq = Yii::app()->request->getPost( 'FAQ' );
			$ProjectFAQ->answer = Yii::app()->request->getPost( 'Answer' );
			$ProjectFAQ->addeddate = date("Y-m-d H:i:s");
			$ProjectFAQ->status = 1;
			$ProjectFAQ->save();
		}
	}
	public function getProjectFAQBySlug($ProjectID){
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."' AND status=1";
		$Projects = $this->findAll($criteria);
		
		$ProjResult = array();
		$i=0;
		foreach($Projects as $Project):
			$ProjResult[$i]['projectfaqid'] = $Project->projectfaqid;
			$ProjResult[$i]['faq'] = $Project->faq;
			$ProjResult[$i]['answer'] = $Project->answer;
			$i = $i + 1;
		endforeach;
		return $ProjResult;
	}
}