<?php
[
    'title' => $title,
    'accordion' => $accordion
] = $content;

$accordion_items_html = '';
foreach ($accordion as $accordion_item) {
    $accordion_items_html .= "
        <details>
            <summary class=\"accordion__title\">
                {$accordion_item['title']}
            </summary>
            <div class=\"accordion__content post-content content\">
                {$accordion_item['content']}
            </div>
        </details>
    ";
}
?>
<div class="flexible-content__accordion">
    <?= $title !== '' ? "<h5>{$title}</h5>" : '' ?>
    <div class="accordion">
        <?= $accordion_items_html ?>
    </div>
</div>