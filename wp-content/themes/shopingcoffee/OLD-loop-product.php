<?php if ( ! have_posts() ) : ?>

	<div id="post-0" class="post error404 not-found">

		<h1 class="entry-title">Извините, ничего не найдено</h1>

		<div class="entry-content" style="width: 100% !important;">
<h3 style="text-align: center; padding: 0 0 30px 0;">Пожалуйста, воспользуйтесь поиском снова</h3>
						<?php get_search_form(); ?>
<h2>Или попробуйте найти материал самостоятельно</h2>
				   <ul style="clear: both; overflow: hidden; width: 100%; margin: 0; padding: 0;"><?php
$args=array(
  'orderby' => 'name',
  'order' => 'ASC'
  );
$categories=get_categories($args);
  foreach($categories as $category) {
    echo '<li style="float: left; width: 50%; list-style: none;"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "Смотреть записи из рубрики %s" ), $category->name ) . '" ' . '>' . $category->name.'</a> </li> ';
 }
?>
</ul>


		</div><!-- .entry-content -->

	</div><!-- #post-0 -->

<?php endif; ?>

<?php /* Start the Loop. */ ?>

<? while (have_posts()) : the_post();$count++; ?>

<!-- Начало поста -->
<div id="post-<?php the_ID(); ?>" class="loop hentry product">
	
	<div class="thumbnail">
	<?php 
	$thumbnail = get_post_meta($post->ID, 'picture', true );
	if (has_post_thumbnail()) { ?>
	<a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('thumbnail'); ?></a>
	<?php } elseif($thumbnail) { ?>
	<a rel="nofollow" href="<? the_permalink() ?>"><img alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
	<? } else { ?>
	<a rel="nofollow" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><img src="<?php bloginfo('template_directory'); ?>/images/noimage.png" /></a>
	<? } ?>
	</div>
	
	<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" >
	<? the_title(); ?>
	</a></h3>
	
	<!--div class="excerpt">
		<? //the_excerpt(); ?>
	</div-->

</div><!-- Конец поста -->
		
<?php
endwhile; ?>

	<div id="nav-below" class="navigation">
	<?php	
				if(function_exists('wp_pagenavi')) { wp_pagenavi(); } 
			
	?>
	</div><!-- #nav-below -->
