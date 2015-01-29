<?php
class Category extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{category}}';
	}
	public function saveCategory(){
		if(Yii::app()->request->getPost( 'CategoryID' )){
			foreach($_POST['Category'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->condition	= "categoryslug='".Yii::app()->request->getPost( 'CategoryID' )."' AND languageid='".$Cats."'";
				$Pub = $this->find($criteria);
				if(!$Pub):
					$criteria = new CDbCriteria;
					$criteria->limit = 1;
					$criteria->order = 'categoryid DESC';
					$Pub = $this->find($criteria);
					
					$Languages = new Languages;
					$rsLangs = $Languages->find("isdefault=1");	
					
					$criteria = new CDbCriteria;
					$criteria->condition	= "categoryslug='".Yii::app()->request->getPost( 'CategoryID' )."' AND languageid=".$rsLangs->languageid;
					$MyPub = $this->find($criteria);
					
					$NewAddID = $Pub->categoryid + 1;
					$Pub = new Category;
					$Pub->categoryid = $NewAddID;
					$Pub->categoryimage = $MyPub->categoryimage;
					$Pub->ishomecategory = $MyPub->ishomecategory;
				endif;
				$Pub->category = $value;
				$Pub->categorycolor = Yii::app()->request->getPost( 'CategoryColor' );
				$Pub->languageid = $Cats;
				$Pub->categoryslug = Yii::app()->request->getPost( 'CategoryID' );
				$Pub->parentcategoryid = Yii::app()->request->getPost( 'ParentCategoryID' );
				$Pub->status = Yii::app()->request->getPost( 'Status' );
				$Pub->save();
			endforeach;
			if($Pub->categoryid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/projects/category/")) {
					mkdir("assets/projects/category/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/projects/category/'.Yii::app()->request->getPost( 'CategoryID' ).'.'.$ext);
				$Pub->categoryimage = $Pub->categoryid.'.'.$ext;
				$Pub->save();
				
				$criteria = new CDbCriteria;
				$criteria->condition = "categoryslug='".Yii::app()->request->getPost( 'CategoryID' )."'";
				$uCategory = new Category;
				$uCategory->updateAll(array("categoryimage" => Yii::app()->request->getPost( 'CategoryID' ).'.'.$ext),$criteria);
            }
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");	
			
			$Text = "Category(".$_POST['Category'][$rsLangs->languageid].") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Category has been updated successfully.";
		} else {
			$Languages = new Languages;
			$rsLangs = $Languages->find("isdefault=1");		
			
			$categoryslug = str_replace(" ", "-", $_POST['Category'][$rsLangs->languageid]);
			//$categoryslug = preg_replace("/[^a-zA-Z]+/", "", $_POST['Category'][$rsLangs->languageid]);
			$criteria = new CDbCriteria;
			$criteria->condition = "categoryslug='".$categoryslug."'";
			$isSlug = $this->find($criteria);
			
			if($isSlug):
				$categoryslug = $categoryslug.rand(0,99);
			endif;
				
			foreach($_POST['Category'] as $Cats=>$value):
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'categoryid DESC';
				$Pub = $this->find($criteria);
				
				$NewAddID = $Pub->categoryid + 1;
				
				$xCategory = new Category;
				$xCategory->categoryid = $NewAddID;
				$xCategory->category = $_POST['Category'][$Cats];
				$xCategory->languageid	 = $Cats;
				$xCategory->categoryslug = $categoryslug;
				$xCategory->categorycolor = Yii::app()->request->getPost( 'CategoryColor' );
				if(trim(Yii::app()->request->getPost( 'ParentCategoryID' ))!=''):
					$xCategory->parentcategoryid = Yii::app()->request->getPost( 'ParentCategoryID' );
				endif;
				$xCategory->status = Yii::app()->request->getPost( 'Status' );
				$xCategory->save();
			endforeach;
			
			if($xCategory->categoryid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/projects/category/")) {
					mkdir("assets/projects/category/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/projects/category/'.$categoryslug.'.'.$ext);
				
				$criteria = new CDbCriteria;
				$criteria->condition = "categoryslug='".$categoryslug."'";
				$uCategory = new Category;
				$uCategory->updateAll(array("categoryimage" => $categoryslug.'.'.$ext),$criteria);
				
            }
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Category(".$_POST['Category'][$rsLangs->languageid].") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			Yii::app()->session['AdminSuccess'] = "Category has been added successfully.";
		}
	}
	
	public function findAllByList(){
		$Languages = new Languages;
		$rsLangs = $Languages->find("isdefault=1");
		
		$Cats = $this->findAll("languageid=".$rsLangs->languageid);
		$MyCats = array();
		$i= 0;
		foreach($Cats as $Cat):
			$MyCats[$i]['categoryid'] = $Cat->categoryid;
			$MyCats[$i]['category'] = $Cat->category;
			$MyCats[$i]['ishomecategory'] = $Cat->ishomecategory;
			$MyCats[$i]['categoryslug'] = $Cat->categoryslug;
			$MyCats[$i]['status'] = $Cat->status;
			if($Cat->parentcategoryid):
				$MyMainCat = $this->find("categoryslug='".$Cat->parentcategoryid."' AND languageid='".$rsLangs->languageid."'");
				$MyCats[$i]['parentcategory'] = $MyMainCat->category;
			else:
				$MyCats[$i]['parentcategory'] = "";
			endif;
			$i=$i+1;
		endforeach;
		return $MyCats;
	}
	public function saveHomeCat(){
		$criteria = new CDbCriteria;
		$criteria->condition = "categoryslug='".Yii::app()->request->getPost( 'CategoryID' )."'";
		$this->updateAll(array("ishomecategory" => Yii::app()->request->getPost( 'IsHome' )),$criteria);
		
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
		$Admin = new Admin;
		$Admins = $Admin->find($criteria);
		
		$Language = new Languages;
		$rsLangu = $Language->find("isdefault=1");
		
		$uCategory = new Category;
		$rsProj = $uCategory->find("categoryslug='".Yii::app()->request->getPost( 'CategoryID' )."' AND languageid=".$rsLangu->languageid);
		
		$Text = "Category(".$rsProj->category.") has been set as home page category by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
		$General = new General;
		$General->addLog($Text);
		
		return $rsProj->category;
	}
	public function findByAllLanguage($CategoryID){
		$Cats = $this->findAll("categoryslug='".$CategoryID."'");
		$MyCats = array();
		foreach($Cats as $Cat):
			$MyCats[$Cat->languageid]['categoryid'] = $Cat->categoryid;
			$MyCats[$Cat->languageid]['category'] = $Cat->category;
			$MyCats[$Cat->languageid]['categoryslug'] = $Cat->categoryslug;
			$MyCats[$Cat->languageid]['parentcategoryid'] = $Cat->parentcategoryid;
			$MyCats[$Cat->languageid]['categorycolor'] = $Cat->categorycolor;
			$MyCats[$Cat->languageid]['categoryimage'] = $Cat->categoryimage;
			$MyCats[$Cat->languageid]['status'] = $Cat->status;
		endforeach;
		return $MyCats;
	}
	
	public function homeCats(){
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "ishomecategory=1 AND languageid=".Yii::app()->request->cookies['LanguageName']->value;
		else:
			$Languages = new Languages;
			$Lamgs = $Languages->find("isdefault=1");
			$criteria->condition	= "ishomecategory=1 AND languageid=".$Lamgs->languageid;
		endif;
		return $this->getData($criteria);
	}
	
	public function getData($criteria){
		$Languages = new Languages;
		$Lamgs = $Languages->find("isdefault=1");
			
		$Categories = $this->findAll($criteria);
		$CatResult = array();
		$i=0;
		foreach($Categories as $Category):
			if(isset(Yii::app()->request->cookies['LanguageName']) && $Lamgs->languageid!=Yii::app()->request->cookies['LanguageName']->value && trim($Category->category)==''):
				$DefaulCategory = $this->find("categoryslug	='".$Category->categoryslug	."' AND languageid='".$Lamgs->languageid."'");
			endif;
			$CatResult[$i]['categoryid'] = $Category->categoryid;
			if(trim($Category->category)!=''):
				$CatResult[$i]['category'] = $Category->category;
			else:
				$CatResult[$i]['category'] = $DefaulCategory->category;
			endif;
			$CatResult[$i]['categoryslug'] = $Category->categoryslug;
			$CatResult[$i]['languageid'] = $Category->languageid;
			$CatResult[$i]['parentcategoryid'] = $Category->parentcategoryid;
			$CatResult[$i]['categorycolor'] = $Category->categorycolor;
			$CatResult[$i]['categoryimage'] = $Category->categoryimage;
			$CatResult[$i]['status'] = $Category->status;
			$i = $i + 1;
		endforeach;
		return $CatResult;
	}
	public function getCats(){
		$criteria = new CDbCriteria;
		if(Yii::app()->request->cookies['LanguageName']):
			$criteria->condition	= "status=1 AND languageid=".Yii::app()->request->cookies['LanguageName']->value;
			$criteria->order = "category ASC";
		else:
			$Languages = new Languages;
			$Lamgs = $Languages->find("isdefault=1");
			$criteria->condition	= "status=1 AND languageid=".$Lamgs->languageid;
			$criteria->order = "category ASC";
		endif;
		$resCat = $this->getData($criteria);
		for($i=0;$i<count($resCat);$i++):
			$resArray[$i] = $resCat[$i];
			$Projects = new Project;
			$resArray[$i]['OnlinProject'] = $Projects->getProjectCount($resCat[$i]['categoryslug']);
		endfor;
		return $resArray;
	}
}