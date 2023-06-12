<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <?php lvly_favicon(); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>><div class="tw-preloader"><div data-uk-spinner></div></div><?php
        lvly_template_header(); ?>
        <div<?php lvly_main_data(); ?>><?php
            lvly_template_feature();