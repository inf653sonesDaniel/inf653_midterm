<?php 
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../models/Author.php';
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
    if ($category->update()) {
        echo json_encode(
            array('message' => 'Category Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Found or Update Failed')
        );
    }
  } else {
    echo json_encode(array('message' => 'Missing required data (ID or category)'));
  }
?>