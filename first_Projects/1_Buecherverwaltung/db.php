<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database {
    private $conn;
    private $db_type;
    private $error = '';
    
    public function __construct($db_type = 'mysql') {
        $this->db_type = $db_type;
        $this->connect();
        $this->handleRequests();
    }
    
    private function connect() {
        if ($this->db_type === 'mysql') {
            $this->conn = new mysqli('localhost', 'root', '', 'bücherverwaltung_gst_scheme');
            if ($this->conn->connect_error) {
                die("MySQL Connection failed: " . $this->conn->connect_error);
            }
        } else {
            $this->conn = pg_connect("host=localhost port=5432 dbname=book_management user=wifiUser password=wifi");
            if (!$this->conn) {
                die("PostgreSQL Connection failed: " . pg_last_error());
            }
        }
    }
    
    private function handleRequests() {
        if (isset($_GET['delete'])) {
            $this->handleBookOperation('delete', $_GET['delete']);
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
            $this->handleBookOperation('insert', $_POST);
        }
    }
    
    private function handleBookOperation($operation, $data) {
        if ($operation === 'delete') {
            if ($this->deleteBook($data)) {
                header("Location: " . str_replace('?delete=' . $data, '', $_SERVER['REQUEST_URI']));
                exit();
            } else {
                $this->error = "Error deleting book.";
            }
        } elseif ($operation === 'insert') {
            $title = $data["title"] ?? '';
            $author = $data["author"] ?? '';
            $genre = $data["genre"] ?? '';
            $isbn_number = $data["isbn_number"] ?? '';
            
            if ($this->insertBook($title, $author, $genre, $isbn_number)) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $this->error = "Error inserting book.";
            }
        }
    }
    
    private function executeQuery($operation, $data = []) {
        $config = $this->getDbConfig();
        
        switch($operation) {
            case 'delete':
                $isbn_clean = $this->escape($data);
                $sql = "DELETE FROM {$config['table']} WHERE {$config['isbn_column']} = '$isbn_clean'";
                break;
                
            case 'insert':
                $title_clean = $this->escape($data['title']);
                $author_clean = $this->escape($data['author']);
                $genre_clean = $this->escape($data['genre']);
                $isbn_clean = $this->escape($data['isbn']);
                
                if ($this->db_type === 'mysql') {
                    $sql = "INSERT INTO {$config['table']} (buchtitel, autor, genre, `isbn-nummer`) 
                            VALUES ('$title_clean', '$author_clean', '$genre_clean', '$isbn_clean')";
                } else {
                    $sql = "INSERT INTO {$config['table']} (title, author, genre, isbn_number) 
                            VALUES ('$title_clean', '$author_clean', '$genre_clean', '$isbn_clean')";
                }
                break;
                
            case 'select':
                if ($this->db_type === 'mysql') {
                    $sql = "SELECT buchtitel, autor, genre, `isbn-nummer` FROM {$config['table']}";
                } else {
                    $sql = "SELECT title, author, genre, isbn_number FROM {$config['table']} ORDER BY book_id";
                }
                break;
        }
        
        return $this->query($sql);
    }
    
    private function getDbConfig() {
        if ($this->db_type === 'mysql') {
            return [
                'table' => 'bücher',
                'isbn_column' => '`isbn-nummer`'
            ];
        } else {
            return [
                'table' => 'library.book',
                'isbn_column' => 'isbn_number'
            ];
        }
    }
    
    public function deleteBook($isbn) {
        $result = $this->executeQuery('delete', $isbn);
        return $result ? true : false;
    }
    
    public function insertBook($title, $author, $genre, $isbn) {
        $result = $this->executeQuery('insert', [
            'title' => $title,
            'author' => $author,
            'genre' => $genre,
            'isbn' => $isbn
        ]);
        return $result ? true : false;
    }
    
    public function getAllBooks() {
        $result = $this->executeQuery('select');
        if (!$result) return [];
        
        $books = [];
        if ($this->db_type === 'mysql') {
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
        } else {
            while ($row = pg_fetch_assoc($result)) {
                $books[] = $row;
            }
        }
        return $books;
    }
    
    public function getError() {
        return $this->error;
    }
    
    private function escape($value) {
        if ($this->db_type === 'mysql') {
            return $this->conn->real_escape_string($value);
        } else {
            return pg_escape_string($this->conn, $value);
        }
    }
    
    private function query($sql) {
        if ($this->db_type === 'mysql') {
            return $this->conn->query($sql);
        } else {
            return pg_query($this->conn, $sql);
        }
    }
    
    public function close() {
        if ($this->db_type === 'mysql') {
            $this->conn->close();
        } else {
            pg_close($this->conn);
        }
    }
    
    // Combined debug and info method
    public function getDebugInfo() {
        $config = $this->getDbConfig();
        $info = "Database: {$this->db_type}, Table: {$config['table']}\n";
        
        if ($this->db_type === 'mysql') {
            $result = $this->query("SHOW TABLES");
            $tables = [];
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            $info .= "Available tables: " . implode(', ', $tables);
        } else {
            $result = $this->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'library'");
            $tables = [];
            while ($row = pg_fetch_assoc($result)) {
                $tables[] = $row['table_name'];
            }
            $info .= "Available tables in 'library' schema: " . implode(', ', $tables);
        }
        
        return $info;
    }
}
?>