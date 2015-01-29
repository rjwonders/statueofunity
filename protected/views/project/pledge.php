<?php Yii::import('ext.iwi.Iwi');
$date1 = new DateTime(date("Y-m-d"));
$date2 = new DateTime(date("Y-m-d",strtotime($rsData[0]['projectenddate'])));
$MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/projects/".$rsData[0]['projectimage'])->adaptive(462,320)->cache();
 ?>
<section class="contentpart">
	<div class="wrapper">
    	
        <div class="detailspart">
        	<h2><?php echo $rsData[0]['projectname']; ?></h2>
            <div class="cleanpart">
            	<div class="cleanimg"><img src="<?php echo $MainPicture; ?>" alt=""></div>
                <div class="cleantext">
                	<div>
                        <div class="fundimg">
                            <div class="fundimg-on" style="width:<?php echo $rsData[0]['fundcompleted']; ?>%"></div>
                        </div>
                        <div class="funtext">
                            <h3><strong><?php echo $rsData[0]['fundcompleted']; ?>%</strong><br> <?php echo Yii::app()->vars->myLang['Funded']; ?></h3>
                            <h3><strong><?php echo $date2->diff($date1)->format("%a"); ?></strong><br> <?php echo Yii::app()->vars->myLang['Days To Go']; ?></h3>
                            <h3><strong>&#8377;<?php echo $rsData[0]['goalamount']; ?></strong><br> <?php echo Yii::app()->vars->myLang['Pledged']; ?></h3>
                        </div>
                    	<div class="cl"></div>
                    </div>
                    <p><?php echo $rsData[0]['projectdescription']; ?></p>
                    <?php $Tags = explode(",",$rsData[0]['tags']); ?>
                    <div class="cleanbtn">
                    	<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cl-icon1.png" alt=""><?php echo $rsData[0]['city']; ?></a>
                        <?php foreach($Tags as $Tag): ?><a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cl-icon2.png" alt=""><?php echo $Tag; ?></a><?php endforeach; ?>
                        <a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cl-icon3.png" alt="">Share</a>
                    </div>
                    <div class="cl"></div>
                </div>
                <div class="cl"></div>
            </div>
            <div class="cl"></div>
            <div class="blogform" style="margin-top:30px;">
              <h3>Please enter amount to Contribute</h3>
              <form method="post" action="<?php echo Yii::app()->createUrl("project/contribute"); ?>">
              <div class="bl-form">
                   <input type="text" class="input" name="Amount" placeholder="Amount" value="<?php if($rsAmount!=0): echo $rsAmount; endif; ?>">
              </div>
              <div class="bl-submitbtn">
                  <input type="submit" value="Submit"> 
              </div>
              </form>
          </div>
        </div>
    </div>
</section>