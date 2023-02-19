<?php 

function newsy_dynamic_init() {

	register_block_type( NEWSY_BLOCKS_DIR_PATH . '/build/categories', array(
        'render_callback' => 'render_dynamic_categories',
    ) );

}

add_action( 'init', 'newsy_dynamic_init' );

function render_dynamic_categories( $attributes ) {
    $categories = get_categories();
    $content = '';

    if ( ! empty( $categories ) ) {
        $content .= '<div class="categories-container">';
        if (isset($attributes['title'])) {
            $content .= '<div class="title-container"><h2>' . $attributes['title'] . '</h2></div>';
        }
        if (isset($attributes['subtitle'])) {
            $content .= '<div class="subtitle-container"><p class="subtitle">' . $attributes['subtitle'] . '</p></div>';
        }
        $content .= '<ul>';
        foreach ( $categories as $category ) {
            $category_color = get_term_meta( $category->term_id, 'category_color', true );
            $background_color = $category_color ? ' style="background-color: ' . $category_color . ';"' : '';
            $content .= '<li' . $background_color . '><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
        }
        $content .= '</ul>';
        $content .= '</div>';
    }

    return $content;
}
