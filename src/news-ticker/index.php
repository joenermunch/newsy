<?php
/**
 * Register the post grid block and its render function.
 */
function newsy_dynamic_ticker_init() {	
	// Register the block and specify the render function.
	register_block_type( NEWSY_BLOCKS_DIR_PATH . '/build/news-ticker', array(
		'render_callback' => 'render_dynamic_ticker',
	) );
}
add_action( 'init', 'newsy_dynamic_ticker_init' );

/**
 * Render the post grid block.
 *
 * @param array $attributes The block attributes.
 *
 * @return string The rendered block HTML.
 */
function render_dynamic_ticker( $attributes ) {
	// Get the post IDs from the block attributes.

	// Prepare the query arguments.
	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 10,
	);

	// Run the query.
	$post_query = new WP_Query( $args );

	// Initialize the block content.
	$content = '<div class="news-ticker-container" id="ticker">';

	// If the query returned any posts, add them to the block content.
	if ( $post_query->have_posts() ) {
		$content .= '<ul>';

		// Loop through the posts and add them to the block content.
		while ( $post_query->have_posts() ) {
			$post_query->the_post();

			// Get the post data.
			$post_id        = get_the_ID();
			$post_title     = get_the_title();
			$post_permalink = get_permalink();


			// Add the post to the block content.
			$content .= '<li class="ticker-item">';
			$content .= '<a href="' . esc_url( $post_permalink ) . '">';
            $content .= esc_html( $post_title );			
            $content .= '</a>';
			$content .= '</li>';
		}

		$content .= '</ul>';
	} else {
		// If the query returned no posts, add a "No posts found" message to the block content.
		$content .= '<p>' . esc_html__( 'No posts found.', 'newsy' ) . '</p>';
	}

    $content .= '</div>';

	// Restore the original post data.
	wp_reset_postdata();

	return $content;
}
