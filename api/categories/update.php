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

    // Update Category
    $updated_category = $category->update();

    if ($updated_category) {
        echo json_encode(array(
          'id' => $updated_category->id,
          'category' => $updated_category->category
          ));
    } else {
        echo json_encode(
            array('message' => 'Category Not Found or Update Failed')
        );
    }
  } else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
  }
?>