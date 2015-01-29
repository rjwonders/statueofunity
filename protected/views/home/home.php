<?php Yii::import('ext.iwi.Iwi'); ?>
<section class="contentpart">
	<div class="wrapper">
    	<div class="whybox">
        	<img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/why-bg-img.jpg" alt="">
        	<div class="whytext">
            	<h2><?php echo Yii::app()->vars->Settings['Why Sourcing Title']; ?></h2>
                <p><?php echo Yii::app()->vars->Settings['Why Sourcing Text']; ?></p>
            </div>
        	
        </div>
        <?php $this->widget('PopularCampaignWidget'); ?>
    </div>
</section>
<section class="runpart">
	<div class="wrapper">
    	<div class="runlist">
        	<ul>
            	<li>
                	<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/guj1.jpg" alt=""></a>
                </li>
                <li>
                	<a href="<?php echo Yii::app()->createUrl("testimonials"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/guj2.jpg" alt=""></a>
                </li>
                <li>
                	<a href="<?php echo Yii::app()->createUrl("gallery"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/guj3.jpg" alt=""></a>
                </li>	
            </ul>
            <div class="cl"></div>
        </div>
    </div>
</section>
