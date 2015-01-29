<section class="contentpart">
	<div class="wrapper">
    	
		<div class="workspart contactpart">
        	<h2><?php echo Yii::app()->vars->myLang['Contact Us']; ?><span>Statue of Unity</span></h2>
            
            <div class="add-iconbox">
            	<ul>
                	<?php if(trim(Yii::app()->vars->Settings['Office Address'])!=""): ?>
                        <li>
                            <div class="cnt-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cnt-icon1.png" alt=""></div>
                            <p><?php echo nl2br(Yii::app()->vars->Settings['Office Address']); ?></p>
                        </li>
                    <?php endif; ?>
                    <?php if(trim(Yii::app()->vars->Settings['Office Phone'])!=""): ?>
                        <li>
                            <div class="cnt-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cnt-icon2.png" alt=""></div>
                            <p><?php echo Yii::app()->vars->Settings['Office Phone']; ?></p>
                        </li>
                     <?php endif; ?>
                    <?php if(trim(Yii::app()->vars->Settings['Office Email'])!=""): ?>
                        <li>
                            <div class="cnt-icon"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/cnt-icon3.png" alt=""></div>
                            <p><a href="mailto:<?php echo Yii::app()->vars->Settings['Office Email']; ?>"><?php echo Yii::app()->vars->Settings['Office Email']; ?></a></p>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="cl"></div>
            </div>
            
            <div>
            	<form method="post" action="<?php echo Yii::app()->createUrl("cms/contactUs"); ?>">
            	<div class="contactform">
                	<h3>Contact Form</h3>
                	<div class="frm">
                            <div class="frm-left">
                                <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['Name']; ?>" class="input" name="Name">
                            </div>
                            <div class="frm-right">
                                <input type="email" placeholder="<?php echo Yii::app()->vars->myLang['Email']; ?>" class="input" name="Email">	
                            </div>
                            <div class="cl"></div>
                     </div>
                    <div class="frm">
                            <div class="frm-left">
                                <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['Phone Number']; ?>" class="input" name="Phone">
                            </div>
                            <div class="frm-right">
                                <select name="Subject">
                                	<option value="<?php echo Yii::app()->vars->myLang['Suggest any book']; ?>"><?php echo Yii::app()->vars->myLang['Suggest any book']; ?></option>
                                    <option value="<?php echo Yii::app()->vars->myLang['Features']; ?>"><?php echo Yii::app()->vars->myLang['Features']; ?></option>
                                    <option value="<?php echo Yii::app()->vars->myLang['Bugs']; ?>"><?php echo Yii::app()->vars->myLang['Bugs']; ?></option>
                                    <option value="<?php echo Yii::app()->vars->myLang['Others']; ?>"><?php echo Yii::app()->vars->myLang['Others']; ?></option>
                                </select>
                            </div>
                            <div class="cl"></div>
                     </div>
                    
                    <div class="cn-form">
                    	<textarea placeholder="<?php echo Yii::app()->vars->myLang['Comment']; ?>" name="Comment"></textarea>	
                    </div>
                    <div class="bl-submitbtn">
                        	<input type="submit" value="Submit"> 
                    </div>
                     
                </div>
                </form>
                <div class="mapbox">
                	<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d117506.98606137399!2d72.5797426!3d23.020345749999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1s1st+Floor%2C+Block+No+12%2C+New+Sachivalaya+Complex%2C+Gandhinagar+(Gujarat)%2C+Pin+Code%3A+382010!5e0!3m2!1sen!2sin!4v1419849075485" frameborder="0" style="border:0"></iframe>
                </div>
                <div class="cl"></div>
            </div>
            
            
        </div>        
        
    </div>
</section>