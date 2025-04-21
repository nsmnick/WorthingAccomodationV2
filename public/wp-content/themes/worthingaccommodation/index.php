<?php
get_header();

echo 'HERE3';

while (have_posts()) {
    the_post();
}

get_footer();
