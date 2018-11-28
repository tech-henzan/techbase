
<title>mission_4</title>


<?php

$name      = $_POST[name];
$comment   = $_POST[comment];
$pass      = $_POST[pass];
$editnum   = $_POST[editnum];

$date      = date("Y/m/d H:i:s");

$editpass  = $_POST[editpass];





/*  データベース接続  */
$dsn = 'データベース';
$user = 'ユーザーネーム';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

/*  テーブル作成  */
$sql="CREATE TABLE mission4(id INT AUTO_INCREMENT, name char(32), comment TEXT, pass char(16), date char(32), primary key(id))";
$create = $pdo->query($sql);



/*  編集フォーム処理  */


if(!empty($_POST[edit]))
  {
   $sql='SELECT*FROM mission4';
   $selectall=$pdo->query($sql);
   
   $flags_edit=false;
   foreach($selectall as $row)
     {
      $flag_edit = false;/*パスとりあえず偽*/

      if(($_POST[edit]==$row[0])and($editpass==$row[3]))
        {
         $flag_edit = true;/*パス真に上書き*/
         $edit = $_POST[edit];
         $nm   = $row[1];
         $kome = $row[2];
         $path = $row[3];
        }

      $flags_edit = $flag_edit || $flags_edit; 

     }/*foreach閉*/
   if(!$flags_edit){echo"パスワードが違います";}
  }/*大if閉*/



/*  投稿フォーム処理  */
if(!empty($name) and !empty($comment))
  {
   //新規投稿
   if(empty($editnum))
     {
      $insert=$pdo->prepare('INSERT INTO mission4 (name,comment,pass,date) VALUES (:name, :comment, :pass, :date)');
      $insert->bindParam(':name',$name,PDO::PARAM_STR);
      $insert->bindParam(':comment',$comment,PDO::PARAM_STR);
      $insert->bindParam(':pass',$pass,PDO::PARAM_STR);
      $insert->bindParam(':date',$date,PDO::PARAM_STR);
      $insert->execute();
     }

   //編集
   else
     {
      $sql = "update mission4 set name='$name', comment='$comment', pass='$pass', date='$date' where id=$editnum";
      $result = $pdo->query($sql);
     }
  }



/*  削除フォーム処理  */
$delete    = $_POST[delete];
$delpass= $_POST[delpass];

if(!empty($delete))
  {
   $sql='SELECT*FROM mission4';
   $selectall=$pdo->query($sql);
  
   $flags_del=false;
   foreach($selectall as $row)
     {
      $flag_del = false;/*パスとりあえず偽*/

      if(($delete==$row[0])and($delpass==$row[3]))
        {
         $flag_del = true;/*パス真に上書き*/
         $sql = "delete from mission4 where id=$delete";
         $result = $pdo->query($sql);
        }

      $flags_del = $flag_del || $flags_del;

     }
   if(!$flags_del){echo "パスワードが違います";}
  }




?>




<!--     入力用フォーム      -->

<!-- 送信フォーム -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="name"  placeholder="名前" value="<?php echo $nm; ?>" ><br>
     <input type="text"  name="comment"  placeholder="コメント" value="<?php echo $kome; ?>"><br>
     <input type="text"  name="pass"  placeholder="編集/削除用パスワード" value="<?php echo $path; ?>">
     <input type="submit" value="送信">
   　<input type="hidden"  name="editnum" value="<?php echo $edit; ?>">
  </p>

<!--編集番号フォーム -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="edit"  placeholder="編集対象番号"><br>
     <input type="text" name="editpass" placeholder="パスワード">
     <input type="submit" value="編集">
  </p>

<!--削除フォーム -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="delete"  placeholder="削除対象番号"><br>
     <input type="text"  name="delpass" placeholder="パスワード">
     <input type="submit" value="削除">
  </p>










<?php

//テーブル一覧開示
$sql='SHOW TABLES';
$show_t=$pdo->query($sql);
foreach($show_t as $row)
 {echo $row[0];echo '<br>';}
echo "<hr>";


//テーブル情報開示
$sql='SHOW CREATE TABLE mission4';
$result=$pdo->query($sql);
foreach($result as $row)
 {print_r($row);}
echo"<hr>";

$sql='SELECT* FROM mission4 ORDER BY id ASC';
$selectall=$pdo->query($sql);
foreach($selectall as $row)
 {echo 
  $row['id']. ',' .$row['name']. ',' .$row['comment']. ',' .$row['date']. ',' .'<br>';
 }

?>

