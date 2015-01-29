<?php $method = Yii::app()->controller->action->id; ?>
<div class="leftpanel">
  <div class="logopanel">
      <h1>Statue Of Unity</h1>
  </div><!-- logopanel -->
  <div class="leftpanelinner">    
      <div class="visible-xs hidden-sm hidden-md hidden-lg">   
          <div class="media userlogged">
          	<?php 
			if(trim($admins->profilepicture)!='' && file_exists(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$admins->profilepicture)):
				Yii::import('ext.iwi.Iwi');
				$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$admins->profilepicture);
				$picture->resize(0,24, Iwi::NONE);
			?>
            	<img src="<?php echo $picture->cache(); ?>" alt="" />
        	<?php else: ?>
              <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/photos/loggeduser.png" class="media-object">
            <?php endif; ?>
              <div class="media-body">
                  <h4><?php echo $admins->firstname; ?> <?php echo $admins->lastname; ?></h4>
              </div>
          </div>
        
          <h5 class="sidebartitle actitle">Account</h5>
          <ul class="nav nav-pills nav-stacked nav-bracket mb30">
            <li><a href="<?php echo Yii::app()->createUrl("webend/admins/AdminID/".Yii::app()->session['AdminID']); ?>"><i class="fa fa-user"></i> <span>Profile</span></a></li>
            <!--<li><a href="#"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>-->
            <li><a href="<?php echo Yii::app()->createUrl("webend/logout"); ?>"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
          </ul>
      </div>
    
        <h5 class="sidebartitle">Navigation</h5>
        <ul class="nav nav-pills nav-stacked nav-bracket">
          <li <?php if($method=="dashboard"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/dashboard"); ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
          <?php if(Yii::app()->session['UserTypeID']==1): ?>
          	 <li class="nav-parent <?php if($method=="admin" || $method=="admins" || $method=="creator" || $method=="creators"): ?>nav-active active<?php endif; ?>"><a href="#"><i class="fa fa-users"></i> <span>Users</span></a>
                <ul class="children" <?php if($method=="admin" || $method=="admins" || $method=="creator" || $method=="creators"): ?> style="display:block;"<?php endif; ?>>
                    
                        <li <?php if($method=="admin" || $method=="admins"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/admin"); ?>"><i class="fa fa-caret-right"></i> <span>System Admin/Editor</span></a></li>
                        <li <?php if($method=="creator" || $method=="creators"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/creator"); ?>"><i class="fa fa-caret-right"></i> <span>Campaigner</span></a></li> 
                </ul>
         	</li>
		 <?php endif; ?>
         <li class="nav-parent <?php if($method=="category" || $method=="category" || $method=="project" || $method=="projects" || $method=="projectImages" || $method=="projectVideos" || $method=="projectUpdates" || $method=="projectFAQs"): ?>nav-active active<?php endif; ?>"><a href="#"><i class="fa fa-rupee"></i> <span>Projects</span></a>
            <ul class="children" <?php if($method=="category" || $method=="category" || $method=="project" || $method=="projects" || $method=="projectImages" || $method=="projectVideos" || $method=="projectUpdates" || $method=="projectFAQs"): ?> style="display:block;"<?php endif; ?>>
            	<?php if(Yii::app()->session['UserTypeID']==1): ?>
            		<li <?php if($method=="category" || $method=="categorys"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/category"); ?>"><i class="fa fa-caret-right"></i> <span>Category</span></a></li>
                <?php endif; ?>
                <li <?php if($method=="project" || $method=="projects" || $method=="projectImages" || $method=="projectVideos" || $method=="projectUpdates" || $method=="projectFAQs"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/project"); ?>"><i class="fa fa-caret-right"></i> <span>Project</span></a></li> 
            </ul>
         </li>
         <?php if(Yii::app()->session['UserTypeID']==1): ?>
         	<li class="nav-parent <?php if($method=="language" || $method=="languages" || $method=="languageText" || $method=="settings" || $method=="cms" || $method=="cmss" || $method=="testimonial" || $method=="testimonials"): ?>nav-active active<?php endif; ?>"><a href="#"><i class="fa fa-gears"></i> <span>Settings</span></a>
                <ul class="children" <?php if($method=="language" || $method=="languages" || $method=="languageText" || $method=="settings" || $method=="testimonial" || $method=="testimonials"): ?> style="display:block;"<?php endif; ?>>
                    	<li <?php if($method=="settings"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/settings"); ?>"><i class="fa fa-caret-right"></i> <span>General Settings</span></a></li>
                        <li <?php if($method=="language" || $method=="languages" || $method=="languageText"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/language"); ?>"><i class="fa fa-caret-right"></i> <span>Languages</span></a></li>
                        <li <?php if($method=="cms" || $method=="cmss"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/cms"); ?>"><i class="fa fa-caret-right"></i> <span>CMS</span></a></li>
                        <li <?php if($method=="testimonial" || $method=="testimonials"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/testimonial"); ?>"><i class="fa fa-caret-right"></i> <span>Testimonial</span></a></li>
                       
                </ul>
         	</li>
		<?php endif; ?>
        <?php if(Yii::app()->session['UserTypeID']==1): ?>
         	<li class="nav-parent <?php if($method=="images" || $method=="videos"): ?>nav-active active<?php endif; ?>"><a href="#"><i class="fa fa-desktop"></i> <span>Gallery</span></a>
                <ul class="children" <?php if($method=="images" || $method=="videos"): ?> style="display:block;"<?php endif; ?>>
                    	<li <?php if($method=="images"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/images"); ?>"><i class="fa fa-caret-right"></i> <span>Image Gallery</span></a></li>
                        <li <?php if($method=="videos"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/videos"); ?>"><i class="fa fa-caret-right"></i> <span>Video Gallery</span></a></li>
                       
                </ul>
         	</li>
		<?php endif; ?>
        <?php if(Yii::app()->session['UserTypeID']==1): ?>
        	<li <?php if($method=="logs"): ?> class="active" <?php endif; ?>><a href="<?php echo Yii::app()->createUrl("webend/logs"); ?>"><i class="fa fa-eye"></i> <span>Logs</span></a></li>  
        <?php endif; ?>
	</ul>
	</div><!-- leftpanelinner -->
</div>
