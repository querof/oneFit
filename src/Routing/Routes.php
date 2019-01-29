<?php

namespace src\Routing;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

use src\Controller\PlanController;
use src\Controller\ExcercisesController;
use src\Controller\UserPlanController;
use src\Controller\WorkoutDaysController;
use src\Controller\WorkoutDaysExcercisesController;
use src\Controller\UserController;
use src\Controller\AuthController;
use src\lib\Auth;

/*
 * Class thats create and return routes of the app.
 */

class Routes
{
    private $routes;

    private $secure = [];


    public function __construct()
    {
        $this->setRoutes();
        $this->setSecure();
    }

    /**
     * Method thats return the routes of app.
     *
     * @return Symfony\Component\Routing\RouteCollection
     */

    public function getRoutes()
    {
        return $this->routes;
    }


    /**
     * Method thats create the routes of app.
     *
     */

    public function isSecure($route)
    {
        return in_array($route, $this->secure['secure'])?true:false;
    }


    /**
     * Method thats Call the routes of app.
     *
     */

    public function callRoute(Request $request)
    {
        $routeParameters = $this->getRouteParameters($request);

        if ($this->isSecure($request->attributes->get('_route')) === false) {
            return call_user_func_array($routeParameters['controller'], $routeParameters['arguments']);
        }
        if (Auth::Check($request->get('token'))) {
            return call_user_func_array($routeParameters['controller'], $routeParameters['arguments']);
        }

        return new JsonResponse(array('message' => 'Invalid user logged in.'));
    }


    /**
     * Method thats Return the controller and arguments of a route.
     *
     */

    public function getRouteParameters(Request $request)
    {
        $routes = $this->getRoutes();

        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new Routing\Matcher\UrlMatcher($routes, $context);

        $controllerResolver = new HttpKernel\Controller\ControllerResolver();
        $argumentResolver = new HttpKernel\Controller\ArgumentResolver();

        $request->attributes->add($matcher->match($request->getPathInfo()));

        $controller = $controllerResolver->getController($request);
        $arguments = $argumentResolver->getArguments($request, $controller);

        return array('controller' => $controller, 'arguments' => $arguments);
    }

    /**
     * Method thats create the routes of app.
     *
     */

    private function setRoutes()
    {
        $this->routes = new RouteCollection();
        $fileLocator = new FileLocator(array(__DIR__));
        $loader = new YamlFileLoader($fileLocator);
        $routes = $loader->load(__DIR__.'/../../conf/routes.yml');

        foreach ($routes as $route => $value) {
            $controllerStr =  'src\Controller\\'.explode('::', $value->getDefaults()['_controller'])[0];
            $controller = new $controllerStr;

            $this->routes->add($route, new Route(
          $value->getPath(),
          array('_controller' => array($controller, explode('::', $value->getDefaults()['_controller'])[1])),
          $value->getRequirements(),
          array(),
          '',
          array(),
          $value->getMethods()
        ));
        }
    }


    /**
     * Method thats asign security to routes of app.
     *
     */

    private function setSecure()
    {
        $this->secure = json_decode(file_get_contents(__DIR__.'/../../conf/secure.json'), true);
    }
}
