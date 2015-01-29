<?php

class ExploreController extends Controller
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
	public function actionIndex($CategoryID=""){
		if($CategoryID):
			$Category = new Category;
			$SiteCats = $Category->find("categoryslug='".$CategoryID."'");
			
			$Project = new Project;
			$SiteProjects = $Project->getProjectByCategory($CategoryID);
			
			$this->render('category',array("rsProject"=>$SiteProjects, "rsCategory"=>$SiteCats));
		else:
			$Category = new Category;
			$SiteCats = $Category->getCats();
			
			$Project = new Project;
			$SiteProject = $Project->getFocusProject();
			
			$this->render('explore',array("rsCategory"=>$SiteCats, "rsProject"=>$SiteProject));
		endif;
	}
	public function actionAll(){
		$Project = new Project;
		$SiteProject = $Project->getProjectAll();
		$this->render('all-projects',array("rsCategory"=>$SiteCats, "rsProject"=>$SiteProject));
	}
	public function actionTag($TagID=""){
		$Category = new Category;
		$SiteCats = $Category->getCats();
		
		$Project = new Project;
		$SiteProject = $Project->getProjectsByTag($TagID);
			
		$this->render('explore',array("rsCategory"=>$SiteCats, "rsProject"=>$SiteProject));
	}
}
