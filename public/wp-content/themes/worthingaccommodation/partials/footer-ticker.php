<?php
$footer_ticker_items = get_field('footer_ticker', 'options');
$footer_ticker_html = '';

$link = '/contact/';

foreach ($footer_ticker_items as $key => $footer_ticker_item) {
    $footer_ticker_item_headline = $footer_ticker_item['headline'];

    $footer_ticker_html .= '<li class="ticker__item">';

    if ($key == count($footer_ticker_items) - 1) {
        $footer_ticker_html .= '<div class="heading-container"><a href="' . $link . '"><h2>' . esc_html($footer_ticker_item_headline) . '</h2></a><a href="' . $link . '" class="circle-button circle-button--responsive circle-button--arrow-right"></a></div>';
    } else {
        $footer_ticker_html .= '<div class="heading-container"><a href="' . $link . '"><h2>' . esc_html($footer_ticker_item_headline) . '</h2></a></div>';
    }

    $footer_ticker_html .= '</li>';
}
?>


<ul class="ticker__list"><?php echo $footer_ticker_html; ?></ul>

<script>
    var ticker = document.querySelector('.ticker'),
        list = document.querySelector('.ticker__list'),
        items = Array.from(list.children);

    for (let i = 0; i < 3; i++) {
        items.forEach(function(item) {
            var clone = item.cloneNode(true);
            list.appendChild(clone);
        });
    }
</script>