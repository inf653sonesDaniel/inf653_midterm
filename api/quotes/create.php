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
    $created_quote = $quote->create();  // This will return the newly created quote

    // Check if the creation was successful
    if ($created_quote) {
        // Return the created quote as JSON
        echo json_encode($created_quote);  // Directly return the newly created quote's details
    } else {
        echo json_encode(array('message' => 'Quote Not Created'));
    }
?>