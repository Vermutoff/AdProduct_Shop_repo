<?php



/*	Добавляем блок партнерских ссылок
================================================*/

add_action('add_meta_boxes', 'my_link_fields', 1);

function my_link_fields() {
	add_meta_box( 'link_fields', 'Партнерские ссылки', 'link_fields_box_func', 'post', 'normal', 'high'  );
}

// код блока
function link_fields_box_func( $post ){
	$links = get_post_meta($post->ID, 'link', 1); ?>
	
	<div class="link_list">
		<div id="link_block" style="display: none;">
			<div class="add_link_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
				
				<p><input size="75" type="text" name="link[]" value="" /><label> - Название </label></p>
				<p><input size="75" type="text" name="link[]" value="" /><label> - ссылка</label></p>
				<button class="up">Наверх</button>
				<button class="down">Вниз</button>
				<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
			</div>
			
		</div>
	<?php $lnk_count=0;
	foreach($links as $link) { $lnk_count++;
		if($lnk_count !== 1) {
			
			echo '<div class="add_link_block" style="padding: 15px; margin: 15px 0; border: 1px dashed #dddddd; display: block; overflow: hidden; position: relative;">
			<div style="float: left; margin-right: 25px;">';
				
			echo '</div><p><input size="75" type="text" name="link[]" value="'.$link[0].'" /><label> - Название </label></p>
					<p><input size="75" type="text" name="link[]" value="'.$link[1].'" /><label> - ссылка</label></p>
					<button class="up">Наверх</button>
					<button class="down">Вниз</button>
					<button class="deleted_block" style="position: absolute; top: 5px; right: 5px;">Удалить блок</button>
				</div>';
		}
	}
	
	//var_dump($links);

	
?>
	
</div>
	<button id="add_link_block">Добавить блок</button>
	<input type="hidden" name="link_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_link_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_link_fields_update( $post_id ){
	if ( !wp_verify_nonce($_POST['link_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['link']) ) return false;	

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['link'] = array_map('trim', $_POST['link']);
	
	delete_post_meta($post_id, 'link');
	$link = array_chunk($_POST['link'], 2);
		
	update_post_meta($post_id, 'link', $link);
	
		
	return $post_id;
}



?>