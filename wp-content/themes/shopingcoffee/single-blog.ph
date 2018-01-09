<?php get_header(); ?>

		<div id="container">
			<div class="bbcrumb"><?php kama_breadcrumbs(); ?></div>
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<h1 class="single-title"><?php the_title(); ?></h1>
	<div class="entry-post">
		
		<?php the_content(); ?>

    </div>



				</div><!-- #post-## -->
	
<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->

		</div><!-- #container -->

<?php get_sidebar('blog'); ?>
<?php get_footer(); ?>