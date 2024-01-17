<?php require 'DB_connect/db-connect.php'; ?>
<?php

$msgName = '';
$msgPass = '';

if (isset($_POST['login'])) {
    unset($_SESSION['User']);
    $pdo = new PDO($connect, USER, PASS);
    $sql = $pdo->prepare('select * from User_info where user_name=?');
    $sql->execute([$_POST['user_name']]);
    $data = $sql->fetchAll();
    if (empty($data)) {
        $msgName = "ユーザーIDが登録されていません";
    } else {
        foreach ($data as $row) {
            if (password_verify($_POST['password'], $row['password']) == true) {
                $_SESSION['User'] = [
                    'user_id' => $row['user_id'],
                    'user_name' => $row['user_name'],
                    'password' => $row['password']
                ];
            } 
              
            
        }
    }

}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <title>ログイン</title>
</head>

<body>

    <form action="login.php" method="post">
        <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
            <p class="title is-3 "> ログイン</p>
            <div class='columns  is-mobile  is-centered'>
                <div class='column is-8'>
                    <div class=" box has-background-white-bis box-padding-4 ">
                        <div class="field">
                            <div class="control m-1">
                                <label class="label is-size-6 m-4">ユーザーID</label>
                                <div class="field  has-addons-centered">

                                    <input class="input is-normal " type="text" name="user_name" placeholder="🙍" style="width: 615px;" required>
                                    <p class="m-3 has-text-danger-dark"><?= $msgName ?></p>
                                </div>
                            </div>

                            <div class="control m-1">
                                <label class="label is-size-6 m-4">パスワード</label>
                                <div class=" has-addons-centered">
                                    <input type="password" class="input  is-normal  " name="password" placeholder="🔐" style="width: 615px;" required>
                                    <p class="m-3 has-text-danger-dark"><?= $msgPass?></p>
                                </div>
                            </div>
                        </div>
                      
                                <button type="submit" class="button   mx-4 mt-4" name="login" value="send">ログイン</button>

                        <p class=" mt-5 mb-4 "><a href="toroku.php">新規登録はこちら</a></p>
                      
    </form>
    </div>
    </div>
    </div>
    </div>
</body>

</html>