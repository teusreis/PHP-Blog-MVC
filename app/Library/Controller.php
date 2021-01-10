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

    protected function redirect(string $route = "", array $flags = []): void
    {
        if(!empty($flags)){
            foreach($flags as $flag => $value){
                $_SESSION[$flag] = $value;
            }
        }
        if($route == "/") $route = "";
        header('Location: '. url($route) .'');
        die();
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
        include __DIR__ . "./../View/layout/" . $this->layout . ".php";
        return ob_get_clean();
    }

    protected function serialize(array $data): array
    {
        $body = [];
        foreach ($data as $key => $value) {
            $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        
        return $body;
    }
}
