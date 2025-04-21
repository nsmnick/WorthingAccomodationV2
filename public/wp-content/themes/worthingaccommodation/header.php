<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php
        wp_title(' - ', true, 'right');
        ?>
    </title>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo THEMEROOT; ?>/images/favicon.png">

    <?php wp_head(); ?>

    <?php echo get_field('embed_script_header', 'options'); ?>

</head>

<body <?php body_class(); ?>>

    <?php echo get_field('embed_script_body', 'options'); ?>

    <?php

    ?>

    <header>

        <div id="page-header" class="page-header">

            <div class="header-container animate fade-in">

                <div class="header-container__col1">
                    <a href="<?php echo site_url(); ?>/">
                        <div class="site-header-logo"></div>
                    </a>
                </div>

                <div class="header-container__col2">

                    <div class="mobile-menu-toggle">
                        <div id="mobile-menu-toggle" class="mobile-menu-toggle__button ">
                            <div class="mobile-menu-toggle__left"></div>
                            <div class="mobile-menu-toggle__right"></div>
                        </div>
                    </div>

                    <div class="contact-container">
                        <div class="contact-container__row">
                            <a class="phone_number" href="tel:<?php echo get_field('phone_number', 'options'); ?>"><?php echo get_field('phone_number_display', 'options'); ?></a>

                        </div>

                        <div class="contact-container__row">
                            <a class="email_address" href="mailto:<?php echo get_field('email_address', 'options'); ?>"><?php echo get_field('email_address', 'options'); ?></a>
                        </div>
                    </div>

                </div>





            </div>


        </div>

        <div class="page-menu">

            <div class="container">

                <nav id="main-menu" class="main-menu">
                    <ul>
                        <?php

                        wp_nav_menu([
                            'theme_location' => 'primary-menu',
                            'container' => '',
                            'items_wrap' => '%3$s'
                        ]);
                        ?>
                    </ul>


                </nav>
            </div>
        </div>

    </header>