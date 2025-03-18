<?php
  class Category {
    // DB Stuff
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        category
      FROM
        ' . $this->table . '
      ORDER BY
        id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Category
    public function read_single(){
      // Create query
      $query = 'SELECT
            id,
            category
          FROM
            ' . $this->table . '
        WHERE id = ? LIMIT 1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        // Fetch the row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if category was found
        if($row) {
          $this->id = $row['id'];
          $this->category = $row['category'];
          return $this;
        } else {
          return null;  // Return null if category not found
        }
    }

    // Create category
    public function create() {
      // Create Query
      $query = 'INSERT INTO ' .
      $this->table .
      ' (category) VALUES (:category)';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->category = htmlspecialchars(strip_tags($this->category));

      // Bind data
      $stmt-> bindParam(':category', $this->category);

      // Execute query
      if ($stmt->execute()) {
        // Retrieve the last inserted id and set it to the model property
        $this->id = $this->conn->lastInsertId(); // Get the last inserted id

        return true;
      }

      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);
      return false;
    }

    // Update category
    public function update() {
      // First, check if the category with the given id exists
      if (!$this->categoryExists()) {
          return array('message' => 'Category does not exist');  // Return error if category does not exist
      }

      // Prepare update query
      $query = 'UPDATE ' . $this->table . ' 
                SET category = :category
                WHERE id = :id';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->category = htmlspecialchars(strip_tags($this->category));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':category', $this->category);
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      if ($stmt->execute()) {
          // If update is successful, fetch the updated category
          return $this->read_single();  // Return the updated category object
      } else {
          // If the update fails, return an error message
          return array('message' => 'Failed to update the category');
      }
    }


    // Delete category
    public function delete() {
      // First, check if the category is in use by any quotes
      $query = 'SELECT id FROM quotes WHERE category_id = :id LIMIT 1';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind the id
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      $stmt->execute();

      // If there are any quotes associated with the category, return false
      if ($stmt->rowCount() > 0) {
          return false;  // Category cannot be deleted because it is in use by quotes
      }

      // If no quotes are associated, proceed with deleting the category
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Bind the id
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      if ($stmt->execute()) {
          return true;  // Category deleted successfully
      }

      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);
      return false;  // Something went wrong during the deletion
    }

    // Check if the category exists
    public function categoryExists() {
      // Create query to check if the category exists
      $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind the id
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      $stmt->execute();

      // Check if the category exists
      if ($stmt->rowCount() > 0) {
          return true; // Category exists
      } else {
          return false; // Category doesn't exist
      }
    }
  }
?>