<?php /* start WPide restore code */
                                    if ($_POST["restorewpnonce"] === "3c0115f1dca89705a0fd09005f29c36a11bf4b235f"){
                                        if ( file_put_contents ( "/home/bpdcom/public_html/wp/tria/wp-content/themes/tria/header.php" ,  preg_replace("#<\?php /\* start WPide(.*)end WPide restore code \*/ \?>#s", "", file_get_contents("/home/bpdcom/public_html/wp/tria/wp-content/plugins/wpide/backups/themes/tria/header_2014-08-13-07.php") )  ) ){
                                            echo "Your file has been restored, overwritting the recently edited file! \n\n The active editor still contains the broken or unwanted code. If you no longer need that content then close the tab and start fresh with the restored file.";
                                        }
                                    }else{
                                        echo "-1";
                                    }
                                    die();
                            /* end WPide restore code */ ?><?php
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
                        <li class="search_top">
                            <?php get_search_form(); ?>
                        </li>
                        <li class="has-button">
                            <a class="small button search-button" href="#">&#128269;</a>
                        </li>
                    </ul>
                    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'right top-bar-two' ) ); ?>
                </section>
            </nav>
        </div>
    </div>
