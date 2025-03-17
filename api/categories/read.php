<?php
// Set content type to JSON
header('Content-Type: application/json');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);  // Suppress deprecated and notice warnings

include_once '../../config/Database.php';
include_once '../../models/Category.php';  // Ensure the correct file path for Category model

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get the query parameter for 'id'
$query_params = $_GET; // Get the query parameters (e.g., 'id')

// If 'id' is passed in the query string
if (isset($query_params['id'])) {
    // Set the ID for fetching a specific category
    $category->id = $query_params['id'];

    // Fetch the single category by ID
    $result = $category->read_single();

    // Check if the category was found
    if ($result) {
        // Return the single category's data as a JSON object
        echo json_encode(array(
            'id' => $category->id,    // Use the object properties
            'category' => $category->category
        ));
    } else {
        // If no category is found, return a message
        echo json_encode(array('message' => 'category_id Not Found'));
    }

} else {
    // If no 'id' is passed, fetch all categories
    $result = $category->read();
    $num = $result->rowCount();

    // Check if there are categories
    if ($num > 0) {
        $category_arr = array();

        // Loop through all the categories and format the data
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            // Create the category item
            $category_item = array(
                'id' => $id,           // Field 'id'
                'category' => $category    // Field 'category'
            );

            // Push the current category to the categories array
            array_push($category_arr, $category_item);
        }

        // Return the list of categories as a JSON array
        echo json_encode($category_arr);

    } else {
        // No categories found, return an empty array
        echo json_encode(array());
    }
}
?>