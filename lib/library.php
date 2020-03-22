<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'ca27777_test');
define('DB_USER', 'ca27777_test');
define('DB_PASS', 'H6gx4Gdk5Xm');
define('DB_CHARSET', 'utf8');

class DB{

    protected $pdo;

    public function __construct(){
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
    }

    public function getUsers(){
        $stmt = $this->pdo->prepare('SELECT u.id, u.name, c.name as city FROM Users u LEFT JOIN City c ON (u.city_id = c.id)');
        $stmt->execute();
        $users = $stmt->fetchAll();
        foreach ($users as $key => $user){
            $users[$key]['skills'] = $this->getUserSkills($user['id']);
        }
        return $users;
    }

    public function getUserSkills($user_id){
        $data = array(
            'user_id' => $user_id,
        );
        $stmt = $this->pdo->prepare('SELECT s.name FROM Skills s LEFT JOIN Users_skills us ON (s.id = us.skill_id) WHERE us.user_id = :user_id');
        $stmt->execute($data);
        $skills = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $skills;
    }

}