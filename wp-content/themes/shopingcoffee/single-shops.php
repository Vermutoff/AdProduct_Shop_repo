<?php get_header(); ?>
	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
$post_id = $post->ID;?>



<?php 	
	setPostViews(get_the_ID());
	$shop_description = get_post_meta($post->ID, 'shop_description', 1); 
	$offers_name = get_post_meta($post->ID, 'wpcf-offers_name', 1); 
	$payments = get_post_meta($post->ID, 'wpcf-payments', 0); 
	$promocode_description = get_post_meta($post->ID, 'wpcf-promocode_description', 1);
	$magazin_code = get_post_meta($post->ID, 'wpcf-code', 1);
	$top_code = get_post_meta($post->ID, 'wpcf-top_code', 1);
	$shop_id = get_post_meta($post->ID, 'vitrina_shop_id', 1);	
	if($shop_id) { $link = 'http://adproduct.ru/goto?shop_id='.$shop_id.'&sub_id=logo_link'; 	}
	$sale_link = get_post_meta($post->ID, 'wpcf-sale_link', 1); 
	$excerpt = get_the_excerpt();
?>

<section>
	<div id="post-<?php the_ID(); ?>" class="single-magazin">
		<div class="row">
			<div class="col-md-12"><?php
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('<p id="breadcrumbs" class="grey-text font-size-10 margin-bottom-0">','</p>');
}
?></div>
			
			<div class="col-md-12"><h1 class="entry-title"><?php the_title(); if(!empty($shop_description)) { echo ' '.$shop_description; } ?></h1></div>
	
			<div class="col-md-3"><div class="white-block p-25 m-0-0-45-0">
				
					
						<div class="m-0-0-25-0 shop-logo">
							<?php 
							$shop_logo_image_url = get_post_meta($post->ID, 'shop_logo_image_url', 1);
							$thumbnail = get_post_meta($post->ID, 'wpcf-pictures', true );
							if (has_post_thumbnail()) { ?>
								<span <?php if($shop_id) { echo 'class="link img" data-href="'.$link.'"'; } ?>><?php the_post_thumbnail('medium', array('class' => 'thumbnail img-responsive center-block')); ?></span>
							<?php } elseif($shop_logo_image_url) { ?>
								<span <?php if($shop_id) { echo 'class="link img" data-href="'.$link.'"'; } ?>><img class="thumbnail img-responsive center-block" src="<? echo $shop_logo_image_url; ?>" /></span>
							<? } else { ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/noimage.jpg" /></a>
							<? } ?>
							
							
							
							<? 	
								if($shop_id) { ?> <span class="btn btn-success center-block link" onclick="yaCounter21865573.reachGoal('gotosite'); return true;" data-href="<?php echo $link; ?>">Официальный сайт</span> <? }
								if($sale_link) { echo '<span class="sale_link link" data-href="'.$sale_link.'">Распродажа в магазине</span>';}
								
							?>
							
						
						</div>
				
						<div id="top-navigation">
							<!--button class="nav_link btn btn-warning btn-block" data-ancor="#catalog">Каталог</button-->
							<button class="nav_link btn btn-danger btn-block" data-ancor="#cupons">Скидки</button>
							<button class="nav_link btn btn-primary btn-block" data-ancor="#respond">Отзывы</button>
							<button class="nav_link btn btn-info btn-block" data-ancor="#description">Обзор</button>
						
							<?php //if($shop_id) { echo '<span class="nav_link link" data-href="'.$link.'">Официальный сайт</span>';} ?>
						</div>
					
					
				</div>
		</div>
		
		<div class="col-md-9 about_magazin">
			<div class="row"><div class="col-md-12">
				<div class="white-block p-25 m-0-0-45-0">
					<div class="row">
						<div class="col-md-4"> 
							<div class="center-text">Рейтинг магазина</div>
							<?php if(function_exists('the_ratings')) { the_ratings(); } ?></div>
							
							<div class="col-md-4"> 
							<?php if(!empty($payments)) {//var_dump($payments[0]);
							$payments_string = '<div class="center-text">Способы оплаты</div><ul class="grey-text list-style-none padding-left-0 margin-bottom-0">';
								foreach($payments[0] as $key => $array0) {
									if($array0[0] == 'nal') { $payments_string .= '<li>Наличные</li>';}
									if($array0[0] == 'visa') { $payments_string .= '<li>Visa/MasterCard</li>';}
									
								}
								$payments_string .= '</ul>';
								echo $payments_string;
							}
							?>
							</div>
						<?php//if($excerpt != '') { echo '<div class="">'.removeLinks($excerpt).'</div>';} ?>
						</div>	
				
				
					</div>	

			</div></div>	
						
						
				
	<div id="catalog" class="row">
		
		<div class="m-0-0-45-0">
		<div class="col-md-12"><div class="h2 margin-top-0">Каталог товаров</div></div>
		<div class="result"></div>
		<div id="shop_catalog"><img src="/wp-content/themes/shopingwoman/images/ajax-loader.gif"></div>
		<?php
		if($shop_id) { ?><div class="col-md-4 col-md-offset-4"><span style="max-width: 250px; text-decoration: none;" class="btn btn-warning center-block text-center link" onclick="yaCounter21865573.reachGoal('gotosite'); return true;" data-href="<?php echo $link; ?>">Перейти в магазин</span></div> <? }
		
		
			
			
					/*	Описание магзина
					=============================================*/
				//	if($magazin_description) { echo '<noindex><div class="magazin_description">'.removeLinks($magazin_description).'</div></noindex>'; } 
			
					/*	Произвольный код сверху
					=============================================*/
					if($top_code) { echo '<div class="top_code">'.$top_code.'</div>'; }
					
			?>
			
		
		
		<?php
		
			
		 
			
			
				?>
		
		
		
		
	</div>
	</div>	

	<div id="respond" class="row">
		<div class="col-md-12">
		<h2 class="h1">Отзывы</h2>
		<div class="white-block p-25 m-0-0-45-0">
			<p>Если Вы уже совершали покупки в этом Интернет магазине, пожалуйста, добавьте Ваш отзыв. Он будет полезен тем, кто собирается или сомневается 	сделать покупку. Расскажите о качестве товара, про обслуживание и работу персонала, а также другие моменты, которые Вы считаете важными.</p>
			<?php get_template_part('share'); ?>
		</div>
		<?php comments_template(); ?>
	</div></div>					
						
						
		</div>
	</div>
	
	
			

<?php 
$default_list_id = get_post_meta($post->ID, 'wpcf-default_list_id', 1); 
		$unisender_action = get_post_meta($post->ID, 'wpcf-unisender_action', 1); 


echo '<div class="row">
	<div id="cupons" class="h1 col-md-12">Бесплатные купоны и промокоды</div>
	';
		
		
		if($default_list_id) { 
			echo '<div class="col-md-4"><div class="widget green block"><div class="widget-title">Подпишись и экономь!</div><p>Новые купоны '.$offers_name.' - отправляем каждую неделю прямо на почту</p><form method="POST" action="'.$unisender_action.'" name="subscribtion_form" onsubmit="return us_.onSubmit(this);" us_mode="embed">
				<label>Введите ваш E-mail*</label>
				<input type="text" name="email" _validator="email" _required="1" _label="E-mail" placeholder="Email адрес">
				<div class="error-block" style="display:none;color:#ff592d;font:11px/18px Arial;"></div>
				<button href="javascript:;" target="_blank">Получать купоны</button>
				
				<input type="hidden" name="charset" value="">
				<input type="hidden" name="default_list_id" value="'.$default_list_id.'">
				<input type="hidden" name="overwrite" value="2">
			</form></div>'; 
			echo '</div>';
		}
		
		
			

	
		
			echo do_shortcode('[adproduct_promo_vitrina_shortcode id="'.$post->ID.'"] ');
		
		
		
			
			
	
		
	
echo '</div>';
 ?>

<div class="row">
	<div id="description" class="col-md-8">	
		<div class="white-block p-25">	
			
				<?php the_content(); 
				
			/*	Видео о магазине
			=============================================*/
			$videos = get_post_meta($post->ID, 'wpcf-video');
			if($videos['0'] != '') { 
				echo '<h3 class="h3">Интересное видео про '.$offers_name.'</h3><div class="row magazin_video">';
				foreach ($videos as $video) {
					echo '<div class="col-md-4"><div class="block video"><iframe src="http://www.youtube.com/v/'.$video.'" frameborder="0" allowfullscreen></iframe></div></div>';
				}
				echo '</div>';
			}
			?>
			
			<?php get_template_part('share'); ?>
		</div></div>
		
	<div class="col-md-4">
		<div class="">
		<?php 
			/* Полезные ссылки
		==============================*/

			$tags = wp_get_post_tags($post->ID);
			if ($tags) {
				echo '<div class="best_links">';
				$first_tag = null;
				foreach ($tags as $tag_term_id) {
					$first_tag[] = $tag_term_id->term_id;
				}
			
				$args=array(
				'post_type' => 'blog',
				'tag__in' => $first_tag,
				'showposts' => 4
				);
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					
				
					<!-- Начало поста -->
					<div id="post-<?php the_ID(); ?>" class="card-blog white-block m-0-0-25-0">
						
						<?php 
						$thumbnail = get_post_meta($post->ID, 'wpcf-pictures', true );
						if (has_post_thumbnail()) { ?>
						<a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('medium', array( 'class'=>'img-responsive')); ?></a>
						<?php } elseif($thumbnail) { ?>
						<a rel="nofollow" href="<? the_permalink() ?>"><img class="thumbnail img-responsive" alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
						<? } ?>
						<div class="p-25">
							<a href="<?php the_permalink(); ?>"><? the_title(); ?></a>
						</div>
					</div><!-- Конец поста -->
					
				<?php	endwhile;
				}
				wp_reset_query();
				echo '</div>';
			}
				
		?>
		</div>
	</div>
</div>
	
			<form action="/prices.html" method="post">
			<input id="post_id-<? the_ID(); ?>" name="post_id" type="hidden" value="<? echo $post->ID; ?>">
			</form>

		
			
<?php endwhile; ?>
<div class="posted_on">Опубликованно <span class="updated"><?php the_time('j F Y'); ?> в <time><?php the_time('G:i'); ?></time></span></div>
			
	</div>
</section>
	
<?php get_footer(); ?>