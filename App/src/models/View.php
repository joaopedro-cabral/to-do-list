<?php

declare (strict_types=1);

namespace App\Models;

class View
{
    const HEADER_TEMPLATE = VIEWS_PATH . '/template/header.php';
    const FOOTER_TEMPLATE = VIEWS_PATH . '/template/footer.php';

    public function __construct(
        protected string $view, 
        protected array $params = []
    ){}

    public static function make(string $view, array $params = [])
    {
        return new static($view, $params);
    }

    public function render()
    {
        $viewPath = VIEWS_PATH . '/' . $this->view . '.php';

        if (!file_exists( $viewPath)) 
        {
            throw new \App\Models\Exception\ViewNotFoundException();
        }

        foreach($this->params as $key => $value) 
        {
            $$key = $value;
        }

        include self::HEADER_TEMPLATE;
        include $viewPath;
        include self::FOOTER_TEMPLATE;
    }
}

?>