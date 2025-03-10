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

// Check if result is an array (error message)
if (is_array($result) && isset($result['message'])) {
    // Output the message if quote was not found
    echo json_encode(array('message' => $result['message']));
} else {
    // Output quote data if found
    echo json_encode(
        array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id,
            'author_name' => $quote->author_name,
            'category_name' => $quote->category_name
        )
    );
}
?>
