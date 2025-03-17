<?php 
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Author query
  $result = $author->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any Authors
  if($num > 0) {
    $author_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $author_item = array(
        'id' => $id,
        'author' => $author
      );

      // Push to "data"
      array_push($author_arr, $author_item);
    }

    // Wrap the data in an array under a 'data' key
    $response = array(
      'data' => $author_arr
    );

    // Return the JSON response with the authors' data
    echo json_encode($response);

  } else {
    // No authors found, return a message
    echo json_encode(
      array('message' => 'No Authors Found')
    );
  }
?>