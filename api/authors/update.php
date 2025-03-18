<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Ensure 'id' and 'author' are set in the request
    if (!isset($data->id) || !isset($data->author)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();  // Exit if any required data is missing
    }

    // Set ID and author for update
    $author->id = $data->id;
    $author->author = $data->author;

    // Attempt to update the author
    if($author->update()) {
        $updated_author = $author->read_single();

        // Return the updated author as a JSON object
        echo json_encode(
            array(
                'id' => $updated_author->id,
                'author' => $updated_author->author
        ));
    } else {
        // If update fails, return a message
        echo json_encode(array('message' => 'Failed to update the quote'));
    }
?>