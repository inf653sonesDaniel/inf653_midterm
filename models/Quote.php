<?php
    class Quote {
        // DB stuff
        private $conn;
        private $table = 'quotes';
    
        // Properties
        public $id;
        public $quote;
        public $author_name;
        public $category_name;
        public $author_id;
        public $category_id;
    
        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }
    
        // Check if the quote exists by ID
        public function quoteExists() {
            // Query to check if the quote exists by ID
            $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            // Bind the id
            $stmt->bindParam(':id', $this->id);
    
            // Execute the query
            $stmt->execute();
    
            // Check if quote exists
            if ($stmt->rowCount() > 0) {
                return true; // Quote exists
            } else {
                return false; // Quote doesn't exist
            }
        }
    
        // Check if the author exists
        public function authorExists() {
            // Query to check if the author exists by ID
            $query = 'SELECT id FROM authors WHERE id = :author_id LIMIT 1';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind the author_id
            $stmt->bindParam(':author_id', $this->author_id);
    
            // Execute the query
            $stmt->execute();
    
            // Check if author exists
            return $stmt->rowCount() > 0;
        }
    
        // Check if the category exists
        public function categoryExists() {
            // Query to check if the category exists by ID
            $query = 'SELECT id FROM categories WHERE id = :category_id LIMIT 1';
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind the category_id
            $stmt->bindParam(':category_id', $this->category_id);
    
            // Execute the query
            $stmt->execute();
    
            // Check if category exists
            return $stmt->rowCount() > 0;
        }
    
        // Get quotes with author and category names, optionally filtered by author_id and category_id
        public function read() {
            // Start building the base query
            $query = 'SELECT 
                        quotes.id,
                        quotes.quote,
                        authors.author AS author_name,
                        categories.category AS category_name
                    FROM ' . $this->table . ' 
                    LEFT JOIN authors ON quotes.author_id = authors.id
                    LEFT JOIN categories ON quotes.category_id = categories.id';

            // Array to hold filter conditions
            $conditions = array();
            
            // Add filtering by author_id if provided
            if (!empty($this->author_id)) {
                $conditions[] = 'quotes.author_id = :author_id';
            }

            // Add filtering by category_id if provided
            if (!empty($this->category_id)) {
                $conditions[] = 'quotes.category_id = :category_id';
            }

            // If there are conditions, append them to the query
            if (count($conditions) > 0) {
                $query .= ' WHERE ' . implode(' AND ', $conditions);
            }

            // Add ORDER BY clause
            $query .= ' ORDER BY quotes.id';

            // Prepare the query
            $stmt = $this->conn->prepare($query);

            // Bind parameters if author_id is set
            if (!empty($this->author_id)) {
                $stmt->bindParam(':author_id', $this->author_id);
            }

            // Bind parameters if category_id is set
            if (!empty($this->category_id)) {
                $stmt->bindParam(':category_id', $this->category_id);
            }

            // Execute the query
            $stmt->execute();

            return $stmt;
        }
    
        // Get single quote with author and category names
        public function read_single() {
            $query = 'SELECT 
                        quotes.id,
                        quotes.quote,
                        authors.author AS author_name,
                        categories.category AS category_name
                      FROM ' . $this->table . ' 
                      LEFT JOIN authors ON quotes.author_id = authors.id
                      LEFT JOIN categories ON quotes.category_id = categories.id
                      WHERE quotes.id = ? 
                      LIMIT 1';
        
            $stmt = $this->conn->prepare($query);
            
            // Bind the id
            $stmt->bindParam(1, $this->id);
        
            // Execute the query
            $stmt->execute();
        
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($row) {
                $this->quote = $row['quote'];
                $this->author_name = $row['author_name'];
                $this->category_name = $row['category_name'];
                return $this;
            } else {
                return null; // No quote found
            }
        }
    
        // Create quote
        public function create() {
            // Create the query to insert the quote
            $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) 
                      VALUES (:quote, :author_id, :category_id)';
    
            $stmt = $this->conn->prepare($query);
    
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
    
            if ($stmt->execute()) {
                // Fetch the last inserted id
                $this->id = $this->conn->lastInsertId();
                
                // After inserting the quote, return it as JSON
                return array(
                    'id' => $this->id,
                    'quote' => $this->quote,
                    'author_id' => $this->author_id,
                    'category_id' => $this->category_id
                );
            }
            return false;
        }
    
        // Update quote
        public function update() {
            if (!$this->quoteExists()) {
                return array('message' => 'Missing Required Parameters');
            }
    
            // Check if author and category exist before updating
            if (!$this->authorExists()) {
                return array('message' => 'Author does not exist');
            }
    
            if (!$this->categoryExists()) {
                return array('message' => 'Category does not exist');
            }
    
            $query = 'UPDATE ' . $this->table . ' 
                      SET quote = :quote, author_id = :author_id, category_id = :category_id 
                      WHERE id = :id';
    
            $stmt = $this->conn->prepare($query);
    
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);
    
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    
        // Delete quote
        public function delete() {
            if (!$this->quoteExists()) {
                return false; // Quote doesn't exist
            }
    
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
            $stmt = $this->conn->prepare($query);
    
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            $stmt->bindParam(':id', $this->id);
    
            if ($stmt->execute()) {
                return true;
            }
    
            return false;
        }
    }
?>    