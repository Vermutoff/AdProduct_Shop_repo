<?php 




add_action('admin_menu', function(){
	add_menu_page( 'Настройки AdProduct', 'AdProduct', 'manage_options', 'adproduct-options', 'adproduct_setting', '', 80 ); 
} );

// функция отвечает за вывод страницы настроек
// подробнее смотрите API Настроек: http://wp-kama.ru/id_3773/api-optsiy-nastroek.html
function adproduct_setting(){
	
	$adproduct_options_array = array();
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>

		<?php
		// settings_errors() не срабатывает автоматом на страницах отличных от опций
		if( get_current_screen()->parent_base !== 'options-general' )
			settings_errors('название_опции');
		
		if ($_POST['action'] == 'update') {
			
			if ($_POST['adproduct_unisender_api_key']) {
				$adproduct_options_array['adproduct_unisender_api_key'] = $_POST['adproduct_unisender_api_key'];
			}
			
			if ($_POST['adproduct_api_key']) {
				$adproduct_options_array['adproduct_api_key'] = $_POST['adproduct_api_key'];
			}
			
			if ($_POST['adproduct_server']) {
				$adproduct_options_array['adproduct_server'] = $_POST['adproduct_server'];
			}
			
			
			update_option('adproduct_options', $adproduct_options_array);
			
		}
		
		$adproduct_options = get_option('adproduct_options');
		?>

		<form action="" method="POST">
			<p>
				<label>API ключ от Unisender</label>
				<input type="text" name="adproduct_unisender_api_key" value="<?php echo $adproduct_options['adproduct_unisender_api_key'];?>">
			</p>
			
			<p>
				<label>API ключ от AdProduct</label>
				<input type="text" name="adproduct_api_key" value="<?php echo $adproduct_options['adproduct_api_key'];?>">
			</p>
			
			<p>
				<label>С каким сервером работать?</label>
				<select name="adproduct_server">
					<option <?php if($adproduct_options['adproduct_server'] == '') echo 'selected'; ?> value="">Выберите сервер</option>
					<option <?php if($adproduct_options['adproduct_server'] == 'adproduct.ru') echo 'selected'; ?> value="adproduct.ru">Боевой сервер</option>
					<option <?php if($adproduct_options['adproduct_server'] == 'test.adproduct.ru') echo 'selected'; ?> value="test.adproduct.ru">Тестовый сервер</option>
				</select>
				
			</p>
			<?php
				settings_fields("opt_group");     // скрытые защитные поля
				do_settings_sections("opt_page"); // секции с настройками (опциями).
				submit_button();
			?>
		</form>
	</div>
	<?php

}


function adproduct_button_shortcode($atts) {
	//svar_dump($atts);
	
	
	
	if($atts['url'] and $atts['ancor']) {
		if($atts['shop_id']) { $shop_id = 'shop_id='.$atts['shop_id'].'&';}
		return '<span class="link btn btn-block '.$atts['class'].'" target="blank" data-href="http://adproduct.ru/goto?'.$shop_id.'link='.$atts['url'].'">'.$atts['ancor'].'</span>';
	}
	
}

add_shortcode( 'adproduct_button_shortcode' , 'adproduct_button_shortcode');


 ?>