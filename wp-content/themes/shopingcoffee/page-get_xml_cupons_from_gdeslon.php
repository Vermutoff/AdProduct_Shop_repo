<?php // Template name: Скачиваем купоны из Где Слон
get_header();?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php 

	get_xml_cupons_from_gdeslon();
 ?>
<?php endwhile; ?>
<?php get_footer();?>