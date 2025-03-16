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
    $query_params = $_GET; // Get the query parameters (author_id, category_id, id, etc.)

switch ($request) {
    case '/api/quotes/create':
        require __DIR__ . '/create.php';
        break;
    case '/api/quotes/read':
        // Check if query parameters (author_id, category_id) are set
        if (isset($query_params['author_id']) || isset($query_params['category_id'])) {
            // Pass the query parameters to the read.php file
            require __DIR__ . '/read.php';
        } else {
            // Default behavior: return all quotes
            require __DIR__ . '/read.php';
        }
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
    case '/api/quotes':  // This will match "/api/quotes" (for fetching all quotes or filtered ones)
        // Check if query parameters (author_id, category_id) are set
        if (isset($query_params['author_id']) || isset($query_params['category_id'])) {
            // Pass the query parameters to the read.php file
            require __DIR__ . '/read.php';
        } elseif (isset($query_params['id'])) {
            // If 'id' is set in the query parameters, route to the read_single.php
            require __DIR__ . '/read_single.php';
        } else {
            // Default behavior: return all quotes
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