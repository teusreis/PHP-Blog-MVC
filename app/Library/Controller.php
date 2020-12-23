<?php

namespace App\Library;

class Controller
{
    protected string $layout = "main";

    public function __construct()
    {
    }

    protected function render(string $view, array $params = [])
    {
        if (isset($this->layout) && $this->layout !== "") {
            $layout = $this->renderLayout($params);
            $viewContent = $this->renderOnlyView($view, $params);
            echo str_replace("{{content}}", $viewContent, $layout);
        } else {
            $view = $this->renderOnlyView($view);
            echo $view;
        }
        //require __DIR__ . "./../view/" . $view;
    }

    protected function redirect(): void
    {
        // redirect user!
    }

    private function renderOnlyView(string $view, array $params = [])
    {
        extract($params);
        ob_start();
        include __DIR__ . "./../View/" . $view;
        return ob_get_clean();
    }

    private function renderLayout(array $params = [])
    {
        extract($params);
        ob_start();
        include __DIR__ . "./../View/layout/main.php";
        return ob_get_clean();
    }
}
