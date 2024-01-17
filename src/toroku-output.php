<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>
<!--デザインだけ-->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <title>レシピ新規登録</title>
</head>
  <body>
  <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
  <nav class="level  is-mobile">
            <div class="level-left">
        
                </div>
                <div class="level-item">
                <h1 class="title is-3 ">レシピ登録完了</h1>

                </div>
                
                <div class="level-right">
                
                </div>
        </nav>
    <p>以下の内容で登録しました。</p>
<?php


$pdo = new PDO($connect, USER, PASS);

$temporary_file = $_FILES['user_file_name']['tmp_name']; # 一時ファイル名
$true_file = $_FILES['user_file_name']['name']; # 本来のファイル名

# is_uploaded_fileメソッドで、一時的にアップロードされたファイルが本当にアップロード処理されたかの確認
if (is_uploaded_file($temporary_file)) {
  echo '<p><img src="../img/', $true_file , '" alt=" "></p>';
  
} else {
    echo "ファイルが選択されていません。";
}

# レシピDBに登録
$today = date("Y-m-d");
         
    $sql = $pdo->prepare('insert into Recipe values (null,?,?,?,?,?,?,null,null,0)');
    $sql->execute([
        $_POST['category'], $_POST['recipe_name'], $_POST['title'], $true_file, $_POST['recipe_point'], $today
    ]);
    echo '<p>タイトル：',$_POST['title'],'</p>';
    echo '<p>レシピ名：', $_POST['recipe_name'],'</p>';
  

    $sql = $pdo->query('select max(recipe_id) from Recipe');
    $max = $sql->fetch(PDO::FETCH_COLUMN);
  
  
#材料DBに登録
$countmeterial=1;
$material=$_POST['material'];
$material_num=$_POST['material_num'];
foreach (array_map(null, $material, $material_num) as [$mate, $matenum]) {

  $sql = $pdo->prepare('insert into Meterial values(?,null,?,?)');
  $sql->execute([
   $max,$mate,$matenum
  ]);
  $countmeterial++;
}

#料理作業DBに追加
foreach ($_POST['work']as $work) {
  
  $sql = $pdo->prepare('insert into Cooking_work values(?,null,?)');
  $sql->execute([
    $max,$work
  ]);

}
   
  
?>
  <button class="button mt-3 " type="button" onclick="location.href='home.php'">ホーム（一覧）に戻る</button>
</div>
 </body>
</html>


