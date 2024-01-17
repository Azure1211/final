<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>
<?php
    
    $id = $_GET['id'];
  $_SEESION['id']=$id;
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
                 $image=$row['image'];

                $title=$row['title'];

                $category =$row['category_id'];

                $recipe_name=$row['recipe_name'];

                $recipe_point=$row['recipe_point'];
                
       
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <title>レシピ新規登録</title>
</head>
<body>
    <div id="app">
    <form enctype="multipart/form-data"  action="updatecomp.php" method="POST">
        <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">

        
<nav class="level  is-mobile">
            <div class="level-left">
                <?php
                  $link=$_SERVER['HTTP_REFERER'] ;

                  if(strpos($link,'detail')  !== false){ 

                   
                        echo '<a href="' ,$link,'"><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x"></i></rb><rp>（</rp><rt>商品詳細</rt><rp>）</rp></ruby></a>';
                        
                        $flag=0;
                    }else if(strpos($link,'update')  !== false){
                
                         
                          echo '<a href="#" onclick="' ,$link,'id=',$id,'"><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x" ></i></rb><rp>（</rp><rt>ゴミ箱</rt><rp>）</rp></ruby></a>';
                          $flag=1;
                    }
                  
         
            ?>
                </div>
                <div class="level-item">
                <h1 class="title is-3">レシピ編集</h1>
                </div>
                
                <div class="level-right">
             <?php  echo ' <p class="mr-4"><a href="delete.php?id=',$id,'"><ruby><rb>	<i class="fas fa-trash-alt fa-2x"></i></rb><rp>（</rp><rt>ゴミ箱に入れる</rt><rp>）</rp></ruby></a></p>  '; ?>   
                </div>
        </nav>
        <hr>
                <?php echo ' <input type="hidden" name="id" value=',$id,'>'; ?>
                <div class='columns  is-mobile  is-centered'> 
                <div class='column is-8'> 
                <div class=" box has-background-white-bis box-padding-4 ">
                <div class="field">
        
                <div class="control m-1">
                        <label class="label is-size-6 m-5"> 料理画像 </label>

                            
                   <p>現在の画像</p>
                   <?php echo '<p><img src="../img/', $image , '" alt=" "></p><br>';
                       echo  '<input type="hidden" name="name" value="value" />';
                       echo   '<input name="user_file_name" type="file"/>(現：',$image,')' ;?>
                               

                              
                </div>
              
                <div class="control m-1">
                        <label class="label is-size-6 m-5">タイトル</label>
                        <div class="field has-addons-centered">
                            <?php    echo '<input type="text"  class="input is-normal " name="title"  value= ',$title,'  style="width: 515px;" required/>' ?>
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">カテゴリー</label>
                        <div class="field  has-addons-centered">
                                <select class="input  is-normal " style="width: 515px;" name="category" required>
                                <option value=0>クリックで選択</option>
                        <?php
                                $pdo = new PDO($connect, USER, PASS);
                                $sql = $pdo->prepare('select  * from Category');
                                $sql->execute();
                                foreach ($sql as $row) {
                                        if(  $category ==$row['category_id']){
                                                echo '<option value=',$row['category_id'],' selected>',$row['category_name'],'</option>';
                                        }else{
                                        echo '<option value=',$row['category_id'],'>',$row['category_name'],'</option>';
                                        }
                                }
                                ?>
                                </select>
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">レシピ名</label>
                        <div class="field  has-addons-centered">
                             <?php  echo '<input type="text"  class="input  is-normal " name="recipe_name"  value=', $recipe_name,' style="width: 515px;" required  />  '       ?>   
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">作り方</label><!--ボタンを押すとフォームが増える-->
                        <div class="field  has-addons-centered">
                        <div id="input_pluralBox">
                      
                    <?php
                        $sql = $pdo->prepare('select *  from Cooking_work where recipe_id=?');
                        $sql->execute([$id]);
                        foreach ($sql as $row) {
                  
                                echo '<div id="input_plural">
                                <input type="text" class="input  is-normal mb-3 " value= "',$row['cooking'],'" name="work[]"  style="width: 700px;" required>
                                <input type="button" value="＋" class="add pluralBtn ">
                                <input type="button" value="－" class="del pluralBtn">
                                </div>';
                              }
                    ?>
                      
        
                               
                            
                      
                        </div>
                   

                       
                        </div>
                </div>

             
    

       
          

                <div class="control m-1">
                        <label class="label is-size-6 m-5">レシピのポイント</label>
                        <div class="field has-addons-centered">                
                               <?php echo '<input type="text" class="input  is-normal  " name="recipe_point"value=', $recipe_point,' style="width: 515px;" required />';?>
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">材料</label><!--ボタンを押すとフォームが増える-->
                        <div id="input_pluralBox2">

                        <?php
                        $sql = $pdo->prepare('select *  from Meterial where recipe_id=?');
                        $sql->execute([$id]);
                        foreach ($sql as $row) {
                  
                                echo '<div id="input_plural2">
                                
                                <input type="text" class="input  is-normal mb-3 "  value="',$row['meterial'],'"name="material[]"  style="width: 265px;" required>
                                <input type="text" class="input  is-normal mb-3 " value="',$row['meterial_num'],'" name="material_num[]"  style="width: 140px; " required>
                                <input type="button" value="＋" class="add1 pluralBtn ">
                                <input type="button" value="－" class="del pluralBtn">

                                </div>';
                              }
                    ?>
                        
                        
                        </div>
                </div>

        </div>
        <input  type="submit" class="button mt-3 mb-5"  value="レシピを更新">
        </form>

      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script type="text/javascript">
                $(document).on("click", ".add", function() {
                $(this).parent().clone(true).insertAfter($(this).parent());
                });
                $(document).on("click", ".del", function() {
                var target = $(this).parent();
                if (target.parent().children().length > 1) {
                        target.remove();
                }
                });

                $(document).on("click", ".add1", function() {
                $(this).parent().clone(true).insertAfter($(this).parent());
                });
                $(document).on("click", ".del", function() {
                var target = $(this).parent();
                if (target.parent().children().length > 1) {
                        target.remove();
                }
                });


                </script>
                      <style>

                        #input_plural input.pluralBtn {
                        width: 40px;
                        height: 40px;
                        border: 1px solid #ccc;
                        background: #fff;
                        border-radius: 5px;
                        padding: 0;
                        margin: 0;
                        }

                        #input_plural2 input.pluralBtn {
                        width: 40px;
                        height: 40px;
                        border: 1px solid #ccc;
                        background: #fff;
                        border-radius: 5px;
                        padding: 0;
                        margin: 0;
                        }
                      </style> 
</body>
</html>

