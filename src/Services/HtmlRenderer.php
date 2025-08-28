<?php

class HtmlRenderer
{
    function render(string $view, array $data = []): string
    {
        ob_start();
        extract($data);

        unset ($data);
        require(__DIR__ . '/../../View/' . $view);
        $html = ob_get_clean();
        return $html;
    }
}
