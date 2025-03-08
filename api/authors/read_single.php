<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get ID
  $author->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get Author
  $author->read_single();

  // Create array
  $post_arr = array(
    'id' => $author->id,
    'author' => $author->author
  );

  // Make JSON
  echo json_encode($post_arr);