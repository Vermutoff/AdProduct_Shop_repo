<?php // Template name: Скачать все XML файлы из Где Слон
get_header();?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php 
	save_xml_to_server();

 ?>
<?php endwhile; ?>
<?php get_footer();?>