<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Check if author_id is provided in the query string
    if (isset($_GET['author_id'])) {
        $quote->author_id = $_GET['author_id'];
    }

    // Check if category_id is provided in the query string
    if (isset($_GET['category_id'])) {
        $quote->category_id = $_GET['category_id'];
    }

    // Get quotes (filtered or all)
    $stmt = $quote->read();
    $num = $stmt->rowCount();

    // Check if any quotes
    if ($num > 0) {
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author_name, // Use author name
                'category' => $category_name // Use category name
            );

            array_push($quotes_arr['data'], $quote_item);
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>