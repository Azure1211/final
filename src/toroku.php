<?php session_start(); ?>
<?php require 'DB_connect/db-connect.php'; ?>
<!--完成-->
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
    <form enctype="multipart/form-data"  action="toroku-output.php" method="POST">
        <div class="m-6 has-text-centered is-family-code has-text-weight-semibold">

        
<nav class="level  is-mobile">
            <div class="level-left">
            <a href="home.php"><ruby><rb><i class="fas fa-long-arrow-alt-left fa-2x" ></i></rb><rp>（（</rp><rt>一覧</rt><rp>）</rp></ruby></a>
                </div>
                <div class="level-item">
                <h1 class="title is-3">レシピ新規登録</h1>
                </div>
                
                <div class="level-right">
                </div>
        </nav>
        <hr>
                <div class='columns  is-mobile  is-centered'> 
                <div class='column is-8'> 
                <div class=" box has-background-white-bis box-padding-4 ">
                <div class="field">
                        
                <div class="control m-1">
                        <label class="label is-size-6 m-5"> 料理画像 </label>

                            <!--登録する画像ファイルはfinal/imgの中にある画像のみ-->
                   
                                <input type="hidden" name="name" value="value" />
                               <input name="user_file_name" type="file" />
                               

                              
                </div>
              
                <div class="control m-1">
                        <label class="label is-size-6 m-5">タイトル</label>
                        <div class="field has-addons-centered">
                                <input type="text"  class="input is-normal " name="title"  placeholder="例：簡単！ホットミルクの作り方"  style="width: 515px;" required/>
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
                                        echo '<option value=',$row['category_id'],'>',$row['category_name'],'</option>';
                                }
                                ?>
                                </select>
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">レシピ名</label>
                        <div class="field  has-addons-centered">
                                <input type="text"  class="input  is-normal " name="recipe_name"  placeholder="例：ホットミルク" style="width: 515px;" required  />            
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">作り方</label><!--ボタンを押すとフォームが増える-->
                        <div class="field  has-addons-centered">
                  
                    <?php
                    $count=1;
                    ?>
                        <div id="input_pluralBox">
                        <div id="input_plural">
        
                               <input type="text" class="input  is-normal mb-3 " placeholder="例：牛乳をフライパンに入れて弱火にします。" name="work[]"  style="width: 700px;" required>
                                <input type="button" value="＋" class="add pluralBtn ">
                                <input type="button" value="－" class="del pluralBtn">
                            
                        </div>
                        </div>
                   

                       
                        </div>
                </div>

             
    

       
          

                <div class="control m-1">
                        <label class="label is-size-6 m-5">レシピのポイント</label>
                        <div class="field has-addons-centered">                
                                <input type="text" class="input  is-normal  " name="recipe_point" placeholder="例：強火にすると焦げてしまうので注意！" style="width: 515px;" required />
                        </div>
                </div>

                <div class="control m-1">
                        <label class="label is-size-6 m-5">材料</label><!--ボタンを押すとフォームが増える-->
                        <div id="input_pluralBox2">
                        <div id="input_plural2">
                                <input type="text" class="input  is-normal mb-3 " placeholder="例：牛乳" name="material[]"  style="width: 265px;" required>
                                <input type="text" class="input  is-normal mb-3 " placeholder="例：100ml" name="material_num[]"  style="width: 140px; " required>
                                <input type="button" value="＋" class="add1 pluralBtn ">
                                <input type="button" value="－" class="del pluralBtn">
                        </div>
                        </div>
                </div>

        </div>
       
        </form>
        <button class="button mt-3 mb-5" type="button" onclick="location.href='home.php'">閉じる</button>
       <input  type="submit" class="button mt-3 mb-5"  value="レシピを登録">
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

