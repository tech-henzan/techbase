
<title>mission_4</title>


<?php

$name      = $_POST[name];
$comment   = $_POST[comment];
$pass      = $_POST[pass];
$editnum   = $_POST[editnum];

$date      = date("Y/m/d H:i:s");

$editpass  = $_POST[editpass];





/*  �f�[�^�x�[�X�ڑ�  */
$dsn = '�f�[�^�x�[�X';
$user = '���[�U�[�l�[��';
$password = '�p�X���[�h';
$pdo = new PDO($dsn,$user,$password);

/*  �e�[�u���쐬  */
$sql="CREATE TABLE mission4(id INT AUTO_INCREMENT, name char(32), comment TEXT, pass char(16), date char(32), primary key(id))";
$create = $pdo->query($sql);



/*  �ҏW�t�H�[������  */


if(!empty($_POST[edit]))
  {
   $sql='SELECT*FROM mission4';
   $selectall=$pdo->query($sql);
   
   $flags_edit=false;
   foreach($selectall as $row)
     {
      $flag_edit = false;/*�p�X�Ƃ肠�����U*/

      if(($_POST[edit]==$row[0])and($editpass==$row[3]))
        {
         $flag_edit = true;/*�p�X�^�ɏ㏑��*/
         $edit = $_POST[edit];
         $nm   = $row[1];
         $kome = $row[2];
         $path = $row[3];
        }

      $flags_edit = $flag_edit || $flags_edit; 

     }/*foreach��*/
   if(!$flags_edit){echo"�p�X���[�h���Ⴂ�܂�";}
  }/*��if��*/



/*  ���e�t�H�[������  */
if(!empty($name) and !empty($comment))
  {
   //�V�K���e
   if(empty($editnum))
     {
      $insert=$pdo->prepare('INSERT INTO mission4 (name,comment,pass,date) VALUES (:name, :comment, :pass, :date)');
      $insert->bindParam(':name',$name,PDO::PARAM_STR);
      $insert->bindParam(':comment',$comment,PDO::PARAM_STR);
      $insert->bindParam(':pass',$pass,PDO::PARAM_STR);
      $insert->bindParam(':date',$date,PDO::PARAM_STR);
      $insert->execute();
     }

   //�ҏW
   else
     {
      $sql = "update mission4 set name='$name', comment='$comment', pass='$pass', date='$date' where id=$editnum";
      $result = $pdo->query($sql);
     }
  }



/*  �폜�t�H�[������  */
$delete    = $_POST[delete];
$delpass= $_POST[delpass];

if(!empty($delete))
  {
   $sql='SELECT*FROM mission4';
   $selectall=$pdo->query($sql);
  
   $flags_del=false;
   foreach($selectall as $row)
     {
      $flag_del = false;/*�p�X�Ƃ肠�����U*/

      if(($delete==$row[0])and($delpass==$row[3]))
        {
         $flag_del = true;/*�p�X�^�ɏ㏑��*/
         $sql = "delete from mission4 where id=$delete";
         $result = $pdo->query($sql);
        }

      $flags_del = $flag_del || $flags_del;

     }
   if(!$flags_del){echo "�p�X���[�h���Ⴂ�܂�";}
  }




?>




<!--     ���͗p�t�H�[��      -->

<!-- ���M�t�H�[�� -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="name"  placeholder="���O" value="<?php echo $nm; ?>" ><br>
     <input type="text"  name="comment"  placeholder="�R�����g" value="<?php echo $kome; ?>"><br>
     <input type="text"  name="pass"  placeholder="�ҏW/�폜�p�p�X���[�h" value="<?php echo $path; ?>">
     <input type="submit" value="���M">
   �@<input type="hidden"  name="editnum" value="<?php echo $edit; ?>">
  </p>

<!--�ҏW�ԍ��t�H�[�� -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="edit"  placeholder="�ҏW�Ώ۔ԍ�"><br>
     <input type="text" name="editpass" placeholder="�p�X���[�h">
     <input type="submit" value="�ҏW">
  </p>

<!--�폜�t�H�[�� -->
  <p><form action="mission_4.php" method="post">
     <input type="text"  name="delete"  placeholder="�폜�Ώ۔ԍ�"><br>
     <input type="text"  name="delpass" placeholder="�p�X���[�h">
     <input type="submit" value="�폜">
  </p>










<?php

//�e�[�u���ꗗ�J��
$sql='SHOW TABLES';
$show_t=$pdo->query($sql);
foreach($show_t as $row)
 {echo $row[0];echo '<br>';}
echo "<hr>";


//�e�[�u�����J��
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

