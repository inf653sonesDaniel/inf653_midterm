<?php
  // Include necessary files and handle the request
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../models/Author.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Ensure the category is set
  if (isset($data->category)) {
    // Set category property for creation
    $category->category = $data->category;

    // Create the category
    if ($category->create()) {
        echo json_encode(array('message' => 'Category Created'));
    } else {
        echo json_encode(array('message' => 'Category Not Created'));
    }
  } else {
    echo json_encode(array('message' => 'Missing required data (Category name)'));
  }
?>