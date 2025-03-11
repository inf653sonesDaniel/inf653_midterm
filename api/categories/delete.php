<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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