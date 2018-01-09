<?php get_header(); ?>


<?php 	if ( have_posts() ) while ( have_posts() ) : the_post(); setPostViews(get_the_ID());
$cat_discount_ID = get_post_meta($post->ID, 'wpcf-offers_id', true); ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<div id="content" role="main" class="block block-600 right">
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<?php //get_xml_cupons_from_gdeslon(); //shops_logo_update_callback();  ?>
		
		<div id="promocode" data-post_id="<?php echo $post->ID;?>">
		<p>Подождите, купоны для <?php echo $offers_name; ?> загружаются. Вы можете испольовать промокоды <?php echo $offers_name; ?> в Интернет магазине, чтобы получить скидку или бесплатную доставку покупок.</p>
		
		<img class="preload" src="/wp-content/themes/promocode/images/ajax-loader.gif">
		</div>
	
</div><!-- #post-## -->
</div><!-- #content -->
	

	<?php get_sidebar('discount'); ?>
	<div class="block both">
		<?php the_content(); ?>	
	</div>
		<div class="posted_on">Опубликованно <span class="updated"><?php the_time('j F Y'); ?> в <time><?php the_time('G:i'); ?></time></span></div>

<? endwhile; ?>

	
<?php get_footer(); ?>