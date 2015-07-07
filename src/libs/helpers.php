<?php

function redirect($path = null)
{
    $action = new \System\Redirect();

    if (is_null($path))
        return $action;

    $action->redirect($path);
}




function dump($var)
{
    print('<pre>');
    json_encode(var_dump($var));

    die();
}

function assets($path)
{
    echo url(ASSETS_PATH."/".$path);
}

function url($string,$return = false){
    $home = API_HOME? API_HOME.'/':'';
    if ($return){
        return "http://$_SERVER[HTTP_HOST]/".$home."$string";
    }
    echo "http://$_SERVER[HTTP_HOST]/".$home."$string";
}

function to_array($delimiter,$string)
{
    return explode($delimiter,$string);
}



function view($view_name)
{
    $path = str_replace('.','/',$view_name);

    try {
        include "views/$path.php";
    } catch (Exception $e){
        dump($e->getMessage());
    }
}

function template_header(){
    try {
        require_once 'views/templates/header.php';
    }catch (Exception $e){
        dump($e->getMessage());
    }
}

function template_footer(){
    try {
        require_once 'views/templates/footer.php';
    }catch (Exception $e){
        dump($e->getMessage());
    }
}

function is_protected($val = false,$next = 'index.php')
{
    if ($val){
        if (!\System\Auth::check())
            redirect($next);
    }
}

function message($key = null)
{
    $msg = new \System\Message();
    if (is_null($key)){
        return $msg;
    }

    echo $msg->get($key);
}

function form()
{
    return new \System\Form();
}

