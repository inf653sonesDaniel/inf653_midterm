<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

    // Include necessary files and handle the request
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote, Author, and Category objects
    $quote = new Quote($db);
    $author = new Author($db);
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Ensure the id is set
    if (isset($data->id)) {
        // Set the quote ID for deletion
        $quote->id = $data->id;

        // Check if the quote exists
        if (!$quote->quoteExists()) {
            echo json_encode(array('message' => 'Quote not found or already deleted'));
            exit();
        }

        // Attempt to delete the quote
        if ($quote->delete()) {
            echo json_encode(array('message' => 'Quote deleted successfully'));
        } else {
            echo json_encode(array('message' => 'Failed to delete the quote'));
        }
    } else {
        echo json_encode(array('message' => 'Missing quote ID'));
    }
?>