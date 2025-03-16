<?php
    // Allow cross-origin requests
    header('Access-Control-Allow-Origin: *');  // This allows any domain. You can replace '*' with your specific domain for better security.
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');  // Allow all necessary HTTP methods
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');  // Allow custom headers if needed

    // Handle OPTIONS request (preflight request)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);  // Exit immediately for OPTIONS request
    }

    // Set content type to JSON for all responses
    header('Content-Type: application/json');

    // Your existing API routing logic here...
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        // Exit early if the request is an OPTIONS request (this is required for CORS preflight)
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