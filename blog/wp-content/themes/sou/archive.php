<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<section class="contentpart">
	<div class="wrapper">
    	<div class="blogpart">
        	<?php the_archive_title( '<h2>', '</h2>' );
			the_archive_description( '<p>', '</p>' ); ?>
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