<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews">
    <div class="uk-grid">
        <div class="uk-width-1-1 uk-width-large-1-2">
            <div id="comments">

                <?php if ( have_comments() ) : ?>

                    <ol class="commentlist">
                        <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
                    </ol>

                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                        echo '<nav class="woocommerce-pagination">';
                        paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
                            'prev_text' => '&larr;',
                            'next_text' => '&rarr;',
                            'type'      => 'list',
                        ) ) );
                        echo '</nav>';
                    endif; ?>

                <?php else : ?>

                    <p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'eclat' ); ?></p>

                <?php endif; ?>
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-large-1-2">
            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

                <div id="review_form_wrapper">
                    <div id="review_form">
                        <?php
                        $commenter = wp_get_current_commenter();
                        $comment_form['comment_field'] = '';

                        $comment_form = array(
                            'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'eclat' ) : esc_html__( 'Be the first to review', 'eclat' ),
                            'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'eclat' ),
                            'comment_notes_before' => '',
                            'comment_notes_after'  => '',
                            'fields'               => array(
                                'author' => '<div class="form-group comment-form-author">' .
                                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" />'.
                                    '<label for="author">' . esc_html__( 'Name', 'eclat' ) . ' <em class="required">*</em></label></div>',
                                'email'  => '<div class="form-group comment-form-email"> ' .
                                    '<input class="form-control" id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" />'.
                                    '<label for="email">' . esc_html__( 'Email', 'eclat' ) . ' <em class="required">*</em></label></div>',
                            ),
                            'label_submit'  => esc_html__( 'Submit review', 'eclat' ),
                            'logged_in_as'  => '',
                            'comment_field' => ''
                        );

                        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                            $comment_form['comment_field'] .= '<p class="comment-form-rating"><label for="rating">' . wp_kses_post( __( 'Rate the product. Please select a rating between<br/> 0 (poorest) and 5 stars (best).', 'eclat' ) ) .'</label><select name="rating" id="rating">
							<option value="">' . esc_html__( 'Rate&hellip;', 'eclat' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'eclat' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'eclat' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'eclat' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'eclat' ) . '</option>
							<option value="1">' . esc_html__( 'Very Poor', 'eclat' ) . '</option>
						</select></p>';
                        }

                        $comment_form['comment_field'] .= '<div class="form-group comment-form-comment textarea"><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea><label for="comment">' . esc_html__( 'Your Review', 'eclat' ) . '</label></div>';

                        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'eclat' ); ?></p>

            <?php endif; ?>
        </div>
    </div>
</div>
