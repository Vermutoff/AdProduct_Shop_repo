<?php


/*	

Из блоков для ссылок и картинок в итоге формируем массив и записываем в произвольное поле с именем : product_links_1 
Одновременно с этим дописываем масссив в произвольном поле с именем product_links, в котором содержится информация о всех существующих блоках product_links для этой записи. Это поле вспомогательное и облегчает работу с другими произвольными полями, в которых хранится информация о картинках и ссылках. В произвольном поле с именем product_links допиcывается массив следующего содержания: array('product_links_1', 'блок ссылок номер 1').

Из предыдущего массива, перебором, мы сможем сформировать список Шорткодов и описаний к ним, который будет очень удобным при работе в админке с постом. Например: [product_links_1] - блок ссылок номер 1, [product_links_2] - блок ссылок номер 2.

Чтобы узнать постфикс, который следует поставить к произвольному полю product_links_ - следует посчитать кол-во массивов в произвольном поле product_links. Прибавляем 1 и получаем имя произвольного поля, куда записываем массив содержимого из блока ссылок.




Блок произвольных полей
===================================*/
// подключаем функцию активации мета блока (my_product_fields)
add_action('add_meta_boxes', 'post_product_links', 1);

function post_product_links() {
	add_meta_box( 'product_links', 'Каталог магазина', 'product_links_box_func', 'blog', 'normal', 'high'  );
}

// код блока
function product_links_box_func( $post ){
	$all_links_blocks = get_post_meta($post->ID, 'all_links_blocks', 1);
	if(is_array($all_links_blocks)) {
		$count_products = count($all_links_blocks);
	} else { $count_products = 0; }
	echo 'Счетчик блоков: '.$count_products.'<br/>';
	var_dump($all_links_blocks);
	echo '<table>';
	foreach($all_links_blocks as $block_links) {
		echo '<tr>
				<td>[links_block name="'.$block_links['field_name'].'"]</td>
				<td> - '.$block_links['description'].'</td>
				<td><button class="edit_this_block_liks">Редактировать</button></td>
				<td><input type="checkbox" name="delete_this_block_liks[]" value="'.$block_links['field_name'].'" class="delete_this_block_liks" /> - Удалить этот блок при обновлении поста</td>
		</tr>';
	}
	echo '</table>';
?>
	
	<div class="product_list">
		<input size="50" type="text" name="name_block" value="" />
		<div id="product_block" style="display: none;">
			<div class="add_product_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
				
				<div style="float: left; margin-right: 25px;">
					<?php true_image_uploader_field( 'product[]', '', $w = 115, $h = 90); ?>
				</div>
				
				<p><input size="50" type="text" name="product[]" value="" /><label> - Название </label></p>
				<p><input size="50" type="text" name="product[]" value="" /><label> - ссылка</label></p>
				<button class="up">Наверх</button>
				<button class="down">Вниз</button>
				<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
			</div>
			
		</div>
	<?php 
	/*
	$pr_count=0;
		
	foreach($all_links_block_xxx as $product) { $pr_count++;
		if($pr_count !== 1) {
			
			echo '<div class="add_product_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
			<div style="float: left; margin-right: 25px;">';
					
				
				true_image_uploader_field( 'product[]', $product[0], $w = 150, $h = 150);
			
				
			echo '</div><p><input size="50" type="text" name="product[]" value="'.$product[1].'" /><label> - Название </label></p>
					<p><input size="50" type="text" name="product[]" value="'.$product[2].'" /><label> - ссылка</label></p>
					<button class="up">Наверх</button>
					<button class="down">Вниз</button>
					<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
				</div>';
		}
	}
	*/
	
	
	//var_dump($products);

	
?>
	
</div>
	<button id="add_product_block">Добавить блок</button>
	<button data-post_id="<?php echo $post->ID;?>" id="save_product_blocks">Сохранить эти блоки</button>
	<button data-post_id="<?php echo $post->ID;?>" id="delete_all_product_blocks">Удалить все сохраненны блоки</button>
	<div id="result_ajax"></div>
	<input type="hidden" name="product_links_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'post_product_links_update', 0);

/* Сохраняем данные, при сохранении поста */
function post_product_links_update( $post_id ){
	$all_links_blocks = get_post_meta($post_id, 'all_links_blocks', 1);
	if(is_array($all_links_blocks)) {
		$count_products = count($all_links_blocks);
	} else { $count_products = 0; }
	//$count_products = count($all_links_blocks);
	
	
	if ( !wp_verify_nonce($_POST['product_links_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['product']) ) return false;	

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['product'] = array_map('trim', $_POST['product']);
	
	//delete_post_meta($post_id, 'product');
	$product = array_chunk($_POST['product'], 3);
	$name_block = $_POST['name_block'];
	$new_count_products = $count_products+1;
	$field_name = 'links_block_'.$new_count_products;
	

	/* Дописываем в массив ID и дескрипшен нового блока ссылок
	===================================================*/
	$all_links_blocks[$field_name] = array(
		'field_name' => $field_name,
		'description' => $name_block,
		'links' => $product
	);
	
	//$all_links_blocks_string = serialize($all_links_blocks);
		
	update_post_meta($post_id, 'all_links_blocks', $all_links_blocks);
	
	return $post_id;
}

/*	Ajax'ом удаляем все сохраненные блоки
=============================================*/
add_action( 'wp_ajax_delete_all_links_blocks', 'ajax_delete_all_links_blocks_function' ); // для вошедших в админку пользователей
add_action( 'wp_ajax_nopriv_delete_all_links_blocks', 'ajax_delete_all_links_blocks_function' ); // Для не вошедших в админку посетителей
function ajax_delete_all_links_blocks_function() {
	global $wpdb, $post;
	if ($_POST['post_id']) {

		$result = delete_metadata('post', $_POST['post_id'], "all_links_blocks");
		//$result = $wpdb->delete( 'postmeta', array( 'meta_key' => 'all_links_blocks', 'post_id' => $_POST['post_id']), array( '%s', '%d', ) );
		//var_dump($result);
		if($result) {
			echo 'Удалили все блоки ссылок для поста с ID = '.$_POST['post_id'];
		}
	}
	
	
	exit;
}


/*	Ajax'ом сохраняем все блоки и добавляем в массив
==============================================================*/
add_action( 'wp_ajax_save_product_blocks', 'ajax_save_product_blocks_function' ); // для вошедших в админку пользователей
add_action( 'wp_ajax_nopriv_save_product_blocks', 'ajax_save_product_blocks_function' ); // Для не вошедших в админку посетителей
function ajax_save_product_blocks_function() {
	global $wpdb, $post;
	if ($_POST['post_id']) {
		$post_id = $_POST['post_id'];
		$save_product_blocks_for_post_id = post_product_links_update($post_id);
		echo 'Сохранили все блоки и добавили в массив для поста с ID = '.$save_product_blocks_for_post_id;
	}
	
	
	exit;
}


/*	Ajax'ом удаляем конкретный блок ссылок из массива
==============================================================*/
add_action( 'wp_ajax_delete_this_block_liks', 'ajax_delete_this_block_liks_function' ); // для вошедших в админку пользователей
add_action( 'wp_ajax_nopriv_delete_this_block_liks', 'ajax_delete_this_block_liks_function' ); // Для не вошедших в админку посетителей
function ajax_delete_this_block_liks_function() {
	global $wpdb, $post;
	if ($_POST['post_id']) {
		$post_id = $_POST['post_id'];
		$save_product_blocks_for_post_id = delete_this_block_liks($post_id);
		echo 'Сохранили все блоки и добавили в массив для поста с ID = '.$save_product_blocks_for_post_id;
	}
	
	
	exit;
}



/*	Шорткод для вывода блоков с ссылками в содержимом поста
==============================================================*/
function links_block_func( $atts ) {
	global $post;
	$all_links_blocks = get_post_meta($post->ID, 'all_links_blocks', 1);
	$atts['name'];
	$return = null;
	//var_dump($all_links_blocks[$atts['name']]['links']);
	$count=0;
	$this_block_links = $all_links_blocks[$atts['name']];
//	var_dump($atts['name']);
	$return .= '<div class="row">';
	foreach($this_block_links['links'] as $block_links) { $count++;
		if($count>1) {
			$image = wp_get_attachment_url($block_links[0]);
			$return .= '
			<div class="col-md-4"><div class="catalog-product">
				<a href="'.$block_links[2].'">
					<img src="'.$image.'" />
					<div class="name">'.$block_links[1].'</div>
				</a>
			</div></div>';
		}
	}
	$return .= '</div>';
	 
	return $return;
}
add_shortcode('links_block', 'links_block_func');


?>