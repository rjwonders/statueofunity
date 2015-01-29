<?php
class Publishers extends CActiveRecord{
	public function relations(){
		return array();
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public function tableName(){
		return '{{publishers}}';
	}
	
	public function savePublisher(){
		if(Yii::app()->request->getPost( 'PublisherID' )){
			$criteria = new CDbCriteria;
			$criteria->condition	= "publisherid=".Yii::app()->request->getPost( 'PublisherID' );
			$Pub = $this->find($criteria);
			$Pub->publisherid = Yii::app()->request->getPost( 'PublisherID' );
			$Pub->firstname = Yii::app()->request->getPost( 'FirstName' );
			$Pub->lastname = Yii::app()->request->getPost( 'LastName' );
			$Pub->email = Yii::app()->request->getPost( 'Email' );
			if(trim(Yii::app()->request->getPost( 'Password' ))!=''):
				$Pub->password = md5(Yii::app()->request->getPost( 'Password' ));
			endif;
			$Pub->status = Yii::app()->request->getPost( 'Status' );
			$Pub->save();
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Campaigner(".Yii::app()->request->getPost( 'FirstName' )." ".Yii::app()->request->getPost( 'LastName' ).", ID=".Yii::app()->request->getPost( 'PublisherID' ).") has been updated by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			if($Pub->publisherid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/creator/")) {
					mkdir("assets/users/creator/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/creator/'.$Pub->publisherid.'.'.$ext);
				$Pub->profilepicture = $Pub->publisherid.'.'.$ext;
				$Pub->save();
            }
		} else {
			/*$Streams = new streamsend;
			$fname = "Nilay"; 
			$lname = "Patel";
			$email = "nilay@dswtpl.com";
			$xml = "<blast><from><owner></owner><name>Rahul Bhatt</name><email-address>rahul@dswtpl.com</email-address></from><to><audience-id>1</audience-id></to><subject>My First Blast</subject><body><html-part>Hello All</html-part></body><options><track-views>true</track-views><track-clicks>true</track-clicks><include-social-bar>false</include-social-bar></options><scheduled-for>2014-10-10T10:10:10Z</scheduled-for></blast>";
			$Data = $Streams->SendRequest($xml, 'POST', "/audiences/1/blasts.xml");
			print_r($Data);
			exit;*/
			
			$criteria = new CDbCriteria;
			$criteria->limit = 1;
			$criteria->order = 'publisherid DESC';
			$Pub = $this->find($criteria);
			
			$NewAddID = $Pub->publisherid + 1;
			
			$this->publisherid = $NewAddID;
			$this->firstname = Yii::app()->request->getPost( 'FirstName' );
			$this->lastname = Yii::app()->request->getPost( 'LastName' );
			$this->email = Yii::app()->request->getPost( 'Email' );
			$this->password = md5(Yii::app()->request->getPost( 'Password' ));
			$this->status = Yii::app()->request->getPost( 'Status' );
			$this->registartiondate = date("Y-m-d H:i:s");
			$this->save();
			
			$criteria = new CDbCriteria;
			$criteria->condition	= "adminid=".Yii::app()->session['AdminID'];
			$Admin = new Admin;
			$Admins = $Admin->find($criteria);
			
			$Text = "Campaigner(".Yii::app()->request->getPost( 'FirstName' )." ".Yii::app()->request->getPost( 'LastName' ).", ID=".Yii::app()->request->getPost( 'PublisherID' ).") has been added by ".$Admins->firstname." ".$Admins->lastname."(".$Admins->email.") from IP ".$_SERVER['REMOTE_ADDR']." at ".date("d M, Y h:i:s A")."\n";
			$General = new General;
			$General->addLog($Text);
			
			if($this->publisherid){
				$sg=Yii::app()->sendgrid;
				$message = $sg->createEmail();  
				$message  
					->setView('register')  
					->setHtml(array(  
						'Name'=> Yii::app()->request->getPost( 'FirstName' ),
						'Email'=> Yii::app()->request->getPost( 'Email' ),
						'Password'=> Yii::app()->request->getPost( 'Password' ),
						'SiteLink'=> Yii::app()->createAbsoluteUrl("user/login"),
					));  
				$message->setSubject('Welcome to Statue of Unity!')  
					->addTo(Yii::app()->request->getPost( 'Email' ))  
					->setFrom(Yii::app()->params['adminEmail']);
					  
				if(!$sg->send($message)){
					Yii::log("Failed to send email:\n".print_r($sg->lastErrors,true) ,CLogger::LEVEL_ERROR);
				}
			}
			if($this->publisherid && $_FILES['FilePath']['name']!=''){
				if (!file_exists("assets/users/creator/")) {
					mkdir("assets/users/creator/", 0777);
				}
				$path = $_FILES['FilePath']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				copy($_FILES['FilePath']['tmp_name'],'assets/users/creator/'.$this->publisherid.'.'.$ext);
				$this->profilepicture = $this->publisherid.'.'.$ext;
				$this->save();
            }
		}
	}
}