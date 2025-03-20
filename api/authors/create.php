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

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Check if the 'author' field is set in the input data
  if (isset($data->author)) {
    $author->author = $data->author;

    // Create Author
    if ($author->create()) {
      // Return the response with the id of the newly created author
      echo json_encode(
        array(
          'id' => $author->id,
          'author' => $author->author
        )
      );
    } else {
      echo json_encode(
        array('message' => 'Author Not Created')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
  }
?>