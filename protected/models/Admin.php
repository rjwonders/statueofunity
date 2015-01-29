<?php
class Admin extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{admin}}';
	}
	
	
	/* site related functioms */
	
	public function getAdminData($AdminID=0){
		$criteria = new CDbCriteria;
		$criteria->condition	= "1=1";
		$Admins =  $this->findAll($criteria);
		
		$MyAdmins = array();
		$i= 0;
		foreach($Admins as $Adms):
			$MyAdmins[$i]['adminid'] = $Adms->adminid;
			$MyAdmins[$i]['firstname'] = $Adms->firstname;
			$MyAdmins[$i]['lastname'] = $Adms->lastname;
			$MyAdmins[$i]['email'] = $Adms->email;
			$MyAdmins[$i]['password'] = $Adms->password;
			$MyAdmins[$i]['usertypeid'] = $Adms->usertypeid;
			$MyAdmins[$i]['profilepicture'] = $Adms->profilepicture;
			$MyAdmins[$i]['lastloginipaddress'] = $Adms->lastloginipaddress;
			$MyAdmins[$i]['lastlogindate'] = $Adms->lastlogindate;
			$MyAdmins[$i]['registartiondate'] = $Adms->registartiondate;
			$MyAdmins[$i]['status'] = $Adms->status;
			
			$Usertypes = new Usertype;
			$UType = $Usertypes->findByPk($Adms->usertypeid);
			$MyAdmins[$i]['UserType'] = $UType->usertype;
			
			
			$i=$i+1;
		endforeach;
		return $MyAdmins;
	}
	
	
	
	public function saveAdmin(){
		if(Yii::app()->request->getPost( 'AdminID' )){
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->request->getPost( 'AdminID' );
			$Adm = $this->find($criteria);
			$Adm->adminid = Yii::app()->request->getPost( 'AdminID' );
			$Adm->firstname = Yii::app()->request->getPost( 'FirstName' );
			$Adm->lastname = Yii::app()->request->getPost( 'LastName' );
			$Adm->email = Yii::app()->request->getPost( 'Email' );
			if(trim(Yii::app()->request->getPost( 'Password' ))!=''):
				$Adm->password = md5(Yii::app()->request->getPost( 'Password' ));
			endif;
			if(trim(Yii::app()->request->getPost( 'UserTypeID' ))!=''):
				$Adm->usertypeid = Yii::app()->request->getPost( 'UserTypeID' );
			endif;
			$Adm->status = Yii::app()->request->getPost( 'Status' );
			$Adm->save();
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "usertypeid=".Yii::app()->request->getPost( 'UserTypeID' );
			$UserType = new Usertype;
			$Typers = $UserType->find($criteria);
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = $Typers->usertype."(".Yii::app()->request->getPost( 'FirstName' )." ".Yii::app()->request->getPost( 'LastName' ).", ID=".Yii::app()->request->getPost( 'AdminID' ).") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			
			$General = new General;
			$General->addLog($Text);
			
			if($Adm->adminid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/admin/")) {
					mkdir("assets/users/admin/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/admin/'.$Adm->adminid.'.'.$ext);
				$Adm->profilepicture = $Adm->adminid.'.'.$ext;
				$Adm->save();
            }
		} else {
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'adminid DESC';
			$Adm = $this->find($criteria);
			
			$NewAddID = $Adm->adminid + 1;
			
			$this->adminid = $NewAddID;
			$this->firstname = Yii::app()->request->getPost( 'FirstName' );
			$this->lastname = Yii::app()->request->getPost( 'LastName' );
			$this->email = Yii::app()->request->getPost( 'Email' );
			$this->password = md5(Yii::app()->request->getPost( 'Password' ));
			$this->status = Yii::app()->request->getPost( 'Status' );
			if(trim(Yii::app()->request->getPost( 'UserTypeID' ))!=''):
				$this->usertypeid = Yii::app()->request->getPost( 'UserTypeID' );
			endif;
			$this->registartiondate = date("Y-m-d H:i:s");
			$this->save();
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "usertypeid=".Yii::app()->request->getPost( 'UserTypeID' );
			$UserType = new Usertype;
			$Typers = $UserType->find($criteria);
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = $Typers->usertype."(".Yii::app()->request->getPost( 'FirstName' )." ".Yii::app()->request->getPost( 'LastName' ).", ID=".Yii::app()->request->getPost( 'AdminID' ).") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			if($this->adminid){
				$sg=Yii::app()->sendgrid;
				$message = $sg->createEmail();  
				$message  
					->setView('register-admin')  
					->setHtml(array(  
						'Name'=> Yii::app()->request->getPost( 'FirstName' ),
						'Email'=> Yii::app()->request->getPost( 'Email' ),
						'Password'=> Yii::app()->request->getPost( 'Password' ),
						'SiteLink'=> Yii::app()->createAbsoluteUrl("webend"),
					));  
				$message->setSubject('Welcome to Statue of Unity!')  
					->addTo(Yii::app()->request->getPost( 'Email' ))  
					->setFrom(Yii::app()->params['adminEmail']);
					  
				if(!$sg->send($message)){
					Yii::log("Failed to send email:\n".print_r($sg->lastErrors,true) ,CLogger::LEVEL_ERROR);
				}
			}
			if($this->adminid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/admin/")) {
					mkdir("assets/users/admin/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/admin/'.$this->adminid.'.'.$ext);
				$this->profilepicture = $this->adminid.'.'.$ext;
				$this->save();
            }
		}
		
	}
	
	public function deleteAdmin($AdminID){
		$criteria = new CDbCriteria;
		$criteria->condition	= "adminid=".$AdminID;
		$this->deleteAll($criteria);
	}
}