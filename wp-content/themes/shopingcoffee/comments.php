<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to promocode_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'promocode' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
		
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Старые отзывы', 'promocode' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Новые отзывы <span class="meta-nav">&rarr;</span>', 'promocode' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>
		
		
		
			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use promocode_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define promocode_comment() and that will be used instead.
					 * See promocode_comment() in promocode/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'promocode_comment' ) );
				?>
			</ol>
	
		
		
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Старые отзывы', 'promocode' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Новые отзывы <span class="meta-nav">&rarr;</span>', 'promocode' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

	<?php
	/* If there are no comments and comments are closed, let's leave a little note, shall we?
	 * But we only want the note on posts and pages that had comments in the first place.
	 */
	if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Запрещено оставлять отзывы' , 'promocode' ); ?></p>
	<?php endif;  ?>

<?php endif; // end have_comments() ?>

<div class="white-block p-25 m-0-0-45-0">
	<div class="h2 margin-top-0">Напишите отзыв</div>
	<span>Оцените магазин: </span><?php if(function_exists('the_ratings')) { the_ratings(); } ?>
	<?php 
	 $fields = array(
		'author' => '<p class="comment-form-author"><input type="text" id="author" name="author" placeholder="Ваше имя" class="author" value="' . esc_attr($commenter['comment_author']) . '" placeholder="Иван" pattern="[A-Za-zА-Яа-я]{3,}" maxlength="30" autocomplete="on" tabindex="1" required' . $aria_req . '></p>',
		'email' => '<p class="comment-form-email"><input type="email" id="email" name="email" placeholder="Ваше email" class="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="example@example.com" maxlength="30" autocomplete="on" tabindex="2" required' . $aria_req . '></p>'
		//'url' => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label><input type="url" id="url" name="url" class="site" value="' . esc_attr($commenter['comment_author_url']) . '" placeholder="www.example.com" maxlength="30" tabindex="3" autocomplete="on"></p>'
	  );

	$args = array(  
		'fields' => apply_filters( 'comment_form_default_fields', $fields )  
		,'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Ваш отзыв" ></textarea></p>'  
		,'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>'  
		,'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>'  
		,'comment_notes_before' => ''  
		,'comment_notes_after' => ''  
		,'id_form' => 'commentform'  
		,'id_submit' => 'submit'  
		,'title_reply' => ''  
		,'title_reply_to' => __( 'Добавить отзыв' )   
		,'cancel_reply_link' => __( 'Отменить' )   
		,'label_submit' => __( 'Добавить отзыв' )  
	);  

	comment_form($args); ?>
</div>


</div><!-- #comments -->
