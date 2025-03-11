<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get the quote
    $result = $quote->read_single();

    // Check if the result is valid (object)
    if ($result) {
        // Output the response with author_name and category_name only
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_name' => $quote->author_name,
                'category_name' => $quote->category_name
            )
        );
    } else {
        // If no quote found, output a message
        echo json_encode(
            array('message' => 'Quote not found')
        );
    }
?>