<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Check if the 'category' field is set in the input data
  if (isset($data->category)) {
    // Assign category field to the model property
    $category->category = $data->category;

    // Create Category
    if ($category->create()) {
      // Return the response with the id of the newly created category
      echo json_encode(
        array(
          'id' => $category->id,            // Category's ID (auto-incremented)
          'category' => $category->category  // The category's name
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