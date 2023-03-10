<?php
use App\Core\View\View;
use App\Core\Support\Session;
use App\Core\Support\QueryBuilder;

if(!function_exists('env'))
{
     function env($key)
     {
          return $_ENV[$key] ?? $_ENV[$key];
     }
}


if(!function_exists('view'))
{
     function view($view_name, $data = null)
     {
          $view = View::make($view_name);

          if($data != null){
               extract($data);
          }
          
          require $view;
     }
}


if(!function_exists('view_path'))
{
     function view_path()
     {
          return dirname(dirname(dirname(__DIR__))) . '/resources/views/';
     }
}

if(!function_exists('base_path'))
{
     function base_path()
     {
          return dirname(dirname(dirname(__DIR__)));
     }
}

if(!function_exists('main_url'))
{
     function main_url()
     {
          return env('APP_URL') . "/" . env('MAIN_URL');
     }
}

if(!function_exists('admin_url'))
{
     function admin_url()
     {
          return env('APP_URL') . "/" . env('MAIN_URL') . "/admin";
     }
}

if(!function_exists('session'))
{
     function session()
     {
          static $instance = null;

          if (!$instance) {
               $instance = new Session();
          }

          return $instance;
     }
}

if(!function_exists('back'))
{
     function back()
     {
          header('Location:' . $_SERVER['HTTP_REFERER']);
          exit;
     }
}

if(!function_exists('to'))
{
     function to($to)
     {
          header('Location:' . main_url() . '/' . $to);
          exit;
     }
}

if (!function_exists('old')) {
     function old($key)
     {
          if (session()->hasFlash($key)) {
               return session()->getFlash($key);
          }
     }
}

if (!function_exists('if_authenticated')) {
     function if_authenticated()
     {
          if (session()->has('loggedin') && session()->get('loggedin') === TRUE && session()->has('id')) {
               return to('admin');
               
          }
     }
}

if (!function_exists('if_not_authenticated')) {
     function if_not_authenticated()
     {
          if (!session()->has('loggedin') && session()->get('loggedin') !== TRUE) {
               return to('login');
          }
     }
}

if (!function_exists('auth')) {
     function auth()
     {
          if (session()->has('loggedin') && session()->get('loggedin') === TRUE && session()->has('id')) {
               $user = QueryBuilder::get('users', 'id', '=', session()->get('id'));
               $auth = [
                    'id' => session()->get('id'),
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'last_login' => $user->last_login,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
               ];

               return (object)$auth;
          }
          return null;
     }
     
}




if (!function_exists('getTitle')) {
     function getTitle()
     {
          global $pageTitle;
          if(isset($pageTitle)){
               return $pageTitle;
          }else{
               return env('APP_NAME');
          }
     }
}



