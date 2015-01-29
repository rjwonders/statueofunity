<div class="headerbar">
      
      <a class="menutoggle"><i class="fa fa-bars"></i></a>
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php 
				if(trim($admins->profilepicture)!='' && file_exists(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$admins->profilepicture)):
					Yii::import('ext.iwi.Iwi');
					$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/users/admin/".$admins->profilepicture);
					$picture->resize(0,24, Iwi::NONE);
				?>
					<img src="<?php echo $picture->cache(); ?>" alt="" />
				<?php else: ?>
				  <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/admin/photos/loggeduser.png">
				<?php endif; ?>
                <?php echo $admins->firstname; ?> <?php echo $admins->lastname; ?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                <li><a href="<?php echo Yii::app()->createUrl("webend/admins/AdminID/".Yii::app()->session['AdminID']); ?>"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                <li><a href="<?php echo Yii::app()->createUrl("webend/logout"); ?>"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
              </ul>
            </div>
          </li>
          
        </ul>
      </div><!-- header-right -->
      
    </div>