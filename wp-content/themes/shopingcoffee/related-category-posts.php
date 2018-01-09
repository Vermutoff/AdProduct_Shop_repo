<div class="crp_related">
<div class="h3">Похожие магазины</div>
<ul>
<?php
$categories = get_the_category($post->ID);
if ($categories) {
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

    $args=array(
        'category__in' => $category_ids,
        'post__not_in' => array($post->ID),
        'showposts'=>3, // Количество выводимых записей
        'caller_get_posts'=>1
    );

$my_query = new wp_query($args);
    if( $my_query->have_posts() ) {
        echo '';
        while ($my_query->have_posts()) {
            $my_query->the_post();
        ?>

<li class="loop post_mini magazin">
			
	<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
		<a class="thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt=""><?php the_post_thumbnail(); ?></a>
	<?php else : ?>
		<a class="thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" alt=""><img width="234" height="124" src="<?php echo catch_that_image() ?>"></a>
	<?php endif; ?>
	
	<span class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
	<?  $model =  get_post_meta($post->ID, 'wpcf-offers_name', true); if($model) { $title = 'Промокоды '.$model; } else { $title = the_title(); } echo $title; ?>
	</a></span>
</li>

        <?php
        }
        echo '';
    }
    wp_reset_query();
}
?>
</ul>
</div>