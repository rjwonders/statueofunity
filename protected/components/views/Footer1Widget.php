<div class="middle-footer">
    <div class="wrapper">
    	<div class="newletter-box">
            <div class="camp-box">
                <h2>CAMPAIGNING</h2>
                <ul>
                    <li><a href="#">Start your Campaign to Raise Fund</a></li>
                    <li><a href="#">Campaign Support</a></li>
                </ul>
            </div>
            
            <div class="camp-box contri-box">
                <h2>CONTRIBUTING</h2>
                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl("explore"); ?>">Explore</a></li>
                    <li><a href="#">Contributing Resources</a></li>
                    <li><a href="#">Contributing Support</a></li>
                </ul>
            </div>
        	<div class="cl"></div>
			<?php $this->widget('NewsletterWidget'); ?>
        </div>
        <div class="camp-box abt-box">
            <h2>ABOUT us</h2>
            <ul>
                <li><a href="#">How It Works</a></li>
                <li><a href="<?php echo Yii::app()->createUrl("about-us"); ?>">About Us</a></li>
                <li><a href="http://www.statueofunity.in/newsupdate.html">Press</a></li>
                <li><a href="<?php echo Yii::app()->createUrl("blogs"); ?>">Blog</a></li>
            </ul>
        </div>
        
        <div class="camp-box help-box">
            <h2>HELP</h2>
            <ul>
                <li><a href="#">Funding Support</a></li>
                <li><a href="#">Trust & Safety</a></li>
                <li><a href="#">Help & Support</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
        
        <div class="camp-box followbox">
            <h2>follow us</h2>
            <div class="follow">
            	<?php if(trim(Yii::app()->vars->Settings['Facebook Link'])!=""): ?>
                	<a class="fb" href="<?php echo Yii::app()->vars->Settings['Facebook Link']; ?>" target="_blank"></a>
                <?php endif; ?>
                <?php if(trim(Yii::app()->vars->Settings['Twitter Link'])!=""): ?>
                	<a class="twt" href="<?php echo Yii::app()->vars->Settings['Twitter Link']; ?>" target="_blank"></a>
                <?php endif; ?>
                <?php if(trim(Yii::app()->vars->Settings['Google+ Link'])!=""): ?>
                	<a class="pin" href="<?php echo Yii::app()->vars->Settings['Google+ Link']; ?>" target="_blank"></a>
                <?php endif; ?>
                <div class="cl"></div>
            </div>
            <h2>get the latest</h2>
            <div class="follow-comment">
                <div class="fb-follow" data-href="<?php echo Yii::app()->getBaseUrl(true); ?>" data-width="240" data-colorscheme="light" data-layout="standard" data-show-faces="false"></div>
                <a class="twitter-follow-button" href="https://twitter.com/souindia" data-show-count="true"data-lang="en">Follow @souindia</a>
                <script type="text/javascript">
					window.twttr = (function (d, s, id) {
					  var t, js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src= "https://platform.twitter.com/widgets.js";
					  fjs.parentNode.insertBefore(js, fjs);
					  return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
					}(document, "script", "twitter-wjs"));
				</script>
                <script src="https://apis.google.com/js/platform.js" async defer></script>
				<div class="g-follow" data-href="https://plus.google.com/+StatueofUnity"></div>
            </div>
        </div>
        <div class="cl"></div>
    </div>
</div>