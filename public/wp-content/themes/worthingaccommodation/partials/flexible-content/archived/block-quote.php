<?php
[
    'quotation' => $quote,
    'citation' => $cite
] = $content;
?>
<div class="flexible-content__block-quote post-content">
    <blockquote class="block-quote">
        <?= $quote ?>
        <cite><?= $cite ?></cite>
    </blockquote>
</div>