<?php // Template name: Все бренды
get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<div class="block both">
		<div class="tag_cloud">		
			<p>
			<?php 
			
			$args = array(
				'topic_count_text_callback' => '',
				'taxonomy'                  => 'brand'
			);
			
			wp_tag_cloud( $args ); ?>
			</p>
		</div>
	</div>

<div class="block both">
	
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

</div><!-- #content -->
<?php endwhile; ?>
<?php get_footer(); ?>
