<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload classes
spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Build the full path to the class file
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    // Debugging: Print the file path being checked
    echo "Trying to load: $file<br>";

    // Check if the file exists
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Debugging: Print the file path that could not be found
        echo "Class file not found: $file<br>";
    }
});

// Start session (if needed)
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Front Controller: Handle routing
$request = $_SERVER['REQUEST_URI'];
$baseDir = '/projet/'; // Adjust this to match your project's base directory

// Remove the base directory from the request
$request = str_replace($baseDir, '', $request);

// Parse the request
$request = trim($request, '/');
$segments = explode('/', $request);

// Default controller and action
$controllerName = 'MembreController'; // Default controller
$action = 'acceuil'; // Default action to load the "acceuil" page

// Determine the controller and action from the URL
if (!empty($segments[0])) {
    $controllerName = ucfirst($segments[0]) . 'Controller';
}

if (!empty($segments[1])) {
    $action = $segments[1];
}

// Include the controller file
$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';

// Debugging: Print the controller file path being checked
echo "Checking controller file: $controllerFile<br>";

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Create the controller object
    $controllerClass = "App\\Controllers\\$controllerName";
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();

        // Call the action method if it exists
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            // Handle 404 - Action not found
            header("HTTP/1.0 404 Not Found");
            echo "404 - Action not found: $action";
            exit;
        }
    } else {
        // Handle 404 - Controller class not found
        header("HTTP/1.0 404 Not Found");
        echo "404 - Controller class not found: $controllerClass";
        exit;
    }
} else {
    // Handle 404 - Controller file not found
    header("HTTP/1.0 404 Not Found");
    echo "404 - Controller file not found: $controllerFile";
    exit;
}