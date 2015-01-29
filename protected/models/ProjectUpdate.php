<?php
class ProjectUpdate extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{projectupdate}}';
	}
	public function saveUpdate(){
		if(Yii::app()->request->getPost( 'ProjectUpdateID' )){
			$criteria = new CDbCriteria;
			$criteria->condition = "projectupdateid=".Yii::app()->request->getPost( 'ProjectUpdateID' );
			$Adm = $this->find($criteria);
			
			$Adm->updates = Yii::app()->request->getPost( 'Update' );
			$Adm->save();
		} else {
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'projectupdateid DESC';
			$Adm = $this->find($criteria);
				
			$NewAddID = $Adm->projectupdateid + 1;
			
			$ProjectUpdate = new ProjectUpdate;
			$ProjectUpdate->projectupdateid = $NewAddID ;
			$ProjectUpdate->projectslug = Yii::app()->request->getPost( 'ProjectID' );
			$ProjectUpdate->updates = Yii::app()->request->getPost( 'Update' );
			$ProjectUpdate->addeddate = date("Y-m-d H:i:s");
			$ProjectUpdate->status = 1;
			$ProjectUpdate->save();
		}
	}
}