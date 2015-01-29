<?php
class HomeHeaderWidget extends CWidget {
	 public function run() {
		$Project =  new Project;
		$BannerProject = $Project->findByBanner();
		
		$this->render('HomeHeaderWidget', array("BannerProject" => $BannerProject));
    }
}
?>