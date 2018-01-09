<?php
/*
Plugin Name: AdProduct Shop
Plugin URI: http://vermutoff.com/wp-admitad-coupons/
Version: 1.0.1
Author: Dmitry Vermutoff
Author URI: http://vermutoff.com/
Description: .
*/

define( 'ADPRODUCT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( ADPRODUCT__PLUGIN_DIR . 'wp-adproduct-shop-shop.php' );
require_once( ADPRODUCT__PLUGIN_DIR . 'wp-adproduct-shop-vitrina.php' );
require_once( ADPRODUCT__PLUGIN_DIR . 'wp-adproduct-shop-mailing.php' );
require_once( ADPRODUCT__PLUGIN_DIR . 'functions/wp-adproduct-functions.php' );

$adproduct_options = get_option('adproduct_options');
global $adproduct_server_url; $adproduct_server_url = $adproduct_options['adproduct_server'];

/* Создаем произвольный тип записей для товарных витрин
================================================================*/

add_action('init', 'adproduct_register_vitrina_product_post_types');
function adproduct_register_vitrina_product_post_types(){
	$args = array(
		'label'              => null,
		'labels'             => array(
			'name'          => 'Витрины товаров', // основное название для типа записи
			'singular_name' => 'Витрина товаров', // название для одной записи этого типа
			'add_new'       => 'Добавить витрину товаров', // для добавления новой записи
			'add_new_item'  => 'Добавить витрину товаров', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'     => 'Редактировать витрину товаров', // для редактирования типа записи
			'new_item'      => 'Добавить витрину товаров', // текст новой записи
			'view_item'     => 'Смотреть витрину товаров', // для просмотра записи этого типа.
			'search_items'  => 'Искать витрину товаров', // для поиска по этим типам записи
			'not_found'     => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => '', // если не было найдено в корзине
			'parent_item_colon'  => 'Родительские витрины товаров', // для родительских типов. для древовидных типов
			'menu_name'          => 'Витрины товаров', // название меню
		),
		'description'         => '',
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 22,
		'menu_icon'           => null, 
		//'capability_type'     => 'post',
		//'capabilities'        => 'post', // массив дополнительных прав для этого типа записи
		//'map_meta_cap'        => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'        => false,
		'supports'            => array('title','editor', 'thumbnail', 'custom-fields'),
		'taxonomies'          => array(),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
		'show_in_nav_menus'   => true,
	);

	register_post_type('ad_product_vitrina_p', $args );
}

/* Создаем таксономию товарных витрин
================================================================*/

add_action('init', 'adproduct_create_vitrina_taxonomy');
function adproduct_create_vitrina_taxonomy(){
	// заголовки
	$labels = array(
		'name'              => 'Категории витрин',
		'singular_name'     => 'Категория витрин',
		'search_items'      => 'Найти категорию',
		'all_items'         => 'Все категории',
		'parent_item'       => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория',
		'edit_item'         => 'Редактировать категорию',
		'update_item'       => 'Обновить категорию',
		'add_new_item'      => 'Добавить категорию',
		'new_item_name'     => 'Добавить категорию',
		'menu_name'         => 'Категории витрин',
	); 
	// параметры
	$args = array(
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => $labels,
		'public'                => true,
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_tagcloud'         => true, // равен аргументу show_ui
		'hierarchical'          => true,
		'update_count_callback' => '',
		'rewrite'               => true,
		//'query_var'             => $taxonomy, // название параметра запроса
		'capabilities'          => array(),
		'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
		'_builtin'              => false,
		'show_in_quick_edit'    => null, // по умолчанию значение show_ui
	);
	register_taxonomy('ad_product_vitrina_p_category', array('ad_product_vitrina_p'), $args );
}

/* Добавляем блок произвольных полей для постов в блоге
================================================================*/
// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'adproduct_blog_extra_fields', 1);


function adproduct_blog_extra_fields() {
	add_meta_box( 'adproduct_blog_post_extra_fields', 'Параметры поста', 'adproduct_blog_post_box_func', 'post', 'normal', 'high'  );
}


function adproduct_blog_post_box_func( $post ){
	
	?>
	
			
	<p>
		<button id="send_email_from_post" data-post_id="<?php echo $post->ID; ?>">Сформировать рассылку</button>

        <button id="adproduct_test_api" data-post_id="<?php echo $post->ID; ?>">Тест</button>
		<div class="result_send_email_from_post"></div>
	</p>
		


	<input type="hidden" name="adproduct_blog_post_extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}


// включаем обновление полей при сохранении
add_action('save_post', 'adproduct_blog_post_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function adproduct_blog_post_extra_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['adproduct_blog_post_extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['adproduct_blog_post_extra']) ) return false;	// выходим если данных нет

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['adproduct_blog_post_extra'] = array_map('trim', $_POST['adproduct_blog_post_extra']); // чистим все данные от пробелов по краям
	foreach( $_POST['adproduct_blog_post_extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}



/* Добавляем блок произвольных полей для товарных витрин
================================================================*/
// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'adproduct_vitrina_extra_fields', 1);

function adproduct_vitrina_extra_fields() {
	add_meta_box( 'adproduct_product_vitrina_extra_fields', 'Параметры товарной витрины', 'adproduct_product_vitrina_extra_fields_box_func', 'ad_product_vitrina_p', 'normal', 'high'  );
}

function adproduct_product_vitrina_extra_fields_box_func( $post ){
	
	?>
	<p>
		<label>Скопируйте шорткод этой витрины и вставьте в нужный пост</label><br/>
		[adproduct_vitrina_products vitrina_id="<?php echo $post->ID; ?>"]
	</p>
	
	<p>
		<label>Строка для поиска в наименовании товара. Можно указывать SQL параметры.</label><br/>
		<input type="text" name="adproduct_product_vitrina_extra[search_for_name_product]" value="<?php echo get_post_meta($post->ID, 'search_for_name_product', 1); ?>" style="width:50%" />
	</p>
		
	<p>
		<label>Строка для поиска в описании товара. Можно указывать SQL параметры.</label><br/>
		<input type="text" name="adproduct_product_vitrina_extra[search_for_description_product]" value="<?php echo get_post_meta($post->ID, 'search_for_description_product', 1); ?>" style="width:50%" />
	</p>
	
	<p>
		<label>Строка для полнотекстового поиска по имени и описанию товара. Можно указывать соответствующие SQL параметры.</label><br/>
		<input type="text" name="adproduct_product_vitrina_extra[search_for_full]" value="<?php echo get_post_meta($post->ID, 'search_for_full', 1); ?>" style="width:50%" />
	</p>
	
	<p>
		<label>ID магазина по базе "Где слон?"</label><br/>
		<input type="text" name="adproduct_product_vitrina_extra[search_for_id_shop]" value="<?php echo get_post_meta($post->ID, 'search_for_id_shop', 1); ?>" style="width:50%" />
	</p>

	<p>
		<label>ID категории по базе "Где слон?"</label><br/>
		<input type="text" name="adproduct_product_vitrina_extra[search_for_id_category]" value="<?php echo get_post_meta($post->ID, 'search_for_id_category', 1); ?>" style="width:50%" />
	</p>

	<input type="hidden" name="adproduct_product_vitrina_extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}



// включаем обновление полей при сохранении
add_action('save_post', 'adproduct_product_vitrina_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function adproduct_product_vitrina_extra_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['adproduct_product_vitrina_extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['adproduct_product_vitrina_extra']) ) return false;	// выходим если данных нет

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['adproduct_product_vitrina_extra'] = array_map('trim', $_POST['adproduct_product_vitrina_extra']); // чистим все данные от пробелов по краям
	foreach( $_POST['adproduct_product_vitrina_extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}





/*	Преобразуем 3-х буквенные слова в 6-ти буквенные и обратно.
	Это нужно для поиска по MySQL
================================================================*/
function DuhDuh($string) { //фигачим во входной строке все 3-х буквенное в 6 символов и возвращаем
$string = preg_replace("/\b([А-ЯЁ]{3})\b/siu","\\1\\1",$string); //сыр = сырсыр
return $string;
}

function Duh($string) { //фигачим дебиловатые слова вроде сырсыр обратно в нормальные
$string = preg_replace('/\b([А-ЯЁ]{3})\\1\b/siu', '\\1', $string); //сырсыр = сыр
return $string;
}


/*	Шорткод для товарной витрины
===============================================*/
function adproduct_vitrina_products($atts) {
	$post_id = $atts['id'];

	return '<div class="adproduct_vitrina_products" data-vitrina_id="'.$post_id.'"></div>';
	
}
add_shortcode( 'adproduct_vitrina_products' , 'adproduct_vitrina_products');


/*	Шорткод для купонной витрины
===============================================*/
function adproduct_promo_vitrina_shortcode_func($atts) {
	$post_id = $atts['id'];

	return '<div class="adproduct_promo_vitrina row" data-vitrina_id="'.$post_id.'"></div>';
	
}
add_shortcode( 'adproduct_promo_vitrina_shortcode' , 'adproduct_promo_vitrina_shortcode_func');


/*	Шорткод для вывода витрины
==============================================================*/
function vitrins_func( $atts ) {
	global $post;
	
	$atts['id'];
$post_id = $atts['id'];
	if($post_id) {
		$return = '<div class="adproduct_vitrina" data-vitrina_id="'.$post_id.'"></div>';
			
	} 
	
	return $return;
}
add_shortcode('adproduct_vitrina_shortcode', 'vitrins_func');


/*	Ajax подгрузка товаров в товарную витрину
=================================================*/
function adproduct_vitrina_javascript() {
	$adproduct_ajaxurl = array(
	   'url' => admin_url('admin-ajax.php')
	);
    $script_url = plugins_url('js/adproduct_ajax.js', __FILE__);
	wp_enqueue_script( 'adproduct_javascript', $script_url, array('jquery'),null, 1);

	wp_localize_script( 'jquery', 'adproduct_ajaxurl', $adproduct_ajaxurl);
}
add_action('wp_enqueue_scripts', 'adproduct_vitrina_javascript');
add_action('admin_enqueue_scripts', 'adproduct_vitrina_javascript');


/*	Подгружаем товары в товарную витрину - Ajax
=================================================*/
add_action('wp_ajax_adproduct_vitrina_products', 'adproduct_vitrina_products_callback');
add_action('wp_ajax_nopriv_adproduct_vitrina_products', 'adproduct_vitrina_products_callback');
function adproduct_vitrina_products_callback() {
	global $adproduct_server_url;
	$post_id = $_POST['vitrina_id'];
	if($post_id) {
		
		$postdata = array (
			'api_key' => '',
			'action' => 'get_products',
			'vitrina_id' => $post_id
		);

			// Устанавливаем соединение
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'http://'.$adproduct_server_url.'/api');
			$result = curl_exec($ch);
					
			$json_decode = json_decode($result);
			
			
			$products = $json_decode->products;
			//var_dump($postdata);
			
		$products_string = adproduct_get_product($products);
		echo $products_string;
	}
	
	
	exit; // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}


/*	Подгрузка промокодов в купонную витрину
========================================*/
add_action('wp_ajax_adproduct_vitrina_promocode', 'adproduct_vitrina_promocode_callback');
add_action('wp_ajax_nopriv_adproduct_vitrina_promocode', 'adproduct_vitrina_promocode_callback');
function adproduct_vitrina_promocode_callback() {
	global $wpdb;
	
	$vitrina_string = null;
	$post_id = $_POST['vitrina_id'];
	if($post_id) {
		
		$postdata = array (
			'api_key' => '',
			'action' => 'get_cupons',
			'vitrina_id' => $post_id
		);

			// Устанавливаем соединение
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_URL, 'http://'.$adproduct_server_url.'/api');
			$result = curl_exec($ch);
					
			$json_decode = json_decode($result);
			
		//	var_dump($json_decode);
			$cupons = $json_decode->cupons;
			$vitrina_string = adproduct_get_promocode($cupons);
		
		echo $vitrina_string;
	}
	
	
	exit; // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}

/*	Формируем витрину купонов из массива
=========================================================*/
function adproduct_get_promocode($cupons) {
	global $wpdb;
	if($cupons) {
		//var_dump();
		
				//var_dump($cupons);	
					$promocode_count=0;
			foreach($cupons as $promocode) {
				$promocode = (array)$promocode;
				//var_dump($promocode);
				$promocode_count++;
				
				$vitrina_string .= '<div class="col-md-4 text-center"><div id="cupon_card-'.$promocode['cupon_id'].'" data-href="'.$promocode['promo_url'].'" class="product_card link '.$promocode['network'].' p-25 padding-top-0 margin-bottom-25">';
	
				
				$vitrina_string .= '<div class="promocode-title h4 margin-top-0">'.$promocode['name'].'</div>';
				$vitrina_string .= '<div class="promocode-description grey-text margin-bottom-15">'.$promocode['description'].'</div>';
				$vitrina_string .= '<a class="button btn btn-warning product_more">Использовать купон</a>';
			
			
			
				$vitrina_string .= '</div></div>';
				if($promocode_count % 3 == 0) { $vitrina_string .= '<div class="clearfix"></div>'; }
					
			}
	
			$vitrina_string .= '</div>';
		
		
				
	}
	return $vitrina_string;
	
}


function formatNumber( $number, $decimals=2, $dec_point=".", $thousands_sep=",") {
    $nachkomma = abs($in - floor($in));
    $strnachkomma = number_format($nachkomma , $decimals, ".", "");
 
    for ($i = 1; $i <= $decimals; $i++) {
        if (substr($strnachkomma, ($i * -1), 1) != "0") {
            break;
        }
    }
   
    return number_format($in, ($decimals - $i +1), $dec_point, $thousands_sep);
}

/*	Получаем товары из БД по запросу
=========================================================*/
function adproduct_get_product($products) {
//var_dump(count($products));
	
	if(count($products) > 1) {
			$vitrina_string .= '<div class="row">';
			
			foreach($products as $product) {
				$product = (array)$product;
				$name_product = Duh($product['name_product']);
				$price_product = number_format($product['price_product'], 0, '', ' ' );// rtrim(rtrim($product['price_product'], '0'), '.');
				
				$product_count++;
				
				$vitrina_string .= '<div class="col-md-4 text-center"><div id="product_card-'.$product['id'].'" data-href="'.$product['url_product'].'" class="product_card link p-25 margin-bottom-25'.$product_class.'">';
				$vitrina_string .= '<div class="product_image"><img class="thumbnail center-block img-responsive" src="'.$product['thumbnail_product'].'" /></div>';
				
				$vitrina_string .= '<div class="product_title">'.stripslashes_deep($name_product).'</div>';
				$vitrina_string .= '<div class="product_price"><span><b>'.$price_product.'</b> руб.</span></div>';
				$vitrina_string .= '<a class="button btn btn-warning product_more">Купить в магазине</a>';
			
			
			
				$vitrina_string .= '</div></div>';
				if($product_count % 3 == 0) { $vitrina_string .= '<div class="clearfix"></div>'; }
			}
	
			$vitrina_string .= '</div>';
			
	} else { 
		$vitrina_string = 'Извините, товары временно отсутсвуют. Сообщите об этом администратору';
	}
	
	return $vitrina_string;
	
}





/*	Ajax подгрузка товаров в витрину
=========================================*/

function xml_vitrina_javascript() {
	global $post;
	$vitrina_ajaxurl = array(
   'url' => admin_url('admin-ajax.php'),
   'post_id' => $post->ID
);
	wp_enqueue_script( 'xml_vitrina_javascript', get_template_directory_uri() . '/js/custom_ajax.js', '','',1);
	wp_localize_script( 'jquery', 'vitrina_ajaxurl', $vitrina_ajaxurl);
	//wp_localize_script( 'my_script_handle', 'ajax_get_product', array( 'ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'xml_vitrina_javascript');




/*	Получаем список магазинов с удаленного сервера
=========================================================*/
function adproduct_get_list_shops($list_shops_array, $shop_id){
	$list_shops = '<option value="">Выбрать</option>';
	foreach($list_shops_array as $shop) {
		if($shop['id'] == $shop_id) { $selected = 'selected'; } else { $selected = ''; }
		$list_shops .= '<option '.$selected.' value="'.$shop['id'].'">'.$shop['name'].'</option>';
		
	}
	return $list_shops;
}

function adproduct_get_list_shops_array(){
		$list_shops = array();
		$query = "SELECT * FROM wp_posts WHERE post_type = 'shop' AND post_status = 'publish' ORDER BY post_title ASC";
		
		$host="5.101.121.2";/*Имя сервера*/
		$user="my_shops";/*Имя пользователя*/
		$password="iwmknknu37494Jhendd4";/*Пароль пользователя*/
		$db="test_shop";/*Имя базы данных*/
		$link = mysql_connect($host, $user, $password);
		mysql_error($link);
		if($link) {
			
			$select_db = mysql_select_db($db);
			
			if($select_db) {
				mysql_query("SET NAMES utf8");
				$result = mysql_query($query);
				
				if($result) {
			$num_rows = mysql_num_rows($result);
		
			
			
			while ($shop = mysql_fetch_assoc($result)) {
			
				$list_shops[] = array(
					'id' => $shop['ID'],
					'name' => $shop['post_title']
				);
			
			}
	
			
		} else { die('Ошибка запроса к БД'.mysql_error()); }
				mysql_close($link );
			} else {
				die("Нет соединения с БД".mysql_error());
			}
		} else {
			echo 'Соединение не установлено'.mysql_error();
		}
	return $list_shops;
}





/*	Переход по партнерской ссылке - без jQuery
=====================================================*/
function go_to_link($url, $shop_id, $vitrina_id, $pr_count) {
	
	// Подключаемся ко второй БД на сервере, для получения партнерских ссылок магазинов

	//$wpdb2 = new wpdb( 'my_shops', 'iwmknknu37494Jhendd4', 'test_shop', '5.101.121.2' );
	// если не удалось подключиться, и нужно оборвать PHP с сообщением об этой ошибке
	$site_id = str_replace('.', '', $_SERVER['SERVER_NAME']);
	$date = date('d-m-Y');
	
	$link_array_for_bd = array(
		'date' => $date,
		'time' => '',
		'shop_id' => $shop_id,
		'post_id' => $vitrina_id,
		'partner_id' => '',
		'site_id' => $site_id,
		'status' => '',
		'url' => '',
		'network' => ''
	);
	
	if (!isset($wpdb2->error)){
		$results = $wpdb2->get_results("SELECT meta_value FROM wp_postmeta WHERE post_id = '$shop_id' AND meta_key = 'adproduct_shop_extra'");
		$meta_value = unserialize($results[0]->meta_value);
		//var_dump($meta_value);
		
	} else {
		wp_die( $wpdb2->error );
	}
	
	$links_array = array(
		$meta_value['partner_network_1'] => $meta_value['partner_link_1'],
		$meta_value['partner_network_2'] => $meta_value['partner_link_2'],
		$meta_value['partner_network_3'] => $meta_value['partner_link_3'],
	);
	
	foreach($links_array as $network => $link) {
		$full_partner_link = get_full_partner_link($network, $link, $url, $shop_id, $vitrina_id, $pr_count); 
		$return = go_to_partner_link($full_partner_link, $url);
			
			
			// Создаем дескриптор cURL
			$ch = curl_init('http://f.gdeslon.ru/f/9d7899d75f60a4f7/?sub_id=SE_vitrina_42&goto=https://www.wildberries.ru/catalog/1/women.aspx');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
			// Запускаем
			curl_exec($ch);

			// Проверяем наличие ошибок
		
			 $info = curl_getinfo($ch);

			
			
			//var_dump($info);

			// Close handle
			curl_close($ch);
			
			
			$link_array_for_bd['network'] = $network;
			$link_array_for_bd['url'] = $full_partner_link;
			$link_array_for_bd['status'] = $return['code'];
			break;
			
		if($return['result'] == 'true') {
			// Нашли рабочую ссылку. Останавливаем цикл и ссылку на редирект.
			$url_for_redirect = $full_partner_link;
			
			break;
		} else {
			$time = date('H:i:s');
			$link_array_for_bd['time'] = $time;
			// Здесь нужно записать информацию в БД о неудачном переходе по ссылке - ссылка битая или не работает. 
			// Цикл продолжает работать далее в поисках рабочей ссылки
			//wpdb2insertlink($link_array_for_bd);
			
		}
		
	}
	
	if(empty($url_for_redirect)) {
		// Если все партнерские ссылки не работают, то отправляем пользователя по оригинальной
		$url_for_redirect = $url;
		$link_array_for_bd['status'] = '1';
	}
	
	$time = date('H:i:s');
	
	$link_array_for_bd['url'] = $url_for_redirect;
	$link_array_for_bd['time'] = $time;
	
	// Отправляем пользователя по ссылке, которую удалось получить и которая работает
	// В БД записываем информацию об успешном переходе
	
	
	
	//wpdb2insertlink($link_array_for_bd);
	//var_dump($wpdb2);
//	wp_redirect( $url_for_redirect);
	//exit;

}

function wpdb2insertlink($link_array_for_bd) {
	global $wpdb2;
	$link_array_prepared = $wpdb2->prepare( 
		"(%s,%s,%s,%s,%s,%s,%s,%s,%s)", 
		$link_array_for_bd['date'],
		$link_array_for_bd['time'],
		$link_array_for_bd['shop_id'],
		$link_array_for_bd['post_id'],
		$link_array_for_bd['partner_id'],
		$link_array_for_bd['site_id'],
		$link_array_for_bd['status'],
		$link_array_for_bd['url'],
		$link_array_for_bd['network']
	);
		
	
	$wpdb2->query("INSERT INTO wp_adproduct_links (date, time, shop_id, post_id, partner_id, site_id, status, url, network) VALUES $link_array_prepared");
	if( ! empty($wpdb2->error) ) wp_die( $wpdb2->error );
}



/*	Проверяем, работает ли партнерская ссылка
=====================================================*/
function go_to_partner_link($url, $href){
	global $wpdb2;
	$return = array();
	
	if(!empty($url)) {
		//$headers = get_headers($url, 1);
		
		
		
		//var_dump($headers);
	
		// Если ответ сервера содержит код 200
		if(strpos($headers[0], '200')) {
			
			// Записываем информацию о переходе в БД
			$return = array(
				'result' => 'true', 
				'code' => '200'
			);

		} 
		
		// Если ответ сервера содержит код 404
		elseif(strpos($headers[0], '404')) {
			
			$return = array(
				'result' => 'false', 
				'code' => '404'
			);
		} 
		elseif(strpos($headers[0], '302')) {
			
			if($headers['Location']) { $location = $headers['Location']; } elseif($headers['location']) {$location = $headers['location'];}
			if(is_array($location)) {
				$location = end($location);
				if(strpos($location, $href) !== false) {
					$return = array(
						'result' => 'true', 
						'code' => '302_true'
					);
				} else {
					$return = array(
						'result' => 'false', 
						'code' => '302_false'
					);
			}
			} else {
				
				if(strpos($location, $href) !== false) { 
					$return = array(
						'result' => 'true', 
						'code' => '302_true'
					);
				} else { 
					$return = array(
						'result' => 'false', 
						'code' => '302_false'
					);
				}
			}
			
			
		} else {
			
			if($headers['Location']) { $location = $headers['Location']; } elseif($headers['location']) {$location = $headers['location'];}
			if(is_array($location)) {
				$location = end($location);
				if(strpos($location, $href) !== false) {
					$return = array(
						'result' => 'true', 
						'code' => 'withoutcode_true'
					);
				} else {
					$return = array(
						'result' => 'false', 
						'code' => 'withoutcode_false'
					);
			}
			} else {
				
				if(strpos($location, $href) !== false) { 
					$return = array(
						'result' => 'true', 
						'code' => 'withoutcode_true'
					);
				} else { 
					$return = array(
						'result' => 'false', 
						'code' => 'withoutcode_false'
					);
				}
			}
			
			
			
		}
		
		
	} else {
		$return = array(
			'result' => 'false', 
			'code' => 'empty_url'
		);
	}
	
	return $return; 
}




/*	Получаем полную партнерскую ссылку со всеми параметрами
============================================================*/
function get_full_partner_link($network, $link, $url, $shop_id, $vitrina_id, $pr_count){
	
	
	$site_id = str_replace('.', '', $_SERVER['SERVER_NAME']);
	
	$sub_id = 'adproduct_';
	if($vitrina_id) { $sub_id .= 'vitrina_'.$vitrina_id.'_'; }
	if($shop_id) { $sub_id .= 'shop_'.$shop_id.'_'; }
	if($pr_count) { $sub_id .= 'prcount_'.$pr_count.'_'; }
	if($site_id) { $sub_id .= 'site_'.$site_id; }
	
	
	if($network == 'gs') { 
		$full_url = $link;
		$full_url .= '?sub_id='.$sub_id;
		$full_url .= '&goto='.$url;
	} 
	elseif($network == 'admitad') {
		$full_url = $link;
		$full_url .= '?subid='.$sub_id;
		$full_url .= '&ulp='.$url;		
	}
	elseif($network == 'actionpay') {
		$full_url = $link;
		$full_url .= $sub_id.'/';
		$full_url .= 'url='.$url;		
	
	}
	elseif($network == 'ad1') {
		$full_url = $link;
		$full_url .= $sub_id.'/';
		$full_url .= $url;		
		
	}
	elseif($network == 'cityads') {
		$full_url = $link;
		$full_url .= '&sa='.$sub_id;
		$full_url .= '&url='.$url;		
	}
	elseif($network == 'epn') {
		$full_url = $link;
		$full_url .= '?sub='.$sub_id;
		$full_url .= '&to='.$url;	
	}
	
	return $full_url;
}



/*	Получаем текущий URL
==================================*/
function request_url()
{
  $result = ''; // Пока результат пуст
  $default_port = 80; // Порт по-умолчанию
 
  // А не в защищенном-ли мы соединении?
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
    // В защищенном! Добавим протокол...
    $result .= 'https://';
    // ...и переназначим значение порта по-умолчанию
    $default_port = 443;
  } else {
    // Обычное соединение, обычный протокол
    $result .= 'http://';
  }
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
 
  // А порт у нас по-умолчанию?
  if ($_SERVER['SERVER_PORT'] != $default_port) {
    // Если нет, то добавим порт в URL
    $result .= ':'.$_SERVER['SERVER_PORT'];
  }
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  // Уфф, вроде получилось!
  return $result;
}


?>