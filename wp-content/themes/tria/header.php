<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tria
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="row">
        <div class="large-12 columns">
            <nav class="top-bar" data-topbar data-options="scrolltop:false;">
                <ul class="title-area">
                    <li class="logo">
                        <div class="logo-innerwrap">
                            <?php
                            $logo = wen_get_option('logo');
                            ?>
                            <h1>
                                <a href="<?php echo esc_url(home_url('/')); ?>">
                                    <?php if ($logo): ?>
                                        <img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
                                    <?php else: ?>
                                        <?php bloginfo('name'); ?>
                                    <?php endif ?>
                                </a>
                            </h1>
                        </div>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
                </ul>
                <section class="top-bar-section">
                    <?php
                        //  Social Links
                        $social_links = wen_get_option('social_links')
                    ?>
                    <ul class="right show-for-medium-up">
                        <?php foreach($social_links as $social_link) { ?>
                        <a href="<?php echo $social_link['social_link']; ?>">
                            <li class="<?php echo $social_link['social_class'] . (strpos($social_link['social_class'], 'social') > -1 ? '' : ' icons'); ?>">
                                <?php echo $social_link['title']; ?>
                            </li>
                        </a>
                        <?php } ?>
                        <li class="vertical-separator">&nbsp;</li>
                        <li class="icons phone-icon">&#128222;</li>
                        <li class="phone-number"><?php echo wen_get_option('contact_phone_number'); ?></li>
                        <li class="search">
                            <?php get_search_form(); ?>
                        </li>
                        <li class="has-button">
                            <a class="small button search-button" href="#" id="btn-main-search-button">&#128269;</a>
                        </li>
                    </ul>
                    <?php
                    $menu_args = array(
                        'theme_location' => 'primary',
                        'menu_class' => 'right top-bar-two skip-dyn-class',
                        'walker' => new tria_walker_nav_menu(),
                        );
                    wp_nav_menu( $menu_args ); ?>
                </section>
            </nav>
        </div>
    </div>
