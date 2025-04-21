<?php
[
    'items' => $items
] = $content;

$list_html = '';
foreach ($items as $item) {
    $list_html .= "<li>{$item['item']}</li>";
}
?>
<div class="flexible-content__list">
    <ul class="list post-content">
        <?= $list_html ?>
    </ul>
</div>