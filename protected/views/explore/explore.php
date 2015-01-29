<?php Yii::import('ext.iwi.Iwi'); ?>
<section class="contentpart">
	<div class="wrapper">
        <div class="cate-part">
            <h2><?php echo Yii::app()->vars->myLang['Discover categories']; ?></h2>
            <h3><?php echo count($rsCategory); ?> <?php echo Yii::app()->vars->myLang['diverse categories']; ?>.</h3>
            
            <div class="catelist">
                <ul>
                	<?php for($i=0;$i<count($rsCategory);$i++):
					$picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/projects/category/".$rsCategory[$i]['categoryimage']); ?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl("explore/index",array("CategoryID"=>$rsCategory[$i]['categoryslug'])); ?>">
                            <div class="cate-text">
                                <?php echo $rsCategory[$i]['category']; ?><br> <span><?php echo $rsCategory[$i]['OnlinProject']; ?> <?php echo Yii::app()->vars->myLang['live projects']; ?></span>
                            </div>
                            <div class="cate-icon"><img src="<?php echo $picture->cache(); ?>" alt=""></div>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
                <div class="cl"></div>
            </div>
            
        </div>        
    	<?php if($rsProject):
			Yii::import('ext.iwi.Iwi'); ?> 
            <div class="cleanpart travel-slider">
                <ul class="bxslider-travel">
                	<?php for($k=0;$k<count($rsProject);$k++):
						$MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/projects/".$rsProject[$k]['projectimage'])->adaptive(462,320)->cache(); 
						$date1 = new DateTime(date("Y-m-d"));
            			$date2 = new DateTime(date("Y-m-d",strtotime($rsProject[$k]['projectenddate'])));?>
                        <li>
                            <div class="cleanimg"><img alt="" src="<?php echo $MainPicture; ?>"></div>
                            <div class="cleantext travel-text">
                                <h3><?php echo $rsProject[$k]['projectname']; ?></h3>
                                <p><?php echo $rsProject[$k]['projectdescription']; ?></p>
                                <div>
                                    <div class="fundimg">
                                        <div class="fundimg-on" style="width:<?php echo $rsProject[$k]['fundcompleted']; ?>%"></div>
                                    </div>
                                    <div class="funtext">
                                        <h3><strong><?php echo $rsProject[$k]['fundcompleted']; ?>%</strong><br> <?php echo Yii::app()->vars->myLang['Funded']; ?></h3>
                                        <h3><strong><?php echo $date2->diff($date1)->format("%a"); ?></strong><br> <?php echo Yii::app()->vars->myLang['Days To Go']; ?></h3>
                                        <h3><strong>&#8377;<?php echo number_format($rsProject[$k]['goalamount']); ?></strong><br> <?php echo Yii::app()->vars->myLang['Pledged']; ?></h3>
                                    </div>
                                    <div class="cl"></div>
                                </div>
                                <div class="cl"></div>
                            </div>
                            <div class="cl"></div>
                        </li>
                    <?php endfor; ?>
                </ul>   
                <div class="cl"></div>
            </div>
        <?php endif; ?>
		<?php $this->widget('PopularCampaignWidget'); ?>   
    </div>
</section>