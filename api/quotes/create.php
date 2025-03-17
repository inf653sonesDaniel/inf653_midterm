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

    // Check for missing parameters and provide specific error messages
    if (!isset($data->quote)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    }

    if (!isset($data->author_id)) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }

    if (!isset($data->category_id)) {
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }

    // Set quote properties
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Check if author exists
    $author->id = $data->author_id;
    if (!$author->authorExists()) {
        echo json_encode(array('message' => 'author_id Not Found'));
        exit();
    }

    // Check if category exists
    $category->id = $data->category_id;
    if (!$category->categoryExists()) {
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }

    // Create the quote
    if ($quote->create()) {
        // Fetch author and category names
        $author_name = $author->read_single()->author;  // Assuming `read_single()` returns the author name
        $category_name = $category->read_single()->category;  // Assuming `read_single()` returns the category name

        // Return the created quote with author and category names
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author' => $author_name,
                'category' => $category_name
            )
        );
    } else {
        echo json_encode(array('message' => 'Quote Not Created'));
    }
?>