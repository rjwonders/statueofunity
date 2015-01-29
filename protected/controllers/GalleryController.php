<?php

class GalleryController extends Controller
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
		$Gallery =  new Gallery;
		$rsImageGallery = $Gallery->getImages();
		$rsVideoGallery = $Gallery->getVideos();
		$this->render('gallery', array("rsImageGallery" => $rsImageGallery, "rsVideoGallery" => $rsVideoGallery));	
	}
	
}
