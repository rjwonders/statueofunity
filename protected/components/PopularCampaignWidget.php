<?php
class PopularCampaignWidget extends CWidget {

    public function run() {
		$Category = new Category;
		$SiteCats = $Category->homeCats();
		
		$Project = new Project;
		$SiteProject = $Project->findProjectByHomeCategory();
		$this->render('PopularCampaignWidget',array("rsCategory"=>$SiteCats, "rsProject"=>$SiteProject));
    }
}
?>