<section class="contentpart">
	<div class="wrapper">
    	<div class="loginpart">
        	<div class="left-log">
            	<form method="post" action="<?php echo Yii::app()->createUrl("user/setEmails"); ?>">
                    <div class="loginform">
                        <h2><?php echo Yii::app()->vars->myLang['Add your Email ID']; ?></h2>
                        <div class="frm">
                            <input type="email" placeholder="<?php echo Yii::app()->vars->myLang['Email']; ?>" class="input" name="Email">	
                        </div>
                        <div class="subbtn">
                            <input type="submit" value="<?php echo Yii::app()->vars->myLang['Submit']; ?>">
                        </div>
                    </div>
            	</form>
            </div>
            <div class="cl"></div>
        </div>
    </div>
</section>