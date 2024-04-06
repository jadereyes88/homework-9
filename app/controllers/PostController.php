<?php

namespace app\controllers;

use app\models\Post;

class PostController
{
    public function validatePost($inputData) {
        $errors = [];
        $title = $inputData['title'];
        $description = $inputData['description'];

        if ($title) {
            $title = htmlspecialchars($title, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($title) < 2) {
                $errors['titleShort'] = 'title is too short';
            }
        } else {
            $errors['titleRequired'] = 'title is required';
        }

        if ($description) {
            $description = htmlspecialchars($description, ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
            if (strlen($description) < 2) {
                $errors['descriptionShort'] = 'description is too short';
            }
        } else {
            $errors['descriptionRequired'] = 'description is required';
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }
        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    public function getPosts($id = null) {
        header("Content-Type: application/json");
        $postModel = new Post(); 
        if ($id) {
            $post = $postModel->findById($id);
            echo json_encode($post);
        } else {
            $posts = $postModel->findAll();
            echo json_encode($posts);
        }
    
        exit();
    }
    

    public function savePost() {
        $inputData = [
            'title' => $_POST['title'] ?? false,
            'description' => $_POST['description'] ?? false,
        ];
        $postData = $this->validatePost($inputData);
    
        $postModel = new Post();
        $postModel->save($postData); 
    
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }

    public function updatePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }
    
        // Parse the input data
        parse_str(file_get_contents('php://input'), $_PUT);
    
        $inputData = [
            'title' => $_PUT['title'] ?? false,
            'description' => $_PUT['description'] ?? false,
        ];
        // Validate and sanitize the input data
        $postData = $this->validatePost($inputData);
    
        // Include the ID in $postData to indicate an update operation
        $postData['id'] = $id;
    
        $postModel = new Post();
        // Use the save method for both creating and updating
        $result = $postModel->save($postData);
    
        if ($result) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Post updated successfully']);
        } else {
            // Handle failure (e.g., invalid input, database error)
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update post']);
        }
        exit();
    }
    
    public function deletePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }
    
        $postModel = new Post();
        $postModel->delete($id);
    
        http_response_code(200);
        echo json_encode(['success' => true]);
        exit();
    }
    

    public function postsView() {
        include '../public/assets/views/post/posts-view.html';
        exit();
    }

    public function postsAddView() {
        include '../public/assets/views/post/posts-add.html';
        exit();
    }

    public function postsDeleteView() {
        include '../public/assets/views/post/posts-delete.html';
        exit();
    }

    public function postsUpdateView() {
        include '../public/assets/views/post/posts-update.html';
        exit();
    }


}
