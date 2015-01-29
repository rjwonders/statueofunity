<?php
class Users extends CActiveRecord{
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{users}}';
	}
	public function saveUsers(){
		//echo ABSPATH . WPINC . '/registration.php';exit;
		if(Yii::app()->request->getPost( 'UserID' )){
			$criteria = new CDbCriteria;
			$criteria->condition = "projectupdateid=".Yii::app()->request->getPost( 'ProjectUpdateID' );
			$Adm = $this->find($criteria);
			
			$Adm->updates = Yii::app()->request->getPost( 'Update' );
			$Adm->save();
		} else {
			$IsUsers = $this->find("email='".Yii::app()->request->getPost( 'Email' )."'");
			if($IsUsers):
				Yii::app()->session['UserError'] = "This email already exist in our database. Please try registering with another email id.";
				return 0;
			endif;
			
			$Publishers = new Publishers;
			$IsPublisher = $Publishers->find("email='".Yii::app()->request->getPost( 'Email' )."'");
			if($IsPublisher):
				Yii::app()->session['UserError'] = "This email already exist in our database. Please try registering with another email id.";
				return 0;
			endif;
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'userid DESC';
			$Adm = $this->find($criteria);
				
			$NewAddID = $Adm->userid + 1;
			
			$NewUniqueID = uniqid(time(),true);
			$Users = new Users;
			$Users->userid = $NewAddID ;
			$Users->firstname = Yii::app()->request->getPost( 'FirstName' );
			$Users->lastname = Yii::app()->request->getPost( 'LastName' );
			$Users->email = Yii::app()->request->getPost( 'Email' );
			$Users->password = md5(Yii::app()->request->getPost( 'Password' ));
			$Users->registrationdate = date("Y-m-d H:i:s");
			$Users->gender = Yii::app()->request->getPost( 'Gender' );
			$Users->dateofbirth = Yii::app()->request->getPost( 'BirthDate' );
			$Users->uniquecode = $NewUniqueID;
			$Users->status = 0;
			$Users->save();
			
			
			$user_login		= Yii::app()->request->getPost( 'Email' );	
			$user_email		= Yii::app()->request->getPost( 'Email' );
			$user_first 	= Yii::app()->request->getPost( 'FirstName' );
			$user_last	 	= Yii::app()->request->getPost( 'LastName' );
			$user_pass		= Yii::app()->request->getPost( 'Password' );
			$pass_confirm 	= Yii::app()->request->getPost( 'Password' );
	 
			// this is required for username checks
			require_once(ABSPATH . WPINC . '/registration.php');
	 		$new_user_id = wp_insert_user(array(
					'user_login'		=> $user_login,
					'user_pass'	 		=> $user_pass,
					'user_email'		=> $user_email,
					'first_name'		=> $user_first,
					'last_name'			=> $user_last,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'role'				=> 'subscriber'
				)
			);
			if($new_user_id) {
				wp_new_user_notification($new_user_id);
	 		}
	 
		
			if(Yii::app()->request->getPost( 'IsNewsletter' )):
				$General =  new General;
				$General->addNewsletter(Yii::app()->request->getPost( 'Email' ), Yii::app()->request->getPost( 'FirstName' )." ".Yii::app()->request->getPost( 'LastName' ));
			endif;
			$sg=Yii::app()->sendgrid;
			$message = $sg->createEmail();  
			$message  
				->setView('user-register')  
				->setHtml(array(  
						'Name'=> Yii::app()->request->getPost( 'FirstName' ),
						'ActivationURL'=> Yii::app()->createAbsoluteUrl("user/activateAccount",array("UniqueCode"=>$NewUniqueID)),
				));  
			$message->setSubject('Welcome to Statue of Unity!')  
				->addTo(Yii::app()->request->getPost( 'Email' ))  
				->setFrom(Yii::app()->params['adminEmail']);
			
			$sg->send($message);
				Yii::app()->session['UserSuccess'] = "You have successfully registered with us. Please check your email and activate your account.";
			return 1;
		}
	}
	public function activateAccount(){
		$User = $this->find("uniquecode='".Yii::app()->request->getParam( 'UniqueCode' )."'");
		if($User):
		$User->status = 1;
		$User->activationdate = date("Y-m-d H:i:s");
		$User->uniquecode = "";
		$User->save();
		Yii::app()->session['UserSuccess'] = "You have successfully activated your account.";
		return 1;
		else:
			return 0;
		endif;
	}
	public function Login(){
		require_once(ABSPATH . WPINC . '/registration.php');
		$Users =  new Users;
		$rsUser = $Users->find("email='".Yii::app()->request->getPost( 'Email' )."' AND password='".md5(Yii::app()->request->getPost( 'Password' ))."' AND status=1");
		
		if($rsUser):
			$rsUser->lastlogindate = date("Y-m-d H:i:s");
			$rsUser->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
			$rsUser->save();
			Yii::app()->session['UserID'] = $rsUser->userid;
			Yii::app()->session['UserType'] = "User";
			$user = get_user_by( 'email', $rsUser->email );
			wp_setcookie($rsUser->email, Yii::app()->request->getPost( 'Password' ), true);
			wp_set_current_user($user->ID, $rsUser->email);	
			do_action('wp_login', $rsUser->email);
			return 1;
		else:
			$Publishers =  new Publishers;
			$rsPublisher = $Publishers->find("email='".Yii::app()->request->getPost( 'Email' )."' AND password='".md5(Yii::app()->request->getPost( 'Password' ))."' AND status=1");
			if($rsPublisher):
				$rsPublisher->lastlogindate = date("Y-m-d H:i:s");
				$rsPublisher->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$rsPublisher->save();
				Yii::app()->session['UserID'] = $rsPublisher->publisherid;
				Yii::app()->session['UserType'] = "Contributor";
				$user = get_user_by( 'email', $rsPublisher->email );
				wp_setcookie($rsPublisher->email, Yii::app()->request->getPost( 'Password' ), true);
				wp_set_current_user($user->ID, $rsPublisher->email);	
				do_action('wp_login', $rsPublisher->email);
				return 2;
			else:
				Yii::app()->session['UserError'] = "Invalid Email id or Password.";
				return 0;
			endif;
		endif;
	}
	public function saveFbLogin($Perm){
		$rsUser = $this->find("email='".$Perm['email']."' AND status=1");
		if($rsUser):
			$rsUser->lastlogindate = date("Y-m-d H:i:s");
			$rsUser->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
			$rsUser->save();
			Yii::app()->session['UserID'] = $rsUser->userid;
			Yii::app()->session['UserType'] = "User";
			if(trim($rsUser->email)==""):
				return 4;
			endif;
			return 1;
		else:
			$Publishers =  new Publishers;
			$rsPublisher = $Publishers->find("email='".$Perm['email']."' AND status=1");
			if($rsPublisher):
				$rsPublisher->lastlogindate = date("Y-m-d H:i:s");
				$rsPublisher->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$rsPublisher->save();
				Yii::app()->session['UserID'] = $rsPublisher->publisherid;
				Yii::app()->session['UserType'] = "Contributor";
				if(trim($rsPublisher->email)==""):
					return 4;
				endif;
				return 2;
			else:
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'userid DESC';
				$Adm = $this->find($criteria);
					
				$NewAddID = $Adm->userid + 1;
				
				$Users = new Users;
				$Users->userid = $NewAddID ;
				$Users->firstname = $Perm['first_name'];
				$Users->lastname = $Perm['last_name'];
				$Users->email = $Perm['email'];
				$Users->facebookprofileid = $Perm['id'];
				$Users->registrationdate = date("Y-m-d H:i:s");
				$Users->lastlogindate = date("Y-m-d H:i:s");
				$Users->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$Users->status = 1;
				$Users->save();
				
				Yii::app()->session['UserID'] = $NewAddID;
				Yii::app()->session['UserType'] = "User";
				return 3;
			endif;
		endif;
	}
	public function saveTwLogin($Perm){
		$rsUser = $this->find("twitterprofileid='".$Perm->id."' AND status=1");
		if($rsUser):
			$rsUser->lastlogindate = date("Y-m-d H:i:s");
			$rsUser->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
			$rsUser->save();
			Yii::app()->session['UserID'] = $rsUser->userid;
			Yii::app()->session['UserType'] = "User";
			if(trim($rsUser->email)==""):
				return 3;
			endif;
			return 1;
		else:
			$Publishers =  new Publishers;
			$rsPublisher = $Publishers->find("twitterprofileid='".$Perm->id."' AND status=1");
			if($rsPublisher):
				$rsPublisher->lastlogindate = date("Y-m-d H:i:s");
				$rsPublisher->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$rsPublisher->save();
				Yii::app()->session['UserID'] = $rsPublisher->publisherid;
				Yii::app()->session['UserType'] = "Contributor";
				if(trim($rsPublisher->email)==""):
					return 3;
				endif;
				return 2;
			else:
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'userid DESC';
				$Adm = $this->find($criteria);
					
				$NewAddID = $Adm->userid + 1;
				$Names = explode(" ",$Perm->name);
				$Users = new Users;
				$Users->userid = $NewAddID ;
				$Users->firstname = $Names[0];
				$Users->lastname = $Names[1];
				$Users->twitterprofileid = $Perm->id;
				$Users->registrationdate = date("Y-m-d H:i:s");
				$Users->lastlogindate = date("Y-m-d H:i:s");
				$Users->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$Users->status = 1;
				$Users->save();
				
				Yii::app()->session['UserID'] = $NewAddID;
				Yii::app()->session['UserType'] = "User";
				return 3;
			endif;
		endif;
	}
	public function saveGpLogin($Perm){
		$rsUser = $this->find("email='".$Perm['email']."' AND status=1");
		if($rsUser):
			$rsUser->lastlogindate = date("Y-m-d H:i:s");
			$rsUser->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
			$rsUser->save();
			Yii::app()->session['UserID'] = $rsUser->userid;
			Yii::app()->session['UserType'] = "User";
			if(trim($rsUser->email)==""):
				return 4;
			endif;
			return 1;
		else:
			$Publishers =  new Publishers;
			$rsPublisher = $Publishers->find("email='".$Perm['email']."' AND status=1");
			if($rsPublisher):
				$rsPublisher->lastlogindate = date("Y-m-d H:i:s");
				$rsPublisher->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$rsPublisher->save();
				Yii::app()->session['UserID'] = $rsPublisher->publisherid;
				Yii::app()->session['UserType'] = "Contributor";
				if(trim($rsPublisher->email)==""):
					return 4;
				endif;
				return 2;
			else:
				$criteria = new CDbCriteria;
				$criteria->limit = 1;
				$criteria->order = 'userid DESC';
				$Adm = $this->find($criteria);
					
				$NewAddID = $Adm->userid + 1;
				
				$Users = new Users;
				$Users->userid = $NewAddID ;
				$Users->firstname = $Perm['given_name'];
				$Users->lastname = $Perm['family_name'];
				$Users->email = $Perm['email'];
				$Users->googleplusprofileid = $Perm['id'];
				$Users->gender = $Perm['gender'];
				$Users->profilepicture = $Perm['picture'];
				$Users->registrationdate = date("Y-m-d H:i:s");
				$Users->lastlogindate = date("Y-m-d H:i:s");
				$Users->lastloginipaddress = $_SERVER['REMOTE_ADDR'];
				$Users->status = 1;
				$Users->save();
				
				Yii::app()->session['UserID'] = $NewAddID;
				Yii::app()->session['UserType'] = "User";
				return 1;
			endif;
		endif;
	}
	public function saveEmail(){
		if(Yii::app()->session['UserType']=="User"):
			$rsUser = $this->find("UserID='".Yii::app()->session['UserID'] ."'");
			$rsUser->email = Yii::app()->request->getPost( 'Email' );
			$rsUser->save();
		else:
			$Publishers =  new Publishers;
			$rsPublishers = $Publishers->find("UserID='".Yii::app()->session['UserID']."'");
			$rsPublishers->email = Yii::app()->request->getPost( 'Email' );
			$rsPublishers->save();
		endif;
	}
	public function saveUser(){
		if(Yii::app()->session['UserType']=="Contributor"):
			$Users =  new Publishers;
		else:
			$Users = new Users;
		endif;
		$rsUser = $Users->findByPk(Yii::app()->session['UserID']);
		
		$rsUser->firstname = Yii::app()->request->getPost( 'FirstName' );
		$rsUser->lastname = Yii::app()->request->getPost( 'LastName' );
		$rsUser->email = Yii::app()->request->getPost( 'Email' );
		$rsUser->phone = Yii::app()->request->getPost( 'Phone' );
		$rsUser->aboutme = Yii::app()->request->getPost( 'AboutMe' );
		$rsUser->address = Yii::app()->request->getPost( 'Address' );
		$rsUser->address2 = Yii::app()->request->getPost( 'Address2' );
		$rsUser->city = Yii::app()->request->getPost( 'City' );
		$rsUser->state = Yii::app()->request->getPost( 'State' );
		$rsUser->country = Yii::app()->request->getPost( 'Country' );
		$rsUser->zipcode = Yii::app()->request->getPost( 'Zipcode' );
		$rsUser->gender = Yii::app()->request->getPost( 'Gender' );
		$rsUser->dateofbirth = Yii::app()->request->getPost( 'BirthDate' );
		$rsUser->save();
		
		$xuser = get_user_by( 'email', $rsUser->email );
		
		wp_update_user(array(
			"ID"		 => $xuser->ID,
			"user_login" => Yii::app()->request->getPost( 'Email' ),
			"user_email" => Yii::app()->request->getPost( 'Email' ),
			"first_name" => Yii::app()->request->getPost( 'FirstName' ),
			"last_name"  => Yii::app()->request->getPost( 'LastName' ),
			"description"=> Yii::app()->request->getPost( 'AboutMe' ),
		));
		Yii::app()->session['UserSuccess'] = "Profile updated successfully.";
	}
	public function saveProfileImage(){
		$path = $_FILES['myfile']['name'];
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		if(Yii::app()->session['UserType']=="Contributor"):
			$Users =  new Publishers;
			$ImageName = "creator/".Yii::app()->session['UserID'].".".$ext;
			if (!file_exists("assets/users/creator/")):
				mkdir("assets/users/creator/", 0777);
			endif;
		else:
			$Users = new Users;
			$ImageName = "user/".Yii::app()->session['UserID'].".".$ext;
			if (!file_exists("assets/users/user/")):
				mkdir("assets/users/user/", 0777);
			endif;
		endif;
		$rsUser = $Users->findByPk(Yii::app()->session['UserID']);
		copy($_FILES['myfile']['tmp_name'],'assets/users/'.$ImageName);
		$rsUser->profilepicture = Yii::app()->session['UserID'].'.'.$ext;
		$rsUser->save();
		Yii::import('ext.iwi.Iwi');
        $MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/".$ImageName)->adaptive(150,150)->cache();
		return '<img src="'.$MainPicture.'" alt="" />';
	}
	public function changePassword(){
		if(Yii::app()->session['UserType']=="Contributor"):
			$Users =  new Publishers;
		else:
			$Users = new Users;
		endif;
		$rsUser = $Users->findByPk(Yii::app()->session['UserID']);
		if(md5(Yii::app()->request->getPost( 'CurrentPassword' ))!=$rsUser->password):
			Yii::app()->session['UserError'] = "Current Password is invalid.";
				return;
		endif;
		
		if(trim(Yii::app()->request->getPost( 'CurrentPassword' ))==trim(Yii::app()->request->getPost( 'NewPassword' ))):
			Yii::app()->session['UserError'] = "Current Password and New Password must not be same.";
				return;
		endif;
		
		if(trim(Yii::app()->request->getPost( 'ConfirmPassword' ))!=trim(Yii::app()->request->getPost( 'NewPassword' ))):
			Yii::app()->session['UserError'] = "New Password and Confrim Password mest be same.";
				return;
		endif;
		$rsUser->password = md5(Yii::app()->request->getPost( 'CurrentPassword' ));
		$rsUser->save();
		$xuser = get_user_by( 'email', $rsUser->email );
		
		wp_update_user(array(
			"ID"		 => $xuser->ID,
			"user_pass" => Yii::app()->request->getPost( 'NewPassword' ),
		));
		
		Yii::app()->session['UserSuccess'] = "Password updated successfully.";
		return;
	}
	public function updateNotifications(){
		if(Yii::app()->session['UserType']=="Contributor"):
			$Users =  new Publishers;
		else:
			$Users = new Users;
		endif;
		$rsUser = $Users->findByPk(Yii::app()->session['UserID']);
		$rsUser->projectslove =  Yii::app()->request->getPost( 'ProjectsLove' );
		$rsUser->whatshappening =  Yii::app()->request->getPost( 'WhatsHappening' );
		$rsUser->newsevents =  Yii::app()->request->getPost( 'NewsEvents' );
		$rsUser->projectsupdate =  Yii::app()->request->getPost( 'ProjectsUpdate' );
		if(Yii::app()->session['UserType']=="Contributor"):
			$rsUser->newpledges =  Yii::app()->request->getPost( 'NewPledges' );
			$rsUser->newcomments =  Yii::app()->request->getPost( 'NewComments' );
			$rsUser->newlikes =  Yii::app()->request->getPost( 'NewLikes' );
		endif;
		$rsUser->save();
		Yii::app()->session['UserSuccess'] = "Notifications updated successfully.";
	}
}