<?php get_header(); ?>
<div id="content" role="main" class="both">
<div class="both block big_product_card">
<?php 	if ( have_posts() ) while ( have_posts() ) : the_post(); 
		setPostViews(get_the_ID()); 
		?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

	
		<div class="left">
			<div class="fotorama" data-nav="thumbs" data-width="800" data-navposition="top">
			</div>
		</div>
	
		<div class="right">
			<div class="big_product_buy">
		
			<div class="big_product_price"><h3 style="color: #888888;">Цена</h3><b><? echo get_post_meta($post->ID, 'price', true); ?></b> рублей</div>
	
			<div class="product_buttons">
				<span class="product_button blue link" data-href="<? echo get_post_meta($post->ID, 'url', true); ?>">Купить в магазине »</span>
			</div>
		</div>
			
		<div class="social_block">
								<div class="h4">Поделитесь или сохраните</div>
								<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,twitter,gplus,facebook,odnoklassniki,yaru,moimir" data-yashareTheme="counter" data-yashareType="large"></div>
							</div>
         
		</div><!-- Конец поста -->

       
<div class="block both">
				<?php the_content(); ?>
			
			<h2>Отзывы<? if($product_name) { echo ' про '.$product_name; }?></h2>
			<?php //comments_template( '', true ); ?>
			
	<div class="posted_on">Опубликованно <span class="updated"><?php the_time('j F Y'); ?> в <time><?php the_time('G:i'); ?></time></span></div>
</div>
<? endwhile; ?>



<?php get_footer(); ?>