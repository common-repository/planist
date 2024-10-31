<?php

/**
 * Plugin Name:     Planist
 * Plugin URI: 		https://planist.live
 * Description:     Planist Shortcode and Block
 * Version:         1.0.0
 * Author:          Parsa Kafi
 * Author URI: 		https://parsa.ws
 */

class Planist
{
    function __construct()
    {
        add_shortcode('planist', [$this, 'shortcode']);
        add_action('enqueue_block_editor_assets', [$this, 'gutenbergBlocks']);
    }

    function gutenbergBlocks()
    {
        wp_enqueue_style(
            'planist-block-style',
            plugins_url('/assets/css/block-style.css', __FILE__),
            array(),
            '1.0'
        );

        $assetFile = include(dirname(__FILE__)  . '/assets/planist-block/build/index.asset.php');
        wp_enqueue_script(
            'planist-block-editor',
            plugins_url('assets/planist-block/build/index.js', __FILE__),
            $assetFile['dependencies'],
            $assetFile['version']
        );

        $data = array();

        wp_localize_script('planist-block-editor', 'planist', $data);
    }

    function shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'url' => ''
        ), $atts, 'planist');

        return $this->iframe($atts['url']);
    }

    private function iframe($url)
    {
        $path = parse_url($url)['path'];

        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }

        $username = explode('/', $path)[1];

        $url = 'https://app.planist.fr' . $path;

        $style = 'border: none;min-height: 500px;width: 100%;';
        $style = apply_filters('planist_iframe_style', $style, $url);


        return '<iframe src="' . esc_url($url) . '" title="' . esc_attr(ucwords($username)) . ' Booking Page" width="100%" height="100%" style="' . $style . '"></iframe>';
    }
}

new Planist();
