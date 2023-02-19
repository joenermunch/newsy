<?php 


function newsy_blocks_newsy_blocks_block_init() {
	register_block_type( NEWSY_BLOCKS_DIR_PATH . '/build/cta');

}
add_action( 'init', 'newsy_blocks_newsy_blocks_block_init' );