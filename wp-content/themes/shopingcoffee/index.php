<?php 
// Template Name: Главная страница
get_header(); ?>

	<div class="row">
		<div class="col-md-12">
		<div class="white-block p-25 m-0-0-45-0">
			
					<h1 class="h1 text-center margin-bottom-25 margin-top-0">Шоппинг-блог для мудрых женщин</h1>
					<p class="text-center">Девушки и женщины очень любят шоппинг. Верно? - Да, да, мы знаем это. Именно поэтому мы создали этот проект и помогаем делать выгодные покупки в Интернет магазинах. Каким образом? Мы делимся своим опытом в блоге и рассказываем секреты, которые помогают экономить. Обзоры помогут Вам выбрать надежный и проверенный Интернет магазин, где Вы удобно и без обмана сделаете покупку. ТАкже на странице магазинов мы выкладываем бесплатные купоны на скидку. В Email рассылке сообщаем о начале распродаж и акций. Мы уверены, что наш сайт сможет быть Вам полезен. Поэтому подписывайтесь на рассылку, подписывайтесь в социальных сетях и совершайте выгодные покупки в Интернете!</p>
						
				
			
			
		</div>
		</div>
	</div>
	
	<div class="row">
				
				<?php get_template_part( 'loop', 'blog' );	?>
				
				
			</div>

	<div class="row">
		<div class="col-md-12">
		<div class="white-block p-25 m-0-0-45-0">
		
			<h2 class="h1 text-center margin-bottom-25 margin-top-0">Лучшие Интернет магазины</h2>
			<?php 	global $query_string; parse_str($query_string, $args);  
					$args['posts_per_page'] = 12;
					$args['post_type'] = 'shops';
					//$args['meta_query'] = array(array('key' => 'wpcf-premium','value' => 'premium'));  
					query_posts( $args ); ?>
					<div class="row">
<?php $count=0; while (have_posts()) : the_post(); $count++;  ?>

<div class="col-md-3 col-sx-12 col-sm-12">
<!-- Начало поста -->
<div id="post-<?php the_ID(); ?>" class="loop hentry blog block-2 text-center">
	
	<?php 
	$thumbnail = get_post_meta($post->ID, 'shop_logo_image_url', true );
	if (has_post_thumbnail()) { ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('full', array( 'class'=>'thumbnail img-responsive')); ?></a>
	<?php } elseif(!empty($thumbnail)) { ?>
	<a href="<? the_permalink() ?>"><img class="img-responsive" alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
	<? } ?>
		
</div><!-- Конец поста -->
</div>		
<?php if($count== 4) { $count=0; echo '<div class="clearfix"></div>';} endwhile; ?>
</div>	
					
					<?php
					
					wp_reset_query();	?>
		</div></div></div>
	


	<div class="row">
		
			<div class="col-md-4">
				<aside class="m-0-0-45-0">
					<div class="ticky_280_1500"><?php get_template_part('subscription'); ?></div>						
				</aside>
			</div>
			
			
			<div class="col-md-4">
				<aside class="m-0-0-45-0">
					<div id="vk_groups_640"></div>
				</aside>
			</div>
			
			<div class="col-md-4">
				<aside class="m-0-0-45-0">
					<div id="vk_poll"></div>
				</aside>
			</div>

			
	
		</div>

		
	<div class="row">
		<div class="col-md-12">
			<div class="white-block p-25">
				<h2 class="margin-bottom-25 margin-top-0">Чем полезен этот сайт?</h2>		
				<p>Ваш шопинг станет проще и удобнее, если вы воспользуетесь нашим каталогом товаров.Мы ежедневно обновляем цены и ассортимент, чтобы предоставить вам актуальные данные.Каталог разбит на категории, поэтому вам не составит труда найти нужный товар и перейти в Интернет магазин для совершения покупки.</p>
				
				<p>Ваши покупки будут выгоднее, если вы используете купон на скидку при оформлении заказа. Вы можете получить скидку практически в каждом Интернет магазине. Купоны сгруппированы по категориям, поэтому вы легко сможете найти подходящий. Многие Интернет магазины предоставляют бесплатную доставку по купону - это очень удобно!</p>
				
				<p>Теперь все купные и надежные Интернет магазины у вас "под рукой". Мы сотрудничаем с крупныи и проверенными Интернет магазинами, где каждый день совершают покупки миллионы людей. Для каждого магазина вы можете посмотреть отзывы других покупателей или оставить свой, а также получить промокод на скидку.</p>
			</div>
		</div>
	</div>


<?php get_footer(); ?>