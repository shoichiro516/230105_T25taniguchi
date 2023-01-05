<?php require '../php03_kadai/header.php'; ?>
<div class="th0">番号</div>
<div class="th1">選手名</div>
<div class="th1">身長</div><br>
<?php
$pdo=new PDO('mysql:host=localhost;dbname=playershop;charset=utf8', 
	'staff', 'password');
if (isset($_REQUEST['command'])) {
	switch ($_REQUEST['command']) {
	case 'insert':
		if (empty($_REQUEST['name']) || 
			!preg_match('/^[0-9]+$/', $_REQUEST['height'])) break;
		$sql=$pdo->prepare('insert into player values(null,?,?)');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['height']]);
		break;
	case 'update':
		if (empty($_REQUEST['name']) || 
			!preg_match('/^[0-9]+$/', $_REQUEST['height'])) break;
		$sql=$pdo->prepare(
			'update player set name=?, height=? where id=?');
		$sql->execute(
			[htmlspecialchars($_REQUEST['name']), $_REQUEST['height'], 
			$_REQUEST['id']]);
		break;
	case 'delete':
		$sql=$pdo->prepare('delete from player where id=?');
		$sql->execute([$_REQUEST['id']]);
		break;
	}
}
foreach ($pdo->query('select * from player') as $row) {
	echo '<form class="ib" action="player.php" method="post">';
	echo '<input type="hidden" name="command" value="update">';
	echo '<input type="hidden" name="id" value="', $row['id'], '">';
	echo '<div class="td0">';
	echo $row['id'];
	echo '</div> ';
	echo '<div class="td1">';
	echo '<input type="text" name="name" value="', $row['name'], '">';
	echo '</div> ';
	echo '<div class="td1">';
	echo '<input type="text" name="height" value="', $row['height'], '">';
	echo '</div> ';
	echo '<div class="td2">';
	echo '<input type="submit" value="更新">';
	echo '</div> ';
	echo '</form> ';
	echo '<form class="ib" action="player.php" method="post">';
	echo '<input type="hidden" name="command" value="delete">';
	echo '<input type="hidden" name="id" value="', $row['id'], '">';
	echo '<input type="submit" value="削除">';
	echo '</form><br>';
	echo "\n";
}
?>
<form action="player.php" method="post">
<input type="hidden" name="command" value="insert">
<div class="td0"></div>
<div class="td1"><input type="text" name="name"></div>
<div class="td1"><input type="text" name="height"></div>
<div class="td2"><input type="submit" value="追加"></div>
</form><br>
<?php require '../footer.php'; ?>
