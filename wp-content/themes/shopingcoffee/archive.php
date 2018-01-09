<?php get_header(); ?>					<div id="content" role="main" class="block both"><h1 class="single-title"><?php if ( is_day() ) : ?>				<?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?><?php elseif ( is_month() ) : ?>				<?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date('F Y') ); ?><?php elseif ( is_year() ) : ?>				<?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date('Y') ); ?>				<?php elseif ( is_category() ) : ?>				<?php printf( __( 'Category: %s', 'twentyten' ), single_cat_title( '', false )); ?><?php else : ?>				<?php printf( __( '%s', 'twentyten' ), single_cat_title( '', false )); ?><?php endif; ?>			</h1>
		

<?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

			

<?php rewind_posts(); ?><? if (is_tax('blog_category')) : ?><? get_template_part( 'loop', 'blog' ); ?><? elseif (is_tax('brand')) : ?><? get_template_part( 'loop', 'blog' ); ?><? else : ?>
<? get_template_part( 'loop', 'blog' ); ?><? endif; ?>

			</div><!-- #content -->
<?php get_footer(); ?>