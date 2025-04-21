<?php

$footer_copyright_message = str_replace('{{date}}', date("Y"), get_field('copyright_message', 'options'));
$agents = get_field('agents', 'options');
$certificates = get_field('certificates', 'options');

?>

<footer>
    <div class="footer-logos">
        <div class="container">

            <div class="logos-container">

                <?php
                foreach ($agents as $agent) {
                    echo '<div class="logos-container__col">';
                    echo '<img src="' . $agent['logo'] . '"/>';
                    echo '</div>';
                }
                ?>

            </div>

        </div>


    </div>

    <div class="footer-main">
        <div class="container">
            <div class="content-container">
                <div class="content-container__col1">
                    <div class="footer-logo"></div>
                    <a class="phone-number" href="tel:<?php echo get_field('phone_number', 'options'); ?>"><?php echo get_field('phone_number_display', 'options'); ?></a>
                    <a class="email-address" href="mailto:<?php echo get_field('email_address', 'options'); ?>"><?php echo get_field('email_address', 'options'); ?></a>
                </div>
                <div class="content-container__col2">

                    <div class="logos-container">
                        <?php
                        foreach ($certificates as $certificate) {
                            echo '<div class="logos-container__col">';
                            echo '<img src="' . $certificate['logo'] . '"/>';
                            echo '</div>';
                        }
                        ?>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">

            <div class="content-container">
                <div class="content-container__col1">
                    <p><?php echo $footer_copyright_message; ?>
                </div>
                <div class="content-container__col2">
                    <a class="footer-menu" href="/privacy-notice/">Privacy notice</a>
                </div>
            </div>

        </div>
    </div>


</footer>

<?php

echo get_field('footer_scripts', 'options');

echo (new Theme\Partials())->render('cookie-accept');

wp_footer();
?>

</body>

</html>