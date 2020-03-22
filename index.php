<?php
    require_once'lib/library.php';
    $db = new DB();
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
    <button class="add-user" style="margin-top: 10px;">Добавить пользователя</button>
</div>
</body>
</html>