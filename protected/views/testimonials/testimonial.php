<?php Yii::import('ext.iwi.Iwi'); ?>
<section class="contentpart">
	<div class="wrapper">
    	
		<div class="testimonialpart">
        	<h2><?php echo Yii::app()->vars->Settings['Testimonials']; ?></h2>
            <div class="testim-list">
            	<ul>
                	<?php for($i=0;$i<count($rsTestimonial);$i++):
						$MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/testimonial/".$rsTestimonial[$i]['userimage'])->adaptive(105,105)->cache(); ?>
            		<li>
                    	<div class="testimone">
                        	<div class="testim-user-img"><img src="<?php echo $MainPicture; ?>" alt=""></div>
                            <div class="testim-user-text">
                            	<div class="colan-one"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/colan-one.png" alt=""></div>
                            	<?php echo $rsTestimonial[$i]['testimonial']; ?>					
                                <div class="colan-two"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/colan-two.png" alt=""></div>
                                <div class="cl"></div>
                            	<div class="testim-user">
                                <h5><?php echo $rsTestimonial[$i]['username']; ?> - <?php echo $rsTestimonial[$i]['designation']; ?>	</h5>
                                <div class="cl"></div>
                            </div>
                            </div>
                            <div class="cl"></div>
                        </div>
            		</li>
                    <?php endfor; ?>
                    
                    
                    
                    
            	</ul>
                <div class="cl"></div>
                	
               </div>
        </div>        
        
    </div>
</section>


