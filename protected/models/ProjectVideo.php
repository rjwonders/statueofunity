<?php
class ProjectVideo extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{projectvideo}}';
	}
	public function saveVideos(){
		$criteria = new CDbCriteria;
		$criteria->limit = 1;
		$criteria->order = 'prjectvideoid DESC';
		$Adm = $this->find($criteria);
			
		$NewAddID = $Adm->prjectvideoid + 1;
		
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', Yii::app()->request->getPost( 'VideoURL' ), $match);
    	$video_id = $match[1];
    	
		$ProjectVideo = new ProjectVideo;
		$ProjectVideo->prjectvideoid = $NewAddID ;
		$ProjectVideo->projectslug = Yii::app()->request->getPost( 'ProjectID' );
		$ProjectVideo->videolink = $video_id;
		$ProjectVideo->addeddate = date("Y-m-d H:i:s");
		$ProjectVideo->status = 1;
		$ProjectVideo->save();
	}
}