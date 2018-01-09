<?php get_header(); ?>
<div id="content" role="main" class="both single-product">

<?php 	if ( have_posts() ) while ( have_posts() ) : the_post(); 
		setPostViews(get_the_ID()); 
		$xml_file = get_post_meta(get_the_ID(), 'wpcf-xml_file', 1);
		
	/*	$product_name = get_post_meta($post->ID, 'wpcf-product_name', true); 
		$post_id = $post->ID;
		
		$post_xml_file = str_replace(' ', '%20', $xml_file);
		$tid = get_post_meta($post_id, 'wpcf-gs_category', 1);
		
		if($post_xml_file) {
			$url  = 'http://api.gdeslon.ru/api/search.xml?';
			$url .= 'q='.$post_xml_file.'&';
			if($tid) { $url .= 'tid='.$tid.'&'; }
			$url .= 'l=99&_gs_at=7f54c3db2888b7a476661eb5410c608e9dff86fe';
			
			
		}
		*/
		?>

	<h1 class="entry-title"><?php the_title(); ?></h1>
	
	<?php	
	$excerpt = get_the_excerpt();
	$more_links = get_post_custom_values('wpcf-more_link', $post->ID);
	if($more_links and $more_links[0] != '') {
		$more_link_block .= '<div class="more_links"><span style="font-weight: bold;">Популярное:</span>';
		foreach($more_links as $more_link) {
			if($more_link) {
				$more_link_block .= '<a rel="nofollow" target="_blank" title="'.$more_link.'" href="http://shopingeconom.ru/product_search.html?name_product='.$more_link.'">'.$more_link.'</a>';
			}
		}
		$more_link_block .= '</div>';
	}
	
	if($xml_file) {
			echo do_shortcode('[adproduct_vitrina_product_shortcode vitrina_id="'.$xml_file.'"]');
		}
	
	?>
	
	
	
	<?php
	//echo '<div class="large-title">Каталог с ценами</div>';
	//if($more_link_block) { echo $more_link_block;}
//	echo '<div id="vitrina"></div>';
	//get_gs_vitrina($post->ID);
	
	
	
	/*
	
	$xml_request = get_post_meta($post->ID, 'wpcf-xml_file', true);
		
		if($xml_request) { 	
			$url = 'http://www.shopingeconom.ru/wp-content/themes/promocode/functions/product_xmls/'.$xml_request.'.xml';
			$xml = simplexml_load_file($url);
			if($xml) {
				//echo $url;
				
				foreach ($xml->xpath('shop/offers/offer') as $product) {
					$num = $product->price; 
					$price = rtrim(rtrim($num, ''), '.');
					$id_product = $product[id];
					$product_original_picture = $product->original_picture[0];
					
						$product_for_vitrina[] = array(
							'id' => $id_product,
							'image' => $product_original_picture,
							'merchant' => $product[merchant_id],
							'name' => $product->name,
							'price' => $price,
							'link' => $product->url,
							'parent' => $post->ID
						);
					
					
				}
				
			}
	
		}

if($product_for_vitrina) {
	function sort_p($a, $b)
	{
	return strnatcmp($b["price"], $a["price"]);
	}

	//usort($product_for_vitrina, "sort_p");
	
	//shuffle($product_for_vitrina);
	
	$vitrina .= '<div class="product_list both">';
	$product_count = 0;
	foreach ($product_for_vitrina as $product_this) {
		$product_count++;
		if($product_count == 1) { $product_class = 'first'; }
		if($product_count == 2) { $product_class = 'second'; }
		if($product_count == 3) { $product_class = 'last'; }
		$vitrina .= '<div id="product_card-'.$product_this['id'].'" class="product_card block '.$product_class.'">';
		$vitrina .= '<span class="thumb"><span class="link" data-href="'.$product_this['link'].'"><img id="'.$product_this['id'].'" class="product_more" alt="Купить '.$product_this['name'].' за '.$product_this['price'].' рублей" src="';
		if($product_this['image']) { $vitrina .= $product_this['image']; } else { $vitrina .= '/wp-content/themes/promocode/images/noimage_product.png';}
		$vitrina .= '"></span></span>';
		$vitrina .= '<span class="product_title link" data-href="/product.html?parent='.$product_this['parent'].'&product_id='.$product_this['id'].'">'.$product_this['name'].'</span>';
		$vitrina .= '<span class="product_price"><b>'.$product_this['price'].'</b> руб</span>';
		$vitrina .= '<span class="link product_button grey" data-href="'.$product_this['link'].'">Купить</span>
		
		<button title="В список покупок" class="lovely_product" 
		data-id="'.$product_this['id'].'" 
		data-name="'.$product_this['name'].'" 
		data-img="'.$product_this['image'].'" 
		data-price="'.$product_this['price'].'" 
		data-parent="'.$product_this['parent'].'" 
		data-link="'.$product_this['link'].'"
		
		>Отложить товар</button>';
		$vitrina .= '</div>';
		if($product_count == 3) { $product_count = 0; }
	}
	$vitrina .= '</div>';
	
	if($vitrina) { echo $vitrina; } 
} 
*/


		?>

</div><!-- #content -->

<?php
/*
$categories = get_the_terms($post->ID, 'product_cat');
if ($categories) {
    $category_ids = array();
    foreach($categories as $individual_category) {
		$category_ids[] = $individual_category->term_id;
		//echo $individual_category->term_id;
	}

    $args=array(
		'post_type' => 'product',		
		'tax_query' => array(  
			'relation' => 'AND',  
			array(  
				'taxonomy' => 'product_cat',  
				'field' => 'id',  
				'terms' => $category_ids[0]
			)
		),
        'post__not_in' => array($post->ID),
		'orderby' => 'rand',
		'posts_per_page' => 4
    );

$relateds = new wp_query($args);
    if( $relateds->have_posts() ) {
		echo '<div class="block row">';
		$category_ids_litle_name = get_option('product_cat_'.$category_ids[0].'_litle_name_category');
        echo '<span class="h2 large-title col-md-12">'.$category_ids_litle_name.' от других брендов</span>';
        while ($relateds->have_posts()) {
            $relateds->the_post();
        ?>
		<div class="col-md-3">
          <!-- Начало поста -->
		<div id="post-<?php the_ID(); ?>" class="loop hentry product">
			
			<div class="thumbnail">
			<?php 
			$thumbnail = get_post_meta($post->ID, 'wpcf-pictures', true );
			if (has_post_thumbnail()) { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('medium'); ?></a>
			<?php } elseif($thumbnail) { ?>
			<a href="<? the_permalink() ?>"><img alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
			<? } else { ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/noimage.png" /></a>
			<? } ?>
			</div>
			
			<h4 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
			<? the_title(); ?>
			</a></h4>
			
			<!--div class="excerpt">
				<? //the_excerpt(); ?>
			</div-->

		</div><!-- Конец поста -->
		</div>
        <?php
        }
        echo '</div>';
    }
    wp_reset_query();
}
*/
?>

		
<div id="view" class="block row">
	
	<div class="col-md-12">
		<div class="white-block p-25 m-0-0-45-0">
			<?php the_content(); ?>
		</div>
	</div>	
	
	<div class="col-md-12">
		<div class="white-block p-25 m-0-0-45-0">
			<h2 id="respond">Отзывы<? if($product_name) { echo ' про '.$product_name; }?></h2>
			<?php comments_template( '', true ); ?>
		</div>
	</div>
			
			
	<div class="posted_on">Опубликованно <span class="updated"><?php the_time('j F Y'); ?> в <time><?php the_time('G:i'); ?></time></span></div>
</div>
<? endwhile; ?>



<?php get_footer(); ?>