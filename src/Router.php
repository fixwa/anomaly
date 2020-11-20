<?php

namespace Fixwa\Anomaly;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Router
{
    public function __construct()
    {
        $moduleConfigs = Config::$MODULES;
        foreach ($moduleConfigs as $moduleName => $configs) {
            foreach ($configs['routes'] as $routeName => $routeConfig) {

                //$route = new Route('/blog/{slug}', ['_controller' => IndexController::class]);
                $route = new Route($routeConfig[0],
                    [
                        '_controller' => $routeConfig[1][0],
                        '_method' => $routeConfig[1][1],
                    ]
                );
                $routes = new RouteCollection();
                $routes->add($moduleName . '.' . $routeName, $route);
                //$routes->add('blog_show', $route);
            }
        }

        $request = Request::createFromGlobals();
        $context = new RequestContext();
// Routing can match routes with incoming requests
        $matcher = new UrlMatcher($routes, $context);
        $parameters = $matcher->matchRequest($request);


        $controller = new $parameters['_controller'];

        return $configs->{$parameters['_method']};
        var_dump($parameters);
        die;
// $parameters = [
//     '_controller' => 'App\Controller\BlogController',
//     'slug' => 'lorem-ipsum',
//     '_route' => 'blog_show'
// ]
    }
}