<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
 ?>
<section class="contentpart">
	<div class="wrapper">
    	
        <div class="blogpart">
        	<h2>Our Blog</h2>
            <div class="left-blog">
                <?php while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				endwhile; ?>
			</div>
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
                <div class="right-blog">
                    <?php dynamic_sidebar( 'sidebar-1' ); ?>
                </div><!-- .widget-area -->
            <?php endif; ?>
            <div class="cl"></div>
        </div>
        
    </div>
</section>