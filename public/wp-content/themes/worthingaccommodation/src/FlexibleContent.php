<?php

namespace Theme;

class FlexibleContent extends Partials
{
    /**
     * Path to flexible content templates (relative to theme directory).
     *
     * @var string
     */
    public string $templates_path = '/partials/flexible-content/';

    /**
     * Render flexible content fields for current post.
     *
     * @return string
     */
    public function render(string $template_name = '', array $content = []): string
    {
        $content_blocks = get_field('content_blocks');
        $content = '';

        if (is_array($content_blocks)) {
            foreach ($content_blocks as $content_fields) {
                $template_name = $content_fields['acf_fc_layout'];
                unset($content_fields['acf_fc_layout']);
                $content .= $this->renderTemplate(
                    $template_name,
                    $content_fields
                );
            }
        }

        return $content;
    }
}
