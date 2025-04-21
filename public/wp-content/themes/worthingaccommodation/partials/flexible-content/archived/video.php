<?php
[
    'title' => $title,
    'youtube_url' => $oembed
] = $content;
?>
<div class="flexible-content__video">
    <div class="post-video">
        <?= $oembed ?>
    </div>
</div>