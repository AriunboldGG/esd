<?php 
$header_search = lvly_get_option('header_search');
$header_cart = lvly_get_option('header_cart');
?>

<header class="header-container tw-header tw-header-sidebar uk-light uk-height-viewport uk-visible@l">
    <div class="tw-header-top">
        <?php lvly_logo(); ?>
    </div>
    <div class="tw-header-middle">
        <?php lvly_sidemenu(); ?>
    </div>
    <div class="tw-header-bottom">
        <?php echo lvly_fullmenu_social(); if ($header_cart) {lvly_modal_cart(array('pos'=>'right-bottom','boundary'=>''));} ?>
        <?php lvly_sidebar_search($header_search); ?>
    </div>
</header>
<div class="header-container tw-header tw-header-dark uk-light uk-hidden@l">
    <nav class="uk-navbar-container uk-flex-center" data-uk-navbar>
        <div class="uk-navbar-left">
            <?php lvly_logo(); ?>
        </div>
        <div class="uk-navbar-center">
            <?php lvly_menu(); ?>
        </div>
        <div class="uk-navbar-right">
            <div class="tw-header-meta">
                <a class="search-btn uk-navbar-toggle" href="#modal-full" data-uk-toggle><i class="simple-icon-magnifier"></i></a><?php
                if ($header_cart) {lvly_modal_cart();} ?>
                <a class="mobile-menu uk-navbar-toggle uk-hidden@m" href="#" data-uk-toggle="target: #mobile-menu-modal"><i class="ion-navicon-round"></i></a>
            </div>
        </div>
        <?php lvly_modal_search($header_search); ?>
    </nav>
    <?php lvly_modal_mobile_menu(); ?>
</div>