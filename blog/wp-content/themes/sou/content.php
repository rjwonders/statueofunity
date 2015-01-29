<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<?php if(is_single()): ?>
<div class="blog-detailspart">
    <div class="blog-detailimg"><?php the_post_thumbnail('full'); ?></div>
    <div class="blog-detailtext">
        <h3><?php the_title(); ?></h3>
        <div class="datepart">
            <div class="cl-box">
                <img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/calender-blog.png">
                <h6>04 May 2011</h6>
                <div class="cl"></div>
            </div>
            
            <div class="cl"></div>
        </div>
        <?php the_content(); ?>
        
    </div>
</div>                                
<?php else: ?>
<div class="blog-one">
    <div class="blog-img">
        <?php the_post_thumbnail('thumbnail'); ?>
    </div>
    
    <div class="blog-text">
        <h3><?php the_title(); ?></h3>
        <div class="datepart">
            <div class="cl-box">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/calender-blog.png" alt="">
                <h6>04 May 2011</h6>
                <div class="cl"></div>
            </div>
            
            <div class="cl"></div>
        </div>
        <?php the_excerpt(); ?>
        
        <div class="btn-part">
            <div class="readbtn">
                <a href="<?php the_permalink(); ?>">Read More <img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/images/read-btn-arrow.png" alt=""></a>
            </div>
            
            <div class="cl"></div>
        </div>
        
    </div>
    <div class="cl"></div>
</div>
<?php endif; ?>