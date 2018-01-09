<div class="crp_related">

<div class="h3">Похожие товары</div>
<ul>
<?php
$categories = get_the_terms($post->ID, 'product_cat');
if ($categories) {
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

    $args = array(
        'category__in' => $category_ids,
		'post_type' => 'product',
        'post__not_in' => array($post->ID),
        'posts_per_page'=>6
    );

	$related_products = new WP_Query($args);
	if( $related_products->have_posts() ) {
		while ($related_products->have_posts()) {
			$related_products->the_post();
?>

	<li class="loop hentry product">
				
		<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
			<a class="post_thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt=""><?php the_post_thumbnail(); ?></a>
		<?php else : ?>
			<a class="post_thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt=""><img width="234" height="124" src="<?php echo catch_that_image() ?>"></a>
		<?php endif; ?>
		
		<span class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
		<?  $model =  get_post_meta($post->ID, 'wpcf-offers_name', true); if($model) { $title = 'Промокоды '.$model; } else { $title = the_title(); } echo $title; ?>
		</a></span>
	</li>

<?php
		}
	} else { echo 'Похожих товаров нет';}
		wp_reset_query();
} else { echo 'Категорий у товара нет';}
?>
</ul>

</div>