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

  // Instantiate blog post object
  $author = new Author($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Ensure the id is set
  if (isset($data->id)) {
    // Set ID for deletion
    $author->id = $data->id;

    // First, check if the author exists in the authors table
    if (!$author->authorExists()) {
        // If the author doesn't exist, return an error message
        echo json_encode(array('message' => 'Author Not Found'));
        exit();
    }
        
    if ($author->delete()) {
          // Return the id of the deleted author
          echo json_encode(array('id' => $author->id));
    } else {
          echo json_encode(array('message' => 'Failed to delete the author.'));
    }
  } else {
    echo json_encode(array('message' => 'Missing author ID'));
  }
?>