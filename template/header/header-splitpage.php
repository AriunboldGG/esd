<?php 
$header_search = lvly_get_option('header_search');
$header_cart = lvly_get_option('header_cart');
$offset="";
if ( is_admin_bar_showing() ) {
    $offset = 'style="top: 32px;"';
}
else{
    $offset = 'style="top: 0;"';
}
?>

<header class="header-container tw-header tw-header-index uk-position-fixed tw-header-minimal uk-light tw-header-transparent"<?php echo ($offset);?>>
    <nav class="uk-navbar-container" data-uk-navbar>
        <div class="uk-navbar-left">
            <?php lvly_logo(); ?>
        </div>
        <div class="uk-navbar-right">
            <div class="tw-header-meta">
                <?php
                if ($header_search) {
                    echo '<a class="search-btn uk-navbar-toggle" href="#search-modal" data-uk-toggle><i class="simple-icon-magnifier"></i></a>';
                }
                if ($header_cart) {lvly_modal_cart();} ?>
                <div class="mobile-menu uk-navbar-toggle" data-uk-toggle="target: #mobile-menu-modal"><i class="ion-navicon-round"></i></div>
            </div>
        </div>
    </nav>
    <?php lvly_modal_search($header_search); ?>
    <div id="mobile-menu-modal" class="uk-modal-full" data-uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-full" type="button" data-uk-close <?php echo ($offset);?>></button>
            <div class="uk-light uk-height-viewport tw-mobile-modal uk-flex uk-flex-middle uk-flex-center" data-uk-scrollspy="target:>ul>li,>div>a; cls:uk-animation-slide-bottom-medium; delay: 150;">
                <?php lvly_mobilemenu_main(); ?>
                <?php echo lvly_fullmenu_social();?>
            </div>
        </div>
    </div>
</header>