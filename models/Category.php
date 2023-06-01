<?php
    class Category {
        private $conn;
        private $table = 'categories';

        // Properties
        public $id;
        public $name;
        public $created_at;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        public function read() {
            $query = 'SELECT id, name, created_at FROM ' . $this->table . ' ORDER BY created at';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        public function read_single() {
            $query = 'SELECT id, name, created_at FROM ' . $this->table . ' WHERE id = ? LIMIT 0, 1';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
            $this->created_at = $row['created_at'];            

        }

        public function create() {
            $query = 'INSERT INTO ' . $this->table . ' SET name = :name';

            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':name', $this->name);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function update() {
            $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->id);

            if ($stmt->execute()) {
                return true;
            }

            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        public function delete() {
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(':id', $this->id);

            if ($stmt->execute()) {
                return true;
            }
            
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }


?>