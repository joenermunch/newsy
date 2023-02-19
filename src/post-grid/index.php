<?php
/**
 * Register the post grid block and its render function.
 */
function newsy_dynamic_post_grid_init() {
	// Register the block and specify the render function.
	register_block_type( NEWSY_BLOCKS_DIR_PATH . '/build/post-grid', array(
		'render_callback' => 'render_dynamic_posts',
	) );
}
add_action( 'init', 'newsy_dynamic_post_grid_init' );

/**
 * Render the post grid block.
 *
 * @param array $attributes The block attributes.
 *
 * @return string The rendered block HTML.
 */
function render_dynamic_posts( $attributes ) {
	// Get the post IDs from the block attributes.
	$post_ids = wp_list_pluck( $attributes['posts'], 'id' );


	// Prepare the query arguments.
	$args = array(
		'post_type'      => 'any',
		'post__in'       => $post_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => -1,
	);

	// Run the query.
	$post_query = new WP_Query( $args );

	// Initialize the block content.
	$content = '<div class="post-grid-container">';

	if (isset($attributes['title'])) {
		$content .= '<div class="title-container"><h2>' . $attributes['title'] . '</h2></div>';
	}

	if (isset($attributes['subtitle'])) {
		$content .= '<div class="subtitle-container"><p class="subtitle">' . $attributes['subtitle'] . '</p></div>';
	}

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
			$post_thumbnail = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
			$categories     = get_the_category();

			// Get the main category of the post.
			$main_category = '';
			$category_name = '';
			if ( ! empty( $categories ) ) {
				$main_category = $categories[0];
				$category_name = $main_category ? $main_category->name : '';
			}

			// Get the background color of the main category, if it has one.
			$category_color    = $main_category ? get_term_meta( $main_category->term_id, 'category_color', true ) : '';
			$background_color  = $category_color ? ' style="background-color: ' . esc_attr( $category_color ) . ';"' : '';

			// Add the post to the block content.
			$content .= '<li class="post-item" style="background-image: url('.esc_url( $post_thumbnail ).')">';
			$content .= '<a href="' . esc_url( $post_permalink ) . '">';
            $content .= '<div class="text-container"><h2>'.esc_html( $post_title ).'</h2><p>' . esc_html(get_the_excerpt()) . '</p></div>';
			$content .= '<div class="categories-container post">';
			$content .= '<ul>';
			$content .= '<li' . $background_color . '>' .esc_html( $category_name ) . '</li>';
			$content .= '</ul>';
			$content .= '</div>';
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
