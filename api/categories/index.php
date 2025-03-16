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
    $query_params = $_GET; // Get the query parameters (e.g., id)

    switch ($request) {
        case '/api/categories/create':
            require __DIR__ . '/create.php';
            break;
    
        case '/api/categories/read':
            // Check if 'id' is set in the query string
            if (isset($query_params['id'])) {
                // If 'id' is provided, route to read_single.php to fetch a specific category
                require __DIR__ . '/read_single.php';
            } else {
                // Otherwise, fetch all categories by routing to read.php
                require __DIR__ . '/read.php';
            }
            break;
    
        case '/api/categories/read_single':
            require __DIR__ . '/read_single.php';
            break;
    
        case '/api/categories/update':
            require __DIR__ . '/update.php';
            break;
    
        case '/api/categories/delete':
            require __DIR__ . '/delete.php';
            break;
    
        case '/api/categories':  // This will match "/api/categories"
            // Check if 'id' is provided in the query parameters
            if (isset($query_params['id'])) {
                // If 'id' is set, fetch the single category
                require __DIR__ . '/read_single.php';
            } else {
                // Default behavior: return all categories
                require __DIR__ . '/read.php';
            }
            break;
    
        default:
            // If no route is matched, return 404
            http_response_code(404);
            echo json_encode(['message' => 'Not Found']);
            break;
    }
?>