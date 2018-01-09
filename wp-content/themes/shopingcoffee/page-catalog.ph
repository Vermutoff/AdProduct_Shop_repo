<?php
/*
Template Name: Каталог мобильных устройств
*/
?>
<?php get_header(); ?>

		<div id="container">
			<div class="content" role="main">

<?php
$my_posts = get_posts('numberposts=-1&post_type=ps_catalog');
foreach ($my_posts as $post) :
setup_postdata($post);
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<div class="entry-content">
						<?php the_excerpt(); ?>
					</div><!-- .entry-content -->
</div><!-- #post-## -->
<?php endforeach; ?>

			</div><!-- #content -->
		</div><!-- #container -->
		

<?php get_sidebar(); ?>
<?php get_footer(); ?>
