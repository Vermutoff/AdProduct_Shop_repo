<?
/*
 * The template name: Список скидок
 */
?>

<?php
// require_once('wp-load.php');
	if (!empty($_POST['post_id'])) { $cat_discount_ID = $_POST['post_id']; }
	
	// если мы получили id posta, то продолжаем
	if($cat_discount_ID) {
		
		$url = 'http://shopingeconom.ru/wp-content/themes/promocode/functions/xmls/cupons.xml'; // получили URL адрес для скачивания RSS фида с промокодами для нужного арендодателя
		
		$xml = simplexml_load_file($url); // проверяем существование этого фида
		
		// если RSS feed существует, то продолжаем
		if($xml) {
			
			// разбираем фид и извлекаем промокоды
			foreach ($xml->xpath('coupons/coupon') as $coupon) {
				if($coupon) {
				// если удалось извлечь купоны, то записываем полученные данные в строку
					$category_ids = array();
					$category_ids = $coupon->categories;
					foreach($category_ids->category_id as $category_id) {
						if($category_id == $cat_discount_ID and $coupon->types->type_id == 1) {
							$coupon_str_delivery .= '<div class="coupon">';
							
							$offers_id = $coupon->advcampaign_id;
							$link_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta  WHERE meta_key = 'wpcf-offers_id' and meta_value = $offers_id"); 
							
						
							if($link_post_id) {
								$link_to_post = get_permalink($link_post_id);
								$coupon_str_delivery .= '<div class="coupon_logo"><a target="_blank" href="'.$link_to_post.'"><img src="'.$coupon->logo.'"></a></div>';
							} else { 
								$coupon_str_delivery .= '<div class="coupon_logo"><img src="'.$coupon->logo.'"></div>';
							}
							$coupon_str_delivery .= '<h4><b>'.$coupon->short_name.': </b>'.$coupon->name.'</h4>';
							
							$coupon_str_delivery .= '<div class="coupon_description"><p>'.$coupon->description.'</p>';
							$coupon_str_delivery .= '<a target="_blanck" rel="nofollow" class="get-price blue link" data-href="'.$coupon->promolink.'">Использовать купон »</a></div>';
							$coupon_str_delivery .= '</div>';
						}else
						if($category_id == $cat_discount_ID and $coupon->types->type_id == 2) {
							$coupon_str_discount .= '<div class="coupon">';
							
							$offers_id = $coupon->advcampaign_id;
							$link_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta  WHERE meta_key = 'wpcf-offers_id' and meta_value = $offers_id
							"); 
							
						
							if($link_post_id) {
								$link_to_post = get_permalink($link_post_id);
								$coupon_str_discount .= '<div class="coupon_logo"><a target="_blank" href="'.$link_to_post.'"><img src="'.$coupon->logo.'"></a></div>';
							} else { 
								$coupon_str_discount .= '<div class="coupon_logo"><img src="'.$coupon->logo.'"></div>';
							}
							$coupon_str_discount .= '<h4><b>'.$coupon->short_name.': </b>'.$coupon->name.'</h4>';
							
							$coupon_str_discount .= '<div class="coupon_description"><p>'.$coupon->description.'</p>';
							$coupon_str_discount .= '<a target="_blanck" rel="nofollow" class="get-price blue link" data-href="/link.php?to='.$coupon->promolink.'">Использовать купон »</a></div>';
							$coupon_str_discount .= '</div>';
						} else
						if($category_id == $cat_discount_ID and $coupon->types->type_id == 3) {
							$coupon_str_present .= '<div class="coupon">';
							
							$offers_id = $coupon->advcampaign_id;
							$link_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta  WHERE meta_key = 'wpcf-offers_id' and meta_value = $offers_id
							"); 
							
						
							if($link_post_id) {
								$link_to_post = get_permalink($link_post_id);
								$coupon_str_present .= '<div class="coupon_logo"><a target="_blank" href="'.$link_to_post.'"><img src="'.$coupon->logo.'"></a></div>';
							} else { 
								$coupon_str_present .= '<div class="coupon_logo"><img src="'.$coupon->logo.'"></div>';
							}
							$coupon_str_present .= '<h4><b>'.$coupon->short_name.': </b>'.$coupon->name.'</h4>';
							
							$coupon_str_present .= '<div class="coupon_description"><p>'.$coupon->description.'</p>';
							$coupon_str_present .= '<a target="_blanck" rel="nofollow" class="get-price blue link" data-href="/link.php?to='.$coupon->promolink.'">Использовать купон »</a></div>';
							$coupon_str_present .= '</div>';
						} else
						if($category_id == $cat_discount_ID and $coupon->types->type_id == 4) {
							$coupon_str_money .= '<div class="coupon">';
							
							$offers_id = $coupon->advcampaign_id;
							$link_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta  WHERE meta_key = 'wpcf-offers_id' and meta_value = $offers_id
							"); 
							
						
							if($link_post_id) {
								$link_to_post = get_permalink($link_post_id);
								$coupon_str_money .= '<div class="coupon_logo"><a target="_blank" href="'.$link_to_post.'"><img src="'.$coupon->logo.'"></a></div>';
							} else { 
								$coupon_str_money .= '<div class="coupon_logo"><img src="'.$coupon->logo.'"></div>';
							}
							$coupon_str_money .= '<h4><b>'.$coupon->short_name.': </b>'.$coupon->name.'</h4>';
							
							$coupon_str_money .= '<div class="coupon_description"><p>'.$coupon->description.'</p>';
							$coupon_str_money .= '<a target="_blanck" rel="nofollow" class="get-price blue link" data-href="/link.php?to='.$coupon->promolink.'">Использовать купон »</a></div>';
							$coupon_str_money .= '</div>';
						}
					}
					
					
				} else {
					$error = '<div style="text-align: center; width: 100%;padding: 15px;">Извините, промокоды для этого магазина временно отсутствуют</div>';
				}			
			} 
		} else { echo 'XML не получен';}
		
		//if ($coupon_str) { echo $coupon_str; } else { echo $error;}
		
	} else { echo 'POST_ID не получен';}
?>


	<!-- Начинаются вкладки -->
<ul class="tabs tabs1">
		<li class="t1 tab-current">Скидки</li>
		<li class="t2">Бесплатная доставка</li>
		<li class="t3">Подарок</li>
		<li class="t4">Деньги в подарок</li>
</ul>
		
	<div class="t1">
		<? echo $coupon_str_discount; ?> 
	</div>
	
	<div class="t2">
		<? echo $coupon_str_delivery; ?> 
	</div>
	
	<div class="t3">
		<? echo $coupon_str_present; ?> 
	</div>
	
	<div class="t4">
		<? echo $coupon_str_money; ?> 
	</div>