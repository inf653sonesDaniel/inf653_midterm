<?php
  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get the query parameter for 'id'
  $query_params = $_GET; // Get the query parameters (e.g., 'id')

  // If 'id' is passed in the query string
  if (isset($query_params['id'])) {
    // Set the ID for fetching a specific author
    $author->id = $query_params['id'];

    // Fetch the single author by ID
    $result = $author->read_single();

    // Check if the author was found
    if ($result) {
      // Return the single author's data as a JSON object
      echo json_encode(array(
        'id' => $author->id,    // Use the object properties
        'author' => $author->author
      ));
    } else {
      // If no author is found, return a message
      echo json_encode(array('message' => 'Author not found'));
    }

  } else {
    // If no 'id' is passed, fetch all authors
    $result = $author->read();
    $num = $result->rowCount();

    // Check if there are authors
    if ($num > 0) {
      $author_arr = array();

      // Loop through all the authors and format the data
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        // Create the author item
        $author_item = array(
          'id' => $id,           // Field 'id'
          'author' => $author    // Field 'author'
        );

        // Push the current author to the authors array
        array_push($author_arr, $author_item);
      }

      // Return the list of authors as a JSON array
      echo json_encode($author_arr);

    } else {
      // No authors found, return an empty array
      echo json_encode(array());
    }
  }
?>