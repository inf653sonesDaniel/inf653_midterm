<?php

  class Database {
    // DB Params (use environment variables)
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct(){
      $this->username = getenv('USERNAME');
      $this->password = getenv('PASSWORD');
      $this->db_name = getenv('DBNAME');
      $this->host = getenv('HOST');
      # port variable needed for local testing
      #$this->port = getenv('PORT');
    }

    // DB Connect
    public function connect() {
      if ($this->conn){
        return $this->conn;
      } else {

        $dsn = "pgsql:host={$this->host};port=5432;dbname={$this->db_name};sslmode=require";

        try {
          $this->conn = new PDO($dsn, $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->conn;
        } catch(PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }
      }
    }
  }
?>