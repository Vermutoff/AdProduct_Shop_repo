<?php get_header(); ?>
		

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

			

<?php rewind_posts(); ?>
<? get_template_part( 'loop', 'blog' ); ?>

			</div><!-- #content -->
<?php get_footer(); ?>