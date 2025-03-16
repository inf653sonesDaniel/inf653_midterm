<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Initialize filtering variables
    $filters = [];

    // Check if author_id or category_id is provided (for filtering)
    if (isset($_GET['author_id'])) {
        $quote->author_id = $_GET['author_id'];  // Set author_id for filtering
        $filters['author_id'] = $_GET['author_id'];  // Add to filter list
    }

    if (isset($_GET['category_id'])) {
        $quote->category_id = $_GET['category_id'];  // Set category_id for filtering
        $filters['category_id'] = $_GET['category_id'];  // Add to filter list
    }

    // Get quotes with the applied filters (or all quotes if no filters are set)
    if (!empty($filters)) {
        $stmt = $quote->read_(); //
    } else {
        $stmt = $quote->read();  //
    }

    $num = $stmt->rowCount();

    if ($num > 0) {
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        // Fetch quotes and structure the response
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author_name,  // Assuming author_name is available in the data
                'category' => $category_name  // Assuming category_name is available in the data
            );
            array_push($quotes_arr['data'], $quote_item);
        }

        // Return the list of quotes in JSON format
        echo json_encode($quotes_arr);
    } else {
        // Return a message if no quotes were found
        echo json_encode(array('message' => 'No Quotes Found'));
    }
?>