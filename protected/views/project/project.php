<?php Yii::import('ext.iwi.Iwi');
$date1 = new DateTime(date("Y-m-d"));
$date2 = new DateTime(date("Y-m-d",strtotime($rsData[0]['projectenddate'])));
$MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/projects/".$rsData[0]['projectimage'])->adaptive(480,362)->cache();
 ?>
<section class="contentpart">
	<div class="wrapper">
    	
        <div class="detailspart">
        	<div class="cleanpart">
            	<div class="cleanimg"><img src="<?php echo $MainPicture; ?>" alt=""></div>
                <div class="cleantext">
                	<div class="bookbox">
                    	<input type="checkbox">
                        <div class="booklink">
                        	<a href="#">Bookmark this project</a>
                        </div>
                    </div>
                	<h2><?php echo $rsData[0]['projectname']; ?></h2>
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
                    <?php echo $rsData[0]['projectdescription']; ?>
                    <?php $Tags = explode(",",$rsData[0]['tags']); ?>
                    <div class="cleanbtn">
                    	<a href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cl-icon1.png" alt=""><?php echo $rsData[0]['city']; ?></a>
                        <?php foreach($Tags as $Tag): ?><a href="<?php echo Yii::app()->createUrl("explore",array("tag"=>$Tag)); ?>"><?php echo $Tag; ?></a><?php endforeach; ?>
                        
                        <?php $this->widget('application.extensions.SocialShareButton.SocialShareButton', array(
        'style'=>'horizontal',
        'networks' => array('facebook','googleplus','twitter'),
        'data_via'=>'souindia', //twitter username (for twitter only, if exists else leave empty)
)); ?>
                    </div>
                    <div class="cl"></div>
                </div>
                <div class="cl"></div>
            </div>
            
            <div class="storypart">
            	<div class="storymenu" id="tabs">
                	<ul>
                    	<li><a class="selected" href="#tab1">About</a></li>
                        <?php if($rsUpdates): ?>
                        	<li><a href="#tab2"><?php echo Yii::app()->vars->myLang['Updates']; ?> (<?php echo count($rsUpdates); ?>)</a></li>
                        <?php endif; ?>
                        <?php if($rsComments): ?>
                        	<li><a href="#tab3"><?php echo Yii::app()->vars->myLang['Comment']; ?> (<?php echo count($rsComments); ?>)</a></li>
                        <?php endif; ?>
                        <?php if(count($rsFAQ)>0): ?>
                        	<li><a href="#tab6"><?php echo Yii::app()->vars->myLang['FAQ']; ?></a></li>
                        <?php endif; ?>
                        <?php if(count($rsContributors)>0): ?>
                        	<li><a href="#tab7"><?php echo Yii::app()->vars->myLang['Contributor']; ?></a></li>
                        <?php endif; ?>
                        <?php if($rsVideos || $rsImages): ?>
                        	<li><a href="#tab4"><?php echo Yii::app()->vars->myLang['Gallery']; ?></a></li>
                        <?php endif; ?>
						
                    </ul>
                    <div class="right-cnt">
                	<div class="faqbtn"><a href="<?php echo Yii::app()->createUrl("project",array("pledge"=>$rsData[0]['projectslug'])); ?>">Contribute Now</a></div>
                </div>
                    <div class="cl"></div>
                </div>
                <div class="left-cnt">
                	<div class="story-cnt" id="tab1">
                    	<h2>Project Story</h2>
                    	<?php echo $rsData[0]['projectstory']; ?>
                    </div>
                    <?php if($rsUpdates): ?>
                    	<div class="story-cnt" id="tab2">
                			<?php foreach($rsUpdates as $Updates): ?>
                            	<div class="updateone">
                            		<div class="updatetext">
                                		<h3><span><?php echo date("M d, Y",strtotime($Updates->addeddate)); ?></span> <?php echo $Updates->updates; ?></h3>
                                	</div>
                                	<div class="cl"></div>
                            	</div>
                            <?php endforeach; ?>
                		</div>
                    <?php endif; ?>
                    <div class="story-cnt" id="tab3">
                    </div>
                    <?php if($rsVideos || $rsImages): ?>
                    	<div class="story-cnt" id="tab4">
                        	<?php if($rsVideos): ?>
                            	<h2><?php echo Yii::app()->vars->myLang['Videos']; ?></h2>
								<?php foreach($rsVideos as $Videos): ?>
                                    <iframe width="410" height="300" src="//www.youtube.com/embed/<?php echo $Videos->videolink; ?>" frameborder="0" allowfullscreen></iframe>
                                <?php endforeach; ?>
                             <?php endif; ?>
                             <?php if($rsImages): ?>
                            	<h2><?php echo Yii::app()->vars->myLang['Images']; ?></h2>
								<div class="img-gal popup-gallery">
									<?php foreach($rsImages as $Images): ?>
                                        <?php 
                                        $picture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/projects/".$Images->projectslug."/".$Images->images)->adaptive(400,400)->cache();?>
                                        <a href="<?php echo Yii::app()->request->baseUrl."/assets/projects/".$Images->projectslug."/".$Images->images; ?>" title=""><img src="<?php echo $picture; ?>" class="img-responsive" alt="" /></a>
                                    <?php endforeach; ?>
                                </div>
                             <?php endif; ?>
                		</div>
                    <?php endif; ?>
                   	<?php if(count($rsFAQ)>0): ?>
                    	<div class="faqbox" id="tab6">
                    		<?php for($i=0;$i<count($rsFAQ);$i++): ?>
                            	<div class="ques-one">
                                	<div class="ques">
                                        <h3><?php echo $rsFAQ[$i]['faq']; ?></h3>
                                    </div>
                                    <div class="answer">
                                        <?php echo $rsFAQ[$i]['answer']; ?>
                                    </div>
                            		<h4><a href="#"></a></h4>
                            	</div>
							<?php endfor; ?>
                            <div class="faqbtn"><a href="#">Ask a Question</a></div>
                            
                    	</div>
                    <?php endif; ?>
                </div>
                <?php if(count($rsProjectRewards)>0): ?>
                	<div class="right-cnt">
                		<h2>Rewards</h2>
                    	<?php foreach($rsProjectRewards as $Rewards): ?>	
                            <div class="pled-one">
                        	<div class="pled-top">
                            	<div class="pledimg"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/pled-img.png" alt=""></div>
                                <h3>Pledge &#8377;<?php echo $Rewards->amounttoback; ?> or More</h3>
                                <h4>5 Backers</h4>
                                <p>Points: <strong><?php echo $Rewards->reward; ?></strong></p>
                                <div class="cl"></div>
                            </div>
                            
                            <div class="overlay-text">
                            	<h4><a href="<?php echo Yii::app()->createUrl("project",array("pledge"=>$rsData[0]['projectslug'],$Rewards->amounttoback=>"")); ?>">Select this Reward</a></h4>
                            </div>
                        </div>
                    	<?php endforeach; ?>
                    </div>
            	<?php endif; ?>
                
                <div class="cl"></div>
            </div>	
        </div>
    </div>
</section>