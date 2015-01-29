<?php $controller = Yii::app()->getController();?>
<div class="ac-menu">
  <ul>
      <li <?php if($controller->action->id == "dashboard"): ?> class="active" <?php endif; ?>>
          <a href="<?php echo Yii::app()->createUrl("user/dashboard"); ?>">
              <span class="menu-icon-one"></span>
              <?php echo Yii::app()->vars->myLang['Dashboard']; ?>
          </a>
      </li>
      <?php if(Yii::app()->session['UserType']=='Contributor'): ?>
          <li <?php if($controller->action->id == "projects"): ?> class="active" <?php endif; ?>>
              <a href="<?php echo Yii::app()->createUrl("user/projects"); ?>">
                  <span class="menu-icon-two"></span>
                  <?php echo Yii::app()->vars->myLang['My Projects']; ?>
              </a>
          </li>
      <?php endif; ?>
      <li <?php if($controller->action->id == "messages"): ?> class="active" <?php endif; ?>>
          <a href="<?php echo Yii::app()->createUrl("user/messages"); ?>">
              <span class="menu-icon-three"></span>
              <?php echo Yii::app()->vars->myLang['My Messages']; ?>
          </a>
      </li>
      <li <?php if($controller->action->id == "profile"): ?> class="active" <?php endif; ?>>
          <a href="<?php echo Yii::app()->createUrl("user/profile"); ?>">
              <span class="menu-icon-four"></span>
              <?php echo Yii::app()->vars->myLang['My Profile']; ?>
          </a>
      </li>
      <li <?php if($controller->action->id == "notification"): ?> class="active" <?php endif; ?>>
          <a href="<?php echo Yii::app()->createUrl("user/notification"); ?>">
              <span class="menu-icon-five"></span>
              <?php echo Yii::app()->vars->myLang['Notifications']; ?>
          </a>
      </li>
      <li <?php if($controller->action->id == "invite"): ?> class="active" <?php endif; ?>>
          <a href="<?php echo Yii::app()->createUrl("user/invite"); ?>">
              <span class="menu-icon-six"></span>
              <?php echo Yii::app()->vars->myLang['Invite Friends']; ?>
          </a>
      </li>
  </ul>	
  <div class="cl"></div>
</div>