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

    // Define the base route
    $base_route = '/api/categories';
    $request = rtrim($request, '/');

    switch ($method) {
        case 'GET':
            if ($request === $base_route) {
                // If no 'id' query parameter is provided, fetch all categories (minimum 5 categories)
                if (isset($query_params['id'])) {
                    // Fetch a single category by id
                    require __DIR__ . '/read_single.php';
                } else {
                    // Fetch multiple categories (at least 5)
                    require __DIR__ . '/read.php';
                }
            } else {
                // If no valid path matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;

        case 'POST':
            if ($request === $base_route) {
                // Create a new category
                require __DIR__ . '/create.php';
            } else {
                // If no valid path matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;

        case 'PUT':
            if ($request === $base_route) {
                // Update an existing category
                require __DIR__ . '/update.php';
            } else {
                // If no valid path matched
                http_response_code(404);
                echo json_encode(['message' => 'Not Found']);
            }
            break;

        case 'DELETE':
            if ($request === $base_route) {
                // Delete a category
                require __DIR__ . '/delete.php';
            } else {
                // If no valid path matched
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