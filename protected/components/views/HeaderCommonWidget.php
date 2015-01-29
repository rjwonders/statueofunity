<div class="header">
    <div class="logo">
        <a href="<?php echo Yii::app()->createUrl("home"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/logo.png" alt=""></a>
    </div> 
    <div class="gov-icon">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/Government.png" alt="">
    </div> 
    <div class="right-header">
        <div class="social-box">
        	<?php if(!isset(Yii::app()->session['UserID']) || !isset(Yii::app()->session['UserType'])): ?>
            	<h5><a href="<?php echo Yii::app()->createUrl("user/login"); ?>"><?php echo Yii::app()->vars->myLang['Login']; ?>/<?php echo Yii::app()->vars->myLang['Register']; ?></a></h5>
            <?php else: ?>
            	<h5><a href="<?php echo Yii::app()->createUrl("user/logout"); ?>"><?php echo Yii::app()->vars->myLang['Logout']; ?></a></h5>
            <?php endif; ?>
            <div class="lan-link">
            	<?php foreach($Languages as $Lang): ?>
                	<a href="<?php echo Yii::app()->createUrl("general/changeLanguage",array("LanguageName"=>$Lang->languageid)); ?>" <?php if(Yii::app()->request->cookies['LanguageName']==$Lang->languageid): ?> class="active" <?php endif; ?>><?php echo $Lang->language; ?></a>
                <?php endforeach; ?>
                <div class="cl"></div>
            </div>
        </div>
        <nav class="nav">
            <ul>
                <?php /*?><li><a href="<?php echo Yii::app()->createUrl("cms/raise"); ?>"><?php echo Yii::app()->vars->myLang['Raise Funds']; ?></a></li><?php */?>
                <li><a href="<?php echo Yii::app()->createUrl("explore/all"); ?>"><?php echo Yii::app()->vars->myLang['Discover']; ?></a></li>
                <?php /*?><li><a href="<?php echo Yii::app()->createUrl("cms/gallery"); ?>"><?php echo Yii::app()->vars->myLang['Gallery']; ?></a></li><?php */?>
                <li><a href="<?php echo Yii::app()->createUrl("user/login"); ?>"><?php echo Yii::app()->vars->myLang['Top Contributors']; ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl("blogs"); ?>"><?php echo Yii::app()->vars->myLang['Blog']; ?></a></li>
                <li><a href="<?php echo Yii::app()->createUrl("contact-us"); ?>"><?php echo Yii::app()->vars->myLang['Contact']; ?></a></li>
            </ul>
            <div class="cl"></div>
        </nav>
    </div> 
    <div class="cl"></div> 	
</div>