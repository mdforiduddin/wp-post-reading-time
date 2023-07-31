<?php

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Reading_Time {
    public function __construct() {

        add_filter( 'the_content', [$this, 'wp_post_reading_time'] );
    }

    function wp_post_reading_time( $post_content ) {

        $stripped_content = strip_tags( $post_content );
        $word_number      = str_word_count( $stripped_content );

        $before_label = apply_filters( "wp_post_reading_time_before_text", __( 'Total Reading Time:', 'word-count' ) );
        $after_label  = apply_filters( "wp_post_reading_time_after_text", '' );
        $html_tag     = apply_filters( 'wp_post_reading_time_html_tag', 'h2' );

        $reading_minute  = floor( $word_number / 200 );
        $reading_seconds = floor( $word_number % 200 / ( 200 / 60 ) );

        $is_visible   = apply_filters( 'wp_post_reading_time_is_visible', true );
        $text_content = sprintf( '%1$s %2$s minutes %3$s seconds %4$s', $before_label, $reading_minute, $reading_seconds, $after_label );

        if ( $is_visible ) {
            $post_content .= sprintf( '<%1$s> %2$s </%3$s>', $html_tag, $text_content, $html_tag );
        }

        return $post_content;
    }
}