<?php
    // Allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization');

    // Handle OPTIONS request (preflight request)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);  // Exit immediately for OPTIONS request
    }

    // Set content type to JSON for all responses
    header('Content-Type: application/json');

    // Your existing API routing logic here...
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Clean URI path to handle routing
    $request = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');// Get path without query string
    $query_params = $_GET; // Get the query parameters (author_id, category_id, id, etc.)

    switch ($method) {
        case 'GET':
            if ($request === '/api/quotes') {
                // If 'id' is provided, fetch a single quote
                if (isset($query_params['id'])) {
                    require __DIR__ . '/read_single.php';
                } else {
                    // If 'author_id' or 'category_id' are provided, handle filtering
                    if (isset($query_params['author_id']) || isset($query_params['category_id'])) {
                        require __DIR__ . '/read.php';  // Pass to read.php to handle filtering
                    } else {
                        // If no parameters are provided, fetch all quotes
                        require __DIR__ . '/read.php';
                    }
                }
            } else {
                // If no valid route is matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'POST':
            if ($request === '/api/quotes') {
                require __DIR__ . '/create.php';  // Create a new quote
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'PUT':
            if ($request === '/api/quotes') {
                require __DIR__ . '/update.php';  // Update an existing quote
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'DELETE':
            if ($request === '/api/quotes') {
                require __DIR__ . '/delete.php';  // Delete a quote
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        default:
            http_response_code(404);
            echo json_encode(['message' => 'Method Not Allowed']);
            break;
    }
?>