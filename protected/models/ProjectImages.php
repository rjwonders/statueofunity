<?php
class ProjectImages extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{projectimages}}';
	}
	public function saveImages(){
		if (!file_exists("assets/projects/".Yii::app()->request->getPost( 'ProjectID' )."/")) {
			mkdir("assets/projects/".Yii::app()->request->getPost( 'ProjectID' )."/", 0777);
		}
			
		for($i=0;$i<count($_FILES['myfile']['name']);$i++):
			$PImages = new ProjectImages;
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'projectimagesid DESC';
			$Adm = $PImages->find($criteria);
				
			$NewAddID = $Adm->projectimagesid + 1;
			
			$path = $_FILES['myfile']['name'][$i];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			copy($_FILES['myfile']['tmp_name'][$i],'assets/projects/'.Yii::app()->request->getPost( 'ProjectID' ).'/Image-'.$Adm->projectimagesid.'.'.$ext);
		
			$ProjectImages = new ProjectImages;
			$ProjectImages->projectimagesid = $NewAddID ;
			$ProjectImages->projectslug = Yii::app()->request->getPost( 'ProjectID' );
			$ProjectImages->images = "Image-".$Adm->projectimagesid.".".$ext;
			$ProjectImages->addeddate = date("Y-m-d H:i:s");
			$ProjectImages->status = 1;
			$ProjectImages->save();
		endfor;
	}
}