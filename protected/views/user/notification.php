<section class="contentpart">
	<div class="wrapper">
    	<div class="accountpart">
        	<?php $this->widget('AccountHeaderWidget'); ?>
            <div class="ac-content">
            	<div class="sms-title">
            		<h3><?php echo Yii::app()->vars->myLang['Notifications']; ?></h3>	
                    
                    <div class="cl"></div>
                </div>
                
                <div class="notif-part">
                	<form method="post" action="<?php echo Yii::app()->createUrl("user/updateNotifications"); ?>">
                	<div class="notif-one">
                    	<div class="notif-title">
                        	<h3><?php echo Yii::app()->vars->myLang['Subscriptions']; ?>:</h3>
                        </div>
                        <div class="notif-content">
                        	<ul>
                            	<li>
                                	<input type="checkbox" name="ProjectsLove" value="1" id="ProjectsLove" <?php if($rsProfile->projectslove==1): ?> checked="checked" <?php endif; ?>>
                                    <h4><label for="ProjectsLove"><?php echo Yii::app()->vars->myLang['Projects We Love (weekly)']; ?></label></h4>
                                    <h5><?php echo Yii::app()->vars->myLang['Projects we think are creative, inspiring, and fun']; ?></h5>
                                    <div class="cl"></div>
                                </li>
                                <li>
                                	<input type="checkbox" name="WhatsHappening" value="1" id="WhatsHappening" <?php if($rsProfile->whatshappening==1): ?> checked="checked" <?php endif; ?>>
                                    <h4><label for="WhatsHappening"><?php echo Yii::app()->vars->myLang['Happening (twice weekly)']; ?></label></h4>
                                    <h5><?php echo Yii::app()->vars->myLang['Arts and culture from the Kickstarter universe and beyond']; ?></h5>
                                    <div class="cl"></div>
                                </li>
                                <li>
                                	<input type="checkbox" name="NewsEvents" value="1" id="NewsEvents" <?php if($rsProfile->newsevents==1): ?> checked="checked" <?php endif; ?>>
                                    <h4><label for="NewsEvents"><?php echo Yii::app()->vars->myLang['News & Events (infrequent)']; ?></label></h4>
                                    <h5><?php echo Yii::app()->vars->myLang['Big announcements, goings-on in your area, and other hopefully relevant stuff']; ?></h5>
                                    <div class="cl"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="cl"></div>
                    </div>
                    
                    <div class="notif-one">
                    	<div class="notif-title">
                        	<h3><?php echo Yii::app()->vars->myLang['Projects you back']; ?>:</h3>
                        </div>
                        <div class="notif-content">
                        	<ul>
                            	<li>
                                	<input type="checkbox" name="ProjectsUpdate" value="1" id="ProjectsUpdate" <?php if($rsProfile->projectsupdate==1): ?> checked="checked" <?php endif; ?>>
                                    <h6><label for="ProjectsUpdate"><?php echo Yii::app()->vars->myLang['New project updates']; ?></label></h6>
                                    <div class="cl"></div>
                                </li>
                            </ul>
                        </div>
                        <div class="cl"></div>
                    </div>
                    
                    <?php if(Yii::app()->session['UserType']=="Contributor"): ?>
                        <div class="notif-one">
                            <div class="notif-title">
                                <h3><?php echo Yii::app()->vars->myLang['Campaigner notifications']; ?>:</h3>
                            </div>
                            <div class="notif-content">
                                <ul>
                                    <li>
                                        <input type="checkbox" name="NewPledges" value="1" id="NewPledges" <?php if($rsProfile->newpledges==1): ?> checked="checked" <?php endif; ?>>
                                        <h6><label for="NewPledges"><?php echo Yii::app()->vars->myLang['New pledges']; ?></label></h6>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="NewComments" value="1" id="NewComments" <?php if($rsProfile->newcomments==1): ?> checked="checked" <?php endif; ?>>
                                        <h6><label for="NewComments"><?php echo Yii::app()->vars->myLang['New comments']; ?></label></h6>
                                        <div class="cl"></div>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="NewLikes" value="1" id="NewLikes" <?php if($rsProfile->newlikes==1): ?> checked="checked" <?php endif; ?>>
                                        <h6><label for="NewLikes"><?php echo Yii::app()->vars->myLang['New likes']; ?></label></h6>
                                        <div class="cl"></div>
                                    </li>
                                </ul>
                            </div>
                            <div class="cl"></div>
                        </div>
                    <?php endif; ?>
                    <div class="notif-save-btn">
                    	<input type="submit" value="<?php echo Yii::app()->vars->myLang['Save']; ?>">
                    </div>
                    </form>
                    
                </div>
                
                
            </div>
            
            
            
        </div>
        
    </div>
</section>