<?php
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../models/Author.php';
  include_once '../../models/Category.php';

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
      echo json_encode(
        array('message' => 'Author Created')
      );
    } else {
      echo json_encode(
        array('message' => 'Author Not Created')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'No author data provided')
    );
  }
?>