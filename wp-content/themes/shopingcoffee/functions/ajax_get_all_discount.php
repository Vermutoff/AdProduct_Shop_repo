<?
/*
 * The template name: Список всех промокодов на странице - Скидки
 */
?>
<?php

		$url = 'http://shopingeconom.ru/wp-content/themes/promocode/functions/xmls/cupons.xml';
		
		$xml = simplexml_load_file($url); // проверяем существование этого фида
		
		// если RSS feed существует, то продолжаем
		if($xml) {
			
			// разбираем фид и извлекаем промокоды
			$coupon_count=0;
			foreach ($xml->xpath('coupons/coupon') as $coupon) {
				
				if($coupon) {
					$coupon_count++;
						
							$coupon_str_delivery .= '<div class="col-md-4"><div class="coupon white-block p-25 m-0-0-25-0 text-center">';
							
							$offers_id = $coupon->advcampaign_id;
							$link_post_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta  WHERE meta_key = 'wpcf-offers_id' and meta_value = $offers_id
							"); 
							
						
							
								$coupon_str_delivery .= '<div class="coupon_logo m-0-0-25-0"><img class="img-responsive center-block link" data-href="'.$coupon->promolink.'" src="'.$coupon->logo.'"></div>';
							
							$coupon_str_delivery .= '<div class="name m-0-0-25-0">'.$coupon->name.'</div>';
							
							//$coupon_str_delivery .= '<div class="coupon_description"><p>'.$coupon->description.'</p>';
							$coupon_str_delivery .= '<button target="_blanck" rel="nofollow" class="btn btn-warning btn-block link" data-href="'.$coupon->promolink.'">Использовать купон</button>';
							$coupon_str_delivery .= '</div></div>';
					if($coupon_count % 3 == 0) { $coupon_str_delivery .= '<div class="clearfix"></div>'; }
				} else {
					$error = '<div style="text-align: center; width: 100%;padding: 15px;">Извините, промокоды для этого магазина временно отсутствуют</div>';
				}
				
			} 
		} else { echo 'XML не получен';} 
		



		echo $coupon_str_delivery; ?> 
			