<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.','spalab'); ?></p>
<?php  return;
	endif;?>
    
    <h3> <?php comments_number(__('No Comments','spalab'), __('Comment ( 1 )','spalab'), __('Comments ( % )','spalab') );?></h3>    
    <?php if ( have_comments() ) : ?>
    
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <div class="navigation">
                        <div class="nav-previous"><?php previous_comments_link( __( 'Older Comments','spalab'  ) ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments','spalab') ); ?></div>
                    </div> <!-- .navigation -->
        <?php endif; // check for comment navigation ?>
        
        <ul class="commentlist">
     		<?php wp_list_comments( array( 'callback' => 'dttheme_custom_comments' ) ); ?>
        </ul>
    
    <?php else: ?>
		<?php if ( ! comments_open() ) : ?>
            <p class="nocomments"><?php _e( 'Comments are closed.','spalab'); ?></p>
        <?php endif;?>    
    <?php endif; ?>
	
    <!-- Comment Form -->
    <?php if ('open' == $post->comment_status) : ?>
			<?php $comments_args = array(
					'title_reply' => __( 'Post a Comment ','spalab' ),
					'fields'=>array(
						'author'	=>	'<p class="column dt-sc-one-half first">
										 <input id="author" name="author" type="text" placeholder="Your Name" required /></p>',
										 
						'email'		=>	'<p class="column dt-sc-one-half">
										 <input id="email" name="email" type="text" placeholder="Your Email" required /></p>',
						'url'		=>	'<p class="one-column clear"> <input id="url" name="url" type="text" placeholder="Website" /></p>'),
						
						'comment_field'=>'<p class="clear">
										 <textarea id="comment" name="comment" cols="5" rows="3" placeholder="Your Message" required></textarea></p>',
						'comment_notes_before'=>'','comment_notes_after'=>'','label_submit'=>__('Comment','spalab'));		
            comment_form($comments_args);?>
	<?php endif; ?>