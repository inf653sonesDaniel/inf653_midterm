<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

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

    // Ensure the id, quote, author_id, and category_id are set
    if (isset($data->id) && isset($data->quote) && isset($data->author_id) && isset($data->category_id)) {
        // Set properties for the update
        $quote->id = $data->id;
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        // Check if the quote exists
        if (!$quote->quoteExists()) {
            echo json_encode(array('message' => 'Quote not found or already deleted'));
            exit();
        }

        // Check if the author exists
        $author->id = $data->author_id;
        if (!$author->authorExists()) {
            echo json_encode(array('message' => 'Author does not exist'));
            exit();
        }

        // Check if the category exists
        $category->id = $data->category_id;
        if (!$category->categoryExists()) {
            echo json_encode(array('message' => 'Category does not exist'));
            exit();
        }

        // Attempt to update the quote
        if ($quote->update()) {
            echo json_encode(array('message' => 'Quote updated'));
        } else {
            echo json_encode(array('message' => 'Failed to update the quote'));
        }
    } else {
        echo json_encode(array('message' => 'Missing required data'));
    }
?>