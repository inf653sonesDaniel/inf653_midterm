<?php
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
        case '/api/authors/create':
            require __DIR__ . '/create.php';
            break;
        case '/api/authors/read':
            require __DIR__ . '/read.php';
            break;
        case '/api/authors/read_single':
            require __DIR__ . '/read_single.php';
            break;
        case '/api/authors/update':
            require __DIR__ . '/update.php';
            break;
        case '/api/authors/delete':
            require __DIR__ . '/delete.php';
            break;
        default:
            // If no route is matched, return 404
            http_response_code(404);
            echo json_encode(['message' => 'Not Found']);
            break;
    }
?>