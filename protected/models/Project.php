<?php
class Project extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{project}}';
	}
	
	public function saveProject(){
		if(Yii::app()->request->getPost( 'ProjectID' )){
			foreach($_POST['ProjectName'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->condition	= "projectslug='".Yii::app()->request->getPost( 'ProjectID' )."' AND languageid=".$Cats;
				$Pub = $this->find($criteria);
				if(!$Pub):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'projectid DESC';
					$Pub = $this->find($criteria);
					
					$NewAddID = $Pub->projectid + 1;
					
					$Languages = new Languages;
					$rsLangs = $Languages->find("isdefault=1");	
					
					$criteria = new CDbCriteria;
					$criteria->condition	= "projectslug='".Yii::app()->request->getPost( 'ProjectID' )."' AND languageid=".$rsLangs->languageid;
					$MyPub = $this->find($criteria);
				
					$Pub =  new Project;
					$Pub->projectid = $NewAddID;
					$Pub->projectslug = Yii::app()->request->getPost( 'ProjectID' );
					$Pub->languageid = $Cats;
					$Pub->isbannerproject = $MyPub->isbannerproject;
					$Pub->isfocusproject = $MyPub->isfocusproject;
					$Pub->projectimage = $MyPub->projectimage;
					$Pub->fundcompleted = $MyPub->fundcompleted;
				endif;
				$Pub->projectname = $value;
				$Pub->publisherid = Yii::app()->request->getPost( 'PublisherID' );
				$Pub->adminid = Yii::app()->request->getPost( 'AdminID' );
				$Pub->goalamount = Yii::app()->request->getPost( 'GoalAmount' );
				$Pub->projectenddate = date("Y-m-d",strtotime(Yii::app()->request->getPost( 'ProjectEndDate' )));
				$Pub->projectdescription = $_POST['ProjectDescription'][$Cats];
				$Pub->projectstory = $_POST['ProjectStory'][$Cats];
				$Pub->tags = Yii::app()->request->getPost( 'Tags' );
				$Pub->status = Yii::app()->request->getPost( 'Status' );
				$Pub->save();
			endforeach;
			
			$r = 0;
			$ProjectReward = new ProjectReward;
			$ProjectReward->deleteAllByAttributes(array('projectid' => Yii::app()->request->getPost( 'ProjectID' )));
			foreach($_POST['BackAmount'] as $Back=>$Vals):
				if(trim($Vals)!="" && trim($_POST['RewardPoint'][$r])!=''):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'projectrewardid DESC';
					$ProjectRe = new ProjectReward;
					$Pubs = $ProjectRe->find($criteria);
					
					$NewAdditonID = $Pubs->projectrewardid + 1;
				
					$ProjectReward = new ProjectReward;
					$ProjectReward->projectrewardid = $NewAdditonID;
					$ProjectReward->projectid = Yii::app()->request->getPost( 'ProjectID' );
					$ProjectReward->reward = $_POST['RewardPoint'][$r];
					$ProjectReward->amounttoback = $Vals;
					$ProjectReward->save();
				endif;
				$r = $r + 1;
			endforeach;
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");	
			
			$Text = "Project (".$_POST['ProjectName'][$rsLangs->languageid].") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			if(Yii::app()->request->getPost( 'ProjectID' )){
				$ProjectCategory = new ProjectCategory;
				$ProjectCategory->deleteAllByAttributes(array('projectslug' => Yii::app()->request->getPost( 'ProjectID' )));
				for($i=0;$i<count($_POST['CategoryID']);$i++){
					$ProjectCategory = new ProjectCategory;
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'projectcategoryid DESC';
					$Pubs = $ProjectCategory->find($criteria);
					
					$NewAddID = $Pubs->projectcategoryid + 1;
			
					$ProjectCategory = new ProjectCategory;
					$ProjectCategory->projectcategoryid = $NewAddID;
					$ProjectCategory->projectslug = Yii::app()->request->getPost( 'ProjectID' );
					$ProjectCategory->categoryid = $_POST['CategoryID'][$i];
					$ProjectCategory->save();
				}
			}
			
			if(Yii::app()->request->getPost( 'ProjectID' ) && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/projects/")) {
					mkdir("assets/users/projects/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/projects/'.Yii::app()->request->getPost( 'ProjectID' ).'.'.$ext);
				
				$criteria = new CDbCriteria;
				$criteria->condition = "projectslug='".Yii::app()->request->getPost( 'ProjectID' )."'";
				$Project = new Project;
				$Project->updateAll(array("projectimage" => Yii::app()->request->getPost( 'ProjectID' ).'.'.$ext),$criteria);
            }
		} else {
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");		
			
			$projectslug = str_replace(" ", "-", $_POST['ProjectName'][$rsLangs->languageid]);
			//$categoryslug = preg_replace("/[^a-zA-Z]+/", "", $_POST['Category'][$rsLangs->languageid]);
			$criteria = new CDbCriteria;
			$criteria->condition = "projectslug='".$projectslug."'";
			$isSlug = $this->find($criteria);
			
			if($isSlug):
				$projectslug = $projectslug.rand(0,99);
			endif;
			
			foreach($_POST['ProjectName'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'projectid DESC';
				$Pub = $this->find($criteria);
				
				$NewAddID = $Pub->projectid + 1;
			
				$Project =  new Project;
				$Project->projectid = $NewAddID;
				$Project->projectname = $_POST['ProjectName'][$Cats];
				$Project->projectslug = $projectslug;
				$Project->languageid = $Cats;
				$Project->publisherid = Yii::app()->request->getPost( 'PublisherID' );
				$Project->adminid = Yii::app()->request->getPost( 'AdminID' );
				$Project->goalamount = Yii::app()->request->getPost( 'GoalAmount' );
				$Project->projectenddate = date("Y-m-d",strtotime(Yii::app()->request->getPost( 'ProjectEndDate' )));
				$Project->projectdescription = $_POST['ProjectDescription'][$Cats];
				$Project->projectstory = $_POST['ProjectStory'][$Cats];
				$Project->tags = Yii::app()->request->getPost( 'Tags' );
				$Project->status = Yii::app()->request->getPost( 'Status' );
				$Project->save();
			endforeach;
			
			$r = 0;
			foreach($_POST['BackAmount'] as $Back=>$Vals):
				if(trim($Vals)!="" && trim($_POST['RewardPoint'][$r])!=''):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'projectrewardid DESC';
					$ProjectRe = new ProjectReward;
					$Pubs = $ProjectRe->find($criteria);
					
					$NewAdditonID = $Pubs->projectrewardid + 1;
				
					$ProjectReward = new ProjectReward;
					$ProjectReward->projectrewardid = $NewAdditonID;
					$ProjectReward->projectid = $projectslug;
					$ProjectReward->reward = $_POST['RewardPoint'][$r];
					$ProjectReward->amounttoback = $Vals;
					$ProjectReward->save();
				endif;
				$r = $r + 1;
			endforeach;
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Project (".$_POST['ProjectName'][$rsLangs->languageid].") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			if($projectslug){
				for($i=0;$i<count($_POST['CategoryID']);$i++){
					$ProjectCategory = new ProjectCategory;
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'projectcategoryid DESC';
					$Pub = $ProjectCategory->find($criteria);
					
					$NewAddID = $Pub->projectcategoryid + 1;
			
					$ProjectCategory = new ProjectCategory;
					$ProjectCategory->projectcategoryid = $NewAddID;
					$ProjectCategory->projectslug = $projectslug;
					$ProjectCategory->categoryid = $_POST['CategoryID'][$i];
					$ProjectCategory->save();
				}
			}
			if($projectslug && trim(Yii::app()->request->getPost( 'PublisherID' ))!=''){
				$Publishers = new Publishers;
				$Publish = $Publishers->findByPk(Yii::app()->request->getPost( 'PublisherID' ));
				
				$Text = "Admin ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") has assigned Project (".$_POST['ProjectName'][$rsLangs->languageid].") to Campaigner ".$Publish->firstname." ".$Publish->lastname."(".$Publish->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
				$General = new General;
				$General->addLog($Text);
			
				$sg=Yii::app()->sendgrid;
				$message = $sg->createEmail();  
				$message  
					->setView('add-new-project-campaigner')  
					->setHtml(array(  
						'Name'=> $Publish->firstname,
						'CampaignName'=> $_POST['ProjectName'][$rsLangs->languageid],
						'GoalAmount'=> Yii::app()->request->getPost( 'GoalAmount' ).'.00',
						'EndDate'=> Yii::app()->request->getPost( 'ProjectEndDate' ),
						'CampaignLink'=> Yii::app()->createAbsoluteUrl("campaigns"),
					));  
				$message->setSubject('New project has been posted to your account!')  
					->addTo($Publish->email)  
					->setFrom(Yii::app()->params['adminEmail']);
					  
				if(!$sg->send($message)){
					Yii::log("Failed to send email:\n".print_r($sg->lastErrors,true) ,CLogger::LEVEL_ERROR);
				}
			}
			
			if($projectslug && trim(Yii::app()->request->getPost( 'AdminID' ))!=''){
				$Admin = new Admin;
				$Admins2 = $Admin->findByPk(Yii::app()->request->getPost( 'AdminID' ));
				
				$Text = "Admin ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") has assigned Project (".$_POST['ProjectName'][$rsLangs->languageid].") to Editor ".$Admins2->firstname." ".$Admins2->lastname."(".$Admins2->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
				$General = new General;
				$General->addLog($Text);
				
				$Publishers = new Publishers;
				$Publish = $Publishers->findByPk(Yii::app()->request->getPost( 'PublisherID' ));
				
				$sg=Yii::app()->sendgrid;
				$message = $sg->createEmail();  
				$message  
					->setView('add-new-project-editor')  
					->setHtml(array(  
						'Name'=> $Admins2->firstname,
						'CampaignerName'=> $Publish->firstname,
						'CampaignName'=> $_POST['ProjectName'][$rsLangs->languageid],
						'GoalAmount'=> Yii::app()->request->getPost( 'GoalAmount' ).'.00',
						'EndDate'=> Yii::app()->request->getPost( 'ProjectEndDate' ),
						'CampaignLink'=> Yii::app()->createAbsoluteUrl("campaigns"),
					));  
				$message->setSubject('New project has been posted to your account!')  
					->addTo($Admins2->email)  
					->setFrom(Yii::app()->params['adminEmail']);
					  
				if(!$sg->send($message)){
					Yii::log("Failed to send email:\n".print_r($sg->lastErrors,true) ,CLogger::LEVEL_ERROR);
				}
			}
			
			if($projectslug && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/projects/")) {
					mkdir("assets/users/projects/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/projects/'.$projectslug.'.'.$ext);
				
				$criteria = new CDbCriteria;
				$criteria->condition = "projectslug='".$projectslug."'";
				$Project = new Project;
				$Project->updateAll(array("projectimage" => $projectslug.'.'.$ext),$criteria);
            }
		}
	}
	public function saveBanner(){
		$this->updateAll(array("isbannerproject" => 0));
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "projectslug='".Yii::app()->request->getPost( 'ProjectID' )."'";
		$this->updateAll(array("isbannerproject" => 1),$criteria);
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsProj = $Project->find("projectslug='".Yii::app()->request->getPost( 'ProjectID' )."' AND languageid=".$rsLangu->languageid);
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
		$Admin = new Admin;
		$Admins = $Admin->find($criteria);
			
		$Text = "Project(".$rsProj->projectname.") has been set as banner project by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
		$General = new General;
		$General->addLog($Text);
		
		return $rsProj->projectname;
	}
	
	public function saveFocusProject(){
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "projectslug='".Yii::app()->request->getPost( 'ProjectID' )."'";
		$this->updateAll(array("isfocusproject" => 1),$criteria);
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsProj = $Project->find("projectslug='".Yii::app()->request->getPost( 'ProjectID' )."' AND languageid=".$rsLangu->languageid);
		
		return $rsProj->projectname;
	}
	public function findAllBySlug($ProjectID){
		$Projects = $this->findAll("projectslug='".$ProjectID."'");
		$MyProject = array();
		foreach($Projects as $Project):
			$MyProject[$Project->languageid]['projectid'] = $Project->projectid;
			$MyProject[$Project->languageid]['projectname'] = $Project->projectname;
			$MyProject[$Project->languageid]['languageid'] = $Project->languageid;
			$MyProject[$Project->languageid]['projectslug'] = $Project->projectslug;
			$MyProject[$Project->languageid]['goalamount'] = $Project->goalamount;
			$MyProject[$Project->languageid]['fundcompleted'] = $Project->fundcompleted;
			$MyProject[$Project->languageid]['projectenddate'] = $Project->projectenddate;
			$MyProject[$Project->languageid]['projectimage'] = $Project->projectimage;
			$MyProject[$Project->languageid]['projectdescription'] = $Project->projectdescription;
			$MyProject[$Project->languageid]['projectstory'] = $Project->projectstory;
			$MyProject[$Project->languageid]['projectcreationdate'] = $Project->projectcreationdate;
			$MyProject[$Project->languageid]['projectapprovaldate'] = $Project->projectapprovaldate;
			$MyProject[$Project->languageid]['totalviews'] = $Project->totalviews;
			$MyProject[$Project->languageid]['totallikes'] = $Project->totallikes;
			$MyProject[$Project->languageid]['publisherid'] = $Project->publisherid;
			$MyProject[$Project->languageid]['adminid'] = $Project->adminid;
			$MyProject[$Project->languageid]['totalfbshare'] = $Project->totalfbshare;
			$MyProject[$Project->languageid]['totaltwittershare'] = $Project->totaltwittershare;
			$MyProject[$Project->languageid]['totalgpshare'] = $Project->totalgpshare;
			$MyProject[$Project->languageid]['isbannerproject'] = $Project->isbannerproject;
			$MyProject[$Project->languageid]['tags'] = $Project->tags;
			$MyProject[$Project->languageid]['status'] = $Project->status;
		endforeach;
		return $MyProject;
	}
	public function findByBanner(){
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "isbannerproject=1 AND languageid=".Yii::app()->request->cookies['LanguageName']->value;
		else:
			$Languages = new Languages;
			$Lamgs = $Languages->find("isdefault=1");
			$criteria->condition	= "isbannerproject=1 AND languageid=".$Lamgs->languageid;
		endif;
		return $this->getData($criteria);
	}
	public function getData($criteria){
		$Languages = new Languages;
		$Lamgs = $Languages->find("isdefault=1");
			
		$Projects = $this->findAll($criteria);
		
		$ProjResult = array();
		$i=0;
		foreach($Projects as $Project):
			if(isset(Yii::app()->request->cookies['LanguageName']) && $Lamgs->languageid!=Yii::app()->request->cookies['LanguageName']->value && (trim($Project->projectname)=='' || trim($Project->projectdescription)=='')):
				$DefaulProject = $this->find("projectslug='".$Project->projectslug."' AND languageid='".$Lamgs->languageid."'");
			endif;
			$ProjResult[$i]['categories'] = array();
			$ProjectCategory = new ProjectCategory;
			$Categories = $ProjectCategory->findAll("projectslug='".$Project->projectslug."'");
			foreach($Categories as $Categorys):
				$Category = new Category;
				$myCategory = $Category->find("categoryslug='".$Categorys->categoryid."' AND languageid='".$Lamgs->languageid."'");
				$ProjResult[$i]['categories'][] = $myCategory->category;
				$ProjResult[$i]['categoryimage'][] = $myCategory->categoryimage;
			endforeach;
			if($Project->publisherid!=''):
				$Publishers = new Publishers;
				$Publish = $Publishers->findByPk($Project->publisherid);
				$ProjResult[$i]['username'] = $Publish->firstname." ".$Publish->lastname;
				$ProjResult[$i]['city'] = $Publish->city;
			endif;
			$ProjResult[$i]['projectid'] = $Project->projectid;
			if(trim($Project->projectname)!=''):
				$ProjResult[$i]['projectname'] = $Project->projectname;
			else:
				$ProjResult[$i]['projectname'] = $DefaulProject->projectname;
			endif;
			if(trim($Project->projectstory)!=''):
				$ProjResult[$i]['projectstory'] = $Project->projectstory;
			else:
				$ProjResult[$i]['projectstory'] = $DefaulProject->projectstory;
			endif;
			$ProjResult[$i]['languageid'] = $Project->languageid;
			//$ProjResult[$i]['username'] = $Project->firstname." ".$Project->lastname;
			$ProjResult[$i]['projectslug'] = $Project->projectslug;
			$ProjResult[$i]['goalamount'] = $Project->goalamount;
			$ProjResult[$i]['fundcompleted'] = $Project->fundcompleted;
			$ProjResult[$i]['projectenddate'] = $Project->projectenddate;
			$ProjResult[$i]['projectimage'] = $Project->projectimage;
			if(trim($Project->projectdescription)!=''):
				$ProjResult[$i]['projectdescription'] = $Project->projectdescription;
			else:
				$ProjResult[$i]['projectdescription'] = $DefaulProject->projectdescription;
			endif;
			$ProjResult[$i]['projectcreationdate'] = $Project->projectcreationdate;
			$ProjResult[$i]['projectapprovaldate'] = $Project->projectapprovaldate;
			$ProjResult[$i]['totalviews'] = $Project->totalviews;
			$ProjResult[$i]['totallikes'] = $Project->totallikes;
			$ProjResult[$i]['publisherid'] = $Project->publisherid;
			$ProjResult[$i]['adminid'] = $Project->adminid;
			$ProjResult[$i]['totalfbshare'] = $Project->totalfbshare;
			$ProjResult[$i]['totaltwittershare'] = $Project->totaltwittershare;
			$ProjResult[$i]['totalgpshare'] = $Project->totalgpshare;
			$ProjResult[$i]['isbannerproject'] = $Project->isbannerproject;
			$ProjResult[$i]['tags'] = $Project->tags;
			$ProjResult[$i]['status'] = $Project->status;
			$i = $i + 1;
		endforeach;
		return $ProjResult;
	}
	public function findProjectByHomeCategory(){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Category = new Category;
		$HomeCats = $Category->findAll("ishomecategory=1 AND languageid=".$rsLangu->languageid);
		
		$HomePro = array();
		foreach($HomeCats as $HomeCat):
			$criteria = new CDbCriteria;
			$criteria->limit = 4;
			$criteria->join = "LEFT Join projectcategory pc on t.projectslug=pc.projectslug ";
			if(Yii::app()->request->cookies['LanguageName']):
				$criteria->condition	= "t.status=1 AND pc.categoryid='".$HomeCat->categoryslug."' AND languageid='".Yii::app()->request->cookies['LanguageName']->value."'";
			else:
				$Languages = new Languages;
				$Lamgs = $Languages->find("isdefault=1");
				$criteria->condition	= "t.status=1 AND pc.categoryid='".$HomeCat->categoryslug."' AND languageid='".$Lamgs->languageid."'";
		endif;
			$HomePro[$HomeCat->categoryslug] = $this->getData($criteria);
		endforeach;
		
		return $HomePro;
	}
	function getProjectCount($CatID){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$criteria = new CDbCriteria;
		$criteria->join = "LEFT Join projectcategory pc on t.projectslug=pc.projectslug ";
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "t.status=1 AND pc.categoryid='".$CatID."' AND languageid='".Yii::app()->request->cookies['LanguageName']->value."'";
		else:
			$criteria->condition	= "t.status=1 AND pc.categoryid='".$CatID."' AND languageid='".$rsLangu->languageid."'";
		endif;
		return $MyPro = count($this->getData($criteria));
	}
	function getFocusProject(){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND isfocusproject=1 AND languageid='".Yii::app()->request->cookies['LanguageName']->value."'";
		else:
			$criteria->condition	= "status=1 AND isfocusproject=1 AND languageid='".$rsLangu->languageid."'";
		endif;
		return $this->getData($criteria);
	}
	
	function getProjectByCategory($CategoryID){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$criteria = new CDbCriteria;
		$criteria->join = "LEFT Join projectcategory pc on t.projectslug=pc.projectslug ";
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND pc.categoryid='".$CategoryID."' AND languageid='".Yii::app()->request->cookies['LanguageName']->value."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		else:
			$criteria->condition	= "status=1 AND pc.categoryid='".$CategoryID."' AND languageid='".$rsLangu->languageid."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		endif;
		$criteria->order = "projectenddate ASC";
		return $this->getData($criteria);
	}
	
	public function getProjectByAllCategory(){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Category = new Category;
		$HomeCats = $Category->findAll("status=1 AND languageid=".$rsLangu->languageid);
		
		$HomePro = array();
		foreach($HomeCats as $HomeCat):
			$criteria = new CDbCriteria;
			$criteria->join = "LEFT Join projectcategory pc on t.projectslug=pc.projectslug ";
			if(Yii::app()->request->cookies['LanguageName']):
				$criteria->condition	= "t.status=1 AND pc.categoryid='".$HomeCat->categoryslug."' AND languageid='".Yii::app()->request->cookies['LanguageName']->value."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
			else:
				$Languages = new Languages;
				$Lamgs = $Languages->find("isdefault=1");
				$criteria->condition	= "t.status=1 AND pc.categoryid='".$HomeCat->categoryslug."' AND languageid='".$Lamgs->languageid."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		endif;
			$HomePro[$HomeCat->categoryslug] = $this->getData($criteria);
		endforeach;
		
		return $HomePro;
	}
	
	function getProjectBySlug($ProjectID){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND projectslug='".$ProjectID."' AND languageid='".Yii::app()->request->cookies['LanguageName']->value."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		else:
			$criteria->condition	= "status=1 AND projectslug='".$ProjectID."' AND languageid='".$rsLangu->languageid."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		endif;
		return $this->getData($criteria);
	}
	
	function getProjectsByTag($TagID){
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND (tags like '%,".$TagID.",%' OR tags like '".$TagID.",%' OR tags like '%,".$TagID."' OR tags like '".$TagID."') AND languageid='".Yii::app()->request->cookies['LanguageName']->value."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		else:
			$criteria->condition	= "status=1 AND (tags like '%,".$TagID.",%' OR tags like '".$TagID.",%' OR tags like '%,".$TagID."' OR tags like '".$TagID."') AND pc.categoryid='".$CategoryID."' AND languageid='".$rsLangu->languageid."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		endif;
		$criteria->order = "projectenddate ASC";
		return $this->getData($criteria);
	}
	
	function makePayment(){
		$id="id=90002078";
		$password="password=password1";
		$action="action=1";
		$langid="langid=USA";
		$currencycode="currencycode=356";
		$amt="amt=".number_format(Yii::app()->request->getPost( 'Amount' ),2);
		$responseURL="responseURL=".Yii::app()->createAbsoluteUrl("project/payment");
		$errorURL="errorURL=".Yii::app()->createAbsoluteUrl("project/paymentError");
		$trackid="trackid=TRC01";
		
		$param=$id."&".$password."&".$action."&".$langid."&".$currencycode."&".$amt."&".$responseURL."&".$errorURL."&".$trackid;
		$url = "https://securepgtest.fssnet.co.in/pgway/servlet/PaymentInitHTTPServlet";
		$ch = curl_init() or die(curl_error()); 
		curl_setopt($ch, CURLOPT_POST,1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS,$param); 
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); 
		$data1=curl_exec($ch) or die(curl_error());
		curl_close($ch); 
		$response = $data1;
        $i =  strpos($response,":");
		$paymentId = substr($response, 0, $i);
		$paymentPage = substr( $response, $i + 1);
        return $r = $paymentPage . "?PaymentID=" . $paymentId;
	}
	public function getProjectAll(){
		$HomePro = array();
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND languageid='".Yii::app()->request->cookies['LanguageName']->value."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		else:
			$Languages = new Languages;
			$Lamgs = $Languages->find("isdefault=1");
			$criteria->condition	= "status=1 AND languageid='".$Lamgs->languageid."' AND projectenddate>='".date("Y-m-d H:i:s")."'";
		endif;
		$criteria->order = "projectenddate DESC";
		$HomePro = $this->getData($criteria);
		return $HomePro;
	}
}