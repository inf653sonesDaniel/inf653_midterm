<?php 
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

  // Check if 'id' and 'author' are set in the request
  if (isset($data->id) && isset($data->author)) {
    // Set ID and author for update
    $author->id = $data->id;
    $author->author = $data->author;

    // Update Author
    if ($author->update()) {
      echo json_encode(
        array('message' => 'Author Updated')
      );
    } else {
      echo json_encode(
        array('message' => 'Author Not Updated')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Missing required data')
    );
  }
?>