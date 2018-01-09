<?
/*
 * The template name: Список промокодов
 */
?>

<?php
// require_once('wp-load.php');
	if (!empty($_POST['post_id'])) { $post_id = $_POST['post_id']; }
	
	// если мы получили id posta, то продолжаем
	if($post_id) {
		$offers_id = get_post_meta($post_id, 'wpcf-offers_id', true); // получаем id нужного оффера для нужного поста и подставляем значение в URL
		$offers_logo = the_post_thumbnail($post_id, 'medium', array('class' => 'img-responsive'));
		$url = 'http://shopingeconom.ru/wp-content/themes/promocode/functions/xmls/cupons.xml'; // получили URL адрес для скачивания RSS фида с промокодами для нужного арендодателя
		
		$xml = simplexml_load_file($url); // проверяем существование этого фида
		
		// если RSS feed существует, то продолжаем
	if($xml) {
		
			// разбираем фид и извлекаем промокоды
		foreach ($xml->xpath('coupons/coupon') as $coupon) {
			if($coupon) {
				if($coupon->advcampaign_id == $offers_id) {
					
						$cupons_array[] = array(
							'cupon_id' => $coupon['id'],
							'cupon_advert_id' => $coupon->advcampaign_id,
							'cupon_logo' => $coupon->logo,
							'cupon_short_name' => $coupon->short_name,
							'cupon_name' => $coupon->name,
							'cupon_description' => $coupon->description,
							'cupon_promolink' => $coupon->promolink,
							'cupon_specie_id' => $coupon->specie_id,
							'cupon_date_start' => $coupon->date_start,
							'cupon_date_end' => $coupon->date_end
						);
						
				} else {
					$error = '<div style="text-align: center; width: 100%;padding: 15px;">Извините, промокоды для этого магазина временно отсутствуют</div>';
				}	
			} 		
		} 
	} else { $error .= 'XML не получен';}
		
		if (is_array($cupons_array)) { echo get_cupon_list($cupons_array); } else { echo $error;}
		
	} else { $error .= 'POST_ID не получен';}

		
/*	Формируем список купонов из массива
============================================
function get_cupon_list($cupons_array) {
	if(is_array($cupons_array)) {
		$cupon_string = null;
		$cupon_string .= '<div class="coupon col-md-6">';
		foreach ($cupons_array as $cupon) {
			
			$cupon_string .= '<div class="coupon_logo">'.$cupon['cupon_logo'].'</div>';
			$cupon_string .= '<h4><b>'.$cupon['cupon_short_name'].': </b>'.$cupon['cupon_name'].'</h4>';
			$cupon_string .= '<div class="coupon_description"><p>'.$cupon['cupon_description'].'</p>';
			$cupon_string .= '<button class="btn btn-warning btn-block link" data-href="'.$cupon['cupon_promolink'].'">Использовать купон »</button>';
			
		}
		$cupon_string .= '</div>';
	}
	return $cupon_string;
}
*/	
?>