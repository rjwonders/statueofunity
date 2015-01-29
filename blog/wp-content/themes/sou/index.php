<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
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
            	<?php if ( have_posts() ) : ?>
                	<?php while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile;
					the_posts_pagination( array(
						'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
						'next_text'          => __( 'Next page', 'twentyfifteen' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
					) );
				else :
					get_template_part( 'content', 'none' );
				endif; ?>
				<div class="cl"></div>
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