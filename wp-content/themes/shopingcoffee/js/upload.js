jQuery(document).ready(function($) {
 
		 $.countupload = function(){
			var i=0;
			$(".product_list .upload_image_button").each(function(){
				i++;
				var this_obj = $(this);
				$(this).attr("id","upload_image_button_"+i);	
				$(this).prev().attr("id","upload_image_"+i);
				$(this_obj).data('count', i);
			});
		  };
		$.countupload();
		
	$('#add_product_block').click(function(){
		
		var add_product_block = $('#product_block').html(); 
		$('.product_list').append(add_product_block);
		
		$.countupload();		
		
		return false;
	 });
	 
	 $('#add_link_block').click(function(){
		
		var add_product_block = $('#link_block').html(); 
		$('.link_list').append(add_product_block);
		
		$.countupload();		
		
		return false;
	 });
   /*
	 * действие при нажатии на кнопку загрузки изображения
	 * вы также можете привязать это действие к клику по самому изображению
	 */
	$('.upload_image_button').live('click', function(){
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		wp.media.editor.send.attachment = function(props, attachment) {
			$(button).parent().prev().attr('src', attachment.url);
			$(button).prev().val(attachment.id);
			wp.media.editor.send.attachment = send_attachment_bkp;
		}
		wp.media.editor.open(button);
		return false;    
	});
	/*
	 * удаляем значение произвольного поля
	 * если быть точным, то мы просто удаляем value у input type="hidden"
	 */
	$('.remove_image_button').live('click', function(){
		var r = confirm("Уверены?");
		if (r == true) {
			var src = $(this).parent().prev().attr('data-src');
			$(this).parent().prev().attr('src', src);
			$(this).prev().prev().val('');
		}
		return false;
	});
	
	$('.add_link_block .deleted_block').live('click', function(){
		
		$(this).parent(".add_link_block").remove()
		
		return false;
	});
	
	$('.add_product_block .deleted_block').live('click', function(){
		
		$(this).parent(".add_product_block").remove()
		
		return false;
	});
	
	$('#delete_all_product_blocks').on('click', function(){
		var post_id = $(this).data('post_id');
		
		$.ajax({
				type: "POST",
				url: wptoolset_forms_local.ajaxurl,
				data: {
					action: 'delete_all_links_blocks',
					post_id:post_id
				}, 
									
				success: function(html) {
					$('#result_ajax').empty();
					$('#result_ajax').append(html);
				}
			});
		
		return false;
	});
	
	
	$('#save_product_blocks').on('click', function(){
		//var post_id = $(this).data('post_id');
		
		$.ajax({
				type: "POST",
				url: wptoolset_forms_local.ajaxurl,
				data: {
					action: 'save_product_blocks',
					post_id:post_id
				}, 
									
				success: function(html) {
					$('#result_ajax').empty();
					$('#result_ajax').append(html);
				}
			});
		
		return false;
	});
	
	$('.delete_this_block_liks').on('click', function(){
		var post_id = $(this).data('post_id');
		
		$.ajax({
				type: "POST",
				url: wptoolset_forms_local.ajaxurl,
				data: {
					action: 'delete_this_block_liks',
					post_id:post_id
				}, 
									
				success: function(html) {
					$('#result_ajax').empty();
					$('#result_ajax').append(html);
				}
			});
		
		return false;
	});
	
	/*	Перемещение блоков
	===================================*/
	$(function() {
		
		$('.up').live('click', function() {
			var currentImgBlock = $(this).parent();
			var prevImgBlock = currentImgBlock.prev();
			swap(currentImgBlock, prevImgBlock);
			return false;
		});
		 
		$('.down').live('click', function() {
			var currentImgBlock = $(this).parent();
			var nextImgBlock = currentImgBlock.next();
			swap(nextImgBlock, currentImgBlock);
			return false;
		});
	});
	 
	function swap(a, b) {
		if (a.size() > 0 && b.size() > 0) {
			a.insertBefore(b);
		}
	}
	
});