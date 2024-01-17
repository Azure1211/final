<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>
<?php
    
    $id = $_GET['id'];
    
    $de = $_GET['de'];

    $pdo=new PDO($connect,USER,PASS);
    
    if($de==0){
        
    $sql = $pdo->prepare('update Recipe set trash=0 where recipe_id=?');
    $sql->execute([$id]);
    echo ' <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
    <div class=" box has-background-white-bis box-padding-4 ">
                    <div class="field">  <p class="title is-4">元に戻しました </p><p> <a href="home.php">ホームに戻る</a></p></div></div></div>';
    }else{

    $sql = $pdo->prepare('delete from  Recipe  where recipe_id=?');
    $sql->execute([$id]);

    $sql = $pdo->prepare('delete from  Cooking_work  where recipe_id=?');
    $sql->execute([$id]);

    $sql = $pdo->prepare('delete from  Meterial  where recipe_id=?');
    $sql->execute([$id]);
    echo '<div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
    <div class=" box has-background-white-bis box-padding-4 ">
                    <div class="field">  <p class="title is-4">完全に削除しました </p>  <p><a href="home.php">ホームに戻る</a></p></div></div></div>';
    }
    ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="css/main.css">
   
    <title>レシピ詳細画面</title>
</head>
<body>
        <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
        
       

            </div>

        
        
</body>
</html>


    