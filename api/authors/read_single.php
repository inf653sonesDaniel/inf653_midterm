<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get ID
  $author->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get Author
  $author->read_single();

  // Get the author
  $result = $author->read_single();

  // Check if result contains an array (error message)
  if (is_array($result) && isset($result['message'])) {
    // Output the message if no author was found
    echo json_encode(array('message' => $result['message']));
  } else {
    // Output author data if found
    echo json_encode(
        array(
            'id' => $author->id,
            'author' => $author->author
        )
    );
  }
?>