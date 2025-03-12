<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $categories = new Category($db);

  // Category query
  $result = $categories->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
    $categories_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $categories_item = array(
        'id' => $id,
        'category' => $category
      );

      // Push to the array
      array_push($categories_arr, $categories_item);
    }

    // Turn to JSON & output
    echo json_encode($categories_arr);

  } else {
    // No Category
    echo json_encode(
      array('message' => 'No such category Found')
    );
  }
?>