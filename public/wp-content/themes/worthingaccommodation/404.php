<?php

get_header();


$content = '';
$block = acf_get_block_type('acf/internal-hero-panel');
$block['data']['page_heading'] = 'Page not found';
$block['data']['generic_block_settings'] = array('background_colour' => 'green', 'hide_panel' => false);
echo acf_rendered_block($block, $content, false);
?>

<section class="panel content content__simple-text-panel inset mpu bgc-floral-white ir-default">
    <div class="container container--narrow">
        <div class="wysiwyg-container">
            <h2 class="animate fade-up">Oops! That page can’t be found.</h2>
            <P>It looks like nothing was found at this location. Please use the menu to find the page you are looking for.</p>
        </div>
    </div>
</section>


<?php

get_footer();

?>