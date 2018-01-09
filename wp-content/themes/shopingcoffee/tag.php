<?php get_header(); ?>

<div id="content" class="block both" role="main">
	<h1 class="single-title page-title"><?php printf( __( '%s', 'promocode' ), '' . single_tag_title( '', false ) . '' ); ?></h1>
</div><!-- #content -->
	
<?php
					global $query_string;  
					// добавляем базовые параметры в массив $args  
					parse_str($query_string, $args);  
					// добавляем/заменяем параметр post_type в массиве  
					$args['post_type'] = array('product');  
					query_posts( $args );
					if ( have_posts() ) { ?>
					<div class="block both">
						<h2><?php printf( __( '%s', 'promocode' ), '' . single_tag_title( '', false ) . '' ); ?> в каталоге товаров</h2>					
						<? get_template_part( 'loop','product' ); ?>
					</div>
					<? } 
					wp_reset_query();
				?>
			
			
			
			
				<?php
					global $query_string;  
					// добавляем базовые параметры в массив $args  
					parse_str($query_string, $args);  
					// добавляем/заменяем параметр post_type в массиве  
					$args['post_type'] = array('blog');  
					query_posts( $args );  
					if ( have_posts() ) { ?>
					<div class="block both">
						<h2><?php printf( __( '%s', 'promocode' ), '' . single_tag_title( '', false ) . '' ); ?> в нашем блоге</h2>					
						<? get_template_part( 'loop','blog' ); ?>
					</div>
					<? } 
					wp_reset_query();
				?>

<?php get_footer(); ?>