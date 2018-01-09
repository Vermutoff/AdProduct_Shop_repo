jQuery(document).ready(function($) {
	
	/*	Заполняем все витрины в блоге товарами
	=================================================*/
		
	(function($){
		  jQuery.fn.insert_product_vitrina = function(){
			
			var make = function(){
			
				// здесь переменная this будет содержать отдельный
				// DOM-элемент, к которому и нужно будет применить
				// воздействия плагина
				var vitrina_data = $(this).data();
				var this_object = $(this);
	
				$(this_object).find('.product_list').append('<div class="preloader"><img src="/wp-content/themes/promocode/images/ajax-loader.gif" /></div>');
			
				var data = {
					action: 'xml_vitrina',
					vitrina_data: vitrina_data
				};
			
			
				$.ajax({
					type: "POST",
					url: vitrina_ajaxurl.url,
					data: data, 		
					success: function(html) {
						
						$(this_object).empty();
						$(this_object).append(html);
							
					}
					
				});
				
				
				
			};

			return this.each(make); 
		  };
		})(jQuery);

	$('.vitrina').insert_product_vitrina();
	
	
		
	/*	Подгружаем товары
	=================================================*/
	(function($){
	jQuery.fn.make_vitrina = function(){
			
		var make = function(){
			var this_object = $(this);
			$(this_object).append('<div class="preloader"><img src="/wp-content/themes/promocode/images/ajax-loader.gif" /></div>');
			
			var data = {
				action: 'xml_vitrina',
				post_id: vitrina_ajaxurl.post_id
			};
			
			$.ajax({
				type: "POST",
				url: vitrina_ajaxurl.url,
				data: data, 		
				success: function(html) {
					$(this_object).empty();
					$(this_object).append(html);	
				}
			});
	
	};

	return this.each(make); 
		  };
		})(jQuery);

	$('#vitrina').make_vitrina();
	
	/*	Подгружаем купоны
	=================================================
				
	(function($){
	jQuery.fn.get_promocode = function(){
			
		var make = function(){
			var this_object = $(this);
			var post_id = $(this).data('post_id');
				
			$.ajax({
				type: "POST",
				url: ajax_get_cupons_gdeslon.ajax_url,
				data: {
					action: 'get_cupons_gdeslon',
					post_id:post_id
				}, 
									
				success: function(html) {
					$(this_object).empty();
					$(this_object).append(html);
				}
			});
	
		};

		return this.each(make); 
	};
	})(jQuery);

	$('#promocode').get_promocode();
				*/
	
	
	
});