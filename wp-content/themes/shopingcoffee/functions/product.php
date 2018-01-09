<?php 
// Template name: Подробно о товаре 

$parent_id = $_GET['parent'];
if(!empty($_GET['parent_category_term_id'])) {
	$parent_category_term_id = $_GET['parent_category_term_id']; 
	$xml_file_gdeslon = get_option('product_cat_'.$parent_category_term_id.'_xml_file_gdeslon');
	$url = GET_XML_VITRINA_BASEPATH.'xml_files/'.$parent_category_term_id.'.xml';
} else {
	$parent_category_term_id = $_GET['parent']; 
	$xml_request = get_post_meta($_GET['parent'], 'wpcf-xml_file', true);
	$xml_file_gdeslon = 'http://www.shopingeconom.ru/wp-content/themes/promocode/functions/gde_slon_vitrina/xml_files/'.$parent_category_term_id.'.xml';
	$url = $xml_file_gdeslon;
}


$id_product = $_GET['product_id'];

if(!$xml_file_gdeslon) { echo 'Пожалуйста, введите поисковый запрос'; } else { 
	
	$xml = simplexml_load_file($url);
	$this_product = null;
	if($xml) {
		foreach ($xml->xpath('shop/offers/offer') as $product) {
			if($id_product == $product[id]) {
					
				// Форматируем цену
				$num = explode('.',$product->price); 
				$price = $num[0];
						
				// собираем картинки
				$product_images = array();
				$product_images = $product->original_picture;
						
				// записываем все в массив для дальнейшей работы
				$this_product = array(
					'id' => $product[id],
					'name' => $product->name,
					'img' => $product_images,
					'merchant' => $product[merchant_id],
					'price' => $price,
					'link' => $product->url,
					'description' => $product->description
				);
			}
		}			
	}
} 
?>
<!DOCTYPE html>
<html lang="ru-RU" prefix="og: http://ogp.me/ns#">
<head>

<!-- Мета теги -->
<meta charset="UTF-8" />

<title>Купить <? echo $this_product['name']; ?> в Интернет магазине за <? echo $this_product['price'].' рублей'; ?></title>
<meta name="description" content="Рекомендуем купить - <? echo $this_product['name']; ?> в Интернет магазинах наших партнеров. В нашем каталоге вы найдете этот товар по цене <? echo $this_product['price'].' рублей'; ?>."/>
<!-- Линки -->
<link rel="shorcut icon" type="image/png" href="/favicon.png">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="stylesheet" type="text/css" media="all" href='http://shopingeconom.ru/wp-content/themes/promocode/style.css' />
<link rel="stylesheet" type="text/css" media="all" href='http://shopingeconom.ru/css/header.css' />
<link rel="publisher" href="https://plus.google.com/100560824791976032685"/>

<link rel='stylesheet' id='fotorama.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama.css?ver=3.7.1' type='text/css' media='all' />
<link rel='stylesheet' id='fotorama-wp.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama-wp.css?ver=3.7.1' type='text/css' media='all' />

<script type='text/javascript' src='http://shopingeconom.ru/wp-includes/js/jquery/jquery.js?ver=1.10.2'></script>
<script type='text/javascript' src='http://shopingeconom.ru/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>

<link rel='stylesheet' id='fotorama.css-css'  href='/wp-content/themes/promocode/js/fotorama/fotorama.css' type='text/css' media='all' />
<script type='text/javascript' src='/wp-content/themes/promocode/js/fotorama/fotorama.js'></script>
</head>

<body>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5V8LL3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5V8LL3');</script>
<!-- End Google Tag Manager -->

<div id="wrapper">
<div id="header">
		
	<div id="header_menu" class="main_menu">
		<div class="branding">
			<?php //wp_nav_menu( array( 'container_class' => '', 'theme_location' => 'main_menu' ) ); ?>
			<div class="logo">
				<a rel="nofollow" href="http://shopingeconom.ru">Выгодные<br/> покупки в Интернете</a>
			</div>
			
			
			
			<div id="ya_search">
				<div class="ya-site-form ya-site-form_inited_no" onclick="return {'action':'http://shopingeconom.ru/search_site.html','arrow':false,'bg':'transparent','fontsize':14,'fg':'#000000','language':'ru','logo':'rb','publicname':'Поиск по сайту ShopingEconom.ru','suggest':true,'target':'_self','tld':'ru','type':2,'usebigdictionary':true,'searchid':2102546,'webopt':false,'websearch':false,'input_fg':'#000000','input_bg':'#ffffff','input_fontStyle':'normal','input_fontWeight':'normal','input_placeholder':'','input_placeholderColor':'#000000','input_borderColor':'#7f9db9'}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="2102546"/><input type="hidden" name="l10n" value="ru"/><input type="hidden" name="reqenc" value=""/><input type="search" name="text" value=""/><input type="submit" value="Поиск"/></form></div><style type="text/css">.ya-page_js_yes .ya-site-form_inited_no { display: none; }</style><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0],e=d.documentElement;if((' '+e.className+' ').indexOf(' ya-page_js_yes ')===-1){e.className+=' ya-page_js_yes';}s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Form.init()})})(window,document,'yandex_site_callbacks');</script>
			</div>
		</div>
		
		<div class="services">
			<ul>
				<li class="cupons"><a rel="nofollow" href="http://shopingeconom.ru/discount.html">Купоны на скидку</a></li>
				<li class="credits"><a rel="nofollow" href="http://bank.shopingeconom.ru">Покупки в кредит</a></li>
				<li class="sales"><a rel="nofollow" href="">Распродажи</a></li>
			</ul>
		</div>
	</div>
	
	


<div class="search_menu">
	<div class="branding">
		<?php wp_nav_menu( array( 'container_class' => 'main_menu', 'theme_location' => 'main_menu' ) ); ?>
		<?php wp_nav_menu( array( 'container_class' => 'right_menu', 'theme_location' => 'right_menu' ) ); ?>		
	</div>
</div>
<?php //if(is_post_type_archive('product') or is_tax('product_cat') or is_singular('product')) { get_sidebar('product'); } ?>


</div><!-- #header -->

<div id="main">
<div class="bbcrumb">
	<a title="ShopingEconom" rel="nofollow" href="http://shopingeconom.ru" class="home">Главная</a> &raquo; <a title="<? echo get_the_title($_GET['parent']); ?>"  href="<? echo get_permalink($_GET['parent']); ?>"><? echo get_the_title($_GET['parent']); ?></a> &raquo; <? echo $this_product['name']; ?>
</div>
<div id="content" role="main" class="both">
<?
if ( have_posts() ) while ( have_posts() ) : the_post(); 

if($this_product) {

$merchant_id = $this_product['merchant'];
$merchant_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'wpcf-merchant_id' and meta_value = $merchant_id"); 


	$product_card .= '<h1>'.$this_product['name'].'</h1>';
	$product_card .= '<div class="big_product_card">';
	$product_card .= '<div class="left">';
	$big_product_images = $this_product['img'];
	$count_img = count($big_product_images);
	if($count_img > 1) {
	$product_card .= '<div class="fotorama" data-nav="thumbs" data-width="800" data-navposition="top">';
			
			foreach ($big_product_images as $big_product_image) {
				$product_card .= '<img src="'.$big_product_image.'" />';
			}
		$product_card .= '</div>';
	} else {
		$product_card .= '<img src="'.$big_product_images.'" />';
	}
	
	
	$product_card .= '</div>';
	
	$product_card .=	'<div class="right">';
	
	$product_card .=	'<div class="big_product_buy">
		
		<div class="big_product_price"><div class="h2">Цена</div><b>'.$this_product['price'].'</b> рублей</div>';
	
	if($merchant_post_id) {
		$merchant_thumbnail = get_the_post_thumbnail( $merchant_post_id);
		$merchant_permalink = get_permalink( $merchant_post_id);
		
		$product_card .= '<div class="merchant"><div class="h2">Магазин</div><a class="merchant_thumbnail" target="_blank" href="'.$merchant_permalink.'">'.$merchant_thumbnail.'</a></div>';
	}
	
		
	$product_card .=	'<div class="product_buttons"><span class="product_button grbutton link" data-href="'.$this_product['link'].'?sub_id=SE_product_more">Купить в магазине »</span>';
	
	
				
	$product_card .= '<span title="В список покупок" class="product_button lovely_product" 
							data-id="'.$this_product['id'].'" 
							data-name="'.$this_product['name'].'" 
							data-img="'.$this_product['img'].'" 
							data-price="'.$this_product['price'].'" 
							data-parent="'.$post->ID.'" 
							data-link="'.$this_product['link'].'"
						
						>Добавить в список покупок</span></div>';
	
	$product_card .= '</div>';
			
	$product_card .= '<div class="social_block">
								<div class="h4">Поделитесь или сохраните</div>
								<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,twitter,gplus,facebook,odnoklassniki,yaru,moimir" data-yashareTheme="counter" data-yashareType="large"></div>
							</div>
	';
	
	
	
	//if($merchant_post_id) { $product_card .= '<span class="get_promocode">Хочу скидку!</span>'; }

	
	
	
	
	
	
/*	
	if($merchant_post_id) {
		$product_card .= '<h3>Ваши купоны</h3>';
		$product_card .= '<div id="promocode"></div>';
	}
*/
	
//	$product_card .=	'<div class="big_product_description"><h3>Описание товара</h3>'.$this_product['description'].'</div>';
	$product_card .= 	'</div>';
	$product_card .= '<div class="description"><div class="h2">От производителя</div>'.$this_product['description'].'</div>';
	$product_card .= '</div>';
	//if(!$merchant_post_id) { $product_card .= $merchant_id;}
	
} else {
	$product_card .= 'Данные о продукте не получены';
}
echo $product_card;

endwhile;
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
		var post_id = <?php echo $merchant_post_id;?>
																	
		$.ajax({
			type: "post",
			url: "/spisok-promokodov.html",
			data: {
				post_id: post_id
			},
			success: function(data) {
										
			$('#promocode').html(data);
			}
		});	
});
</script>


<?php $xml_request = get_post_meta($_GET['parent'], 'wpcf-xml_file', true);

if($xml_request) { 	
			$url = 'http://www.shopingeconom.ru/wp-content/themes/promocode/functions/product_xmls/'.$xml_request.'.xml';
			$xml = simplexml_load_file($url);
			if($xml) {
				
				$product_for_vitrina = null;
				foreach ($xml->xpath('shop/offers/offer') as $product) {
					
					$num = explode('.',$product->price); 
					$price = $num[0];
					$id_product = $product[id];
					$product_original_picture = $product->original_picture[0];
					
					$product_for_vitrina[] = array(
						'id' => $id_product,
						'image' => $product_original_picture,
						'merchant' => $product[merchant_id],
						'name' => $product->name,
						'price' => $price,
						'link' => $product->url,
						'parent' => $_GET['parent'],
						'parent_category_term_id' => $parent_category_term_id
					);
					
				}
				
			}
	
		}

if($product_for_vitrina) {
	function sort_p($b, $a)
	{
	return strnatcmp($b["price"], $a["price"]);
	}

	shuffle($product_for_vitrina);
	
	//shuffle($product_for_vitrina);
	
	$vitrina .= '<div class="product_list both">';
	$product_count = 0;
	$xml_count = 0;
	foreach ($product_for_vitrina as $product_this) {
		$product_count++;
		$xml_count++;
		if($xml_count<10) {
			if($product_count == 1) { $product_class = 'first'; }
			if($product_count == 2) { $product_class = 'second'; }
			if($product_count == 3) { $product_class = 'last'; }
			$vitrina .= '<div id="product_card-'.$product_this['id'].'" class="product_card block '.$product_class.'">';
			$vitrina .= '<span class="thumb"><span class="link" data-href="/product.html?parent='.$product_this['parent'].'&product_id='.$product_this['id'].'"><img id="'.$product_this['id'].'" class="product_more" alt="Купить '.$product_this['name'].' за '.$product_this['price'].' рублей" src="';
			if($product_this['image']) { $vitrina .= $product_this['image']; } else { $vitrina .= '/wp-content/themes/promocode/images/noimage_product.png';}
			$vitrina .= '"></span></span>';
			$vitrina .= '<span class="product_title link" data-href="/product.html?parent='.$product_this['parent'].'&product_id='.$product_this['id'].'">'.$product_this['name'].'</span>';
			$vitrina .= '<span class="product_price"><b>'.$product_this['price'].'</b> руб</span>';
			$vitrina .= '<span class="link product_button grey" data-href="'.$product_this['link'].'">Купить</span>
			
			<button title="В список покупок" class="lovely_product" 
			data-id="'.$product_this['id'].'" 
			data-name="'.$product_this['name'].'" 
			data-img="'.$product_this['image'].'" 
			data-price="'.$product_this['price'].'" 
			data-parent="'.$product_this['parent'].'" 
			data-link="'.$product_this['link'].'"
			
			>Отложить товар</button>';
			$vitrina .= '</div>';
			if($product_count == 3) { $product_count = 0; }
		}
	}
	$vitrina .= '</div>';
	
	if($vitrina) { 
		$parent_title = get_the_title($_GET['parent']); 
		echo '<h2>Смотрите еще</h2>'.$vitrina; } 
} 

 ?>

<?php get_footer(); ?>