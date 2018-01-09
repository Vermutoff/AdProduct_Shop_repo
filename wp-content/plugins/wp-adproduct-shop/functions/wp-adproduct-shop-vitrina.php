<?php 

define( 'ADPRODUCT__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/* Создаем произвольный тип записей для товарных витрин
================================================================*/

add_action('init', 'adproduct_register_vitrina_post_types');
function adproduct_register_vitrina_post_types(){
	$args = array(
		'label'              => null,
		'labels'             => array(
			'name'          => 'Витрины', // основное название для типа записи
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
			'menu_name'          => 'Витрины', // название меню
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

	register_post_type('ad_product_vitrina', $args );
}


/*	Блок произвольных полей
===================================*/
// подключаем функцию активации мета блока (my_product_fields)
add_action('add_meta_boxes', 'my_product_fields', 1);

function my_product_fields() {
	add_meta_box( 'product_fields', 'Каталог магазина', 'product_fields_box_func', 'shops', 'normal', 'high'  );
	add_meta_box( 'product_fields', 'Витрина', 'product_fields_box_func', 'vitrina', 'normal', 'high'  );
}

// код блока
function product_fields_box_func( $post ){
	
	$products = get_post_meta($post->ID, 'product', 1);
	//var_dump($products);
	$partner_prefix = get_post_meta($post->ID, 'partner_prefix', 1);

	echo 'Скопируйте шорткод витрины: [vitrina id="'.$post->ID.'" name="'.$post->post_title.'"] ';?>
	
	<div class="product_list">
	
		<div id="product_block" style="display: none;">
			<div class="add_product_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
				
				<div style="float: left; margin-right: 25px;">
					<?php true_image_uploader_field( 'product[]', '', $w = 200, $h = 150); ?>
				</div>
				
				<p><input size="50" type="text" name="product[]" value="" /><label> - Название </label></p>
				<p><input size="50" type="text" name="product[]" value="" /><label> - оригинальная ссылка</label></p>
				<p><input size="50" type="text" name="product[]" value="" /><label> -  партнерская ссылка 1</label></p>
				<p><input size="50" type="text" name="product[]" value="" /><label> -  партнерская ссылка 2</label></p>
				<p><input size="50" type="text" name="product[]" value="" /><label> -  партнерская ссылка 3</label></p>
				<button class="up">Наверх</button>
				<button class="down">Вниз</button>
				<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
			</div>
			
		</div>
	<?php if(is_array($products)) {
		$pr_count=0;
		foreach($products as $product) { $pr_count++;
			if($pr_count !== 1) {
				
				echo '<div class="add_product_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
				<div style="float: left; margin-right: 25px;">';
						
					
					true_image_uploader_field( 'product[]', $product[0], $w = 200, $h = 150);
				
					
				echo '</div><p><input size="50" type="text" name="product[]" value="'.$product[1].'" /><label> - Название </label></p>
						<p><input size="50" type="text" name="product[]" value="'.$product[2].'" /><label> - оригинальная ссылка</label></p>
							<p><input size="50" type="text" name="product[]" value="'.$product[3].'" /><label> -  партнерская ссылка 1</label></p>
							<p><input size="50" type="text" name="product[]" value="'.$product[4].'" /><label> -  партнерская ссылка 2</label></p>
							<p><input size="50" type="text" name="product[]" value="'.$product[5].'" /><label> -  партнерская ссылка 3</label></p>
						<button class="up">Наверх</button>
						<button class="down">Вниз</button>
						<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
					</div>';
			}
		}
	}
//	var_dump($products);

	
?>
	
</div>
	<button id="add_product_block">Добавить блок</button>
	<input type="hidden" name="product_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_product_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_product_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['product_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['product']) ) return false;	

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['product'] = array_map('trim', $_POST['product']);
	
	delete_post_meta($post_id, 'product');
	$product = array_chunk($_POST['product'], 6);

	update_post_meta($post_id, 'product', $product);

	
		
	return $post_id;
}

function true_include_myuploadscript() {
	// у вас в админке уже должен быть подключен jQuery, если нет - раскомментируйте следующую строку:
	// wp_enqueue_script('jquery');
	// дальше у нас идут скрипты и стили загрузчика изображений WordPress
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
	// само собой - меняем admin.js на название своего файла
 	wp_enqueue_script( 'myuploadscript', ADPRODUCT__PLUGIN_DIR() . '/js/upload.js', array('jquery'), null, false );
}
 
add_action( 'admin_enqueue_scripts', 'true_include_myuploadscript' );

function true_image_uploader_field( $name, $value = '', $w = 200, $h = 150) {
	$default = ADPRODUCT__PLUGIN_DIR() . '/img/no-image.png';
	if( $value ) {
		$image_attributes = wp_get_attachment_image_src( $value, array($w, $h) );
		$src = $image_attributes[0];
	} else {
		$src = $default;
	}
	echo '
	<div>
		<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
			<input type="hidden" name="' . $name . '" id="img_'.$value.'" value="' . $value . '" />
			<button type="submit" class="upload_image_button button">Загрузить</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
}

 ?>