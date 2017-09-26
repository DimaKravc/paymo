<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section.
 *
 * @package PAYMO
 * @version 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#00acc1">
    <meta name="msapplication-navbutton-color" content="#00acc1">
    <meta name="apple-mobile-web-app-status-bar-style" content="#00acc1">
    <?php wp_site_icon(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
