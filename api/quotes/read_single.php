<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

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
        $response = array(
            'id' => $quote_item->id,
            'quote' => $quote_item->quote,
            'author' => $quote_item->author_name,
            'category' => $quote_item->category_name
        );
        echo json_encode($response);
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>