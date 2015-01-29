<?php
class Gallery extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{gallery}}';
	}
	public function saveImages(){
		if (!file_exists("assets/gallery/")) {
			mkdir("assets/gallery/", 0777);
		}
			
		for($i=0;$i<count($_FILES['myfile']['name']);$i++):
			$Gallery = new Gallery;
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'galleryid DESC';
			$Adm = $Gallery->find($criteria);
				
			$NewAddID = $Adm->galleryid + 1;
			
			$path = $_FILES['myfile']['name'][$i];
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			copy($_FILES['myfile']['tmp_name'][$i],'assets/gallery/Image-'.$Adm->galleryid.'.'.$ext);
		
			$Gallery = new Gallery;
			$Gallery->galleryid = $NewAddID ;
			$Gallery->gallerytype = 1;
			$Gallery->path = "Image-".$Adm->galleryid.".".$ext;
			$Gallery->addeddate = date("Y-m-d H:i:s");
			$Gallery->status = 1;
			$Gallery->save();
		endfor;
	}
	public function saveVideos(){
		$criteria = new CDbCriteria;
		$criteria->limit = 1;
		$criteria->order = 'galleryid DESC';
		$Adm = $this->find($criteria);
			
		$NewAddID = $Adm->galleryid + 1;
		
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', Yii::app()->request->getPost( 'VideoURL' ), $match);
    	$video_id = $match[1];
    	
		$Gallery = new Gallery;
		$Gallery->galleryid = $NewAddID;
		$Gallery->gallerytype = 2;
		$Gallery->path = $video_id;
		$Gallery->addeddate = date("Y-m-d H:i:s");
		$Gallery->status = 1;
		$Gallery->save();
	}
	public function getImages(){
		$criteria = new CDbCriteria;
		$criteria->condition = "gallerytype=1 AND status=1";
		$criteria->order = 'addeddate DESC';
		
		return $this->findAll($criteria);
	}
	
	public function getVideos(){
		$criteria = new CDbCriteria;
		$criteria->condition = "gallerytype=2 AND status=1";
		$criteria->order = 'addeddate DESC';
		
		return $this->findAll($criteria);
	}
}