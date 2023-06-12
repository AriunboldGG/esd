<?php 
echo lvly_top_bar(true);
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
} ?>

<header class="header-container tw-header<?php echo esc_attr($header_class); ?>"<?php if ($sticky) { echo (' data-uk-sticky="'.esc_attr($sticky).'"'); } ?>>
    <?php   
        if ($header_container) {
            echo '<div class="'.esc_attr($header_container).'">'; 
        }
    ?>
        <nav class="uk-navbar-container uk-flex-center" data-uk-navbar>
            <div class="uk-navbar-left"><?php lvly_logo($header_color); ?></div>
            <?php 
            if ($header_search || $header_cart) {
                echo '<div class="uk-navbar-center">';
                        lvly_menu();
                echo '</div>';
                echo '<div class="uk-navbar-right">';
                    echo '<div class="tw-header-meta">';
                        if ($header_search) {
                            echo '<a class="search-btn uk-navbar-toggle" href="#search-modal" data-uk-toggle><i class="simple-icon-magnifier"></i></a>';
                        }
                        if ($header_cart) {lvly_modal_cart();}
                        echo '<a class="mobile-menu uk-navbar-toggle uk-hidden@m" href="#" data-uk-toggle="target: #mobile-menu-modal"><i class="ion-navicon-round"></i></a>';
                    echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="uk-navbar-right">';
                    echo '<div class="tw-header-meta">';
                        lvly_menu();
                        echo '<a class="mobile-menu uk-navbar-toggle uk-hidden@m" href="#" data-uk-toggle="target: #mobile-menu-modal"><i class="ion-navicon-round"></i></a>';
                    echo '</div>';
                echo '</div>';
            }
            lvly_modal_search($header_search); ?>
        </nav>
        <?php lvly_modal_mobile_menu(); ?>
    <?php   
        if ($header_container) {
            echo '</div>';
        }
    ?>
</header><!-- .header-container.tw-header -->