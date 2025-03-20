<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

  // Include necessary files and handle the request
  include_once '../../config/Database.php';
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

    if (!$category->categoryExists()) {
      // If the category doesn't exist, return an error message
      echo json_encode(array('message' => 'category Not Found'));
      exit();
    }
        
    if ($category->delete()) {
          // Return the id of the deleted category
          echo json_encode(array('id' => $category->id));
    } else {
          echo json_encode(array('message' => 'Failed to delete the author.'));
    }
} else {
  echo json_encode(array('message' => 'Missing category ID'));
}
?>