<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set quote properties
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Create the quote
if ($quote->create()) {
    echo json_encode(
        array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $data->author_name, // Return author name (passed in request)
            'category' => $data->category_name // Return category name (passed in request)
        )
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Created')
    );
}
?>
