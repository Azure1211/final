<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>
<?php
echo '<div class="m-6 has-text-centered is-family-code has-text-weight-semibold"> <div class="columns  is-mobile  is-centered">
       
<div class="column">
    <div class=" box has-background-white-bis box-padding-4 ">  <p class="title is-3 "> レシピ更新完了</p>';
$pdo = new PDO($connect, USER, PASS);
$temporary_file = $_FILES['user_file_name']['tmp_name']; # 一時ファイル名
$true_file = $_FILES['user_file_name']['name']; # 本来のファイル名
$id=$_POST['id'];
# is_uploaded_fileメソッドで、一時的にアップロードされたファイルが本当にアップロード処理されたかの確認
if (is_uploaded_file($temporary_file)) {
  echo '<p><img src="../img/', $true_file , '" alt=" "></p>';
  $flag=true;
} else {

    $flag=false;
}

# レシピDB更新
$today = date("Y-m-d");
         if($flag){
    $sql = $pdo->prepare('update Recipe set category_id=?, recipe_name=? ,title=?,image=?,recipe_point=?,Update_date=? where recipe_id=?');
    $sql->execute([
        $_POST['category'], $_POST['recipe_name'], $_POST['title'], $true_file, $_POST['recipe_point'], $today,$id
    ]);
         }else{
            $sql = $pdo->prepare('update Recipe set category_id=?, recipe_name=? ,title=?,recipe_point=?,Update_date=? where recipe_id=?');
            $sql->execute([
                $_POST['category'], $_POST['recipe_name'], $_POST['title'],  $_POST['recipe_point'], $today,$id
            ]);
         }
         echo '<p>タイトル：',$_POST['title'],'</p>';
         echo '<p>レシピ名：', $_POST['recipe_name'],'</p>';
       
    $sql = $pdo->prepare("select * from Meterial where recipe_id = ?");
    $sql->execute([$id]);
    $countmeterial = $sql->rowCount();

#材料DB更新

$material=$_POST['material'];
$countmate = count($material);

//そのrecipe_idの最小のmaterial_idを取得
$sql = $pdo->prepare('select min(meterial_id) from Meterial where recipe_id = ?');
$sql->execute([
 $id
]);
$min1 = $sql->fetch(PDO::FETCH_COLUMN);
$countm=1;

$material_num=$_POST['material_num'];
foreach (array_map(null, $material, $material_num) as [$mate, $matenum]) {
    if($countm> $countmeterial){
        $sql = $pdo->prepare('insert into Meterial values(?,null,?,?)');
        $sql->execute([
         $id,$mate,$matenum
        ]);
     
        $countm++;
}else{
    $sql = $pdo->prepare('update Meterial set meterial=?, meterial_num=? where recipe_id=? and meterial_id=?');
    $sql->execute([
     $mate,$matenum,$id,$min1
    ]);
    $min1++;
    $countm++;
}
}
 while( $countm<=$countmeterial){

    $sql = $pdo->prepare('select max(meterial_id) from Meterial where recipe_id = ?');
$sql->execute([
 $id
]);
$maxmate = $sql->fetch(PDO::FETCH_COLUMN);


    $sql = $pdo->prepare('delete from  Meterial where recipe_id=? and meterial_id=?');
    $sql->execute([$id,$maxmate]);
    $countm++;
 }





 $sql = $pdo->prepare("select * from Cooking_work where recipe_id = ?");
 $sql->execute([$id]);
 $countworks = $sql->rowCount();
 $countw=1;

 $countwork = count($_POST['work']);
//そのrecipe_idの最小のmaterial_idを取得
$sql = $pdo->prepare('select min(cooking_id) from Cooking_work  where recipe_id =?');
$sql->execute([
 $id
]);
$min2 = $sql->fetch(PDO::FETCH_COLUMN);





foreach ($_POST['work']as $work) {
  

    if($countw> $countworks){
        $sql = $pdo->prepare('insert into Cooking_work values(?,null,?)');
            $sql->execute([
                $id,$work
            ]); 
     
        $countw++;
}else{
    $sql = $pdo->prepare('update Cooking_work set cooking=? where recipe_id=? and cooking_id=?');
    $sql->execute([
        $work, $id,$min2
      ]);
      $min2++;
    $countw++;
}
}
 while( $countw<=$countworks){

    $sql = $pdo->prepare('select max(cooking_id) from Cooking_work where recipe_id = ?');
$sql->execute([
 $id
]);
$maxwork = $sql->fetch(PDO::FETCH_COLUMN);


    $sql = $pdo->prepare('delete from  Cooking_work where recipe_id=? and cooking_id=?');
    $sql->execute([$id,$maxwork]);
    $countw++;
 }






   
  
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <title>更新完了画面</title>
</head>
<body>
    <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">
       
       
              
                    <p class=" mb-6"><a href="home.php">ホーム（一覧）へ➝</a></p>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </p>
</body>

</html>