<?php get_header(); ?>

<?php

	if ( have_posts() )
		the_post();
?>
<?php rewind_posts(); ?>
</section>
<?php get_footer(); ?>