<section class="top-main-head"  id="putbg">	
	<div class="wrapper">
    	<div class="top-head">	
			<?php $this->widget('HeaderCommonWidget'); ?>
        	<div class="bannertext">
                <h1><?php echo $BannerProject[0]['projectname']; ?></h1>
                <div class="fundbox">
                    <div class="fundimg">
                        <div class="fundimg-on" style="width:<?php echo $BannerProject[0]['fundcompleted']; ?>%"></div>
                    </div>
                    <?php
						$date1 = new DateTime(date("Y-m-d"));
						$date2 = new DateTime(date("Y-m-d",strtotime($BannerProject[0]['projectenddate'])));
					?>
                    <div class="funtext">
                        <h3><strong><?php echo $BannerProject[0]['fundcompleted']; ?>%</strong><br> <?php echo Yii::app()->vars->myLang['Funded']; ?></h3>
                        <h3><strong><?php echo $date2->diff($date1)->format("%a"); ?></strong><br> <?php echo Yii::app()->vars->myLang['Days To Go']; ?></h3>
                        <h3><strong>&#8377;<?php echo number_format($BannerProject[0]['goalamount']); ?></strong><br> <?php echo Yii::app()->vars->myLang['Goal']; ?></h3>
                    </div>
                    <div class="cl"></div>
                </div>
                <div class="cont-btn"><a href="<?php echo Yii::app()->createUrl("project/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Know More']; ?></a> <a href="<?php echo Yii::app()->createUrl("project/pledge/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Contribute']; ?></a></div>
                <div class="cl"></div>
            </div>
        	
        	<div class="cl"></div>
        	<div class="banner-menubox">
        		<div class="banner-menu">
                <ul>
                    <li>
                        <div class="headding-box">
                            <div class="bm-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/bm1.png" alt=""> </div>
                            <h4><a href="<?php echo Yii::app()->createUrl("project/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Project']; ?></a> </h4>
                        </div>
                        <?php /*?><div class="contentbox">
                        	<?php echo Yii::app()->vars->Settings['Project Text']; ?>
                        </div><?php */?>
                    </li><li>
                    	<div class="headding-box">
                            <div class="bm-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/bm2.png" alt=""> </div>
                            <h4><a href="<?php echo Yii::app()->createUrl("project/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Location']; ?></a> </h4>
                        </div>
                        <?php /*?><div class="contentbox">
                        	<?php echo Yii::app()->vars->Settings['Location Text']; ?>
                        </div><?php */?>
                                               
                    </li><li>
                        <div class="headding-box">
                            <div class="bm-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/bm3.png" alt=""> </div>
                            <h4><a href="<?php echo Yii::app()->createUrl("project/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Goal']; ?></a> </h4>
                        </div>
                         <?php /*?><div class="contentbox">
                        	<?php echo Yii::app()->vars->Settings['Goal Text']; ?>
                        </div> <?php */?>                      
                    </li><li>
                        <div class="headding-box">
                            <div class="bm-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/bm4.png" alt=""> </div>
                            <h4><a href="<?php echo Yii::app()->createUrl("project/".$BannerProject[0]['projectslug']); ?>"><?php echo Yii::app()->vars->myLang['Connect']; ?></a> </h4>
                        </div>
                        <?php /*?><div class="contentbox">
                        	<?php echo Yii::app()->vars->Settings['Connect Text']; ?>
                        </div><?php */?>
                    </li>	
                </ul>
                <div class="cl"></div>
            </div>
        	</div>
        	
         </div>
	</div>
    <?php
		Yii::import('ext.iwi.Iwi');
		$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/users/projects/".$BannerProject[0]['projectimage']);
		//$picture->resize(2000,0, Iwi::NONE);
	?>
    <div id="homebanner"><img src="<?php echo $picture->cache(); ?>" alt=""></div>
</section> 