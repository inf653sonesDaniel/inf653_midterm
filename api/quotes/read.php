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

    // Check if the 'id' parameter is provided (for fetching a specific quote)
    if (isset($_GET['id'])) {
        $quote->id = $_GET['id']; // Set the ID to fetch a specific quote
        $stmt = $quote->read_single(); // Assuming read_single() method fetches a single quote by ID
        $num = $stmt ? 1 : 0; // If a quote is found, num should be 1
    } else {
        // Check if author_id or category_id is provided (for filtering quotes)
        if (isset($_GET['author_id'])) {
            $quote->author_id = $_GET['author_id'];
        }
        if (isset($_GET['category_id'])) {
            $quote->category_id = $_GET['category_id'];
        }

        // Get quotes (filtered or all)
        $stmt = $quote->read(); // Assuming read() fetches quotes
        $num = $stmt->rowCount(); // Number of quotes fetched
    }

    // Check if any quotes or a specific quote is found
    if ($num > 0) {
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        if (isset($quote->id)) { // If the ID is set (single quote)
            // Process the single quote
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author_name, // Assuming the quote object has this field
                'category' => $category_name // Assuming the quote object has this field
            );

            array_push($quotes_arr['data'], $quote_item);
        } else { // If it's multiple quotes (filtered or all)
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author_name, // Assuming the quote object has this field
                    'category' => $category_name // Assuming the quote object has this field
                );

                array_push($quotes_arr['data'], $quote_item);
            }
        }

        // Ensure the response is valid JSON
        echo json_encode($quotes_arr);
    } else {
        // Return an appropriate message if no quotes found
        echo json_encode(array('message' => 'No Quotes Found'));
    }
?>