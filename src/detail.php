<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'?>

<?php
    
    $id = $_GET['id'];
    
    $link=$_SERVER['HTTP_REFERER'] ;
  
   
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
<nav class="level  is-mobile">
            <div class="level-left">
                <?php
                 $flag=0;
                  if(strpos($link,'home')  !== false){ 

                   
                    echo ' <a href="home.php" ><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x" ></i></rb><rp>（</rp><rt>ホーム（一覧）</rt><rp>）</rp></ruby></a>';
                    
                    $flag=0;
                }else if(strpos($link,'trash')  !== false){
            
                     
                      echo '<a href="#" onclick="history.back()"><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x" ></i></rb><rp>（</rp><rt>ゴミ箱</rt><rp>）</rp></ruby></a>';
                      $flag=1;
                }else if(strpos($link,'update')  !== false){
            
                     
                    echo '<a href="home.php" ><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x" ></i></rb><rp>（</rp><rt>ホーム（一覧）</rt><rp>）</rp></ruby></a>';
                    $flag=1;
              }
              
              
                echo '</div>
                <div class="level-item">
                    <h1 class="title is-3">レシピ詳細</h1>
                </div>';
             
             

                echo '<div class="level-right">';
                if($flag){ 
                    echo '<a href="Delete-comp.php?id=',$id,'&de=0"><ruby><rb><i class="fas fa-trash-restore fa-2x"></i></rb><rp>（（</rp><rt>元に戻す</rt><rp>）</rp></ruby></a>';
                 
                }else{
                    echo '<a href="update.php?id=',$id,'"><ruby><rb><i class="fas fa-pencil-alt fa-2x"></i></rb><rp>（（</rp><rt>編集</rt><rp>）</rp></ruby></a>';
                }
                ?>
                </div>
        </nav>

<hr>
    <div class="main">
 <?php   
 
        $pdo=new PDO($connect,USER,PASS);
            $sql=$pdo->prepare("select Re.recipe_id,Re.category_id,Re.recipe_name,Re.title,Re.image,Re.recipe_point,Re.Regist_date,Re.Update_date,
                                    Me.recipe_id,Me.meterial_id,Me.meterial,Me.meterial_num,
                                        Co.recipe_id,Co.cooking_id,cooking
                                from Recipe as Re ,Meterial as Me,Cooking_work as Co
                                    where Re.recipe_id = ? and
                                    Re.recipe_id = Me.recipe_id and
                                    Re.recipe_id = Co.recipe_id
                                    group by Re.recipe_id
                                ");
            $sql->execute([$id]);        
              
              
            foreach($sql as $row){
           
                echo '<img src="../img/' ,$row['image'], '"  border="1" width="500vw">';

                echo '<p class="is-size-5 m-3">',$row['title'],'</p>';

                echo '<p class="m-3"><label class=" title  is-5 has-text-weight-bold">-レシピ名-  </label></p><label class="has-text-danger-dark">',$row['recipe_name'],'</label><br>';

                echo '<p class="m-3"><label class=" title  is-5 has-text-weight-bold">-レシピのポイント- </label></p><label class="has-text-warning-dark">',$row['recipe_point'],'</label><br>';

                $_SESSION['Recipe']['recipe_id']=$row['recipe_id'];

            }

        //編集完了後、RecipeSESSIONをunset
        echo '<p class="m-3"><label class=" title  is-5 has-text-weight-bold">-材料-  </label></p>';
        $countmate=0; 
        $sql=$pdo->prepare("select Me.recipe_id,Me.meterial_id,Me.meterial,Me.meterial_num
                                    from Meterial as Me
                                    where Me.recipe_id = ?
                                ");
            $sql->execute([$id]);        
            echo '<div class="box  has-text-centered ">';
            foreach($sql as $row){
                $countmate++;
                echo '<p class="m-4"><label class="has-text-link-dark">',$countmate,':</label>';
                echo $row['meterial'],' : ';
                echo $row['meterial_num'],'</p>';
            }
            echo '</div>';

            echo '<p class="m-3"><label class=" title  is-5 has-text-weight-bold">-作り方-  </label></p>';
            echo '<div class="box  has-text-centered ">';
            $sql=$pdo->prepare("select Co.recipe_id,Co.cooking_id,cooking
                                from Cooking_work as Co
                                    where Co.recipe_id= ? 
                                ");
            $sql->execute([$id]);       
            $count=0; 
            
            foreach($sql as $row){
                $count++;
                echo '<p class="m-4"><label class="has-text-success-dark">',$count,':</label>',$row['cooking'],'</p>';

            }
            echo '</div>';
            if($flag){ 
               
                echo '<a href="Delete-comp.php?id=',$id,'&de=1">完全に削除する</a>';
            }


?>
</div>
    </div>

        
        
</body>
</html>
