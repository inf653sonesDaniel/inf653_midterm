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

// Get single quote
$quote->read_single();

// Create array
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author_name, // Return author name
    'category' => $quote->category_name // Return category name
);

// Make JSON
echo json_encode($quote_arr);
?>
