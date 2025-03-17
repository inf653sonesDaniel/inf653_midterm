<?php 
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get ID from query parameter
  $author->id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(array('message' => 'Author ID is required')));

  // Get the author
  $result = $author->read_single();

  // Check if author is found
  if ($result) {
    // Return the author data as a single JSON object
    echo json_encode(
      array(
        'id' => $author->id, // Use the property from the object
        'author' => $author->author // Use the property from the object
      )
    );
  } else {
    // Return a message if no author is found
    echo json_encode(
      array('message' => 'author_id Not Found')
    );
  }
?>