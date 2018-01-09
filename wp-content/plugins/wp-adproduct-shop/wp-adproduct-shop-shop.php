<?php 



/* Создаем произвольный тип записей для магазинов
================================================================*/

add_action('init', 'adproduct_register_shop_post_types');
function adproduct_register_shop_post_types(){
	$args = array(
		'label'              => null,
		'labels'             => array(
			'name'          => 'Магазины', // основное название для типа записи
			'singular_name' => 'Магазин', // название для одной записи этого типа
			'add_new'       => 'Добавить магазин', // для добавления новой записи
			'add_new_item'  => 'Добавить магазин', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'     => 'Редактировать магазин', // для редактирования типа записи
			'new_item'      => 'Добавить магазин', // текст новой записи
			'view_item'     => 'Смотреть магазин', // для просмотра записи этого типа.
			'search_items'  => 'Искать магазин', // для поиска по этим типам записи
			'not_found'     => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => '', // если не было найдено в корзине
			'parent_item_colon'  => 'Родительские витрины товаров', // для родительских типов. для древовидных типов
			'menu_name'          => 'Магазины', // название меню
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
		'supports'            => array('title','editor', 'thumbnail', 'custom-fields', 'comments'),
		'taxonomies'          => array(),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
		'show_in_nav_menus'   => true,
	);

	register_post_type('shops', $args );
}



/*	Подгружаем каталог магазина
=================================================================*/
add_action('wp_ajax_shop_catalog', 'shop_catalog_callback');
add_action('wp_ajax_nopriv_shop_catalog', 'shop_catalog_callback');
function shop_catalog_callback() {
	global $adproduct_server_url;
	
	$post_id = $_POST['post_id'];
	
	if($post_id) {
		$vitrina_id = $post_id;
		$products = get_post_meta($post_id, 'product', 1);
		$vitrina_shop_id = get_post_meta($post_id, 'vitrina_shop_id', 1);
		$catalog_string = null;
		//var_dump($vitrina_shop_id);
		if(1 < count($products)) {
			$pr_count=-1; $pr_real_count=0;
			foreach($products as $product) { $pr_count++;
				if($pr_count !== 0) {
					
					$image_attributes = wp_get_attachment_image_src( $product[0], 'full');
					$src = $image_attributes[0];
					if(empty($vitrina_shop_id)) { $shop_id = $product[3]; } else { $shop_id = $vitrina_shop_id; }
					if(!empty($product[2]) and !empty($src)) { $pr_real_count++;
					$catalog_string .= '<div class="col-md-4 col-sm-6 col-xs-12">
						<div class="catalog-product white-block m-0-0-25-0">
							<a target="_blank" href="http://'.$adproduct_server_url.'/goto?shop_id='.$shop_id.'&vitrina_id='.$vitrina_id.'&pr_count='.$pr_real_count.'&link='.urlencode($product[2]).'">
							<img src="'.$src.'">
							<div class="name p-25 text-center">'.$product[1].'</div>
							</a>
						</div>
					</div>';
					if($pr_real_count % 3 == 0) { $catalog_string .= '<div class="clearfix"></div>'; }
					}
					
				}
			}		
		} else {
			//$catalog_string = 'Выводим удаленный каталог';
			if($vitrina_shop_id) {
				$adproduct_options = get_option('adproduct_options');
				$api_key = $adproduct_options['adproduct_api_key'];
				//var_dump($vitrina_shop_id);
				$postdata = array (
						 'api_key' => $api_key,
						 'action' => 'get_shop_catalog',
						 'vitrina_id' => $vitrina_shop_id
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
						//var_dump($json_decode);
						$products = $json_decode->products;
						$cupons = $json_decode->cupons;
					
					if(1 < count($products)) {
						$pr_count=-1; $pr_real_count=0;
						foreach($products as $product) { $pr_count++;
							if($pr_count !== 0) {
								
								$src = $product[0];
								if(empty($vitrina_shop_id)) { $shop_id = $product[3]; } else { $shop_id = $vitrina_shop_id; }
								if(!empty($product[2]) and !empty($src)) { 
									$pr_real_count++;
									$catalog_string .= '<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="catalog-product white-block m-0-0-25-0">
											<a target="_blank" href="http://'.$adproduct_server_url.'/goto?shop_id='.$shop_id.'&vitrina_id='.$vitrina_id.'&pr_count='.$pr_real_count.'&link='.urlencode($product[2]).'">
											<img src="'.$src.'">
											<div class="name p-25 text-center">'.$product[1].'</div>
											</a>
										</div>
									</div>';
									if($pr_real_count % 3 == 0) { $catalog_string .= '<div class="clearfix"></div>'; }
								}
								
							}
						}		
					}
					
			}
		} 	
		
			
			$cupons_string = adproduct_get_promocode($cupons);
			
			$json_encode = array(
				'products' => $catalog_string,
				'cupons' => $cupons_string
			);
			echo json_encode($json_encode);
			//var_dump($json_encode);
			
	
	} 
	
	exit; // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}




/*	Блок произвольных полей
===================================*/
// подключаем функцию активации мета блока (my_product_fields)
add_action('add_meta_boxes', 'my_promocode_fields', 1);

function my_promocode_fields() {
	add_meta_box( 'cupon_fields', 'Дополнительные параметры', 'cupon_fields_box_func', 'shops', 'normal', 'high'  );
}

// код блока
function cupon_fields_box_func( $post ){
	
	//$gdeslon = get_post_meta($post->ID, 'shop_id_gdeslon', 1);
	$shop_logo_image_url = get_post_meta($post->ID, 'shop_logo_image_url', 1);
	$shop_description = get_post_meta($post->ID, 'shop_description', 1);
	echo 'Скопируйте шорткод витрины: [adproduct_promo_vitrina_shortcode id="'.$post->ID.'" name="'.$post->post_title.'"] ';
	
	//var_dump($vitrina_shop_id);?>
	
	<p><input type="text" name="promocode[shop_description]" size="100" value="<?php echo $shop_description;?>" /><label> - дескрипшн для магазина</label></p>
	
	
	<p><input type="text" name="promocode[shop_logo_image_url]" value="<?php echo $shop_logo_image_url;?>" /><label> - адрес картинки для логотипа</label></p>
	
				<!--p><b>Для купонной выгрузки</b></p>
				<p><input type="text" name="promocode[shop_id_gdeslon]" value="<?php// echo $gdeslon;?>" /><label> - ID магазина в "Где слон?" </label></p>
				<p><input type="text" name="promocode[shop_id_admitad]" value="<?php //echo $admitad;?>" /><label> - ID магазина в Admitad</label></p-->
				
	


	<input type="hidden" name="promocode_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'cupon_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function cupon_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['promocode_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['promocode'] = array_map('trim', $_POST['promocode']);
	foreach($_POST['promocode'] as $key => $value) {
		update_post_meta($post_id, $key, $value);
		
	}
		
	return $post_id;
}




/* Создаем таксономию для магазинов
================================================================*/

add_action('init', 'adproduct_create_shop_taxonomy');
function adproduct_create_shop_taxonomy(){
	// заголовки
	$labels = array(
		'name'              => 'Категории',
		'singular_name'     => 'Категория',
		'search_items'      => 'Найти категорию',
		'all_items'         => 'Все категории',
		'parent_item'       => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория',
		'edit_item'         => 'Редактировать категорию',
		'update_item'       => 'Обновить категорию',
		'add_new_item'      => 'Добавить категорию',
		'new_item_name'     => 'Добавить категорию',
		'menu_name'         => 'Категории магазинов',
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
	register_taxonomy('shop_category', array('shops'), $args );
}









 ?>