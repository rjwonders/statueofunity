<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title>Welcome To Statue of Unity</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/style.css">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/jquery.gritter.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/bootstrap-theme.css">
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,700,900' rel='stylesheet' type='text/css'>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/jquery.bxslider.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/media.css">
   <?php wp_head(); ?> 
</head>
<body>
	<div id="fb-root"></div>
	<script language="javascript" type="text/javascript">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    </script>
	<div id="loaders" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/loaders/loader4.gif" /></div>
	<input type="hidden" id="BaseURL" value="<?php echo Yii::app()->getBaseUrl(true); ?>" />
    <?php 
		$controller = Yii::app()->getController();
		$CurrentController = $controller->id;
		$default_controller = Yii::app()->defaultController;
		if(($CurrentController == $default_controller) && ($controller->action->id == $controller->defaultAction)):
			$this->widget('HomeHeaderWidget');
		else:
			$this->widget('InnerHeaderWidget');
		endif; ?>
	<?php echo $content; ?>
    <?php //$this->widget('MakeHappenWidget'); ?>
    <footer>
    	<?php //$this->widget('NewsletterWidget'); ?>
        <?php $this->widget('Footer1Widget'); ?>
		<?php $this->widget('Footer2Widget'); ?>
    </footer>
    
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/tabs.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.gritter.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.form.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js//jquery.bxslider.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/functions.js"></script>
    <script language="javascript" type="text/javascript">
		<?php if(isset(Yii::app()->session['UserSuccess'])): ?>
			jQuery.gritter.add({
				title: 'Success!',
				text: '<?php echo Yii::app()->session['UserSuccess']; ?>',
				class_name: 'growl-success',
				image: '<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/success.png',
				sticky: false,
				time: ''
			 });
		 <?php
		 	unset(Yii::app()->session['UserSuccess']);
		 endif;
		 ?>
		 <?php if(isset(Yii::app()->session['UserError'])): ?>
			jQuery.gritter.add({
				title: 'Error!',
				text: '<?php echo Yii::app()->session['UserError']; ?>',
				class_name: 'growl-danger',
				image: '<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/error.png',
				sticky: false,
				time: ''
			 });
		 <?php
		 	unset(Yii::app()->session['UserError']);
		 endif;
		 ?>
    </script>
    <?php wp_footer(); ?>
</body>
</html>