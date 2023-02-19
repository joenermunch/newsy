<?php

/**
 * Adds a custom meta field to category terms to store the category color.
 */
function newsy_blocks_add_category_color_meta() {
    register_meta( 'term', 'category_color', array(
        'type' => 'string',
        'description' => 'Category color',
        'single' => true,
        'show_in_rest' => true,
    ) );
}
add_action( 'init', 'newsy_blocks_add_category_color_meta' );

// Add the color picker script to the admin page
function newsy_blocks_enqueue_color_picker() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'newsy-blocks-color-picker', plugins_url( '/assets/js/category-colors.js', dirname( __FILE__ ) ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'newsy_blocks_enqueue_color_picker' );

/**
 * Adds a color field to the category edit page to allow the user to select a color for the category.
 */
function newsy_blocks_category_color_field( $term ) {
    $color = get_term_meta( $term->term_id, 'category_color', true );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_color"><?php esc_html_e( 'Category Color', 'newsy-blocks' ); ?></label></th>
        <td>
            <input type="text" class="color-field" name="category_color" id="category_color" value="<?php echo esc_attr( $color ); ?>" />
            <p class="description"><?php esc_html_e( 'Select a color for this category.', 'newsy-blocks' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'category_edit_form_fields', 'newsy_blocks_category_color_field', 10, 2 );

/**
 * Saves the category color when a category is updated.
 */
function newsy_blocks_save_category_color_meta( $term_id ) {
    if ( isset( $_POST['category_color'] ) ) {
        update_term_meta( $term_id, 'category_color', sanitize_hex_color( $_POST['category_color'] ) );
    }
}
add_action( 'edited_category', 'newsy_blocks_save_category_color_meta', 10, 2 );