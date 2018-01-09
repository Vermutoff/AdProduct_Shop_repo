<?
/*
 * The template name: Все промокоды
 */
?>

<?php get_header(); ?>

<div id="container">
	<div id="content" class="block">
	<h1>Скидки, акции и подарки в Интернет магазинах</h1>
<?php

	// если мы получили id posta, то продолжаем

		$offers_id = get_post_meta($post_id, 'wpcf-offers_id', true); // получаем id нужного оффера для нужного поста и подставляем значение в URL
		
		$url = 'http://shopingeconom.ru/wp-content/themes/promocode/functions/xmls/cupons.xml'; // получили URL адрес для скачивания RSS фида с промокодами для нужного арендодателя
		$categoryes_adv = $_POST['categoryes_adv'];
		$advcampaigns = $_POST['advcampaigns'];
		
		$xml = simplexml_load_file($url); // проверяем существование этого фида
		
		// если RSS feed существует, то продолжаем
		if($xml) {
			$advcampaign_str .= '<select name="advcampaigns">';
			foreach ($xml->xpath('advcampaigns/advcampaign') as $advcampaign) {
				
				// если удалось извлечь купоны, то записываем полученные данные в строку
			
					
						
						$advcampaign_str .= '<option value="'.$advcampaign[id].'">'.$advcampaign->name.'</option>';
						
					
					
			}
			$advcampaign_str .= '</select>';
			
			
			
			$categoryes_str .= '<select name="categoryes_adv">';
			foreach ($xml->xpath('advcampaign_categories/category') as $category) {
				
				// если удалось извлечь купоны, то записываем полученные данные в строку
			
					
						
						$categoryes_str .= '<option value="'.$category[id].'">'.$category.'</option>';
						
					
					
			}
			$categoryes_str .= '</select>';
			
			
			
			// разбираем фид и извлекаем промокоды
			foreach ($xml->xpath('coupons/coupon') as $coupon) {
				if($coupon) {
				// если удалось извлечь купоны, то записываем полученные данные в строку
			
					
						$coupon_str .= '<div class="coupon">';
						$coupon_str .= '<img src="'.$coupon->logo.'">';
						$coupon_str .= '<h4><b>'.$coupon->short_name.': </b>'.$coupon->name.'</h4>';
						
						$coupon_str .= '<p>'.$coupon->description.'</p>';
						$coupon_str .= '<a target="_blanck" rel="nofollow" class="get-price blue" href="/link.php?to='.$coupon->promolink.'">Использовать купон »</a>';
						$coupon_str .= '</div>';
					
					
			
				} else {
					$error = '<div style="text-align: center; width: 100%;padding: 15px;">Извините, промокоды для этого магазина временно отсутствуют</div>';
				}			
			} 
		} else { echo 'XML не получен';} ?>
		<form> 
		<? 	//if ($advcampaign_str) { echo $advcampaign_str; }
			if ($categoryes_str) { echo $categoryes_str; } ?> 
		</form>
		<?
		if ($coupon_str) { echo $coupon_str; } else { echo $error;}
		
?>

	</div><!-- #content -->
	
		

	
</div><!-- #container -->
<?php get_sidebar(); ?>



<?php get_footer(); ?>