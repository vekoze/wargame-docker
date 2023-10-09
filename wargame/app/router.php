<?php

class Router
{

    private static $routes = array();

    static public function connect($route, $view)
    {
        self::$routes[$route] = VIEW . $view;
    }

    static public function parse($uri)
    {
        // Check if route exists
        if (isset(self::$routes[$uri]))
        {
            return self::$routes[$uri];
        }

        // Check for pattern match (e.g. /user/:id or /destination/:id)
        foreach (self::$routes as $route => $view)
        {
            $pattern = "@^" . preg_replace("/:[a-zA-Z0-9\_\-=]+/", "([a-zA-Z0-9\-\_=]+)", $route) . "$@D";
            if (preg_match($pattern, $uri, $matches))
            {
                // Remove first match (= the URI, e.g. /user/1234)
                array_shift($matches);

                // For each parameter, add it to $_GET (e.g. $_GET["id"] = 1234)
                foreach ($matches as $idx => $param) 
                {
                    $_GET[$idx] = $param;
                }
                return $view;
            }
        }

        // If no route or pattern match, redirect to home by resetting URI
        header("Location: /");
        exit();
    }

};

?>