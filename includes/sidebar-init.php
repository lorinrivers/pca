<?php

// Register widgetized areas

function the_widgets_init() {
    if ( !function_exists('register_sidebars') )
        return;

    register_sidebar(array('name' => 'Home Page Primary','id' => 'home-primary','description' => "Normal full width Sidebar", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));   
    register_sidebar(array('name' => 'Home Page Secondary Left','id' => 'home-secondary-1', 'description' => "Left column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
    register_sidebar(array('name' => 'Home Page Secondary Right','id' => 'home-secondary-2', 'description' => "Right column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
    
    register_sidebar(array('name' => 'Other Pages Primary','id' => 'primary','description' => "Normal full width Sidebar", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));   
    register_sidebar(array('name' => 'Other Pages Secondary Left','id' => 'secondary-1', 'description' => "Left column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));
    register_sidebar(array('name' => 'Other Pages Secondary Right','id' => 'secondary-2', 'description' => "Right column (part of 2-col sidebar)", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>'));	
    register_sidebar(array('name' => 'Footer 1','id' => 'footer-1', 'description' => "Widetized footer", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div></div></div>','before_title' => '<h3>','after_title' => '</h3><div class="outer"><div class="inner">'));
    register_sidebar(array('name' => 'Footer 2','id' => 'footer-2', 'description' => "Widetized footer", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div></div></div>','before_title' => '<h3>','after_title' => '</h3><div class="outer"><div class="inner">'));
    register_sidebar(array('name' => 'Footer 3','id' => 'footer-3', 'description' => "Widetized footer", 'before_widget' => '<div id="%1$s" class="widget %2$s">','after_widget' => '</div></div></div>','before_title' => '<h3>','after_title' => '</h3><div class="outer"><div class="inner">'));
}

add_action( 'init', 'the_widgets_init' );


    
?>