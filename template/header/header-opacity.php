<?php 
echo lvly_top_bar(true);
$header_color = lvly_get_att('header_color');
$scroll_menu = lvly_get_att('scroll_menu');
$header_class = !empty($header_color) ? (' '.$header_color) : '';
$header_search = lvly_get_option('header_search');
$header_container = lvly_get_att('header_container');
$header_cart = lvly_get_option('header_cart');
$sticky = $header_cont = '';
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
}
?>

<header class="header-container tw-header tw-header-opacity<?php echo esc_attr($header_class); ?>"<?php if ($sticky) { echo (' data-uk-sticky="'.esc_attr($sticky).'"'); } ?>>
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
                    <div class="mobile-menu uk-navbar-toggle" data-uk-toggle="target: #mobile-menu-push"><i class="ion-navicon-round"></i><i class="uk-light uk-close uk-icon" data-uk-close></i></div>
                </div>
            </div>
        </nav>
        <?php lvly_modal_search($header_search); ?>
        <div id="mobile-menu-push" data-uk-offcanvas="mode: slide; overlay: true; flip: true">
            <div class="uk-offcanvas-bar">

                <div class="header-container tw-header tw-header-sidebar uk-light uk-height-viewport">

                    <div class="tw-header-top">

                        <?php lvly_mobilemenu_main(); ?>

                    </div>
                    <div class="tw-header-bottom">
                        <?php echo lvly_fullmenu_social(); ?>
                    </div>

                </div>
            </div>
        </div>
    <?php   
        if ($header_container) {
            echo '</div>';
        }
    ?>
</header>