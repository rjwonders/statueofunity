<input type="hidden" id="AJAXURL" value="<?php echo Yii::app()->createUrl("user/getStates"); ?>" />
<section class="contentpart">
	<div class="wrapper">
    	<div class="accountpart">
        	<?php $this->widget('AccountHeaderWidget'); ?>
            <div class="ac-content">
            	<div class="sms-title">
            		<h3><?php echo Yii::app()->vars->myLang['Edit Profile']; ?></h3>	
                    
                    <div class="cl"></div>
                </div>
                
                <div class="sms-content">
                	<form method="post" action="<?php echo Yii::app()->createUrl("user/editProfile"); ?>">
                	<div class="profile-form">
                    	<div class="frm">
                    	<div class="frm-left">
                        	<label><?php echo Yii::app()->vars->myLang['First Name']; ?></label>
                            <input type="text" name="FirstName" class="input" value="<?php echo $rsProfile->firstname; ?>">
                        </div>
                        <div class="frm-right">
                        	<label><?php echo Yii::app()->vars->myLang['Last Name']; ?></label>
                            <input type="text" name="LastName" class="input" value="<?php echo $rsProfile->lastname; ?>">
                        </div>
                        <div class="cl"></div>
                    </div>
                    
                    	<div class="frm">
                            <div class="frm-left">
                                <label><?php echo Yii::app()->vars->myLang['Email']; ?></label>
                                <input type="email" name="Email" class="input" value="<?php echo $rsProfile->email; ?>">	
                            </div>
                            <div class="frm-right">
                                <label><?php echo Yii::app()->vars->myLang['Phone Number']; ?></label>
                                <input type="text" name="Phone" class="input" value="<?php echo $rsProfile->phone; ?>">	
                            </div>
                            <div class="cl"></div>
                        </div>
                        
                        <div class="frm">
                            <div class="frm-left">
                                <label><?php echo Yii::app()->vars->myLang['Address']; ?></label>
                                <input type="text" name="Address"  class="input" value="<?php echo $rsProfile->address; ?>">
                            </div>
                            <div class="frm-right">
                                <label><?php echo Yii::app()->vars->myLang['Address 2']; ?></label>
                                <input type="text" name="Address2" class="input" value="<?php echo $rsProfile->address2; ?>">	
                            </div>
                            <div class="cl"></div>
                        </div>
                        
                        <div class="frm sel-form">
                            <div class="frm-left">
                                <label><?php echo Yii::app()->vars->myLang['Country']; ?></label>
                                <select name="Country" id="CountryID">
                                	<option value="">Select Country</option>
                                	<?php foreach($rsCountry as $Country): ?>
                                		<option value="<?php echo $Country->countryid; ?>" <?php if($Country->countryid==$rsProfile->country): ?> selected="selected" <?php endif; ?>><?php echo $Country->country; ?></option>
                                	<?php endforeach; ?>
                                </select>
                            </div>
                            <div class="frm-right">
                                <label><?php echo Yii::app()->vars->myLang['State']; ?></label>
                                <span class="nodata">
                                    <select name="State">
                                        <option value="">Select State</option>
                                        <?php foreach($rsState as $State): ?>
                                            <option value="<?php echo $State->stateid; ?>" <?php if($State->stateid==$rsProfile->state): ?> selected="selected" <?php endif; ?>><?php echo $State->states; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            	</span>
                            </div>
                            <div class="cl"></div>
                        </div>
                        
                        <div class="frm sel-form">
                            <div class="frm-left">
                                <label><?php echo Yii::app()->vars->myLang['City']; ?></label>
                                <input type="text" name="City" class="input" value="<?php echo $rsProfile->city; ?>">
                            </div>
                            <div class="frm-right">
                                <label><?php echo Yii::app()->vars->myLang['Zip Code']; ?></label>
                                <input type="text" name="Zipcode" class="input" value="<?php echo $rsProfile->zipcode; ?>">	
                            </div>
                            <div class="cl"></div>
                        </div>
                        
                        <div class="frm sel-form">
                            <div class="frm-left">
                                <label for="Gender"><?php echo Yii::app()->vars->myLang['Gender']; ?></label>
                                <select name="Gender" id="Gender">
                                    <option value="male" <?php if($rsProfile->gender=='male'): ?> selected="selected" <?php endif; ?>><?php echo Yii::app()->vars->myLang['Male']; ?></option>
                                    <option value="female" <?php if($rsProfile->gender=='female'): ?> selected="selected" <?php endif; ?>><?php echo Yii::app()->vars->myLang['Female']; ?></option>
                                </select>	
                            </div>
                            <div class="frm-right">
                                <label for="BirthDate"><?php echo Yii::app()->vars->myLang['Birth Date']; ?></label>
                                <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['Birth Date']; ?>" class="input" name="BirthDate" id="BirthDate" value="<?php echo $rsProfile->dateofbirth; ?>">
                            </div>
                            <div class="cl"></div>
                        </div>
                        <div class="frm text-form">
                            <label><?php echo Yii::app()->vars->myLang['Biography']; ?></label>
                            <textarea name="AboutMe"><?php echo $rsProfile->aboutme; ?></textarea>
                        </div>
                        <div class="frm">
                            <label><?php echo Yii::app()->vars->myLang['Profile Picture']; ?></label>
                            <div id="myPics">
								<?php if(Yii::app()->session['UserType']=="Contributor"):
                                    $AddFolder="creator";
                                else:
                                    $AddFolder="user";
                                endif; ?>
                                <?php if($rsProfile->profilepicture!='' && file_exists("assets/users/".$AddFolder."/".$rsProfile->profilepicture)): 
                                    Yii::import('ext.iwi.Iwi');
                                    $MainPicture = Yii::app()->iwi->load(YiiBase::getPathOfAlias('webroot')."/assets/users/".$AddFolder."/".$rsProfile->profilepicture)->adaptive(150,150)->cache();
                                    ?>
                                    <img src="<?php echo $MainPicture; ?>" alt="" />
                                <?php endif; ?>
                            </div>
                            <div class="picture-form">
                            	<span><?php echo Yii::app()->vars->myLang['Add File']; ?>
                                	
                                </span>
                                <div class="progress" style="display:none">
                                    <div class="bar"></div >
                                    <div class="percent">0%</div >
                                </div>
                                <div id="status"></div>
                                <div class="cl"></div>
                            </div>
                        </div>
                        
                        <div class="savebtn">
                        	<input type="submit" value="<?php echo Yii::app()->vars->myLang['Save']; ?>">
                        </div>
                    </div>
                    </form>
                    <?php if(trim($rsProfile->password)!=''): ?>
                        <form method="post" action="<?php echo Yii::app()->createUrl("user/changePassword"); ?>">
                        <div class="profile-form">
                            <div class="sms-title">
                                <h3><?php echo Yii::app()->vars->myLang['Change Password']; ?></h3>	
                                
                                <div class="cl"></div>
                            </div>
                            
                            <div class="frm cue-form">
                                <div class="frm-left">
                                    <label><?php echo Yii::app()->vars->myLang['Current Password']; ?></label>
                                    <input type="password" class="input" name="CurrentPassword">
                                </div>
                                <div class="frm-right">
                                    <label><?php echo Yii::app()->vars->myLang['New Password']; ?></label>
                                    <input type="password"  class="input" name="NewPassword">	
                                </div>
                                <div class="cl"></div>
                            </div>
                            
                            <div class="frm">
                                <div class="frm-left">
                                    <label><?php echo Yii::app()->vars->myLang['Confirm New Password']; ?></label>
                                    <input type="password" class="input" name="ConfirmPassword">
                                </div>
                               
                                <div class="cl"></div>
                            </div>
                            
                            <div class="savebtn">
                                <input type="submit" value="<?php echo Yii::app()->vars->myLang['Save']; ?>">
                            </div>
                            
                        </div>
                        </form>
                    <?php endif; ?>
                    <form action="<?php echo $this->createUrl("user/profileImage"); ?>" id="profileImage" method="post" enctype="multipart/form-data" style="display:none;">
                        <input type="file" id="uploadimagesfield" name="myfile">
                        <input type="submit" id="UploadImageNow" value="" />
                      </form>
                </div>
                
                
            </div>
            
            
        </div>
        
    </div>
</section>