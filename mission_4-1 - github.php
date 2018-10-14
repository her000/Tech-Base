<!DOCTYPE html>

<html lang='ja'>

<head>
<title>mission_4</title>
<meta charset='utf-8'>
</head>

<body>
<?php

if(!empty($_POST['name']) && !empty($_POST['comment'])){
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn,$user,$password);
    $sql="CREATE TABLE tt_404_99sv_coco_com.mission_4_ega"
    ."(id int primary key auto_increment,"
    ."name varchar(10),"
    ."comment varchar(30),"
    ."editnumber int,"
    ."password varchar(10),"
    ."date DATETIME"
    .");";
    $pdo->query($sql);
}

if(!empty($_POST['editnumber']) && !empty($_POST['pass3'])) {
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn,$user,$password);
	$sql = 'select * from mission_4_ega where password is not null order by id desc limit 1;';
	$result = $pdo -> query($sql);
	$results = $result -> fetch(PDO::FETCH_NUM);
	$password = $results[4];
	$sql='select * from mission_4_ega order by id asc;';
	$result = $pdo->query($sql);
	if($_POST['pass3'] === $password) {
		foreach($result as $row) {
			if($row['id'] === $_POST['editnumber']) {
				$hensyuname = $row['name'];
				$hensyucomment = $row['comment'];
				$hensyunumber = $_POST['editnumber'];
			}
		}
	}
}

if(!empty($_POST['editnumber']) && !empty($_POST['pass3'])) {
	$hensyunumber = $_POST['editnumber'];
}

?>
<form action='' method='post'>
<p><input type='text' name='name' placeholder='名前' value="<?php echo $hensyuname; ?>"></p>
<p><input type='text' name='comment' placeholder='コメント' value="<?php echo $hensyucomment; ?>"></p>
<p><input type='text' name='pass1' placeholder='新規パスワード生成'></p>
<p><input type='submit' name='hyoujibutton' value='表示'></p>
<input type='hidden' name='editpreserve' value="<?php echo $hensyunumber; ?>">
</form>

<form action='' method='post'>
<p><input type='text' name='deletenumber' placeholder='削除番号'></p>
<p><input type='text' name='pass2' placeholder='パスワードを入力せよ'></p>
<input type='submit' name='deletebutton' value='削除'>
</form>

<form action='' method='post'>
<p><input type='text' name='editnumber' placeholder='編集番号'></p>
<p><input type='text' name='pass3' placeholder='パスワードを入力せよ'></p>
<input type='submit' name='editbutton' value='編集'>
</form>

<?php
if(!empty($_POST['name']) && !empty($_POST['comment'])){
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn,$user,$password);
    if(empty($_POST['editpreserve'])) {
	    $sql=$pdo->prepare("insert into mission_4_ega (name,comment,editnumber,password,date) VALUES(:name,:comment,:editnumber,:password,now())");
	    $params = array(':name' => $_POST['name'],':comment' => $_POST['comment'],':editnumber' => $_POST['editnumber'],':password' => $_POST['pass1']);
	    $sql->execute($params);
	    $sql='select * from mission_4_ega order by id asc;';
	    $results=$pdo->query($sql);
		foreach($results as $row) {
	        if(isset($row['id'])) echo $row['id'].',';
	        if(isset($row['name'] )) echo $row['name'].',';
	        if(isset($row['comment'])) echo $row['comment'].',';
	        if(isset($row['editnumber'])) echo $row['editnumber'].',';
	        if(isset($row['date'])) echo $row['date'];
	        echo "<br>";
	    }
	}else{
		$sql = 'select * from mission_4_ega order by id asc;';
		$result = $pdo -> query($sql);
		foreach($result as $row) {
			$sql = "update mission_4_ega set name = '".$_POST['name']."',comment = '".$_POST['comment']."' where id = ".$_POST['editpreserve'].";";
			$pdo -> query($sql);
		}
		$sql = 'select * from mission_4_ega order by id asc;';
		$result = $pdo -> query($sql);
		foreach($result as $row) {
			if(isset($row['id'])) echo $row['id'].',';
	        if(isset($row['name'] )) echo $row['name'].',';
	        if(isset($row['comment'])) echo $row['comment'].',';
	        if(isset($row['editnumber'])) echo $row['editnumber'].',';
	        if(isset($row['date'])) echo $row['date'];
	        echo "<br>";
	    }
	    $editnumber = '';
	}
}
if(!empty($_POST['hyoujibutton']) && (empty($_POST['name']) || empty($_POST['comment']))){
    echo '名前・コメントどちらも入力せよ';
}
if(isset($_POST['deletenumber']) && empty($_POST['pass2'])) {
	echo 'パスワードを入力せよ';
}
if(!empty($_POST['deletenumber']) && !empty($_POST['pass2'])) {
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn,$user,$password);
	$sql = 'select * from mission_4_ega where password is not null order by id desc limit 1;';
	$result = $pdo -> query($sql);
	$results = $result -> fetch(PDO::FETCH_NUM);
	$password = $results[4];
	$sql = 'select * from mission_4_ega order by id asc;';
	$result = $pdo -> query($sql);
	if($_POST['pass2'] === $password) {
		foreach($result as $row) {
			if($row['id'] === $_POST['deletenumber']) {
				$sql = "delete from mission_4_ega where id = ".$_POST['deletenumber'].";";
				$pdo -> query($sql);
			}else {
				if(isset($row['id'])) echo $row['id'].',';
			    if(isset($row['name'] )) echo $row['name'].',';
			    if(isset($row['comment'])) echo $row['comment'].',';
			    if(isset($row['editnumber'])) echo $row['editnumber'].',';
			    if(isset($row['date'])) echo $row['date'];
			    echo "<br>";
			}
		}
	}else echo 'パスワードが違います';
}
if(isset($_POST['editnumber']) && empty($_POST['pass3'])) {
	echo 'パスワードを入力せよ';
}
if(!empty($_POST['editnumber']) && !empty($_POST['pass3'])) {
    $dsn='mysql:dbname=データベース名;host=localhost';
    $user='ユーザー名';
    $password='パスワード';
    $pdo=new PDO($dsn,$user,$password);
	$sql = 'select * from mission_4_ega where password is not null order by id desc limit 1;';
	$result = $pdo -> query($sql);
	$results = $result -> fetch(PDO::FETCH_NUM);
	$password = $results[4];
	$sql = 'select * from mission_4_ega order by id asc;';
	$result = $pdo -> query($sql);
	if($_POST['pass3'] === $password) {
		foreach($result as $row) {
			if($row['id'] === $_POST['editnumber']) {
			}else{
				if(isset($row['id'])) echo $row['id'].',';
		        if(isset($row['name'] )) echo $row['name'].',';
		        if(isset($row['comment'])) echo $row['comment'].',';
		        if(isset($row['editnumber'])) echo $row['editnumber'].',';
		        if(isset($row['date'])) echo $row['date'];
		        echo "<br>";
			}
		}
	}else echo 'パスワードが違います';
}

?>

</body>

</html>

