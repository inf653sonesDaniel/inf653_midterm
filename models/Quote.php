<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';

        // Quote properties
        public $id;
        public $quote;
        public $author_id;
        public $category_id;
        public $author_name;
        public $category_name;

        // Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        // Get All Quotes
        public function read() {
            // Create query
            $query = 'SELECT
                    q.id,
                    q.quote,
                    q.author_id,
                    q.category_id,
                    a.author AS author_name,
                    c.category AS category_name
                  FROM
                    ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  ORDER BY
                    q.id DESC';
  
            // Prepare statement
            $stmt = $this->conn->prepare($query);
  
            // Execute query
            $stmt->execute();
  
            return $stmt;
        }

        // Get Single Quote
        public function read_single(){
            // Create query
            $query = 'SELECT
                    q.id,
                    q.quote,
                    q.author_id,
                    q.category_id,
                    a.author AS author_name,
                    c.category AS category_name
                  FROM
                    ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = ?
                  LIMIT 0,1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            $this->author_name = $row['author_name'];
            $this->category_name = $row['category_name'];
        }

        // Create a New Quote
        public function create() {
            // Create Query
            $query = 'INSERT INTO ' .
            $this->table . '
            SET
            quote = :quote,
            author_id = :author_id,
            category_id = :category_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }

        // Update Quote
        public function update() {
            // Create Query
            $query = 'UPDATE ' .
            $this->table . '
            SET
            quote = :quote,
            author_id = :author_id,
            category_id = :category_id
            WHERE
            id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }

        // Delete a quote
        public function delete() {
            // Create Query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
            return false;
        }
    }
?>