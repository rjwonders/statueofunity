<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/style.default.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/colorpicker.css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/jquery.gritter.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/prettyPhoto.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/bootstrap-fileupload.min.css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/jquery.datatables.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/jquery.tagsinput.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin/jquery-ui-1.10.3.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/html5shiv.js"></script>
      	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<?php if(isset(Yii::app()->session['AdminID'])): ?>
	<body class="stickyheader">
<?php else: ?>
	<body class="signin">
<?php endif; ?>
<input type="hidden" id="SiteURL" value="<?php echo Yii::app()->request->baseUrl; ?>">
    <div id="preloader">
        <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
    </div>
    <?php if(isset(Yii::app()->session['AdminID'])): ?>
    	<?php $this->widget('SidebarWidget'); ?>
        <div class="mainpanel">
        	<?php $this->widget('HeaderWidget'); ?>
            <?php echo $content; ?>
    	</div>
	<?php else: ?>
    <section>
  		<div class="signinpanel">
        	<?php echo $content; ?>
		</div>
	</section>
    <?php endif; ?>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery-1.10.2.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery-migrate-1.2.1.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery-ui-1.10.3.min.js"></script>
    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/bootstrap.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/modernizr.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.sparkline.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/toggles.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/retina.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.cookies.js"></script>
    
    <?php /*?><script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/flot/flot.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/flot/flot.resize.min.js"></script><?php */?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/morris.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/raphael-2.1.0.min.js"></script>
    
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.tagsinput.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.datatables.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/bootstrap-fileupload.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/chosen.jquery.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/wysihtml5-0.3.0.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/bootstrap-wysihtml5.js"></script>
   	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.gritter.min.js"></script>
   	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.prettyPhoto.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/colorpicker.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/ckeditor/ckeditor.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/bootstrap-wizard.min.js"></script>
	<script>
    jQuery(document).ready(function(){
        jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});
		
		jQuery('#tags').tagsInput({width:'auto'});
		 
		jQuery('#table').dataTable({
		  "sPaginationType": "full_numbers",
		  "bSort": false
		});
		
		jQuery('#basicWizard').bootstrapWizard();
		
		if(jQuery('#colorpicker').length > 0) {
			 jQuery('#colorSelector').ColorPicker({
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						jQuery('#colorSelector span').css('backgroundColor', '#' + hex);
						jQuery('#colorpicker').val('#'+hex);
					}
			 });
		  }
		<?php if(isset(Yii::app()->session['AdminSuccess'])): ?>
			jQuery.gritter.add({
				title: 'Success!',
				text: '<?php echo Yii::app()->session['AdminSuccess']; ?>',
				class_name: 'growl-success',
				image: '<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/success.png',
				sticky: false,
				time: ''
			 });
		 <?php
		 	unset(Yii::app()->session['AdminSuccess']);
		 endif;
		 ?>
		 <?php if(isset(Yii::app()->session['AdminError'])): ?>
			jQuery.gritter.add({
				title: 'Error!',
				text: '<?php echo Yii::app()->session['AdminError']; ?>',
				class_name: 'growl-danger',
				image: '<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/error.png',
				sticky: false,
				time: ''
			 });
		 <?php
		 	unset(Yii::app()->session['AdminError']);
		 endif;
		 ?>
		jQuery('.thmb').hover(function(){
		  var t = jQuery(this);
		  t.find('.ckbox').show();
		  t.find('.fm-group').show();
		}, function() {
		  var t = jQuery(this);
		  if(!t.closest('.thmb').hasClass('checked')) {
			t.find('.ckbox').hide();
			t.find('.fm-group').hide();
		  }
		});
		
		jQuery('.ckbox').each(function(){
		  var t = jQuery(this);
		  var parent = t.parent();
		  if(t.find('input').is(':checked')) {
			t.show();
			parent.find('.fm-group').show();
			parent.addClass('checked');
		  }
		});
		
		
		jQuery('.ckbox').click(function(){
		  var t = jQuery(this);
		  if(!t.find('input').is(':checked')) {
			t.closest('.thmb').removeClass('checked');
			enable_itemopt(false);
		  } else {
			t.closest('.thmb').addClass('checked');
			enable_itemopt(true);
		  }
		});
		
		jQuery('#selectall').click(function(){
		  if(jQuery(this).is(':checked')) {
			jQuery('.thmb').each(function(){
			  jQuery(this).find('input').attr('checked',true);
			  jQuery(this).addClass('checked');
			  jQuery(this).find('.ckbox, .fm-group').show();
			});
			enable_itemopt(true);
		  } else {
			jQuery('.thmb').each(function(){
			  jQuery(this).find('input').attr('checked',false);
			  jQuery(this).removeClass('checked');
			  jQuery(this).find('.ckbox, .fm-group').hide();
			});
			enable_itemopt(false);
		  }
		});
		
		function enable_itemopt(enable) {
		  if(enable) {
			jQuery('.itemopt').removeClass('disabled');
		  } else {
			
			// check all thumbs if no remaining checks
			// before we can disabled the options
			var ch = false;
			jQuery('.thmb').each(function(){
			  if(jQuery(this).hasClass('checked'))
				ch = true;
			});
			
			if(!ch)
			  jQuery('.itemopt').addClass('disabled');
		  }
		}
		
		//Replaces data-rel attribute to rel.
		//We use data-rel because of w3c validation issue
		jQuery('a[data-rel]').each(function() {
		  jQuery(this).attr('rel', jQuery(this).data('rel'));
		});
		
		jQuery("a[rel^='prettyPhoto']").prettyPhoto();
		
		jQuery('.wysiwyg').wysihtml5({color: true,html:true});
		
		jQuery('#datepicker-multiple').datepicker({
			numberOfMonths: 3,
			showButtonPanel: true
		});
		jQuery("select").chosen({
      		'min-width': '100px',
      		'white-space': 'nowrap',
      		disable_search_threshold: 10
    	});
		jQuery('.table-hidaction tbody tr').hover(function(){
		  jQuery(this).find('.table-action-hide a').animate({opacity: 1});
		},function(){
		  jQuery(this).find('.table-action-hide a').animate({opacity: 0});
		});
		
		
    });
	CKEDITOR.config.allowedContent = true;
    </script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/multifield.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/validator.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/jquery.form.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/custom.js"></script>
    <?php /*?><script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin/dashboard.js"></script><?php */?>
</body>
</html>