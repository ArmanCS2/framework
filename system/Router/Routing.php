<?php

namespace System\Router;

use ReflectionMethod;
use System\Config\Config;

class Routing
{
    private $current_route;
    private $method_field;
    private $routes;
    private $values = [];

    public function __construct()
    {
        $this->current_route =array_filter(explode('/',Config::get('app.CURRENT_ROUTE')));
        $this->method_field = $this->methodField();
        global $routes;
        $this->routes = $routes;
    }

    public function methodField()
    {
        $method_field = strtolower($_SERVER['REQUEST_METHOD']);

        if ($method_field == 'post') {
            if (isset($_POST['_method'])) {
                $method_field = $_POST['_method'];
            }
        }
        return $method_field;
    }
    public function registerUris(){
        require_once BASE_PATH . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'uris.php';
    }
    public function run()
    {
        $match = $this->match();
        if(empty($match)){
            $this->registerUris();
            $this->error404();
        }

        $className = str_replace('\\', DIRECTORY_SEPARATOR, $match['class']);
        $classPath = Config::get('app.BASE_DIR') . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' .
            DIRECTORY_SEPARATOR . $className . '.php';
        if(!file_exists($classPath)){
            echo "class not exists";
            exit();
        }

        $class = "\App\Http\Controllers\\" . $match['class'];
        $object = new $class();
        $method=$match['method'];

        if(method_exists($object,$method)) {

            $reflection = new ReflectionMethod($class,$method);
            $parametersNum = $reflection->getNumberOfParameters();
            if ($parametersNum <= sizeof($this->values)) {
                call_user_func_array(array($object, $method), $this->values);
            } else {
                echo "size error";
                exit();
            }

        }else{
            echo "method doesn't exist in this class";
            exit();
        }
    }

    public function match()
    {
        $reservedUrls = $this->routes[$this->method_field];
        foreach ($reservedUrls as $reservedUrl) {
            if ($this->compare($reservedUrl['url'])) {
                return ['class' => $reservedUrl['class'], 'method' => $reservedUrl['method']];
            } else {
                $this->values = [];
            }
        }
        return [];
    }

    public function compare($reservedUrl)
    {
        $reservedUrl= trim($reservedUrl, '/ ');
        $reservedUrl = explode('/', $reservedUrl);
        $reservedUrl = array_filter($reservedUrl);
        if (sizeof($reservedUrl) != sizeof($this->current_route)) {
            return false;
        }

        for ($i = 0; $i < sizeof($this->current_route); $i++) {

            if ($reservedUrl[$i][0] == "{" && $reservedUrl[$i][strlen($reservedUrl[$i]) - 1] == "}") {
                array_push($this->values, $this->current_route[$i]);
            } else if ($reservedUrl[$i] != $this->current_route[$i]) {
                return false;
            }
        }

        return true;
    }

    public function error404()
    {

        http_response_code(404);
        include __DIR__ . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . "404.php";
        exit();

    }
}
