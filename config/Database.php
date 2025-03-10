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
    $this->port = getenv('PORT');
  }

echo 'DB_HOST: ' . getenv('HOST') . '<br>';
echo 'DB_PORT: ' . getenv('PORT') . '<br>';
echo 'DB_USERNAME: ' . getenv('USERNAME') . '<br>';
echo 'DB_PASSWORD: ' . getenv('PASSWORD') . '<br>';
echo 'DB_NAME: ' . getenv('DBNAME') . '<br>';

  // DB Connect
  public function connect() {
    if ($this->conn){
      return $this->conn;
    } else {

      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";

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
