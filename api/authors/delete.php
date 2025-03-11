<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $author = new Author($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Ensure the id is set
  if (isset($data->id)) {
    // Set ID for deletion
    $author->id = $data->id;

    // First, check if the author exists in the authors table
    if (!$author->authorExists()) {
        // If the author doesn't exist, return an error message
        echo json_encode(array('message' => 'Author Not Found'));
    } else {
        // If the author exists, check if the author is being used in any quotes
        if ($author->delete()) {
            echo json_encode(array('message' => 'Author Deleted'));
        } else {
            echo json_encode(array('message' => 'Author cannot be deleted because it is in use by quotes.'));
        }
    }
  } else {
    echo json_encode(array('message' => 'Missing required data (ID)'));
  }
  ?>