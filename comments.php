    <?php
    if (post_password_required()) {
        ?>
        <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'capital') ?></p>
        <?php
        return;
    }
    /* ----------------------------------------------------------------------------------- */
    /* 	Display the comments + Pings
      /*----------------------------------------------------------------------------------- */
    if (have_comments()) : // if there are comments 
        ?>
        <section class="post-comments">
        	<div id="comments" class="clearfix">
                <h3 class="widgettitle"><?php comments_number(esc_html__('No Comments', 'capital'), esc_html__('Comment(1)', 'capital'), esc_html__('Comments(%)', 'capital')); ?></h3>
                <ol class="comments">
                    <?php wp_list_comments('avatar_size=51&callback=capital_comment'); ?>
                </ol>
            	<?php paginate_comments_links(); ?>
			</div>
		</section>
     <?php endif; ?>       
<?php
/* ----------------------------------------------------------------------------------- */
/* 	Comment Form
  /*----------------------------------------------------------------------------------- */
add_filter('comment_form_defaults', 'capital_comment_form');
function capital_comment_form($form_options)
{
	$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
    // Fields Array
    $fields = array(
        'author' => '<div class="row">
                                <div class="form-group">
                                    <div class="col-md-4 col-sm-4">
										<label>'.esc_html__('Name', 'capital').'</label>
                                        <input type="text" class="margin-20" name="author" id="author" value="" size="22" tabindex="1" placeholder="'.esc_html__('Your name', 'capital').'">
                                    </div>',
        'email' => '<div class="col-md-4 col-sm-4">
										<label>'.esc_html__('Email', 'capital').'</label>
                                        <input type="email" class="margin-20" name="email" id="email" value="" size="22" tabindex="2" placeholder="'.esc_html__('Your email', 'capital').'">
                                    </div>',
        'url' => '<div class="col-md-4 col-sm-4">
										<label>'.esc_html__('Website', 'capital').'</label>
                                        <input type="url" class="margin-20" name="url" id="url" value="" size="22" tabindex="3" placeholder="'.esc_html__('Website (optional)', 'capital').'"></div>
                                </div>
                            </div>',
    );
    // Form Options Array
    $form_options = array(
        // Include Fields Array
        'fields' => apply_filters( 'comment_form_default_fields', $fields ),
        // Template Options
        'comment_field' =>
        '<div class="row">
                            <div class="form-group">
                                <div class="col-md-12">
									<label>'.esc_html__('Comment', 'capital').'</label>
                                    <textarea name="comment" class="margin-20" id="comment-textarea" cols="8" rows="4"  tabindex="4"></textarea>
                                </div>
                            </div>
                        </div>',
        'must_log_in' => '',
        'logged_in_as' =>
       '',
        'comment_notes_before' =>'',
        'comment_notes_after' => '',
		'class_submit' => 'btn btn-primary',
        // Rest of Options
        'id_form' => 'form-comment',
        'id_submit' => 'comment-submit',
        'title_reply' => '
                <h3 class="widgettitle">'.esc_html__( 'Post a comment','capital' ),
		'title_reply_after' => '</h3>',
        'title_reply_to' => esc_html__( 'Leave a Reply to %s','capital' ),
        'cancel_reply_link' => esc_html__( 'Cancel reply','capital' ),
        'label_submit' => esc_html__( 'Submit', 'capital' ),
    );
    return $form_options;
}
comment_form();