<?php
  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Check if the 'category_name' field is set in the input data
  if (isset($data->category_name)) {
    $category->category_name = $data->category_name;

    // Create Category
    if ($category->create()) {
      // Return the response with the id of the newly created category
      echo json_encode(
        array(
          'id' => $category->id,            // Category's ID (auto-incremented)
          'category_name' => $category->category_name  // The category's name
        )
      );
    } else {
      echo json_encode(
        array('message' => 'Category Not Created')
      );
    }
  } else {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
  }
?>