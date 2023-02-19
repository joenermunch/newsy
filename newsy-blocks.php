<?php
/**
 * Plugin Name:       Newsy Blocks
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       newsy-blocks
 *
 * @package           newsy-blocks
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

// Check if ABSPATH is defined before using it
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit the script if ABSPATH is not defined
}

// Define a constant for the plugin directory path
define( 'NEWSY_BLOCKS_DIR_PATH', plugin_dir_path( __FILE__ ) );

// Define a constant for the includes directory path
define( 'NEWSY_BLOCKS_INCLUDES_DIR_PATH', NEWSY_BLOCKS_DIR_PATH . 'includes/' );

// Define a constant for the src directory path
define( 'NEWSY_BLOCKS_SRC_DIR_PATH', NEWSY_BLOCKS_DIR_PATH . 'src/' );

// Requires category colors functionality
require_once NEWSY_BLOCKS_INCLUDES_DIR_PATH . '/category-colors.php';

// Requires dynamic blocks
require_once NEWSY_BLOCKS_SRC_DIR_PATH . '/categories/index.php';
require_once NEWSY_BLOCKS_SRC_DIR_PATH . '/post-grid/index.php';
require_once NEWSY_BLOCKS_SRC_DIR_PATH . '/news-ticker/index.php';
require_once NEWSY_BLOCKS_SRC_DIR_PATH . '/post-list/index.php';
 
// Require Blocks
require_once NEWSY_BLOCKS_INCLUDES_DIR_PATH . '/blocks.php';


function enqueue_plugin_styles() {
    wp_enqueue_style( 'plugin-styles', plugin_dir_url( __FILE__ ) . 'scss/styles.css' );
}

add_action( 'wp_enqueue_scripts', 'enqueue_plugin_styles' );
add_action( 'admin_enqueue_scripts', 'enqueue_plugin_styles' );