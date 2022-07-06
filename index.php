<?php

/*
  Plugin Name: Provecho Recipes
  Version: 1.0
  Author: Provecho
  Author URI: https://github.com/provecho-bio
  Description: This plugin allows Wordpress users to easily embed their Provecho recipes into their sites.
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Provecho
{
  function __construct()
  {
    add_action('init', array($this, 'onInit'));
    add_action('admin_menu', [$this, 'create_admin_menu']);
  }

  function onInit()
  {
    wp_register_script('blockEditorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
    // wp_register_style('blockEditorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('provecho/recipe-embed', array(
      'render_callback' => array($this, 'renderCallback'),
      'editor_script' => 'blockEditorScript',
      // 'editor_style' => 'blockEditorStyle'
    ));
  }

  function renderCallback($attributes)
  {
    if (!is_admin()) {
      wp_enqueue_script('blockFrontendScript', plugin_dir_url(__FILE__) . 'build/frontend.js', array('wp-element'));
      // wp_enqueue_style('blockFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
    }

    return sprintf(
      '<div class="provecho-recipe-embed-insertion-point"><pre style="display: none;"> %1$s </pre></div>',
      esc_html(wp_json_encode($attributes)),
    );
  }

  function renderCallbackBasic($attributes)
  {
    return '<div class="boilerplate-frontend">Hello, the sky is ' . $attributes['skyColor'] . ' and the grass is ' . $attributes['grassColor'] . '.</div>';
  }

 function create_admin_menu()
  {
    $capability = 'manage_options';
    $slug = 'provecho-dashboard';
    $icon =  'data:image/svg+xml;base64,' . base64_encode('<svg width="65" height="65" viewBox="0 0 65 65" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M48.8232 8.82049C47.6834 8.81861 46.5469 8.94933 45.4349 9.21024C44.2503 6.69287 42.4132 4.57238 40.1321 3.08939C37.8509 1.60641 35.2171 0.820312 32.5294 0.820312C29.8418 0.820312 27.2079 1.60641 24.9268 3.08939C22.6456 4.57238 20.8085 6.69287 19.6239 9.21024C18.5129 8.94915 17.3774 8.81843 16.2386 8.82049C8.30289 8.82049 1.86719 15.0874 1.86719 22.8205C1.86719 29.5946 6.80291 35.2429 13.3661 36.5389V64.8203H21.032V45.2154L18.9569 46.5053C18.824 46.5868 18.6767 46.6397 18.5238 46.6608C18.3709 46.6819 18.2155 46.6708 18.0668 46.6281C17.9181 46.5854 17.7791 46.512 17.6581 46.4123C17.537 46.3126 17.4364 46.1885 17.3621 46.0475C17.2067 45.7603 17.1644 45.4213 17.244 45.1022C17.3237 44.783 17.5191 44.5086 17.789 44.337L20.6615 42.5614L21.0439 42.3264V37.2658C21.0446 37.1479 21.0899 37.0351 21.1697 36.9518C21.2496 36.8684 21.3578 36.8212 21.4707 36.8204H24.4411C24.5538 36.8212 24.6616 36.8685 24.741 36.952C24.8204 37.0354 24.865 37.1482 24.865 37.2658V39.9569L31.9499 35.58C31.9597 35.572 31.9707 35.5658 31.9825 35.5615L32.0388 35.5305L32.0951 35.5058C32.1102 35.4978 32.1261 35.4915 32.1426 35.4872C32.1623 35.4772 32.1832 35.47 32.2048 35.4656H32.2463H32.3145C32.3293 35.467 32.3442 35.467 32.359 35.4656H32.4271H32.4746C32.5137 35.4572 32.554 35.4572 32.5931 35.4656H32.6406H32.7088H32.7503H32.8184H32.8599C32.8826 35.4695 32.9045 35.4768 32.9252 35.4872C32.9414 35.492 32.9573 35.4982 32.9726 35.5058L33.0259 35.5305C33.0459 35.5383 33.0648 35.5487 33.0823 35.5615C33.0949 35.5658 33.1069 35.572 33.1178 35.58L40.1998 39.9569L43.6503 42.0913L47.2817 44.337C47.5522 44.5081 47.7481 44.7824 47.8278 45.1018C47.9075 45.4212 47.8647 45.7605 47.7086 46.0475C47.6346 46.1884 47.5342 46.3124 47.4135 46.4121C47.2927 46.5118 47.1539 46.5852 47.0055 46.6279C46.857 46.6706 46.7019 46.6817 46.5492 46.6607C46.3965 46.6396 46.2494 46.5868 46.1167 46.5053L44.0416 45.2154V64.8203H51.6987V36.5389C58.2648 35.2429 63.2005 29.5946 63.2005 22.8205C63.2005 15.0874 56.7648 8.82049 48.8232 8.82049Z" fill="white"/>
    </svg>');


    add_menu_page(
      "Provecho Recipes",
      "Provecho Recipes",
      $capability,
      $slug,
      [$this, 'menu_page_template'],
      $icon
    );
  }

  function menu_page_template()
  {
    if (is_admin()) {
      wp_enqueue_script('adminScript', plugin_dir_url(__FILE__) . 'build/dashboard.js', array('wp-element'));
      // wp_enqueue_style('blockFrontendStyles', plugin_dir_url(__FILE__) . 'build/frontend.css');
    }

    echo '<div id="provecho-admin-app">s</div>';
  }
}

$provecho = new Provecho();
