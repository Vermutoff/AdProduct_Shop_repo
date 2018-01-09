<?php // Template name: Фид банковской системы
get_header(); ?>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/bank_system.js"></script>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<h1 class="entry-title"><?php the_title(); ?></h1>

	 <div id="financeFid"></div>
<div id="content" role="main" class="block both">	
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

</div><!-- #content -->
<?php endwhile; ?>


<?php get_footer(); ?>
