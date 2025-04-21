<?php
['image' => $image_id] = $content;
?>
<div class="flexible-content__image">
    <div class="flexible-content__image__container">
        <?= \Theme\Utils::get_image_html($image_id) ?>
    </div>
</div>