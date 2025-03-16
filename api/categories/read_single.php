<?php 
  // Handle OPTIONS request
  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With, Authorization');
    exit();  // Exit after handling OPTIONS request
  }

  // Normal request handling continues here
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $categories = new Category($db);

  // Get ID
  $categories->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get the author
  $result = $categories->read_single();

  // Check if result contains an array (error message)
  if (is_array($result) && isset($result['message'])) {
    // Output the message if no author was found
    echo json_encode(array('message' => $result['message']));
  } else {
    // Output author data if found
    echo json_encode(
        array(
            'id' => $categories->id,
            'category' => $categories->category
        )
    );
  }
?>