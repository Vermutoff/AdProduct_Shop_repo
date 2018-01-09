<?php get_header(); ?>

<div class="row">
	<div class="col-md-8">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div id="content" class="content m-0-0-45-0" role="main" >

<?php setPostViews($post->ID); $post_id = $post->ID;
$excerpt = get_post_meta($post->ID, 'wpcf-excerpt', 1); ?>

<div id="post-<?php echo $post->ID; ?>" class="blog hentry white-block p-25 m-0-0-45-0">

<h1 class="entry-title h2"><?php the_title(); ?></h1>


<?php if(!empty($excerpt)) { ?>
	<div class="top_meta" itemscope itemtype="http://schema.org/BlogPosting">
	   <div class="excerpt">
			<span itemprop="description"><?php echo $excerpt; ?></span>
			
			<div class="data"><span class="data-schema" itemprop="datePublished"><?php the_time('c'); ?></span></div>
	   </div>
		
	</div>
<?php } ?>


<div class="entry-content">
	<?php the_content(); ?>
</div><!-- #post-## -->


<?php get_template_part('share'); ?>

	<?php 	
	//$from_author = get_post_meta($post->ID, 'wpcf-from_author', 1);
	if($from_author) {
		$author_id = get_the_author_meta('ID');
		$author_name = get_the_author_meta('display_name');
		$author_twitter = get_the_author_meta('twitter');
		$author_vkontakte = get_the_author_meta('vkontakte');
		$author_avatar = '<img src="'.get_user_meta( $author_id, 'wpcf-photoshop', 1).'" />';
		echo '
		<div class="from_author">
			<div class="h2">От автора</div>
			<span class="author_avatar">
				'.$author_avatar.'
				<div itemscope itemtype="http://schema.org/BlogPosting" class="author"><span itemprop="author">'.$author_name.'</span></div>
				<span class="vk link" data-href="'.$author_vkontakte.'">ВКонтакте</span>
				<span class="tw link" data-href="'.$author_twitter.'">Твиттер</span>
			</span>
			<div class="from_author_text">'.$from_author.'</div>
			
		</div>';
	}
	?>
	</div>
	</div>
	
	</div>
		<noindex>
		<div class="col-md-4">
			<?php get_sidebar('blog'); ?>
		</div>
		</noindex>
		
		
		<?php get_shops_for_blog($post_id); ?>
		<?php related_blog_posts($post_id);	?>
		
	
	
		
		
		
	</div>
	
	
			
	<div class="row">
		<div class="col-md-12"><div class="m-0-0-45-0"><div class="row">
		
		<div class="col-md-12"><div class="h2">Добро пожаловать в Клуб!</div></div>
				<div id="club_respond" class="col-md-4">
					<div class="ticky_280_1000"><?php get_template_part('subscription'); ?></div>
				</div>
				
				<div id="club_group" class="col-md-8">
					
					<!-- VK Widget -->
					<div id="vk_groups_640"></div>
				</div>
		</div></div></div>	
		
		<div class="col-md-12"><div class="h2">Ваши вопросы, отзывы и комментарии</div></div>
		<div class="col-md-12"><div class="white-block p-25 m-0-0-45-0">
			
			
			
				<?php disqus_embed('shopingwoman');  ?>
			</div>
		</div>
	<?php endwhile; ?>
	
	
<div class="posted_on">Опубликованно <span class="updated"><?php the_time('j F Y'); ?> в <time><?php the_time('G:i'); ?></time></span></div>
		
	</div>



			</div><!-- #content -->
		</div>
	
</div>

<?php get_footer(); ?>