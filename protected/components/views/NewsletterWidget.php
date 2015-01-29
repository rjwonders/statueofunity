<div class="weekbox">
    <form method="post" action="<?php echo Yii::app()->createUrl("general/addNewsletter"); ?>" enctype="multipart/form-data">
        <label><?php echo Yii::app()->vars->myLang['Sign up for monthly inspiration']; ?></label>
        <div class="weekform">
            <input type="email" name="NewsEmail" placeholder="<?php echo Yii::app()->vars->myLang['Your Email Address']; ?>">
            <input type="submit" value="">
        </div>
    </form>
</div>	
   	