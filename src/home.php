<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <title>ホーム</title>
</head>
<body>
<div class="m-6 has-text-centered is-family-code has-text-weight-semibold">

<nav class="level  is-mobile">
            <div class="level-left">
            <img src="../img/icon.jpg" width="90vw" style="max-width:'100%'">
                </div>
                <div class="level-item">
                <h1 class="title is-3 ">レシピ編一覧</h1>

                </div>
                
                <div class="level-right">
                <p class="mr-4"><a href="trash.php"><ruby><rb>	<i class="fas fa-trash-alt fa-2x"></i></rb><rp>（</rp><rt>ゴミ箱</rt><rp>）</rp></ruby></a></p>
                <a href="toroku.php"><ruby><rb>	<i class="fas fa-plus-square fa-2x"></i></rb><rp>（</rp><rt>レシピ追加</rt><rp>）</rp></ruby></a></p>
                </div>
        </nav>
            <!--一覧を出すとき、loginでsessionに入れたuser_idをwhereに-->
                   
                     
                    <hr>
                    <?php
                       $pdo = new PDO($connect, USER, PASS);
                    $sql = $pdo->prepare("select * from Recipe where trash=0 ");
                    $sql->execute();
                    echo '<div class="columns  is-multiline">';
                    foreach ($sql as $row) {
                        $id = $row['recipe_id'];
                        echo '<div class="column  is-2 is-one-quarter">
                        <div class="card">
                          <div class="card-image">';

                        echo '<figure class="image is-square">';
                        echo '<a href="detail.php?id=', $id, '"><p class="m-1"><img src="../img/', $row['image'], '" alt="', $row['recipe_name'], '"></p></a></figure></div>';
                        echo ' <div class="card-content"> <div class="content">';
                        echo '<hr><p class="has-text-centered is-size-6"><a href="detail.php?id=', $id, '">', $row['title'], '</a></p>';
                      
                        echo '</div></div></div></div>';
                    }
                    echo '</div>';
                    ?>
                </div>
</div>
</body>
</html>