<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Ensure 'id' and 'category' are set in the request
  if (!isset($data->id) || !isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();  // Exit if any required data is missing
  }

  // Set properties for update
  $category->id = $data->id;
  $category->category = $data->category;

  // Attempt to update the category
  if($category->update()) {
    // After update, fetch the updated category
    $updated_category = $category->read_single();

    // If the update was successful, return the updated data
    if ($updated_category) {
        echo json_encode(
            array(
                'id' => $updated_category->id,
                'category' => $updated_category->category
            )
        );
    } else {
        echo json_encode(array('message' => 'Failed to fetch updated category.'));
    }
  } else {
      // If update fails, return a message
      echo json_encode(array('message' => 'Failed to update the category'));
  }
?>