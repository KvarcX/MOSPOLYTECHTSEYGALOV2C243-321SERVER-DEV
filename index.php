<?php

// Автозагрузка классов из папки src по полному имени класса (с неймспейсами)
spl_autoload_register(function (string $className): void {
    // MyProject\Controllers\MainController -> src/MyProject/Controllers/MainController.php
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $className) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});

// Текущий "маршрут" (часть URL после домена), попадает из .htaccess в GET-параметр route
$route = $_GET['route'] ?? '';

// Если route пустой, попробуем взять из REQUEST_URI (для случаев когда .htaccess не сработал)
if (empty($route)) {
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    // Убираем /myproject/ из начала пути и убираем index.php если есть
    $route = preg_replace('~^/myproject/?(?:index\.php)?~', '', $requestUri);
    // Убираем query string если есть
    $route = preg_replace('~\?.*$~', '', $route);
}

// Подключаем конфигурацию маршрутов (паттерн => [Controller::class, 'method'])
$routes = require __DIR__ . '/src/routes.php';

$isRouteFound = false;

foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);

    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    echo 'Страница не найдена!';
    return;
}

// Нулевой элемент — полное совпадение, дальше идут аргументы для метода
unset($matches[0]);

[$controllerName, $actionName] = $controllerAndAction;

$controller = new $controllerName();

// Передаём все найденные части маршрута в экшен как аргументы
$controller->$actionName(...$matches);
