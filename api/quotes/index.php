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
    
    // Clean URI path to handle routing
    $request = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');// Get path without query string
    $query_params = $_GET; // Get the query parameters (author_id, category_id, id, etc.)

    switch ($method) {
        case 'GET':
            if ($request === '/api/quotes') {
                // Simplify the logic for now
                require __DIR__ . '/read.php';  // Just try fetching all quotes
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