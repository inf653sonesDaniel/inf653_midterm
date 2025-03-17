<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

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

  // Ensure the id is set
  if (isset($data->id)) {
    // Set ID for deletion
    $category->id = $data->id;

    // Check if the category exists
    if ($category->categoryExists()) {
      // Try to delete the category
      if ($category->delete()) {
        echo json_encode(array('message' => 'Category Deleted'));
      } else {
        echo json_encode(array('message' => 'Category cannot be deleted because it is in use by quotes.'));
      }
    } else {
      echo json_encode(array('message' => 'Category not found'));
    }
  } else {
    echo json_encode(array('message' => 'Missing required data (ID)'));
  }
?>