<section class="contentpart">
	<div class="wrapper">
    	<div class="popular-box campaigns-page">
        	<h2><?php echo $rsCategory->category; ?></h2>
            <div class="pop-cnt-list">
                <ul>
                    <?php for($j=0;$j<count($rsProject);$j++):
                        $MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/projects/".$rsProject[$j]['projectimage'])->adaptive(274,179)->cache();
                        $picture = new Iwi(YiiBase::getPathOfAlias('webroot')."/assets/projects/category/".$rsCategory->categoryimage);
                        $date1 = new DateTime(date("Y-m-d"));
                        $date2 = new DateTime(date("Y-m-d",strtotime($rsProject[$j]['projectenddate']))); ?>
                        <li>
                            <div class="pop-icon" style="background-color:<?php echo $rsCategory->categorycolor; ?>"><a href="<?php echo Yii::app()->createUrl("explore/index",array("CategoryID"=>$rsCategory->categoryslug)); ?>"><img src="<?php echo $picture->cache(); ?>" alt=""></a>
                            <div class="svg"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
  width="30px" height="50px" viewBox="0 0 30 50" enable-background="new 0 0 30 50" xml:space="preserve">
<path fill-rule="evenodd" clip-rule="evenodd" fill="<?php echo $rsCategory->categorycolor; ?>" d="M0,0h30v50L15,40L0,50V0z"/>
</svg></div>
                            </div>
                            <div class="popimg"><img src="<?php echo $MainPicture; ?>" alt="">
                            <div class="popimghover">
                            	<a href="<?php echo Yii::app()->createUrl("project",array($rsProject[$j]['projectslug']=>"")); ?>"><?php echo Yii::app()->vars->myLang['Know More']; ?></a>
                                <a href="<?php echo Yii::app()->createUrl("project",array("pledge" => $rsProject[$j]['projectslug'])); ?>"><?php echo Yii::app()->vars->myLang['Contribute']; ?></a>
                            </div>
                            </div>
                            <div class="poptext">
                                <h3><a href="<?php echo Yii::app()->createUrl("project",array($rsProject[$j]['projectslug']=>"")); ?>"><?php echo $rsProject[$j]['projectname']; ?></a></h3>
                                <h4>by <span><?php echo $rsProject[$j]['username']; ?>, <?php echo $rsProject[$j]['city']; ?></span></h4>
                                <p><?php echo $rsProject[$j]['projectdescription']; ?></p>
                                <div class="pop-process-box">
                                    <div class="pop-pro-img">
                                        <div class="pop-pro-on" style="width:<?php echo $rsProject[$j]['fundcompleted']; ?>%"></div>
                                    </div>
                                    <div class="pop-pro-text">
                                        <h5><strong><?php echo $rsProject[$j]['fundcompleted']; ?>%</strong><br> <?php echo Yii::app()->vars->myLang['Funded']; ?></h5>
                                        <h5><strong><?php echo $date2->diff($date1)->format("%a"); ?></strong><br>  <?php echo Yii::app()->vars->myLang['Days To Go']; ?></h5>
                                        <h5><strong>&#8377;<?php echo number_format($rsProject[$j]['goalamount']); ?></strong><br> <?php echo Yii::app()->vars->myLang['Goal']; ?></h5>
                                    </div>
                                </div>
                            </div>	
                        </li>
                    <?php endfor; ?>
                </ul>
                <div class="cl"></div>
            </div>
		</div>
	</div>
</section>