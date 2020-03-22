<?php
    require_once'lib/library.php';
    $db = new DB();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['add_user']){
        $db->addNewUser();
        exit;
    }
    $users = $db->getUsers();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>Тестовое задание</title>
</head>
<body>
<div style="max-width: 1170px; margin: 30px auto">
    <button class="add-user" style="margin-bottom: 10px;">Добавить пользователя</button>
    <div class="users-container">
        <?php foreach ($users as $user) : ?>
            <div class="user">
                <?php
                    if(!empty($user['skills'])){
                        $skills = 'Навыки(' . implode(', ', $user['skills']) .')';
                    }else{
                        $skills = '';
                    }
                ?>
                <?=$user['name']?>. Место жительства: <?=$user['city']?>. <?=$skills?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="/js/scripts.js"></script>
</body>
</html>