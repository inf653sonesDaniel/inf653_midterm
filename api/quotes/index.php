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
    $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Get path without query string
    $query_params = $_GET; // Get the query parameters (author_id, category_id, id, etc.)

    switch ($method) {
        case 'GET':
            if ($request === '/api/quotes') {
                // Check if query parameters (author_id, category_id, id) are set
                if (isset($query_params['id'])) {
                    // If 'id' is set, fetch a single quote
                    require __DIR__ . '/read_single.php';
                } elseif (isset($query_params['author_id'])) {
                    // If 'author_id' is set, fetch quotes by author
                    require __DIR__ . '/read_by_author.php';
                } elseif (isset($query_params['category_id'])) {
                    // If 'category_id' is set, fetch quotes by category
                    require __DIR__ . '/read_by_category.php';
                } elseif (isset($query_params['author_id']) && isset($query_params['category_id'])) {
                    // If both 'author_id' and 'category_id' are set, fetch quotes by both
                    require __DIR__ . '/read_by_author_and_category.php';
                } else {
                    // Default behavior: return all quotes (min 25)
                    require __DIR__ . '/read.php';
                }
            } else {
                // If no valid route is matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'POST':
            if ($request === '/api/quotes') {
                // Create a new quote
                require __DIR__ . '/create.php';
            } else {
                // If no valid route is matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'PUT':
            if ($request === '/api/quotes') {
                // Update an existing quote
                require __DIR__ . '/update.php';
            } else {
                // If no valid route is matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        case 'DELETE':
            if ($request === '/api/quotes') {
                // Delete a quote
                require __DIR__ . '/delete.php';
            } else {
                // If no valid route is matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;
    
        default:
            // If no valid method was found
            http_response_code(404);
            echo json_encode(['message' => 'Method Not Allowed']);
            break;
    }
?>