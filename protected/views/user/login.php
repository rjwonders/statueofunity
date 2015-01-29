<section class="contentpart">
	<div class="wrapper">
    	<div class="loginpart">
        	<div class="left-log">
            	<form method="post" action="<?php echo Yii::app()->createUrl("user/signup"); ?>">
                    <div class="loginform">
                        <h2><?php echo Yii::app()->vars->myLang['Signup Now']; ?></h2>
                        <div class="frm">
                            <label for="FirstName"><?php echo Yii::app()->vars->myLang['First Name']; ?></label>
                            <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['First Name']; ?>" class="input" name="FirstName" id="FirstName">	
                        </div>
                        <div class="frm">
                        	<label for="LastName"><?php echo Yii::app()->vars->myLang['Last Name']; ?></label>
                            <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['Last Name']; ?>" class="input" name="LastName" id="LastName">	
                        </div>
                        <div class="frm">
                        	<label for="Emails"><?php echo Yii::app()->vars->myLang['Email']; ?></label>
                            <input type="email" placeholder="<?php echo Yii::app()->vars->myLang['Email']; ?>" class="input" name="Email" id="Emails">	
                        </div>
                        <div class="frm">
                        	<label for="Passwords"><?php echo Yii::app()->vars->myLang['Password']; ?></label>
                            <input type="password" placeholder="<?php echo Yii::app()->vars->myLang['Password']; ?>" class="input" name="Password" id="Passwords">	
                        </div>
                        <div class="frm">
                        	<label for="ConfirmPassword"><?php echo Yii::app()->vars->myLang['Re-enter Password']; ?></label>
                            <input type="password" placeholder="<?php echo Yii::app()->vars->myLang['Re-enter Password']; ?>" class="input" name="ConfirmPassword" id="ConfirmPassword">	
                        </div>
                        <div class="frm">
                        	<label for="Gender"><?php echo Yii::app()->vars->myLang['Gender']; ?></label>
                            <select name="Gender" id="Gender">
                            	<option value="male"><?php echo Yii::app()->vars->myLang['Male']; ?></option>
                                <option value="female"><?php echo Yii::app()->vars->myLang['Female']; ?></option>
                            </select>	
                        </div>
                        <div class="frm">
                        	<label for="BirthDate"><?php echo Yii::app()->vars->myLang['Birth Date']; ?></label>
                            <input type="text" placeholder="<?php echo Yii::app()->vars->myLang['Birth Date']; ?>" class="input" name="BirthDate" id="BirthDate">
                        </div>
                        <div class="ch-form">
                            <input type="checkbox" name="IsNewsletter" value="1" id="IsNewsletter">
                            <h5><label for="IsNewsletter"><?php echo Yii::app()->vars->myLang['Discover projects with our weekly newsletter']; ?></label></h5>
                            <div class="cl"></div>
                        </div>
                        <div class="subbtn">
                            <input type="submit" value="<?php echo Yii::app()->vars->myLang['Signup Now']; ?>">
                        </div>
                        <div class="termslink">
                            <?php echo Yii::app()->vars->myLang['By signing up, you agree to our']; ?> <a href="#"><?php echo Yii::app()->vars->myLang['terms of use']; ?></a> <?php echo Yii::app()->vars->myLang['and']; ?> <a href="#"><?php echo Yii::app()->vars->myLang['privacy policy']; ?></a>
                        </div>
                    </div>
            	</form>
            </div>
            
            <div class="right-log">
            	<div class="loginform">
                	<h2><?php echo Yii::app()->vars->myLang['Login']; ?></h2>
                    <form method="post" action="<?php echo Yii::app()->createUrl("user/logsin"); ?>">
                    <div class="frm">
                    	<label for="Email"><?php echo Yii::app()->vars->myLang['Email']; ?></label>
                        <input type="email" placeholder="<?php echo Yii::app()->vars->myLang['Email']; ?>" class="input" name="Email" id="Email">	
                    </div>
                    <div class="frm">
                    	<label for="Password"><?php echo Yii::app()->vars->myLang['Password']; ?></label>
                        <input type="password" placeholder="<?php echo Yii::app()->vars->myLang['Password']; ?>" class="input" name="Password" id="Password">	
                    </div>
                    <div class="subbtn">
                    	<input type="submit" value="<?php echo Yii::app()->vars->myLang['Login']; ?>">
                    </div>
                    </form>
                    <div class="orbox">
                    	<span><?php echo Yii::app()->vars->myLang['OR']; ?></span>
                    </div>
                    <div class="socialbtn">
                    	<h5>Login with</h5>
                    	<a href="<?php echo Yii::app()->createUrl("user/fbLogin"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/f1.png" alt=""> </a>
                        <a href="<?php echo Yii::app()->createUrl("user/twLogin"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/f2.png" alt=""> </a>
                        <a href="<?php echo Yii::app()->createUrl("user/gpLogin"); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/f3.png" alt=""> </a>
                        <div class="cl"></div>
                    </div>
                </div>
            </div>
            <div class="cl"></div>
        </div>
    </div>
</section>