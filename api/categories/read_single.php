<?php
  // Set content type to JSON
  header('Content-Type: application/json');
  error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Check if 'id' is passed in the query string
  if (isset($_GET['id'])) {
    $category->id = $_GET['id'];
  } else {
    // If no ID is provided, return an error message
    echo json_encode(array('message' => 'Category ID is required'));
    exit;
  }

  // Get the category details by ID
  $result = $category->read_single();  // Fetch the single category by ID

  // Check if category is found
  if ($result) {
    // Return the category data as a single JSON object
    echo json_encode(
      array(
        'id' => $category->id,
        'category' => $category->category
      )
    );
  } else {
    // Return a message if no category is found
    echo json_encode(
      array('message' => 'category_id Not Found')
    );
  }
?>
