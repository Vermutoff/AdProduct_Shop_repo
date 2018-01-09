<?php // Template name: Подробнее о товаре
	$product_card_id = $_GET['product_card_id'];
	$product_card_file = $_GET['product_card_file'];

			$xml = simplexml_load_file($product_card_file);
			if($xml) {
				echo '<div class="product_list">';
				foreach ($xml->xpath('shop/offers/offer') as $product) {
					if($product[id] == $product_card_id) {
						
						$big_product_images = array();
						$big_product_images = $product->original_picture;
						$num = $product->price;
						
						$big_product_card .= 	'<div class="left">';
							$big_product_card .= '<div class="fotorama" data-nav="thumbs" data-width="400" data-navposition="top">';
							foreach ($big_product_images as $big_product_image) {
								$big_product_card .= '<img src="'.$big_product_image.'" />';
							}
							$big_product_card .= '</div>';
						$big_product_card .= 	'</div>';
						$big_product_card .=	'<div class="right">';
						$big_product_card .=	'<div class="big_product_name">'.$product->name.'</div>';
						$big_product_card .=	'';
						$big_product_card .=	'<div class="big_product_buy"><div class="big_product_price">'.rtrim(rtrim($num, '0'), '.').' рублей</div><a target="_blanck" rel="nofollow" class="product_button" href="/link.php?to='.$product->url.'?sub_id=shopingeconom_product_more">Купить в Интернет магазине</a>
						
						</div>';
						$big_product_card .=	'<div class="big_product_description">'.$product->description.'</div>';
						$big_product_card .= 	'</div>';
					}
					
						
				}
					
			} else {
				echo 'XML файл не существует';
			}
	
		
?>
<script type='text/javascript' src='http://shopingeconom.ru/wp-includes/js/jquery/jquery.js?ver=1.10.2'></script>


<link rel='stylesheet' id='fotorama.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama.css?ver=3.7.1' type='text/css' media='all' />
<link rel='stylesheet' id='fotorama-wp.css-css'  href='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama-wp.css?ver=3.7.1' type='text/css' media='all' />

<script type='text/javascript' src='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama.js?ver=3.7.1'></script>
<script type='text/javascript' src='http://shopingeconom.ru/wp-content/plugins/fotorama/fotorama-wp.js?ver=3.7.1'></script>


<div class="big_product_card">
	<?php echo $big_product_card; ?>
</div>