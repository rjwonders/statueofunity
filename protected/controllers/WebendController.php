<?php

class WebendController extends Controller
{
	public $layout='admin';
	/* login page*/ 
	public function actionIndex(){
		//echo Yii::app()->session['AdminID'];
		if(isset(Yii::app()->session['AdminID'])){
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend/dashboard');
		} else {
			$this->render('login');
		}
	}
	
	public function CheckLogin(){
		if(!isset(Yii::app()->session['AdminID'])){
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend');
		}
	}
	/* login validate*/
	public function actionLogin(){
		$Admin = new Admin;
		$criteria = new CDbCriteria;  
		$criteria->condition	= "email='".$_POST["Email"]."' AND password='".md5($_POST["Password"])."' AND status=1";
		
		$User =	$Admin->find($criteria);
		//print_r($User);exit;
		if(count($User) > 0){
			$User->lastlogindate = date("Y-m-d H:i:s");
			$User->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
			$User->save();
			
			$Text = $User->firstname." ".$User->lastname."(".$User->email.") has signed in at ".date("d M, Y h:i:s A")."\n";
			
			$General = new General;
			$General->addLog($Text);
			//Yii::app()->session->add("AdminID", $User->adminid);
			Yii::app()->session['AdminID'] = $User->adminid;
			Yii::app()->session['UserTypeID'] = $User->usertypeid;
			$this->redirect('dashboard');
			
		} else {
			$Text = "There is a wrong login attempt from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminError'] = "Invalid Email or Password";
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend');
		}
	}
	
	/* logout */
	public function actionLogout(){
		unset(Yii::app()->session['AdminID']);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend');
	}
	
	/* dashboard */
	public function actionDashboard(){
		$this->CheckLogin();
		
		$this->render('dashboard');
	}
	
	/* Admin functions */
	public function actionAdmin(){
		$this->CheckLogin();
		$Admin = new Admin;
		$rsAdmin = $Admin->getAdminData();
		$this->render('admin',array('data'=>$rsAdmin));
	}
	public function actionAdmins($AdminID=0){
		$this->CheckLogin();
		$rsAdmin = array();
		if($AdminID!=0){
			$Admin = new Admin;
			$rsAdmin = $Admin->findByPk($AdminID);
		}
		$UserType = new Usertype;
		$rsUserType = $UserType->findAll();
			
		$this->render('add-admin',array('data'=>$rsAdmin, 'usertype'=>$rsUserType));
	}
	public function actionAddAdmins(){
		$Admin = new Admin;
		$Admin->saveAdmin();
		if(Yii::app()->session['UserTypeID']==1):
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend/admin');
		else:
			Yii::app()->session['AdminSuccess'] = "Profile updated successfully.";
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend/admins/AdminID/'.Yii::app()->session['AdminID']);
		endif;
	}
	public function actionDeleteAdmin($AdminID=0){
		$Admin = new Admin;
		$Admin->deleteAdmin($AdminID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/admin');
	}
	/* End Admin functions */
	
	/* Project Creator's functions */
	public function actionCreator(){
		$this->CheckLogin();
		$Publisher = new Publishers;
		$rsPublisher = $Publisher->findAll();
		$this->render('publisher',array('data'=>$rsPublisher));
	}
	public function actionCreators($PublisherID=0){
		$this->CheckLogin();
		$rsPublisher = array();
		if($PublisherID!=0){
			$Publishers = new Publishers;
			$rsPublisher = $Publishers->findByPk($PublisherID);
		}
			
		$this->render('add-publisher',array('data'=>$rsPublisher));
	}
	public function actionAddPublisers(){
		$Publishers = new Publishers;
		$Publishers->savePublisher();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/creator');
	}
	
	public function actionDeleteCreator($PublisherID){
		$Publishers = new Publishers;
		$Res = $Publishers->findByPk($PublisherID);
		if($Res && trim($Res->profilepicture)!=""):
			unlink('assets/users/creator/'.$Res->profilepicture);
		endif;
		$Publishers = new Publishers;
		$Publishers->deleteByPk($PublisherID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/creator');
	}
	/* End Project Creator's functions */
	
	
	/* Project Category functions */
	public function actionCategory(){
		$this->CheckLogin();
		$Category = new Category;
		$rsCategory = $Category->findAllByList();
		$this->render('category',array('data'=>$rsCategory));
	}
	public function actionCategorys($CategoryID=""){
		$this->CheckLogin();
		
		$Category = new Category;
		$rsCategory = $Category->findAll("status=1 GROUP BY categoryslug");
		
		$Languages = new Languages;
		$rsLangs = $Languages->findAll("status=1");
		
		$Languages = new Languages;
		$rsDefaultLang = $Languages->find("isdefault=1");
		
		$rsData = array();
		if($CategoryID!=""){
			$Category = new Category;
			$rsData = $Category->findByAllLanguage($CategoryID);
		}
		$this->render('add-category',array('data'=>$rsData, 'rsCategory'=>$rsCategory, 'rsLanguages'=>$rsLangs, 'rsDefaultLang'=>$rsDefaultLang));
	}
	public function actionAddCategory(){
		$this->CheckLogin();
		$Category = new Category;
		$Category->saveCategory();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/category');
	}
	
	public function actionDeleteCategory($CategoryID){
		$this->CheckLogin();
		$Category = new Category;
		$Category->deleteAll("categoryslug='".$CategoryID."'");
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/category');
	}
	
	public function actionHomeCategory(){
		$this->CheckLogin();
		$Category = new Category;
		$Res = $Category->saveHomeCat();
		echo $Res;
	}
	/* End Project Category functions */
	
	/* Project functions */
	public function actionProject(){
		$this->CheckLogin();
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		if(Yii::app()->session['UserTypeID']==1):
			$rsProject = $Project->findAll("languageid=".$rsLangu->languageid);
		else:
			$rsProject = $Project->findAll("adminid=".Yii::app()->session['AdminID']." AND languageid=".$rsLangu->languageid);
		endif;
		$this->render('project',array('data'=>$rsProject));
	}
	public function actionProjects($ProjectID=""){
		$this->CheckLogin();
		
		$Admin = new Admin;
		$rsAdmin = $Admin->findAll("status=1 AND usertypeid=2");
		
		$Languages = new Languages;
		$rsLangs = $Languages->findAll("status=1");
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Publishers = new Publishers;
		$rsPublishers = $Publishers->findAll("status=1");
		
		$Category = new Category;
		$rsCategory = $Category->findAll("status=1 AND languageid=".$rsLangu->languageid);
		
		$rsData = array();
		$rsProjectCategory = array();
		$rsProjectReward = array();
		if($ProjectID!=""){
			$Project = new Project;
			$rsData = $Project->findAllBySlug($ProjectID);
			
			$ProjectCategory = new ProjectCategory;
			$rsProjectCategories = $ProjectCategory->findAll("projectslug='".$ProjectID."'");
			foreach($rsProjectCategories as $pCat):
				$rsProjectCategory[] = $pCat->categoryid;
			endforeach;
			
			$ProjectReward = new ProjectReward;
			$rsProjectReward = $ProjectReward->findAll("projectid='".$ProjectID."'");
		}
		$this->render('add-project',array('data'=>$rsData, 'rsProjectCategory'=>$rsProjectCategory, 'rsAdmin'=>$rsAdmin, 'rsCategory'=>$rsCategory, 'rsPublishers'=>$rsPublishers, 'rsLangs' => $rsLangs, 'rsLangu' => $rsLangu, 'rsProjectReward' => $rsProjectReward));
	}
	public function actionAddProject(){
		$this->CheckLogin();
		$Project = new Project;
		$Project->saveProject();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/project');
	}
	
	public function actionDeleteProject($ProjectID){
		$this->CheckLogin();
		
		$ProjectCategory = new ProjectCategory;
		$ProjectCategory->deleteAll("projectslug='".$ProjectID."'");
		
		$ProjectImages = new ProjectImages;
		$ProjectImages->deleteAll("projectslug='".$ProjectID."'");
		
		$ProjectVideo = new ProjectVideo;
		$ProjectVideo->deleteAll("projectslug='".$ProjectID."'");
		
		$ProjectUpdate = new ProjectUpdate;
		$ProjectUpdate->deleteAll("projectslug='".$ProjectID."'");
		
		$ProjectFAQ = new ProjectFAQ;
		$ProjectFAQ->deleteAll("projectslug='".$ProjectID."'");
		
		$Project = new Project;
		$Project->deleteAll("projectslug='".$ProjectID."'");
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/project');
	}
	
	
	public function actionProjectImages($ProjectID){
		$this->CheckLogin();
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsData = $Project->find("projectslug='".$ProjectID."' AND languageid=".$rsLangu->languageid);
		
		$ProjectImages = new ProjectImages;
		$rsImages = $ProjectImages->findAll("projectslug='".$ProjectID."'");
		
		$this->render('project-images',array('rsData'=>$rsData, 'rsImages'=>$rsImages));
	}
	public function actionProjectImagesUpload(){
		$this->CheckLogin();
		$ProjectImages = new ProjectImages;
		$ProjectImages->saveImages();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectImages/ProjectID/'.Yii::app()->request->getPost( 'ProjectID' ));
	}
	public function actionProjectImagesDelete($ProjectImagesID){
		$this->CheckLogin();
		$ProjectImages = new ProjectImages;
		$Res = $ProjectImages->findByPk($ProjectImagesID);
		if($Res && trim($Res->images)!=""):
			unlink('assets/projects/'.$Res->projectslug.'/'.$Res->images);
		endif;
		$ProjectImages = new ProjectImages;
		$ProjectImages->deleteByPk($ProjectImagesID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectImages/ProjectID/'.$Res->projectslug);
	}
	public function actionProjectImagesDeleteAll(){
		$this->CheckLogin();
		foreach($_POST['checks'] as $chk):
			$ProjectImages = new ProjectImages;
			$Res = $ProjectImages->findByPk($chk);
			if($Res && trim($Res->images)!=""):
				unlink('assets/projects/'.$Res->projectslug.'/'.$Res->images);
			endif;
			$ProjectImages = new ProjectImages;
			$ProjectImages->deleteByPk($chk);
		endforeach;
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectImages/ProjectID/'.$Res->projectslug);
	}
	
	public function actionProjectVideos($ProjectID){
		$this->CheckLogin();
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsData = $Project->find("projectslug='".$ProjectID."' AND languageid=".$rsLangu->languageid);
		
		$ProjectVideo = new ProjectVideo;
		$rsVideos = $ProjectVideo->findAll("projectslug='".$ProjectID."'");
		
		$this->render('project-video',array('rsData'=>$rsData, 'rsVideos'=>$rsVideos));
		
	}
	public function actionProjectVideosUpload(){
		$this->CheckLogin();
		$ProjectVideo = new ProjectVideo;
		$ProjectVideo->saveVideos();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectVideos/ProjectID/'.Yii::app()->request->getPost( 'ProjectID' ));
	}
	public function actionProjectVideosDelete($ProjectVideosID){
		$this->CheckLogin();
		
		$ProjectVideo = new ProjectVideo;
		$Res = $ProjectVideo->findByPk($ProjectVideosID);
			
		$ProjectVideo = new ProjectVideo;
		$ProjectVideo->deleteByPk($ProjectVideosID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectVideos/ProjectID/'.$Res->projectslug);
	}
	public function actionProjectVideosDeleteAll(){
		$this->CheckLogin();
		foreach($_POST['checks'] as $chk):
			$ProjectVideo = new ProjectVideo;
			$Res = $ProjectVideo->findByPk($chk);
			
			$ProjectVideo = new ProjectVideo;
			$ProjectVideo->deleteByPk($chk);
		endforeach;
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectVideos/ProjectID/'.$Res->projectslug);
	}
	
	
	public function actionProjectUpdates($ProjectID,$ProjectUpdateID=0){
		$this->CheckLogin();
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsData = $Project->find("projectslug='".$ProjectID."' AND languageid=".$rsLangu->languageid);
		
		$rsMyUpdate = array();
		if($ProjectUpdateID!=0){
			$ProjectUpdate = new ProjectUpdate;
			$rsMyUpdate = $ProjectUpdate->findByPk($ProjectUpdateID);
		}
		$ProjectUpdate = new ProjectUpdate;
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."'";
		$criteria->order = 'addeddate DESC';
		$rsUpdate = $ProjectUpdate->findAll($criteria);
		
		$this->render('project-update',array('rsData'=>$rsData, 'rsUpdate'=>$rsUpdate, 'rsMyUpdate'=>$rsMyUpdate));
		
	}
	public function actionProjectAddUpdate(){
		$this->CheckLogin();
		$ProjectUpdate = new ProjectUpdate;
		$ProjectUpdate->saveUpdate();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectUpdates/ProjectID/'.Yii::app()->request->getPost( 'ProjectID' ));
	}
	public function actionDeleteProjectUpdate($ProjectUpdateID){
		$this->CheckLogin();
		
		$ProjectUpdate = new ProjectUpdate;
		$Res = $ProjectUpdate->findByPk($ProjectUpdateID);
			
		$ProjectUpdate = new ProjectUpdate;
		$ProjectUpdate->deleteByPk($ProjectUpdateID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectUpdates/ProjectID/'.$Res->projectslug);
	}
	
	
	public function actionProjectFAQs($ProjectID,$ProjectFAQID=0){
		$this->CheckLogin();
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$Project = new Project;
		$rsData = $Project->find("projectslug='".$ProjectID."' AND languageid=".$rsLangu->languageid);
		
		$rsMyFAQ = array();
		if($ProjectFAQID!=0){
			$ProjectFAQ = new ProjectFAQ;
			$rsMyFAQ = $ProjectFAQ->findByPk($ProjectFAQID);
		}
		$ProjectFAQ = new ProjectFAQ;
		$criteria = new CDbCriteria;
		$criteria->condition = "projectslug='".$ProjectID."'";
		$criteria->order = 'addeddate DESC';
		$rsUpdate = $ProjectFAQ->findAll($criteria);
		
		$this->render('project-faq',array('rsData'=>$rsData, 'rsUpdate'=>$rsUpdate, 'rsMyFAQ'=>$rsMyFAQ));
		
	}
	public function actionProjectAddFAQ(){
		$this->CheckLogin();
		$ProjectFAQ = new ProjectFAQ;
		$ProjectFAQ->saveFAQ();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectFAQs/ProjectID/'.Yii::app()->request->getPost( 'ProjectID' ));
	}
	public function actionDeleteProjectFAQ($ProjectFAQID){
		$this->CheckLogin();
		
		$ProjectFAQ = new ProjectFAQ;
		$Res = $ProjectFAQ->findByPk($ProjectFAQID);
			
		$ProjectFAQ = new ProjectFAQ;
		$ProjectFAQ->deleteByPk($ProjectFAQID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/projectFAQs/ProjectID/'.$Res->projectslug);
	}
	public function actionDefaultBannerProject(){
		$this->CheckLogin();
		$Project = new Project;
		$Res = $Project->saveBanner();
		echo $Res;
	}
	public function actionDefaultFocusProject(){
		$this->CheckLogin();
		$Project = new Project;
		$Res = $Project->saveFocusProject();
		echo $Res;
	}
	/* End Project functions */
	
	/* Start Logs functions */
	public function actionLogs(){
		$this->CheckLogin();
		$rsLog = file_get_contents(Yii::app()->getBaseUrl(true)."/assets/logs/dec-2014.txt");
		$this->render('logs',array("rsLog" => $rsLog));
	}
	/* End Logs functions */
	
	/* Start Language functions */
	public function actionLanguage(){
		$this->CheckLogin();
		$Languages = new Languages;
		$rsData = $Languages->findAll();
		
		$this->render('languages',array('rsData'=>$rsData));
	}
	public function actionLanguages($LanguageID=0){
		$this->CheckLogin();
		$rsLanguage = array();
		if($LanguageID!=0){
			$Languages = new Languages;
			$rsLanguage = $Languages->findByPk($LanguageID);
		}
		
		$this->render('add-language',array('data'=>$rsLanguage));
	}
	public function actionAddLanguages(){
		$Languages = new Languages;
		$LangID = $Languages->saveLanguages();
		if(Yii::app()->request->getPost( 'LanguageID' )):
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend/language');
		else:
			$this->redirect(Yii::app()->getBaseUrl(true).'/webend/languageText/LanguageID/'.$LangID);
		endif;
	}
	public function actionDeleteLanguages($LanguageID=0){
		unlink('assets/translate/lang-'.$LanguageID.".txt");
		$Languages = new Languages;
		$Languages->deleteByPk($LanguageID);
		Yii::app()->db->createCommand()->dropColumn('settings', "lang".$LanguageID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/language');
	}
	public function actionDefaultLanguages(){
		$Languages = new Languages;
		echo $Lang = $Languages->setDefaultLanguage();
	}
	
	public function actionLanguageText($LanguageID){
		$Languages = new Languages;
		$rsLanguage = $Languages->findByPk($LanguageID);
		
		$rsLine = file(Yii::app()->getBaseUrl(true)."/assets/translate/main.txt", FILE_IGNORE_NEW_LINES);
		
		$rsLiner = file(Yii::app()->getBaseUrl(true)."/assets/translate/lang-".$LanguageID.".txt", FILE_IGNORE_NEW_LINES);
		
		$Line = array();
		foreach($rsLiner as $MyLines):
			$Datas = explode("|",$MyLines);
			if(count($Datas)>1):
				$Line[$Datas[0]] = $Datas[1];
			else:
				$Line[$Datas[0]] = "";
			endif;
		endforeach;
		
		$this->render('language-text',array('rsData'=>$rsLanguage, 'rsLine'=>$rsLine, 'rsMyLiner'=>$Line));
	}
	public function actionEditLanguageText(){
		$Languages = new Languages;
		$rsLanguage = $Languages->saveText();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/languageText/LanguageID/'.Yii::app()->request->getPost( 'LanguageID' ));
	}
	/* End Language functions */
	
	/* Start General Settings functions */
	public function actionSettings(){
		$Settings = new Settings;
		$rsSettings = $Settings->findAll();
		
		$Languages = new Languages;
		$rsLanguages = $Languages->findAll();
		$this->render('settings',array('rsData'=>$rsSettings, 'rsLanguages'=>$rsLanguages));
	}
	public function actionSaveSettings(){
		$Settings = new Settings;
		$Settings->saveSettings();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/settings');
	}
	/* End General Settings functions */
	
	/* Gallery Functions */
	public function actionImages(){
		$Gallery = new Gallery;
		$rsGallery = $Gallery->findAll("gallerytype=1");
		$this->render('image-gallery',array('rsGallery'=>$rsGallery));
	}
	public function actionGalleryImagesUpload(){
		$this->CheckLogin();
		$Gallery = new Gallery;
		$Gallery->saveImages();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/images');
	}
	public function actionGalleryImagesDelete($GalleryID){
		$this->CheckLogin();
		$Gallery = new Gallery;
		$Res = $Gallery->findByPk($GalleryID);
		if($Res && trim($Res->path)!=""):
			unlink('assets/gallery/'.$Res->path);
		endif;
		$Gallery = new Gallery;
		$Gallery->deleteByPk($GalleryID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/images');
	}
	public function actionGalleryImagesDeleteAll(){
		$this->CheckLogin();
		foreach($_POST['checks'] as $chk):
			$Gallery = new Gallery;
			$Res = $Gallery->findByPk($chk);
			if($Res && trim($Res->path)!=""):
				unlink('assets/gallery/'.$Res->path);
			endif;
			$Gallery = new Gallery;
			$Gallery->deleteByPk($chk);
		endforeach;
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/images');
	}
	
	public function actionVideos(){
		$Gallery = new Gallery;
		$rsGallery = $Gallery->findAll("gallerytype=2");
		$this->render('video-gallery',array('rsGallery'=>$rsGallery));
	}
	public function actionGalleryVideosUpload(){
		$this->CheckLogin();
		$Gallery = new Gallery;
		$Gallery->saveVideos();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/videos');
	}
	public function actionGalleryVideosDelete($GalleryID){
		$this->CheckLogin();
			
		$Gallery = new Gallery;
		$Gallery->deleteByPk($GalleryID);
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/videos');
	}
	public function actionGalleryVideosDeleteAll(){
		$this->CheckLogin();
		foreach($_POST['checks'] as $chk):
			$Gallery = new Gallery;
			$Gallery->deleteByPk($chk);
		endforeach;
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/videos');
	}
	/* End Gallery Functions */
	
	/* CMS Functions */
	public function actionCms(){
		$CMS = new Cms;
		$rsCMS = $CMS->findAllByLanguage();
		$this->render('cms',array('rsCMS'=>$rsCMS));
	}
	public function actionCmss($CmsID=""){
		$Languages = new Languages;
		$rsLangs = $Languages->findAll("status=1");
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$rsCMS = array();
		if($CmsID):
			$CMS = new Cms;
			$rsCMS = $CMS->findByAllLanguage($CmsID);
		endif;
		$this->render('add-cms',array('data'=>$rsCMS, 'rsLangs'=>$rsLangs, 'rsDefaultLang'=>$rsLangu));
	}
	public function actionAddCms(){
		$this->CheckLogin();
		$CMS = new Cms;
		$CMS->saveCms();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/cms');
	}
	/* End CMS Functions */
	
	
	/* Testimonial Functions */
	public function actionTestimonial(){
		$Testimonials = new Testimonials;
		$rsTestimonials = $Testimonials->findByDefaultLanguage();
		$this->render('testimonial',array('rsTestimonials'=>$rsTestimonials));
	}
	public function actionTestimonials($TestimonialID=""){
		$Languages = new Languages;
		$rsLangs = $Languages->findAll("status=1");
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$rsTestimonial = array();
		if($TestimonialID):
			$Testimonials = new Testimonials;
			$rsTestimonial = $Testimonials->findByAllLanguage($TestimonialID);
		endif;
		$this->render('add-testimonial',array('data'=>$rsTestimonial, 'rsLangs'=>$rsLangs, 'rsDefaultLang'=>$rsLangu));
	}
	public function actionAddTestimonial(){
		$this->CheckLogin();
		$Testimonials = new Testimonials;
		$Testimonials->saveTestimonial();
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/testimonial');
	}
	public function actionDeleteTestimonial($TestimonialID){
		$this->CheckLogin();
		$Testimonials = new Testimonials;
		$Testimonials->deleteAllByAttributes(array('testimonialslug' => $TestimonialID));
		$this->redirect(Yii::app()->getBaseUrl(true).'/webend/testimonial');
	}
	/* End Testimonial Functions */
}
