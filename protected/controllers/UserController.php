<?php
class UserController extends Controller
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
	public function actionLogin(){
		$this->CheckNoLogin();
		$this->render('login');
	}
	public function actionLogout(){
		unset(Yii::app()->session['UserID']);
		unset(Yii::app()->session['UserType']);
		wp_logout();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
	}
	public function CheckLogin(){
		if(!isset(Yii::app()->session['UserID']) || !isset(Yii::app()->session['UserType'])){
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		}
	}
	public function CheckNoLogin(){
		if(isset(Yii::app()->session['UserID']) && isset(Yii::app()->session['UserType'])){
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		}
	}
	public function actionsignup(){
		$Users =  new Users;
		$Users->saveUsers();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
	}
	public function actionActivateAccount($UniqueCode=""){
		if(trim($UniqueCode)==''):
			$this->redirect(Yii::app()->getBaseUrl(true).'/general/404');
		endif;
		$Users =  new Users;
		$MyAccount = $Users->activateAccount();
		if($MyAccount==0):
			$this->redirect(Yii::app()->getBaseUrl(true).'/general/404');
		else:
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		endif;
	}
	public function actionLogsin(){
		$Users =  new Users;
		$MsgCode = $Users->Login();
		if($MsgCode==1):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		elseif($MsgCode==2):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		else:
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		endif;
	}
	public function actionFbLogin(){
		require(__DIR__ . '/../extensions/facebook/facebook.php');
		$facebook = new Facebook(array(
		  'appId'  => Yii::app()->params['fbappid'],
		  'secret' => Yii::app()->params['fbappsecret'],
		));
		$params = array(
		  'scope' => 'email, read_stream, friends_likes, user_friends',
		  'redirect_uri' => Yii::app()->createAbsoluteUrl("user/fbLoginAccept")
		);
		$loginUrl = $facebook->getLoginUrl($params);
		$this->redirect($loginUrl);
	}
	public function actionFbLoginAccept(){
		require(__DIR__ . '/../extensions/facebook/facebook.php');
		$facebook = new Facebook(array(
		  'appId'  => Yii::app()->params['fbappid'],
		  'secret' => Yii::app()->params['fbappsecret'],
		));
		$user = $facebook->getUser();
		if ($user) {
			try {
				$user_profile = $facebook->api('/me');
				$Users = new Users;
				$MsgCode = $Users->saveFbLogin($user_profile);
				if($MsgCode==1):
					$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
				elseif($MsgCode==2):
					$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
				elseif($MsgCode==3):
					$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
				elseif($MsgCode==4):
					$this->redirect(Yii::app()->getBaseUrl(true).'/user/setEmail');
				else:
					$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
				endif;
		  	} catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
		  	}
		}
	}
	public function actionTwLogin(){
		unset(Yii::app()->session['oauth_token']);
		unset(Yii::app()->session['oauth_token_secret']);
		unset(Yii::app()->session['access_token']['oauth_token']);
		unset(Yii::app()->session['access_token']['oauth_token_secret']);
		unset(Yii::app()->session['access_token']);
		require(__DIR__ . '/../extensions/twitter/twitteroauth/twitteroauth.php');
		$connection = new TwitterOAuth(Yii::app()->params['twconsumerkey'], Yii::app()->params['twconsumersecret']);
		$request_token = $connection->getRequestToken(Yii::app()->createAbsoluteUrl("user/twLoginAccept"));
		Yii::app()->session['oauth_token'] = $token = $request_token['oauth_token'];
		Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];
		$loginUrl = $connection->getAuthorizeURL($token);
		$this->redirect($loginUrl);
	}
	public function actionTwLoginAccept(){
		require(__DIR__ . '/../extensions/twitter/twitteroauth/twitteroauth.php');
		if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
			Yii::app()->session['UserError'] = "Error occured. Please try again leter.";
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		}
		$connection = new TwitterOAuth(Yii::app()->params['twconsumerkey'], Yii::app()->params['twconsumersecret'], Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		Yii::app()->session['access_token'] = $access_token;

		unset(Yii::app()->session['oauth_token']);
		unset(Yii::app()->session['oauth_token_secret']);
		
		$content = $connection->get('account/verify_credentials');
		$Users = new Users;
		$MsgCode = $Users->saveTwLogin($content);
		if($MsgCode==1):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		elseif($MsgCode==2):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		elseif($MsgCode==3):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/setEmail');
		else:
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		endif;
	}
	public function actionGpLogin(){
		require dirname(__FILE__).'/gplus/src/Google/Client.php';
		require dirname(__FILE__).'/gplus/src/Google/Config.php';
		require dirname(__FILE__).'/gplus/src/Google/Auth/Abstract.php';
		require dirname(__FILE__).'/gplus/src/Google/Exception.php';
		require dirname(__FILE__).'/gplus/src/Google/Auth/Exception.php';
		require dirname(__FILE__).'/gplus/src/Google/Auth/OAuth2.php';
		require dirname(__FILE__).'/gplus/src/Google/Auth/LoginTicket.php';
		require dirname(__FILE__).'/gplus/src/Google/Http/Request.php';
		require dirname(__FILE__).'/gplus/src/Google/Http/CacheParser.php';
		require dirname(__FILE__).'/gplus/src/Google/Utils.php';
		require dirname(__FILE__).'/gplus/src/Google/IO/Abstract.php';
		require dirname(__FILE__).'/gplus/src/Google/IO/Curl.php';
		require dirname(__FILE__).'/gplus/src/Google/Logger/Abstract.php';
		require dirname(__FILE__).'/gplus/src/Google/Logger/Null.php';
		require dirname(__FILE__).'/gplus/src/Google/Cache/Abstract.php';
		require dirname(__FILE__).'/gplus/src/Google/Cache/File.php';
		require dirname(__FILE__).'/gplus/src/Google/Verifier/Abstract.php';
		require dirname(__FILE__).'/gplus/src/Google/Verifier/Pem.php';
		
		
		//require_once realpath(dirname(__FILE__)  . '/../extensions/gplus/autoload.php');
		//Yii::registerAutoloader(array('google_api_php_client_autoload','autoload'));
		
		$client_id = '897853188352-sov4hsk1mcdcd2vgugf9403t9o5itvbi.apps.googleusercontent.com';
		$client_secret = 'Dg2jxotE84dtGyRiKCzXfzkx';
		$redirect_uri = 'http://localhost/sou/user/gpLogin';
		
		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'));
		
		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
		  	Yii::app()->session['access_token'] = $client->getAccessToken();
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/gpLoginAccept');
		}
		if (isset(Yii::app()->session['access_token']) && Yii::app()->session['access_token']) {
  			$client->setAccessToken(Yii::app()->session['access_token']);
		} else {
 			$authUrl = $client->createAuthUrl();
			$this->redirect($authUrl);
		}
		if ($client->getAccessToken()) {
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/gpLoginAccept');
		}
	}
	public function actionGpLoginAccept(){
		$Access = json_decode(Yii::app()->session['access_token']);
		$q = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$Access->access_token;
		$json = file_get_contents($q);
		$userInfoArray = json_decode($json,true);
		
		$Users = new Users;
		$MsgCode = $Users->saveGpLogin($userInfoArray);
		if($MsgCode==1):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		elseif($MsgCode==2):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
		elseif($MsgCode==3):
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/setEmail');
		else:
			$this->redirect(Yii::app()->getBaseUrl(true).'/user/login');
		endif;
	}
	public function actionSetEmail(){
		$this->CheckLogin();
		$this->render('set-email');
	}
	public function actionSetEmails(){
		$this->CheckLogin();
		$Users = new Users;
		$MsgCode = $Users->saveEmail();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/dashboard');
	}
	public function actionDashboard(){
		$this->CheckLogin();
		$this->render('dashboard');
	}
	public function actionProfile(){
		$this->CheckLogin();
		if(Yii::app()->session['UserType']=="Contributor"):
			$Publishers =  new Publishers;
			$rsProfile = $Publishers->findByPk(Yii::app()->session['UserID']);
		else:
			$User = new Users;
			$rsProfile = $User->findByPk(Yii::app()->session['UserID']);
		endif;
		$Country =  new Country;
		$rsCountry = $Country->findAll("status=1");
		
		$rsState = array();
		if($rsProfile->country!='' && $rsProfile->country!=0):
			$State =  new State;
			$rsState = $State->findAll("status=1 AND countryid='".$rsProfile->country."'");
		endif;
		$this->render('profile',array("rsProfile"=>$rsProfile, "rsCountry"=>$rsCountry, "rsState"=>$rsState));
	}
	public function actionEditProfile(){
		$this->CheckLogin();
		$User = new Users;
		$rsProfile = $User->saveUser();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/profile');
	}
	public function actionGetStates(){
		$State =  new State;
		$rsState = $State->findAll("status=1 AND countryid='".Yii::app()->request->getPost( 'CountryID' )."'");
		$MyRes = $this->renderPartial('get-states',array("rsState"=>$rsState));
		echo $MyRes;
	}
	public function actionProfileImage(){
		$User = new Users;
		echo $rsProfile = $User->saveProfileImage();
	}
	public function actionChangePassword(){
		$User = new Users;
		$User->changePassword();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/profile');
	}
	public function actionNotification(){
		$this->CheckLogin();
		if(Yii::app()->session['UserType']=="Contributor"):
			$Publishers =  new Publishers;
			$rsProfile = $Publishers->findByPk(Yii::app()->session['UserID']);
		else:
			$User = new Users;
			$rsProfile = $User->findByPk(Yii::app()->session['UserID']);
		endif;
		$this->render('notification',array("rsProfile"=>$rsProfile));
	}
	public function actionUpdateNotifications(){
		$User = new Users;
		$User->updateNotifications();
		$this->redirect(Yii::app()->getBaseUrl(true).'/user/notification');
	}
}
