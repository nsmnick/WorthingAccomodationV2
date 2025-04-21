<?php

namespace Theme;

class Partials
{
    /**
     * Path to templates (relative to theme directory).
     *
     * @var string
     */
    public string $templates_path = '/partials/';

    /**
     * Return rendered partial template.
     *
     * @param string $template_name
     * @param array<mixed> $content
     * @return string
     */
    public function render(string $template_name = '', array $content = []): string
    {
        return $this->renderTemplate($template_name, $content);
    }

    /**
     * Find and render template.
     *
     * @param string $template_name
     * @param array<mixed> $content
     * @return string
     */
    public function renderTemplate(string $template_name, array $content): string
    {
        if ($template_name === '') {
            throw new \Exception("Partial template name is blank.");
        }

        $template_path = get_template_directory()
            . $this->templates_path
            . $template_name
            . '.php';

        if (file_exists($template_path)) {
            ob_start();
            include $template_path;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }

        return '';
    }
}
