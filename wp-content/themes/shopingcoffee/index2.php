<?php 
// Template Name: Главная страница
get_header(); ?>
<div>
	<div class="row">
		<div class="col-md-12">
		<div class="white-block">
			<div class="row">
				<div class="col-md-12">
					<h1 class="large-title text-center">Выгодные покупки в Интернете</h1>
					<p class="text-center">Мы знаем, как сложно порой сделать выгодную покупку в Интернет магазине. Предложений очень много, и найти хороший товар по низкой цене непросто. Особенно начинающие шопоголики испытывают много сложностей. Поэтому мы собрали для вас каталог товаров, надежные Интернет магазины и бесплатные купоны на скидку. Пользуйтесь!</p>
						
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-3 col-sm-6 text-center">
					<div class="block" style="padding: 20%;">
						<a class="thumbnail" rel="nofollow" title="Удобный каталог товаров" href="http://shopingeconom.ru/product"><img class="image-responsive center-block" src="/wp-content/themes/promocode/images/index_item1.png"></a>
						<a title="Удобный каталог товаров" href="http://shopingeconom.ru/product">Каталог товаров</a>
					</div>
				</div>
			
				<div class="col-md-3 col-sm-6 text-center">
					<div class="block"  style="padding: 20%;">
						<a class="thumbnail" rel="nofollow" title="Надежные Интернет магазины" href="http://shopingeconom.ru/stores.html"><img class="image-responsive center-block" src="/wp-content/themes/promocode/images/index_item2.png"></a>
						<a title="Надежные Интернет магазины" href="http://shopingeconom.ru/stores.html">Надежные магазины</a>
					</div>
				</div>
			
				<div class="col-md-3 col-sm-6 text-center">
					<div class="block"  style="padding: 20%;">
						<a class="thumbnail" rel="nofollow" title="Скидки в Интернет магазинах" href="http://shopingeconom.ru/discount.html"><img class="image-responsive center-block" src="/wp-content/themes/promocode/images/index_item3.png"></a>
						<a title="Скидки в Интернет магазинах" href="http://shopingeconom.ru/discount.html">Бесплатные купоны</a>
					</div>
				</div>
			
				<div class="col-md-3 col-sm-6 text-center">
					<div class="block"  style="padding: 20%;">
						<a class="thumbnail" rel="nofollow" title="Скидки в Интернет магазинах" href="http://shopingeconom.ru/blog"><img class="image-responsive center-block" src="/wp-content/themes/promocode/images/index_item4.png"></a>
						<a title="Скидки в Интернет магазинах" href="http://shopingeconom.ru/blog">Блог о покупках</a>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>

</div>

<div>
	<div class="row">
		<div class="col-md-12">
		<div class="white-block p-25 m-45-0">
		
			<h2 class="large-title text-center">Лучшие Интернет магазины</h2>
			<?php 	global $query_string;  
					// добавляем базовые параметры в массив $args  
					parse_str($query_string, $args);  
					// добавляем/заменяем параметр post_type в массиве  
					$args['posts_per_page'] = 12;
					$args['post_type'] = 'post';
					$args['meta_query'] = array(
						array(
							'key' => 'wpcf-premium',
							'value' => 'premium'
						)
					);  
					query_posts( $args ); ?>
					<div class="row">
<?php $count=0; while (have_posts()) : the_post(); $count++; $offers_name = get_post_meta($post->ID, 'wpcf-offers_name', 1);  ?>

<div class="col-md-3 col-sx-12 col-sm-12">
<!-- Начало поста -->
<div id="post-<?php the_ID(); ?>" class="loop hentry blog block-2 text-center">
	
	<?php 
	$thumbnail = get_post_meta($post->ID, 'wpcf-pictures', true );
	if (has_post_thumbnail()) { ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('full', array( 'class'=>'thumbnail img-responsive')); ?></a>
	<?php } elseif($thumbnail) { ?>
	<a href="<? the_permalink() ?>"><img class="img-responsive" alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
	<? } ?>
		
</div><!-- Конец поста -->
</div>		
<?php if($count== 4) { $count=0; echo '</div><div class="row">';} endwhile; ?>
</div>	
					
					<?php
					
					wp_reset_query();	?>
		</div></div>
	</div>
</div>

<div>
	<div class="row">
		
			<h2 class="large-title text-center">Наш блог про покупки в Интернете</h2>
			<?php 	global $query_string;  
					// добавляем базовые параметры в массив $args  
					parse_str($query_string, $args);  
					// добавляем/заменяем параметр post_type в массиве  
					$args['posts_per_page'] = 6;
					$args['post_type'] = 'blog';  
					query_posts( $args ); 
					get_template_part( 'card', 'blog' );
					wp_reset_query();	?>
		
	</div>
</div>

<div class="container">
<div>
	<div class="row">
		
		
			<h2 class="large-title col-md-12 text-center">Добро пожаловать в клуб!</h2>
		
		
			<div class="col-md-8">
				<div id="vk_groups_640"></div>
			</div>

			<div class="col-md-4">
				<aside class="aside">
					<div class="ticky_280_1500"><?php get_template_part('subscription'); ?></div>						
				</aside>
			</div>
	
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12">
			<div class="white-block p-25">
			<?php
				while (have_posts()) : the_post();
				the_content();
				endwhile;
				?>
				
				<p>Ваш шопинг станет проще и удобнее, если вы воспользуетесь нашим каталогом товаров.Мы ежедневно обновляем цены и ассортимент, чтобы предоставить вам актуальные данные.Каталог разбит на категории, поэтому вам не составит труда найти нужный товар и перейти в Интернет магазин для совершения покупки.</p>
				
				<p>Ваши покупки будут выгоднее, если вы используете купон на скидку при оформлении заказа. Вы можете получить скидку практически в каждом Интернет магазине. Купоны сгруппированы по категориям, поэтому вы легко сможете найти подходящий. Многие Интернет магазины предоставляют бесплатную доставку по купону - это очень удобно!</p>
				
				<p>Теперь все купные и надежные Интернет магазины у вас "под рукой". Мы сотрудничаем с крупныи и проверенными Интернет магазинами, где каждый день совершают покупки миллионы людей. Для каждого магазина вы можете посмотреть отзывы других покупателей или оставить свой, а также получить промокод на скидку.</p>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>