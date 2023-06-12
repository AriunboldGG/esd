<?php 
echo lvly_top_bar();
$header_color = lvly_get_att('header_color');
$scroll_menu = lvly_get_att('scroll_menu');
$header_class = !empty($header_color) ? (' '.$header_color) : '';
$header_search = lvly_get_option('header_search');
$header_container = lvly_get_att('header_container');
$header_cart = lvly_get_option('header_cart');
$sticky = '';
if ($scroll_menu&&$scroll_menu!='none') {
    if ( is_admin_bar_showing() ) {
        $sticky .= "offset: 32;";
    }
    else{
        $sticky .= "offset: 0;";
    }
    if ($scroll_menu == 'scroll-up') {
        $sticky .= 'show-on-up: true; animation: uk-animation-slide-top;';
    }
}?>

<header class="header-container tw-header tw-header-index<?php echo esc_attr($header_class); ?>"<?php if ($sticky) { echo (' data-uk-sticky="'.esc_attr($sticky).'"'); } ?>>
    <?php   
        if ($header_container) {
            echo '<div class="'.esc_attr($header_container).'">'; 
        }
    ?>
        <nav class="uk-navbar-container" data-uk-navbar>
            <div class="uk-navbar-left">
                <?php lvly_logo($header_color); ?>
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
                <button class="uk-modal-close-full" type="button" data-uk-close></button>
                <div class="uk-light uk-height-viewport tw-mobile-modal uk-flex uk-flex-middle uk-flex-center" data-uk-scrollspy="target:>ul>li,>div>a; cls:uk-animation-slide-bottom-medium; delay: 150;">
                    <?php lvly_mobilemenu_main(); ?>
                    <?php echo lvly_fullmenu_social();?>
                </div>
            </div>
        </div>
    <?php   
        if ($header_container) {
            echo '</div>';
        }
    ?>
</header>