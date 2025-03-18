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

  // Ensure 'id' and 'category' are set in the request
  if (!isset($data->id) || !isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();  // Exit if any required data is missing
  }

  // Set ID and category for update
  $category->id = $data->id;
  $category->category = $data->category;

  // Attempt to update the category
  $updated_category = $category->update();

  // Check if the update was successful
  if (isset($updated_category['message'])) {
      // If update fails, return an error message
      echo json_encode($updated_category);
  } else {
      // If the update is successful, return the updated category as a JSON object
      echo json_encode(array(
          'id' => $updated_category->id,
          'category' => $updated_category->category
      ));
  }
?>