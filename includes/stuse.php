<?php
require_once(dirname(__DIR__ , 1) . '\config.php');
class stuse 
{
    public static function view($view){
        $viewLoc =  APP_URL . '/resources/views/' . $view . '.php';
        $viewLocLocal =  APP_URL_LOCAL . '/resources/views/' . $view . '.php';
        if(file_exists($viewLocLocal)){
            require_once($viewLocLocal);
        }else{
            echo 'View not found!' . '<br>';
            echo($viewLoc);
        }
    }
    public static function template($template){
        $templateLoc =  APP_URL . '/resources/views/templates/' . $template . '.php';
        $templateLocLocal =  APP_URL_LOCAL . '/resources/views/templates/' . $template . '.php';
        if(file_exists($templateLocLocal)){
            require_once($templateLocLocal);
        }else{
            echo 'Template not found!' . '<br>';
            echo($templateLoc);
        }
    }
    public static function css($css){
        $cssLoc =  APP_URL . '/resources/css/' . $css . '.css';
        $cssLocLocal =  APP_URL_LOCAL . '/resources/css/' . $css . '.css';
        if(file_exists($cssLocLocal)){
            echo($cssLoc);
        }else{
            echo 'CSS not found!' . '<br>';
            echo($cssLoc);
        }
    }
    public static function js($js){
        $jsLoc =  APP_URL . '/resources/js/' . $js . '.js';
        $jsLocLocal =  APP_URL_LOCAL . '/resources/js/' . $js . '.js';
        if(file_exists($jsLocLocal)){
            return($jsLoc);
        }else{
            echo 'JS not found!' . '<br>';
            return($jsLoc);
        }
    }
    public static function imgSVG($imgSVG){
        $imgSVGLoc =  APP_URL . '/resources/img/' . $imgSVG . '.svg';
        $imgSVGLocLocal =  APP_URL_LOCAL . '/resources/img/' . $imgSVG . '.svg';
        if(file_exists($imgSVGLocLocal)){
            return($imgSVGLoc);
        }else{
            echo 'JS not found!' . '<br>';
            return($imgSVGLoc);
        }
    }
}
