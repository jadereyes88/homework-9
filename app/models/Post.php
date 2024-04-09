<?php

namespace app\models;
require_once '/Users/jadereyes82/homework-9/app/core/config.php'; 


class Post {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new \PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection error: " . $e->getMessage();
            exit;
        }
    }

    // Method to create a new post
    public function create($title, $description) {
        try {
            $sql = "INSERT INTO posts (title, description) VALUES (:title, :description)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            return $this->conn->lastInsertId(); // Return the ID of the new post
        } catch (PDOException $e) {
            echo "Error creating post: " . $e->getMessage();
            return false;
        }
    }
    

    public function findById($id) {
        $sql = "SELECT * FROM posts WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result : null; // Return the post or null if not found
        } catch (PDOException $e) {
            echo "Error finding post by ID: " . $e->getMessage();
            return null;
        }
    }
    
    public function findAll() {
        $sql = "SELECT * FROM posts ORDER BY title ASC";
        try {
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result; // Return all posts
        } catch (PDOException $e) {
            echo "Error finding all posts: " . $e->getMessage();
            return [];
        }
    }


    public function save($postData) {
        // Check if an ID is set in $postData to determine if we're updating or creating a new post
        if (isset($postData['id']) && !empty($postData['id'])) {
            // Update existing post
            $sql = "UPDATE posts SET title = :title, description = :description WHERE id = :id";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $postData['title']);
                $stmt->bindParam(':description', $postData['description']);
                $stmt->bindParam(':id', $postData['id'], PDO::PARAM_INT);
                $stmt->execute();
                return $postData['id']; // Return the updated post's ID
            } catch (PDOException $e) {
                echo "Error updating post: " . $e->getMessage();
                return false;
            }
        } else {
            // Create new post
            $sql = "INSERT INTO posts (title, description) VALUES (:title, :description)";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':title', $postData['title']);
                $stmt->bindParam(':description', $postData['description']);
                $stmt->execute();
                return $this->conn->lastInsertId(); // Return the new post's ID
            } catch (PDOException $e) {
                echo "Error creating post: " . $e->getMessage();
                return false;
            }
        }
    }
    
    public function delete($id) {
        try {
            $sql = "DELETE FROM posts WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            // Bind the ID to the placeholder in the SQL statement
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            // Execute the statement and return true if successful
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error deleting post: " . $e->getMessage();
            return false;
        }
    }
    
    
}

