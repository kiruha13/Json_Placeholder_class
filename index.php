<?php

class JsonPlaceholderAPI
{
    private $baseURL = "https://jsonplaceholder.typicode.com";

    // Метод для выполнения запроса к API
    private function makeRequest($url, $method = "GET", $data = null)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($method == "POST") {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } elseif ($method == "PUT") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } elseif ($method == "DELETE") {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    // Метод для получения списка пользователей
    public function getUsers()
    {
        $url = $this->baseURL . "/users";
        return $this->makeRequest($url);
    }

    // Метод для получения постов пользователя по идентификатору пользователя
    public function getUserPosts($userId)
    {
        $url = $this->baseURL . "/posts?userId=" . $userId;
        return $this->makeRequest($url);
    }

    // Метод для получения списка заданий
    public function getTodos()
    {
        $url = $this->baseURL . "/todos";
        return $this->makeRequest($url);
    }

    // Метод для добавления нового поста
    public function addPost($userId, $title, $body)
    {
        $url = $this->baseURL . "/posts";

        $data = array(
            "userId" => $userId,
            "title" => $title,
            "body" => $body
        );

        return $this->makeRequest($url, "POST", $data);
    }

    // Метод для редактирования поста по идентификатору поста
    public function editPost($postId, $title, $body)
    {
        $url = $this->baseURL . "/posts/" . $postId;

        $data = array(
            "title" => $title,
            "body" => $body
        );

        return $this->makeRequest($url, "PUT", $data);
    }

    // Метод для удаления поста по идентификатору поста
    public function deletePost($postId)
    {
        $url = $this->baseURL . "/posts/" . $postId;
        return $this->makeRequest($url, "DELETE");
    }
}

// Пример использования класса
$jsonPlaceholderAPI = new JsonPlaceholderAPI();

// Получение списка пользователей
$users = $jsonPlaceholderAPI->getUsers();
var_dump($users);

// Получение постов пользователя по идентификатору пользователя (например, пользователя с id = 1)
$userPosts = $jsonPlaceholderAPI->getUserPosts(1);
var_dump($userPosts);

// Получение списка заданий
$todos = $jsonPlaceholderAPI->getTodos();
var_dump($todos);

// Добавление нового поста
$newPost = $jsonPlaceholderAPI->addPost(1, "New Post", "This is a new post.");
var_dump($newPost);

// Редактирование поста по идентификатору поста (например, поста с id = 1)
$editedPost = $jsonPlaceholderAPI->editPost(1, "Updated Post", "This post has been updated.");
var_dump($editedPost);

// Удаление поста по идентификатору поста (например, поста с id = 1)
$deletedPost = $jsonPlaceholderAPI->deletePost(1);
var_dump($deletedPost);

