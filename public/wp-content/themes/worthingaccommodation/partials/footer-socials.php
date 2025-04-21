<div class="footer-socials">
    <h3 class="footer-heading">Stay connected</h3>

    <ul class="footer-socials__menu">

        <?php
        $social_links = get_field("social_media", "options");
        $social_links_html = '';
        foreach ($social_links as $link) {
            $social_links_html .=
                '<li class="footer-socials__menu__link">'
                . '<a'
                . ' href="' . $link['link'] . '"'
                . ' target="_blank"'
                . ' class="footer-socials__menu__link'
                . ($link['css'] !== '' ? ' footer-socials__menu__link--' . $link['css'] : '')
                . '">'
                . '</a>'
                . '</li>';
        }


        echo $social_links_html;
        ?>
    </ul>
</div>