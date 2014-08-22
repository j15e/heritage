<html>
<body>
<h3>Add word</h3>
<?php 
mysql_connect('localhost','root','maritimes12512');
mysql_select_db('test');
if(isset($_POST['page'])){
	if(!preg_match('/\d{1,3}/',$_POST['page'])){
		echo '<p>La page saisie n\'est pas valide.';
		$error = 1;
	}
	if(!preg_match('/(.){1,255}/',$_POST['word'])){
		echo '<p>Vous devez saisir un mot.';
		$error = 1;
	}
	if(!preg_match('/(.){1,255}/',$_POST['translation'])){
		echo '<p>Vous devez saisir une traduction.';
		$error = 1;
	}
	if(!$error){
		mysql_query('INSERT INTO `vocabulary` (`page` , `word` , `translation` ) VALUES (\''.$_POST['page'].'\', \''.$_POST['word'].'\', \''.$_POST['translation'].'\')');
		$_POST = NULL;
	}
}
?>
<form name="form" id="form1" method="post" action="">
  Page 
  <input name="page" type="text" size="3" maxlength="3">
  <br>
  Word
<input name="word" type="text" maxlength="255">
  <br>
  Translation 
  <input name="translation" type="text" maxlength="255">
  <br>
  <input name="submit" type="submit" value="Add">
</form>
<h3>List</h3>
<?php 
$query = mysql_query('SELECT * FROM `vocabulary` ORDER BY `word` ASC');
while($row = mysql_fetch_row($query)){
	echo '<p><b>Word</b> : '.$row[2].' (p.'.$row[1].')<br><b>Translation</b> : '.$row[3];
}
?>
</body>
</html>
