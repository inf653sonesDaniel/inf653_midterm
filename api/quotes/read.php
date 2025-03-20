<?php
    // Set content type to JSON
    header('Content-Type: application/json');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Check if 'author_id' or 'category_id' is passed and set filtering properties
    if (isset($_GET['author_id'])) {
        $quote->author_id = $_GET['author_id'];  // Set author_id for filtering
    }

    if (isset($_GET['category_id'])) {
        $quote->category_id = $_GET['category_id'];  // Set category_id for filtering
    }

    // Get quotes with the applied filters (or all quotes if no filters are set)
    $stmt = $quote->read(); // Call the existing read() method, which supports filtering

    $num = $stmt->rowCount();

    if ($num > 0) {
        $quotes_arr = array();

        // Fetch quotes and structure the response
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author_name,
                'category' => $category_name
            );
            // Push each quote item to the quotes array directly
            array_push($quotes_arr, $quote_item);
        }

        // Return the list of quotes in JSON format directly as an array
        echo json_encode($quotes_arr);
    } else {
        // Return a message if no quotes were found
        echo json_encode(array('message' => 'No Quotes Found'));
    }
?>