<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get ID from query parameter
  if (isset($_GET['id'])) {
      $author->id = $_GET['id']; // Set the author ID from the query parameter
  } else {
      // If no ID is provided, return an error message
      echo json_encode(array('message' => 'Author ID is required'));
      exit;
  }

  // Get the author
  $result = $author->read_single();  // Fetch the single author by ID

  // Check if author is found
  if ($result) {
    // Return the author data as a single JSON object
    echo json_encode(
      array(
        'id' => $author->id,
        'author' => $author->author
      )
    );
  } else {
    // Return a message if no author is found
    echo json_encode(
      array('message' => 'author_id Not Found')
    );
  }
?>
