<div class="widget subscribtion">
			<div class="h3 white-text widget-title">Любите экономить? Подпишитесь на рассылку!</div>
			<p>Купоны на скидку, <br/>акции и распродажи, <br/>новые записи блога</p>
	<?php 	global $post;
			$post_id = $post->ID;
			$list_id = '13'; 
			
			if($list_id) { 
				echo '<form class="adpr_ajax_form" method="POST" action="" name="adproduct_subscribtion_form">
					<input type="hidden" name="list_id" value="'.$list_id.'">
					<input type="hidden" name="action" value="mailing-add_email_user">
					<input type="hidden" name="ulr" value="'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'">
					<input type="hidden" name="meta[post_id]" value="'.$post_id.'">
					<div class="input-group">
						
						<input type="hidden" name="name" value="">
						<input class="form-control" type="text" name="email" placeholder="Email адрес" value="">
						
					
						<span class="input-group-btn">
							<button type="submit" class="btn btn-warning">Подписаться</button>
						 </span>
						
						
					</div>
					 <div class="result"></div>
					 
					
				</form>';
			} ?>
</div>