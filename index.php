<?php
// index.php
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
    // Authors API routes
    case '/api/authors/create':
        require __DIR__ . '/api/authors/create.php';
        break;
    case '/api/authors/read':
        require __DIR__ . '/api/authors/read.php';
        break;
    case '/api/authors/read_single':
        require __DIR__ . '/api/authors/read_single.php';
        break;
    case '/api/authors/update':
        require __DIR__ . '/api/authors/update.php';
        break;
    case '/api/authors/delete':
        require __DIR__ . '/api/authors/delete.php';
        break;

    // Categories API routes
    case '/api/categories/create':
        require __DIR__ . '/api/categories/create.php';
        break;
    case '/api/categories/read':
        require __DIR__ . '/api/categories/read.php';
        break;
    case '/api/categories/read_single':
        require __DIR__ . '/api/categories/read_single.php';
        break;
    case '/api/categories/update':
        require __DIR__ . '/api/categories/update.php';
        break;
    case '/api/categories/delete':
        require __DIR__ . '/api/categories/delete.php';
        break;

    // Quotes API routes
    case '/api/quotes/create':
        require __DIR__ . '/api/quotes/create.php';
        break;
    case '/api/quotes/read':
        require __DIR__ . '/api/quotes/read.php';
        break;
    case '/api/quotes/read_single':
        require __DIR__ . '/api/quotes/read_single.php';
        break;
    case '/api/quotes/update':
        require __DIR__ . '/api/quotes/update.php';
        break;
    case '/api/quotes/delete':
        require __DIR__ . '/api/quotes/delete.php';
        break;

    default:
        // If no route is matched, return 404
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
}
