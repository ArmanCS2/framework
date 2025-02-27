<?php

function dd($vars, $die = true)
{
    echo "<pre>";
    var_dump($vars);
    echo "</pre>";
    if ($die) {
        exit();
    }


}



function protocol()
{
    $protocol= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on') ? 'https://' : 'http://';
    return $protocol;
}

function currentDomain()
{

    return protocol() . $_SERVER['HTTP_HOST'];
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function uri($reservedUrl, $class, $method, $request_method = 'GET')
{

    //user current url array
    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(\System\Config\Config::get('app.BASE_URL'), '', $currentUrl);
    $currentUrl = trim($currentUrl, '/ ');
    $currentUrl = explode('/', $currentUrl);
    $currentUrl = array_filter($currentUrl);

    //reserved url array
    $reservedUrl = trim($reservedUrl, '/ ');
    $reservedUrl = explode('/', $reservedUrl);
    $reservedUrl = array_filter($reservedUrl);
    if (count($currentUrl) != count($reservedUrl) || $request_method != methodField()) {
        return false;
    }

    $parameters = [];
    for ($key = 0; $key < count($currentUrl); $key++) {
        if ($reservedUrl[$key][0] == "{" && $reservedUrl[$key][strlen($reservedUrl[$key]) - 1] == "}") {
            array_push($parameters, $currentUrl[$key]);
        } elseif ($reservedUrl[$key] != $currentUrl[$key]) {
            return false;
        }
    }

    if ($request_method == "POST") {
        $request = isset($_FILES) ? array_merge($_FILES, $_POST) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;

    call_user_func_array(array($object, $method), $parameters);
    exit;
}

function view($dir, $vars = [])
{
    $viewBuilder = new \System\View\ViewBuilder();
    $viewBuilder->run($dir);
    $viewVars = $viewBuilder->vars;
    $content = $viewBuilder->content;

    if (!empty($viewVars)) {
        extract($viewVars);
    }
    if (!empty($vars)) {
        extract($vars);
    }
    //dd(html_entity_decode($content));
    eval(" ?> " . html_entity_decode($content));

}

function viewPage($dir,$vars=null){
    $dir=str_replace('.',DIRECTORY_SEPARATOR,$dir);
    if($vars){
        extract($vars);
    }
    return require_once BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $dir . '.php' ;
}

function includePage($dir,$vars=null){
    $dir=str_replace('.','/',$dir);
    if($vars){
        extract($vars);
    }
    return require_once BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $dir . '.php' ;
}

function viewPath($filePath){
    $filePath = str_replace('.',DIRECTORY_SEPARATOR,$filePath);
    return BASE_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $filePath . '.php';
}

function html($text)
{
    return html_entity_decode($text);
}


function old($name)
{
    if (isset($_SESSION['temporary_old'][$name])) {
        return $_SESSION['temporary_old'][$name];
    }
    return null;
}

function oldOrValue($name,$value){
    return empty(old($name)) ? $value : old($name);
}

function flash($name, $message = '')
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_flash'][$name])) {
            $msg = $_SESSION['temporary_flash'][$name];
            unset($_SESSION['temporary_flash'][$name]);
            return $msg;
        } else {
            return false;
        }
    } else {
        $_SESSION['flash'][$name] = $message;
    }
}

function flashExists($name = null)
{
    if ($name === null) {
        return isset($_SESSION['temporary_flash']) ? count($_SESSION['temporary_flash']) : false;
    } else {
        return isset($_SESSION['temporary_flash'][$name]) ? true : false;
    }
}

function allFlashes()
{
    if (isset($_SESSION['temporary_flash'])) {
        $temp = $_SESSION['temporary_flash'];
        unset($_SESSION['temporary_flash']);
        return $temp;
    } else {
        return false;
    }
}

function flashText($name){
    if(flashExists($name)){
        return "<div><small class='text-success'>". flash($name) . "</small></div>" ;
    }
    return '';
}

function error($name, $message = '')
{
    if (empty($message)) {
        if (isset($_SESSION['temporary_errorFlash'][$name])) {
            $msg = $_SESSION['temporary_errorFlash'][$name];
            unset($_SESSION['temporary_errorFlash'][$name]);
            return $msg;
        } else {
            return false;
        }
    } else {
        $_SESSION['errorFlash'][$name] = $message;
    }
}

function errorExists($name = null)
{
    if ($name === null) {
        return isset($_SESSION['temporary_errorFlash']) ? count($_SESSION['temporary_errorFlash']) : false;
    } else {
        return isset($_SESSION['temporary_errorFlash'][$name]) ? true : false;
    }
}

function allErrors()
{
    if (isset($_SESSION['temporary_errorFlash'])) {
        $temp = $_SESSION['temporary_errorFlash'];
        //unset($_SESSION['temporary_errorFlash']);
        return $temp;
    } else {
        return false;
    }
}

function errorClass($name){
    return errorExists($name) ? 'is-invalid' : '';
}

function errorText($name){
    if(errorExists($name)){
        return "<div><small class='text-danger'>". error($name) . "</small></div>" ;
    }
    return '';
}

function displayErrors($displayError)
{
    if ($displayError) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}


function redirect($url)
{
    header("Location: " . trim(\System\Config\Config::get('app.BASE_URL'), '/ ') . '/' . trim($url, '/ '));
    exit();
}




function back()
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

function asset($src)
{
    return \System\Config\Config::get('app.BASE_URL') . '/' . trim($src, '/ ');
}

function url($url)
{
    return \System\Config\Config::get('app.BASE_URL') . '/' . trim($url, '/ ');
}

function findRouteByName($name)
{
    global $routes;
    $allRoutes = array_merge($routes['get'], $routes['post'], $routes['put'], $routes['delete']);
    $foundRoute = null;
    foreach ($allRoutes as $route) {
        if ($route['name'] == $name) {
            $foundRoute = $route['url'];
            break;
        }
    }
    return $foundRoute;
}


function route($name, $params = [])
{
    if (!is_array($params)) {
        throw new Exception('params must be array');
    }

    $route = findRouteByName($name);
    $params = array_reverse($params);

    $routeParamsMatch = [];

    if ($route==null){
        $route='';
    }

    preg_match_all("/{[^}.]*}/", $route, $routeParamsMatch);

    if (count($routeParamsMatch[0]) > count($params)) {
        throw new Exception('more params needed');
    }

    foreach ($routeParamsMatch[0] as $routeMatch) {
        $route = str_replace($routeMatch, array_pop($params), $route);
    }

    return \System\Config\Config::get('app.BASE_URL') . "/" . trim($route, '/ ');
}

function redirectToRoute($name)
{
    header("Location: " . route($name));
    exit();
}


function methodField()
{
    $method_field = strtolower($_SERVER['REQUEST_METHOD']);

    if ($method_field == 'post') {
        if (isset($_POST['_method'])) {
            $method_field = $_POST['_method'];
        }
    }
    return $method_field;
}


function array_dot($array, $return_array = array(), $return_key = '')
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $return_array = array_merge($return_array, array_dot($value, $return_array, $return_key . $key . "."));
        } else {
            $return_array[$return_key . $key] = $value;
        }
    }
    return $return_array;
}


function generateToken()
{
    return bin2hex(openssl_random_pseudo_bytes(32));
}

function path($name)
{
    return "images/$name/" . date('Y/M/d');
}

function filesPath($name)
{
    return "files/$name/" . date('Y/M/d');
}

function name()
{
    return date('Y_m_d_H_i_s_') . rand(10, 99);
}

function activationMessage($token)
{
    return '
    <h2>فعال سازی حساب کاربری</h2>
    <p>کاربر گرامی لطفا برای فعال سازی حساب کاربری خود بر روی لینک زیر کلیک کنید</p>
    <p style="text-align: center"><a href="' . route('auth.activation.token', [$token]) . '">فعال سازی</a></p>
    ';
}

function forgotMessage($token)
{
    return '
    <h2>فراموشی رمز عبور</h2>
    <p>کاربر گرامی لطفا برای ارسال لینک تغییر رمز عبور  بر روی لینک زیر کلیک کنید</p>
    <p style="text-align: center"><a href="' . route('auth.reset.password.view', [$token]) . '">تغییر رمز</a></p>
    ';
}

function expire($time)
{
    return date('Y-m-d H:i:s', strtotime("+ $time"));
}

function hash_password($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function jalaliDate($date)
{
    //return \Morilog\Jalali\Jalalian::forge($date)->format('%B %d، %Y');
    //return Lib\Parsidev\Jalali\jDate::forge($date)->format('datetime');
    return Lib\Parsidev\Jalali\jDate::forge($date)->format('%B , %d , %Y');

}

function active($route, $contain = true)
{
    $route = str_replace(currentDomain(), "", $route);
    $route = trim($route, '/ ');

    $currentUrl = str_replace(currentDomain(), "", currentUrl());
    $currentUrl = trim($currentUrl, '/ ');
    if ($contain) {
        if (strpos($currentUrl, $route) === 0) {
            return 'active';
        }
        return '';
    }
    if ($route == $currentUrl) {
        return 'active';
    }

    return '';
}

function paginate($data, $perPage)
{
    $totalRows = count($data);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $totalPages = ceil($totalRows / $perPage);
    $currentPage = min($currentPage, $totalPages);
    $currentPage = max($currentPage, 1);
    $currentRow = ($currentPage - 1) * $perPage;
    $data = array_slice($data, $currentRow, $perPage);
    return $data;
}

function paginateUrl($page)
{
    $urlArray = explode('?', currentUrl());
    if (!empty($urlArray[1])) {
        $_GET['page'] = $page;
        $getVariables = [];
        foreach ($_GET as $key => $value) {
            array_push($getVariables, $key . '=' . $value);
        }
        return $urlArray[0] . '?' . implode('&', $getVariables);
    } else {
        return currentUrl() . '?page=' . $page;
    }
}

function paginateView($data, $perPage)
{
    $totalRows = count($data);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $totalPages = ceil($totalRows / $perPage);
    $currentPage = min($currentPage, $totalPages);
    $currentPage = max($currentPage, 1);


    $paginateView = '';
    $paginateView .= $currentPage != 1 ? '<li><a href="' . paginateUrl(1) . '">&lt;</a></li>' : '';
    $paginateView .= $currentPage - 2 >= 1 ? '<li><a href="' . paginateUrl($currentPage - 2) . '">' . ($currentPage - 2) . '</a></li>' : '';
    $paginateView .= $currentPage - 1 >= 1 ? '<li><a href="' . paginateUrl($currentPage - 1) . '">' . ($currentPage - 1) . '</a></li>' : '';
    $paginateView .= '<li class="active"><span>' . $currentPage . '</span></li>';
    $paginateView .= $currentPage + 1 <= $totalPages ? '<li><a href="' . paginateUrl($currentPage + 1) . '">' . ($currentPage + 1) . '</a></li>' : '';
    $paginateView .= $currentPage + 2 <= $totalPages ? '<li><a href="' . paginateUrl($currentPage + 2) . '">' . ($currentPage + 2) . '</a></li>' : '';
    $paginateView .= $currentPage != $totalPages ? '<li><a href="' . paginateUrl($totalPages) . '">&gt;</a></li>' : '';


    return '
    <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        <ul>
                            ' . $paginateView . '
                        </ul>
                    </div>
                </div>
            </div>
    ';
}

