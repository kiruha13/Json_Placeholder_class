<?php
/*
Написать класс для работы с API https://jsonplaceholder.typicode.com
Сделать методы для получения пользователей, их постов и заданий.
Добавить метод работы с конкретным постом (добавление / редактирование / удаление)
*/
class JsonPlaceholderAPI
{
    private string $sampleURL = "https://jsonplaceholder.typicode.com";

    // Метод для выполнения запроса к API
    private function makeRequest($url, $method = "GET", $data = null)
    {
        $curl = curl_init();
        //Т.к. работа идет на локальном сервере - запретить cURL проверять сертификат.
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //для возврата передачи в виде строки возвращаемого значения функции
        // curl_exec() вместо ее непосредственного вывода.
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
        //echo curl_getinfo($curl);
        curl_close($curl);
        //return $response;
        return json_decode($response, true);
    }

    // Метод для получения списка пользователей
    public function getUsers()
    {
        $url = $this->sampleURL . "/users";
        return $this->makeRequest($url);
    }

    // Метод для получения постов пользователя по идентификатору пользователя
    public function getUserPosts($userId)
    {
        $url = $this->sampleURL . "/posts?userId=" . $userId;
        return $this->makeRequest($url);
    }

    // Метод для получения списка заданий
    public function getTasks()
    {
        $url = $this->sampleURL . "/todos";
        return $this->makeRequest($url);
    }

    // Метод для добавления нового поста
    public function addPost($userId, $title, $body)
    {
        $url = $this->sampleURL . "/posts";

        $data = array(
            "userId" => $userId,
            "title" => $title,
            "body" => $body
        );

        $jsonData = json_encode($data);

        return $this->makeRequest($url, "POST", $jsonData);
    }

    // Метод для редактирования поста по идентификатору поста
    public function editPost($postId, $title, $body)
    {
        $url = $this->sampleURL . "/posts/" . $postId;

        $data = array(
            "title" => $title,
            "body" => $body
        );

        $jsonData = json_encode($data);

        return $this->makeRequest($url, "PUT", $jsonData);
    }

    // Метод для удаления поста по идентификатору поста
    public function deletePost($postId)
    {
        $url = $this->sampleURL . "/posts/" . $postId;
        return $this->makeRequest($url, "DELETE");
    }
}

// Пример использования класса
$result = new JsonPlaceholderAPI();

// Получение списка пользователей
$users = $result->getUsers();
var_dump($users);

// Получение постов пользователя по идентификатору пользователя (например, пользователя с id = 1)
$userPosts = $result->getUserPosts(1);
var_dump($userPosts);

// Получение списка заданий
$todos = $result->getTasks();
var_dump($todos);

// Добавление нового поста
$newPost = $result->addPost(1, "New Post", "This is a new post.");
var_dump($newPost);

// Редактирование поста по идентификатору поста (например, поста с id = 1)
$editedPost = $result->editPost(1, "Updated Post", "This post has been updated.");
var_dump($editedPost);

// Удаление поста по идентификатору поста (например, поста с id = 1)
$deletedPost = $result->deletePost(1);
var_dump($deletedPost);

