<?php
[
    'buttons_alignment' => $buttons_alignment,
    'buttons' => $buttons,
] = $content;

if ($buttons) {
    $buttons_html = '';
    foreach ($buttons as $button) {
        $link = $button['link'] ? $button['link'] : $button['page'];
        $button_classes = [
            'button'
        ];
        $target = '';

        if ($button['colour']) {
            $button_classes[] = "button--{$button['colour']}";
        }

        if ($button['open_in_new_tab']) {
            $target = ' target="_blank"';
            $button_classes[] = 'button--external';
        }

        $button_class_names = implode(' ', $button_classes);

        $buttons_html .= <<<BUTTON
            <a class="{$button_class_names}" href="{$link}"{$target}>{$button['button_text']}</a>
        BUTTON;
    }

    $buttons_classes = [
        'buttons'
    ];

    if (!$buttons_alignment) {
        $buttons_classes[] = 'buttons--left';
    } else {
        $buttons_classes[] = "buttons--{$buttons_alignment}";
    }

    $buttons_class_names = implode(' ', $buttons_classes);

    echo <<<BUTTONS
        <div class="flexible-content__buttons">
            <div class="{$buttons_class_names}">
                {$buttons_html}
            </div>
        </div>
    BUTTONS;
}
