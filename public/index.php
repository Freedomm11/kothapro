<?php
if( !session_id() ) @session_start();
require '../vendor/autoload.php';

use Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use League\Plates\Engine;

$ContainerBuilder = new DI\ContainerBuilder;

$ContainerBuilder->addDefinitions([
    Engine::class => function() {
        return new Engine('../app/views');
    },

    PDO::class => function() {

        $driver = "mysql";
        $host = "localhost";
        $database_name = "blog";
        $username = "root";
        $password = "";

        return new PDO("$driver:host=$host;dbname=$database_name", $username, $password);
    },

    Auth::class => function($container) {
        return new Auth($container->get('PDO'));
    },

    QueryFactory::class => function() {
        return new QueryFactory('mysql');
    },
]);

$container = $ContainerBuilder->build();
$auth = new \Delight\Auth\Auth($container->get('PDO'));

if ($auth->hasRole(\Delight\Auth\Role::SUPER_ADMIN)):

    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
    {
        //AdminPanel
        $r->addRoute('GET', '/admin', ['App\controllers\AdminController', 'admin']);

        //AdminPosts
        $r->addRoute('GET', '/admin/posts', ['App\controllers\AdminController', 'adminPosts']);
        $r->addRoute(['GET', 'POST'], '/admin/post/create', ['App\controllers\AdminController', 'adminPostCreate']);
        $r->addRoute(['GET', 'POST'], '/admin/posts/edit/{id:\d+}', ['App\controllers\AdminController', 'adminPostEdit']);
        $r->addRoute('GET', '/admin/posts/delete/{id:\d+}', ['App\controllers\AdminController', 'adminDeletePost']);

        //AdminCategories
        $r->addRoute('GET', '/admin/categories', ['App\controllers\AdminController', 'adminCategories']);
        $r->addRoute(['GET', 'POST'], '/admin/categories/create', ['App\controllers\AdminController', 'adminCategoryCreate']);
        $r->addRoute(['GET', 'POST'], '/admin/categories/edit/{id:\d+}', ['App\controllers\AdminController', 'adminCategoryEdit']);
        $r->addRoute('GET', '/admin/categories/delete/{id:\d+}', ['App\controllers\AdminController', 'adminDeleteCategory']);

        //AdminUsers
        $r->addRoute('GET', '/admin/users', ['App\controllers\AdminController', 'adminUsers']);
        $r->addRoute(['GET', 'POST'], '/admin/users/create', ['App\controllers\AdminController', 'adminUserCreate']);
        $r->addRoute(['GET', 'POST'], '/admin/users/edit/{id:\d+}', ['App\controllers\AdminController', 'adminUserEdit']);
        $r->addRoute('GET', '/admin/users/delete/{id:\d+}', ['App\controllers\AdminController', 'adminDeleteUser']);

        //HomePage
        $r->addRoute('GET', '/[?page={title:\d+}]', ['App\controllers\HomeController', 'homepage']);
        $r->addRoute(['GET', 'POST'], '/post/[?id={id:\d+}{&reply=reply:\d+}]', ['App\controllers\HomeController', 'showPost']);
        $r->addRoute('GET', '/category/{id:\w+}[?page={title:\d+}]', ['App\controllers\HomeController', 'category']);
        $r->addRoute(['GET', 'POST'], '/subscription', ['App\controllers\HomeController', 'subscription']);

        $r->addRoute(['GET', 'POST'], '/registration', ['App\controllers\AuthController', 'registration']);
        $r->addRoute('GET', '/verification', ['App\controllers\AuthController', 'verification']);
        $r->addRoute(['GET', 'POST'], '/login', ['App\controllers\AuthController', 'login']);
        $r->addRoute('GET', '/logout', ['App\controllers\AuthController', 'logout']);
    }); else:

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
        {
            //HomePage
            $r->addRoute('GET', '/[?page={title:\d+}]', ['App\controllers\HomeController', 'homepage']);
            $r->addRoute(['GET', 'POST'], '/post/[?id={id:\d+}{&reply=reply:\d+}]', ['App\controllers\HomeController', 'showPost']);
            $r->addRoute('GET', '/category/{id:\w+}[?page={title:\d+}]', ['App\controllers\HomeController', 'category']);
            $r->addRoute(['GET', 'POST'], '/subscription', ['App\controllers\HomeController', 'subscription']);

            $r->addRoute(['GET', 'POST'], '/registration', ['App\controllers\AuthController', 'registration']);
            $r->addRoute('GET', '/verification', ['App\controllers\AuthController', 'verification']);
            $r->addRoute(['GET', 'POST'], '/login', ['App\controllers\AuthController', 'login']);
            $r->addRoute('GET', '/logout', ['App\controllers\AuthController', 'logout']);
        }); endif;



// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);



switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        include '../app/views/404.php';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        include '../app/views/404.php';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $cont = $container->call($handler,[$vars]);
        break;
}


