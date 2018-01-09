<?	
// Template name: Ajax поиск товаров
$xml_request = $_POST['name_product'];
if($_POST['page_number']) { $page_number = $_POST['name_product']; } else { $page_number = 1;}

if($xml_request) { 	
	
	$url = 'http://api.gdeslon.ru/api/search.xml?q='.$xml_request.'&order=newest&l=100&p='.$page_number.'&_gs_at=7f54c3db2888b7a476661eb5410c608e9dff86fe';
	$xml = simplexml_load_file($url);
	if($xml) {
				$product_card .= '<div class="product_list">';
				foreach ($xml->xpath('shop/offers/offer') as $product) {
					if($product) {
						$num = $product->price;
						$product_original_picture = $product->original_picture[0];
						$width = '';
							$product_card .= '<div class="product_card">';
							$product_card .= '<span class="thumb"><img id="'.$product[id].'" class="product_more" alt="Купить '.$product->name.' за ' . rtrim(rtrim($num, '0'), '.').' рублей" src="';
							if($product_original_picture) { $product_card .= $product_original_picture; } else { $product_card .= '/wp-content/themes/promocode/images/noimage_product.png';}
							
							$product_card .= '" /></span>';
							$product_card .= '<span class="product_title">'.$product->name.'</span>';
							$product_card .= '<span class="product_price">' . rtrim(rtrim($num, '0'), '.').' руб.</span>';
							$product_card .= '<a target="_blanck" rel="nofollow" class="product_button" href="/link.php?to='.$product->url.'">Купить</a>';
							
							$product_card .= '</div>';
					} else {
						$error_string .= 'Что-то пошло не так... попробуйте еще раз чуть позже';
					}
				}
					
					$product_card .= '</div>';
					//$product_card .= '<button class="goto next_page">Каталог товаров</button>';
	}
	
} else {
	$error_string .= 'Что-то пошло не так... попробуйте еще раз чуть позже';
}
		
	echo '<div id="content" class="block both">';
	echo '<h1 class="entry-title">Вот, что мы нашли в Интернет магазинах по запросу "'.$xml_request.'"</h1>';
		if($product_card) { echo $product_card; }
		if($error_string) { echo $error_string; }
	echo '</div>';
?>
		
		
		<form id="more_about_product">
			<input type="hidden" id="product_card_id" name="product_card_id" value="" />
			<input type="hidden" name="product_card_file" value="<? echo $url; ?>" />
		</form>
		
		