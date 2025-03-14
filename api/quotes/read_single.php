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

    // Get quote ID from query parameter
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(array('message' => 'Quote ID is required')));

    // Get the quote
    $quote_item = $quote->read_single();

    // Check if quote is found
    if ($quote_item) {
        echo json_encode(
            array(
                'id' => $quote_item->id,
                'quote' => $quote_item->quote,
                'author' => $quote_item->author_name,
                'category' => $quote_item->category_name
            )
        );
    } else {
        echo json_encode(
            array('message' => 'No Quote Found')
        );
    }
?>