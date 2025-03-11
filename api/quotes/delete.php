<?php 
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Ensure the id is set
    if (isset($data->id)) {
        // Set the ID for deletion
        $quote->id = $data->id;

        // Check if the quote exists
        if (!$quote->quoteExists()) {
            echo json_encode(array('message' => 'Quote not found or already deleted'));
            exit();
        }

        // Delete the quote
        if ($quote->delete()) {
            echo json_encode(array('message' => 'Quote deleted'));
        } else {
            echo json_encode(array('message' => 'Failed to delete the quote'));
        }
    } else {
        echo json_encode(array('message' => 'Missing required data (ID)'));
    }
?>
