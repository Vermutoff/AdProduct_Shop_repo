<?php if ( ! have_posts() ) : ?>

	<div id="post-0" class="post error404 not-found">

		<h2 class="entry-title">Извините, страница не найдена</h2>
	
		
				<div class="entry-content">
				<p>К сожалению, страница, которую вы искали, отсутствует на блоге. Скорее всего, это ошибка в адресе страницы. Пожалуйста, воспользуйтесь поиском, с помощью формы ниже.</p>
				<div class="ya-site-form ya-site-form_inited_no" onclick="return {'bg': 'transparent', 'publicname': '\u041f\u043e\u0438\u0441\u043a \u043f\u043e \u0441\u0430\u0439\u0442\u0443 ShopingEconom.ru', 'target': '_self', 'language': 'ru', 'suggest': true, 'tld': 'ru', 'site_suggest': true, 'action': 'http://shopingeconom.ru/search_site.html', 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#000000', 'searchid': '2102546', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="2102546" /><input type="hidden" name="l10n" value="ru" /><input type="hidden" name="reqenc" value="" /><input type="text" name="text" value="" /><input type="submit" value="Найти" /></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;(' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1&&(e.className+=' ya-page_js_yes');s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
				
				</div><!-- .entry-content -->

	</div><!-- #post-0 -->

<?php endif; ?>

<?php /* Start the Loop. */ ?>
<div class="row">
	<?php $count=0; while (have_posts()) : the_post(); $count++; ?>
	<div class="col-md-4 text-center">
	<!-- Начало поста -->
	<div id="post-<?php the_ID(); ?>" class="white-block p-25 m-0-0-25-0">
		
			<?php 
			$thumbnail = get_post_meta($post->ID, 'shop_logo_image_url', true );
			if (has_post_thumbnail()) { ?>
			<a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('medium', array('class' => 'thumbnail img-responsive center-block')); ?></a>
			<?php } elseif($thumbnail) { ?>
			<a rel="nofollow" href="<? the_permalink() ?>"><img class="thumbnail img-responsive center-block" src="<? echo $thumbnail; ?>" /></a>
			<? } else { ?>
			<a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/noimage.png" /></a>
			<? } ?>
			
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
		<?php the_title(); ?>
		</a>
		

		<?php /*
		$more_links = get_post_meta($post->ID, 'wpcf-more_link');
		$more_link_block = null;
			if($more_links['0'] != '') { 
				$more_link_block .= '<ul class="more_link">';
				
				$i=0;
				foreach($more_links as $more_link) {
				$i++;
					if($more_link and $i<13) {
						
						$link_arr = explode('|',$more_link);
						if($link_arr[1]) {
							$more_link_block .= '<li><span class="link" data-href="'.$link_arr[1].'">'.$link_arr[0].'</span></li>';
						} else {
							$more_link_block .= '<li>'.$more_link.'</li>';
						}
						
						if($i == 4 or $i == 8) { $more_link_block .= '</ul><ul class="more_link">'; }
					}
				
				}
				$more_link_block .= '</ul>';
				
				echo $more_link_block;
			}
			*/?>
		<div class="meta grey-text">
			
			<div class="rating_shop meta_block">
				<span>Рейтинг:</span> <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
			</div>
			
			<div class="views_shop meta_block">
				<span>Просмотров:</span> <?php $post_views_count = get_post_meta($post->ID, 'post_views_count', 1); if($post_views_count) { echo $post_views_count;} ?>
			</div>
		</div>

	</div><!-- Конец поста -->
	</div>	
	<?php if($count==3) { echo '<div class="clearfix "></div>'; $count=0; } endwhile; ?>
</div>

	<div id="nav-below" class="navigation">
	<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	</div><!-- #nav-below -->