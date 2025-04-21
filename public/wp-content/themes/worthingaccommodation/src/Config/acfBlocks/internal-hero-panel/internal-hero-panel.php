<?php
include __DIR__ . '/../_block-generics.php';

if (!$is_preview && !$generic_block_settings['hide_panel']) {

    $page_heading = get_field('page_heading');
    $strapline = get_field('strapline');

    $page_heading_margin_class = '';
    if ($strapline) {
        $page_heading_margin_class = ' small-margin ';
    }


    $back_link = get_field('back_link');

    if ($back_link) {
        $button_text = $back_link['link_text'];
        $link_url = $back_link['link_url'];
        $link_page = $back_link['link_page'];
        $link = \Theme\Utils::get_link_url($link_url, $link_page);
    }




?>

    <section class="content content__internal-hero-panel <?php echo $generic_block_settings_classes; ?>">

        <div class="container">



            <?php if ($back_link && $link) {
                echo '<div class="back-link">';
                echo '<div class="back-link__col1"><div class="circle-button circle-button--arrow-left circle-button--small"></div></div>';
                echo '<div class="back-link__col2"><a href="' . $link . '">' . $button_text . '</a></div>';
                echo '</div>';
            }
            ?>


            <div class="content-container animate fade-in">

                <h1 class="<?php echo $page_heading_margin_class; ?>"><?php echo $page_heading; ?></h1>
                <?php if (!empty($strapline)) { ?>
                    <p class="page-hero-introduction"><?php echo $strapline; ?></p>
                <?php } ?>

            </div>

        </div>

    </section>



<?php } ?>