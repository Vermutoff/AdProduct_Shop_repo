<?php 
// Template name: Результаты поиска товаров 
$xml_request = $_GET['name_product'];
$xml_for_gs = str_replace(' ','%20',$xml_request);	
$category = $_GET['cat_product'];
?>

<!DOCTYPE html>
<html lang="ru-RU" prefix="og: http://ogp.me/ns#">
<head>

<!-- Мета теги -->
<meta charset="UTF-8" />

<title>Купить <? echo $xml_request; ?> в Интернет магазинах по выгодной цене | ShopingEconom.ru</title>
<meta name="description" content="Рекомендуем купить <? echo $xml_request; ?> в Интернет магазинах наших партнеров. В нашем каталоге вы найдете <? echo $xml_request; ?> по выгодным ценам в Интернете."/>
<!-- Линки -->
<link rel="shorcut icon" type="image/png" href="/favicon.png">
<link rel="icon" type="image/png" href="/favicon.png">
<link rel="stylesheet" type="text/css" media="all" href='http://shopingeconom.ru/wp-content/themes/promocode/style.css' />
<link rel="stylesheet" type="text/css" media="all" href='http://shopingeconom.ru/css/header.css' />
<link rel="pingback" href="http://shopingeconom.ru/xmlrpc.php" />



	<style type="text/css">
		#fancybox-close{right:-15px;top:-15px}
		div#fancybox-content{border-color:#FFFFFF}
		div#fancybox-title{background-color:#FFFFFF}
		div#fancybox-outer{background-color:#FFFFFF}
		div#fancybox-title-inside{color:#333333}
	</style>


<link rel="publisher" href="https://plus.google.com/100560824791976032685"/>

<link rel='stylesheet' id='fotorama.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama.css?ver=3.7.1' type='text/css' media='all' />
<link rel='stylesheet' id='fotorama-wp.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama-wp.css?ver=3.7.1' type='text/css' media='all' />
<link rel='stylesheet' id='fancybox-css'  href='http://shopingeconom.ru/wp-content/plugins/fancybox-for-wordpress/fancybox/fancybox.css?ver=3.7.1' type='text/css' media='all' />
<link rel='stylesheet' id='boxes-css'  href='http://shopingeconom.ru/wp-content/plugins/wordpress-seo/css/adminbar.css?ver=1.4.19' type='text/css' media='all' />
<link rel='stylesheet' id='taxonomy-image-plugin-public-css'  href='http://shopingeconom.ru/wp-content/plugins/taxonomy-images/style.css?ver=0.8.0' type='text/css' media='screen' />
<script type='text/javascript' src='http://shopingeconom.ru/wp-includes/js/jquery/jquery.js?ver=1.10.2'></script>
<script type='text/javascript' src='http://shopingeconom.ru/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<script type='text/javascript' src='http://shopingeconom.ru/wp-content/plugins/fancybox-for-wordpress/fancybox/jquery.fancybox.js?ver=1.3.4'></script>


<!-- Fancybox for WordPress v3.0.2 -->
<script type="text/javascript">
jQuery(function(){

jQuery.fn.getTitle = function() { // Copy the title of every IMG tag and add it to its parent A so that fancybox can show titles
	var arr = jQuery("a.fancybox");
	jQuery.each(arr, function() {
		var title = jQuery(this).children("img").attr("title");
		jQuery(this).attr('title',title);
	})
}

// Supported file extensions
var thumbnails = jQuery("a:has(img)").not(".nolightbox").filter( function() { return /\.(jpe?g|png|gif|bmp)$/i.test(jQuery(this).attr('href')) });

thumbnails.addClass("fancybox").attr("rel","fancybox").getTitle();

})
</script>
<!-- END Fancybox for WordPress -->

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

<div id="header">
	
	<div id="header_menu" class="main_menu">
		<div class="branding">
			<?php //wp_nav_menu( array( 'container_class' => '', 'theme_location' => 'main_menu' ) ); ?>
			<div class="logo">
				<a rel="nofollow" href="http://shopingeconom.ru">ShopingEconom.ru</a>	
			</div>
			
			<div class="site-description">Выгодные покупки в Интернет-магазинах</div>
			
			<div class="header-ya-search ya-site-form ya-site-form_inited_no" onclick="return {'bg': 'transparent', 'publicname': '\u041f\u043e\u0438\u0441\u043a \u043f\u043e \u0441\u0430\u0439\u0442\u0443 ShopingEconom.ru', 'target': '_self', 'language': 'ru', 'suggest': true, 'tld': 'ru', 'site_suggest': true, 'action': 'http://shopingeconom.ru/search_site.html', 'webopt': false, 'fontsize': 12, 'arrow': false, 'fg': '#000000', 'searchid': '2102546', 'logo': 'rb', 'websearch': false, 'type': 2}"><form action="http://yandex.ru/sitesearch" method="get" target="_self"><input type="hidden" name="searchid" value="2102546" /><input type="hidden" name="l10n" value="ru" /><input type="hidden" name="reqenc" value="" /><input type="text" name="text" value="" /><input type="submit" value="Найти" /></form></div>	
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


</div><!-- #header -->
<div id="wrapper">

<div class="bbcrumb">
	<a title="ShopingEconom" rel="nofollow" href="http://shopingeconom.ru" class="home">Главная</a> &raquo; <a title="Каталог товаров в Интернет магазинах"  href="http://shopingeconom.ru/product" class="home">Каталог товаров</a> &raquo; <? if($xml_request) echo $xml_request.' в Интернет магазинах'; ?>
</div>
<div id="main">
<div id="content" role="main" class="both">
	
	
	<?php	if(!$xml_request) { echo 'Пожалуйста, введите поисковый запрос'; } 
	else { 	
		
	if($xml_request) { echo '<h1 class="entry-title">'.$xml_request.'</h1>'; }
		
			$xml_url = 'http://www.gdeslon.ru/api/search.xml?q='.$xml_for_gs.'&l=27&_gs_at=7f54c3db2888b7a476661eb5410c608e9dff86fe';
			
			$product_for_vitrina = search_from_xml($xml_url, $search_args);
			
			$gs_vitrina_string = gs_vitrina_string($product_for_vitrina, $search_args);
	
			echo $gs_vitrina_string;
			
	
		} 
	
		
		?>
			
		<form id="more_about_product">
			<input type="hidden" id="product_card_id" name="product_card_id" value="" />
			<input type="hidden" name="product_card_file" value="<? echo $url; ?>" />
		</form>
		
		</div><!-- #content -->

<? if($product_for_vitrina) { ?>
<div class="block both">
	<h2><? if($xml_request) echo 'Купить '.$xml_request; ?></h2>
	<p>Вот, что мы нашли в Интернет магазинах по запросу - "<? if($xml_request) echo $xml_request; ?>". Если вы решили купить <? if($xml_request) echo $xml_request; ?>, то вы можете получить <a href="http://shopingeconom.ru/all-cupons.html">скидку в Интернет магазинах</a> наших партнеров. Для этого искользуйте специальный купон при оформлении заказа.</p>
</div>
<? } else { ?>
<div class="block both">
	<h2><? if($xml_request) echo 'Извините, по вашему запросу мы не нашли подходящих товаров '; ?></h2>
	<p>Попробуйте воспользоваться поиском еще раз. Мы рекомендуем задать такой запрос, который будет содержать ключевые слова. Например, <a rel="nofollow"  href="http://shopingeconom.ru/product_search.html?name_product=%D0%9A%D0%BE%D1%84%D0%B5%D0%B2%D0%B0%D1%80%D0%BA%D0%B0+Bosch+TAS+2001EE+Tassimo">Кофеварка Bosch TAS 2001EE Tassimo</a></p>
	<div class="non_result">
	<? get_template_part('functions/form','search_product'); ?>
	</div>
</div>
<? } ?>
<?php get_footer(); ?>