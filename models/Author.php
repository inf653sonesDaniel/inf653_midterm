<?php
  class Author {
    // DB Stuff
    private $conn;
    private $table = 'authors';

    // Properties
    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get author
    public function read() {
      // Create query
      $query = 'SELECT
        id,
        author
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

    // Get Single Author
    public function read_single() {
      // Create query
      $query = 'SELECT
              id,
              author
            FROM
              ' . $this->table . '
          WHERE id = ? LIMIT 1';
  
      // Prepare statement
      $stmt = $this->conn->prepare($query);
  
      // Bind ID
      $stmt->bindParam(1, $this->id);
  
      // Execute query
      $stmt->execute();
  
      // Fetch the row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
      // Check if author was found
      if ($row) {
          // Assign the values to object properties
          $this->id = $row['id'];
          $this->author = $row['author'];
          return $this;  // Return the Author object
      } else {
          return null;  // Return null if no author found
      }
    }

    // Create author
    public function create() {
      // Create Query
      $query = 'INSERT INTO ' .
      $this->table .
      ' (author) VALUES (:author)';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->author = htmlspecialchars(strip_tags($this->author));

      // Bind data
      $stmt-> bindParam(':author', $this->author);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);

      return false;
    }

    // Update author
    public function update() {
      // First, check if the author with the given id exists
      if (!$this->authorExists()) {
          return array('message' => 'Author does not exist');  // Return error if author does not exist
      }

      // Prepare update query
      $query = 'UPDATE ' . $this->table . '
                SET author = :author
                WHERE id = :id';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      if ($stmt->execute()) {
        // If update is successful, fetch the updated author
        return $this->read_single();  // Return the updated author object
      } else {
          // If the update fails, return an error message
          return array('message' => 'Failed to update the author');
      }
    }



    // Delete author
    public function delete() {
      // First, check if the author with the given id exists
      $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind the id
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      $stmt->execute();

      // Check if the ID exists
      if ($stmt->rowCount() > 0) {
        // Author exists, now check if the author is in use by any quotes
        $query = 'SELECT id FROM quotes WHERE author_id = :id LIMIT 1';

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind the id
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        $stmt->execute();

        // If there are any quotes associated with the author, return false
        if ($stmt->rowCount() > 0) {
            return false;  // Author cannot be deleted because they are in use by quotes
        }

        // If no quotes are associated, proceed with deleting the author
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare the statement
        $stmt = $this->conn->prepare($query);

        // Bind the id
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;  // Author deleted successfully
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);
        return false;  // Something went wrong during the deletion
      } else {
        // Author ID does not exist
        return false;  // Author not found
      }
    }

    // Check if the author exists
    public function authorExists() {
      // Create query to check if the author exists
      $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

      // Prepare the statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind the id
      $stmt->bindParam(':id', $this->id);

      // Execute the query
      $stmt->execute();

      // Check if the author exists
      if ($stmt->rowCount() > 0) {
          return true; // Author exists
      } else {
          return false; // Author doesn't exist
      }
    }
  }
?>