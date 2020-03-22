<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'ca27777_test');
define('DB_USER', 'ca27777_test');
define('DB_PASS', 'H6gx4Gdk5Xm');
define('DB_CHARSET', 'utf8');

class DB{

    protected $pdo;

    //Подключение к базе данных
    public function __construct(){
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }

    //Получение списка все пользователей
    public function getUsers(){
        $stmt = $this->pdo->prepare('SELECT u.id, u.name, c.name as city FROM Users u LEFT JOIN City c ON (u.city_id = c.id) ORDER BY id DESC');
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $key => $user){
            $users[$key]['skills'] = $this->getUserSkills($user['id']);
        }
        return $users;
    }

    //Получение навыков пользователя
    public function getUserSkills($user_id){
        $data = array(
            'user_id' => $user_id,
        );
        $stmt = $this->pdo->prepare('SELECT s.name FROM Skills s LEFT JOIN Users_skills us ON (s.id = us.skill_id) WHERE us.user_id = :user_id');
        $stmt->execute($data);
        $skills = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $skills;
    }

    //Добавление нового пользователя
    public function addNewUser(){
        $data = array(
            'city_id' => $this->getRandomCity(),
            'name' => $this->getRandomName(),
        );
        $stmt = $this->pdo->prepare('INSERT INTO Users (name, city_id) VALUES (:name, :city_id)');
        $stmt->execute($data);
        $user_id = $this->pdo->lastInsertId();
        if($user_id > 0){
            $this->addRandomSkills($user_id);
        }
    }

    //Получение рандомного имени
    public function getRandomName(){
        $stmt = $this->pdo->prepare('SELECT name FROM Names ORDER BY RAND() LIMIT 1');
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['name'];
    }

    //Добавление произвольных навыков
    public function addRandomSkills($user_id){
        $stmt = $this->pdo->prepare('SELECT id FROM Skills ORDER BY RAND() LIMIT ' . rand(0,5));
        $stmt->execute();
        $skills = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if(!empty($skills)){
            foreach ($skills as $skill){
                $data = array(
                    'user_id' => $user_id,
                    'skill_id' => $skill['id'],
                );
                $stmt = $this->pdo->prepare('INSERT INTO Users_skills (user_id, skill_id) VALUES (:user_id, :skill_id)');
                $stmt->execute($data);
            }
        }
    }

    //Получение рандомного города
    public function getRandomCity(){
        $stmt = $this->pdo->prepare('SELECT id FROM City ORDER BY RAND() LIMIT 1');
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['id'];
    }

}