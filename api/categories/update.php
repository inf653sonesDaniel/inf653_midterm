<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Ensure the id and category are set
  if (isset($data->id) && isset($data->category)) {
    // Set ID and category for update
    $category->id = $data->id;
    $category->category = $data->category;

    // Check if the author exists before updating
    if (!$category->categoryExists()) {
      echo json_encode(array('message' => 'category_id Not Found'));
      exit();  // Exit if the category does not exist
    }

    // Attempt to update the category
    $updated_category = $category->update();

    // Check if the update was successful
    if ($updated_category) {
        // Return the updated category as a JSON object
        echo json_encode(array(
            'id' => $updated_category->id,
            'category' => $updated_category->category
        ));
    }
  } else {
    echo json_encode(
      array('message' => 'Missing Required Parameters'));
  }
?>