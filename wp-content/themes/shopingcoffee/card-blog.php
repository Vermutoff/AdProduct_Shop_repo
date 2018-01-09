<?php $count=0; while (have_posts()) : the_post(); $count++; ?>

<div class="col-md-4">
<!-- Начало поста -->
<div id="post-<?php the_ID(); ?>" class="card-blog white-block m-0-0-45-0">
	
	<?php 
	$thumbnail = get_post_meta($post->ID, 'wpcf-pictures', true );
	if (has_post_thumbnail()) { ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail('medium', array( 'class'=>'img-responsive')); ?></a>
	<?php } elseif($thumbnail) { ?>
	<a href="<? the_permalink() ?>"><img class="thumbnail img-responsive" alt="<?php the_title_attribute(); ?>" src="<? echo $thumbnail; ?>" /></a>
	<? } ?>
	<div class="p-25">
		<a href="<?php the_permalink(); ?>"><? the_title(); ?></a>
	</div>
</div><!-- Конец поста -->
	

</div>	
<?php if($count % 3 == 0) { echo '<div class="clearfix"></div>';} ?> 
<?php endwhile; ?>
