<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }
    
    require_once __DIR__ . '/../../vendor/autoload.php'; // Ensure the autoloader is loaded

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    // Clean URI path to handle routing
    $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Get path without query string

    switch ($request) {
        case '/api/quotes/create':
            require __DIR__ . '/create.php';
            break;
        case '/api/quotes/read':
            require __DIR__ . '/read.php';
            break;
        case '/api/quotes/read_single':
            require __DIR__ . '/read_single.php';
            break;
        case '/api/quotes/update':
            require __DIR__ . '/update.php';
            break;
        case '/api/quotes/delete':
            require __DIR__ . '/delete.php';
            break;
        default:
            // If no route is matched, return 404
            http_response_code(404);
            echo json_encode(['message' => 'Not Found']);
            break;
    }
?>