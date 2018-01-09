<?php get_header(); ?>

		<div class="content" class="block both" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<h2 class="entry-title"><?php the_title(); ?></h2>
					<?php } else { ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php } ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->
				
				<h4 class="com">Оставьте свой комментарий или отзыв</h4>
				
				<?php comments_template( '', true ); ?>

<?php endwhile; ?>

			</div><!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
