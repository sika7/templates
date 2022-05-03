<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <!-- WordPressのjQueryを読み込ませない -->
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="wrapper">
        <!-- header -->
        <header class="header">
            <div class="logo">
                <a href="<?php echo esc_url( home_url()); ?>">
                    <?php bloginfo('name') ; ?>
                </a>
            </div>
            <p class="description">
                <?php bloginfo('description'); ?>
            </p>
            <!-- Navigation -->
            <?php wp_nav_menu( array ( 'theme_location' => 'header-navi','container' => nav, ) ); ?>
            <!-- /Navigation -->
        </header>
        <!-- /header -->
