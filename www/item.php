<?php
	session_start();
	require_once('temp.php');
	echo <<<str
		<html>
<head>
<link href="css/bootstrap.css" rel="stylesheet">  
<title> Добро пожаловать </title>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/scripts.js"></script>
	<script type="text/javascript" src="/gallery/item.js"></script>
	<meta http-equiv="content-type" content="text/html" charset="utf-8">
</head>
<body onload="loadPuctures()">
  <div class="navbar">
		<div class="navbar-inner">
			<a class="brand"><h2 class="form-signin-heading">Картинка</h2></a>
str;
	$tabl=new PDO('mysql:host=localhost;dbname=SWAG','admin','admin');
	if ($_SESSION['authorized']==1) {
		echo file_get_contents('tpl/afterAuthForm.tpl');
	} else {
		echo file_get_contents('tpl/AuthForm.tpl');
	}
	echo <<<str
	</div>
  </div>
  <div class="container">
		<div class="span13">
str;
	$st=$tabl->prepare('SELECT thingType,name,description,cost FROM things WHERE id=:D');
	$st->bindValue(':D',$_GET['id']);
	if (!$st->execute()) var_dump($st->errorInfo());
	if ($st) {
		$a=$st->fetch(PDO::FETCH_ASSOC);
		$tableItem = new template('tpl/tableItem.tpl');
		foreach ($a as $q=>$v) {
			$tableItem->assign($q,$v);
		}
		$tableItem->assign('prop',"class='tableItem'");
		echo $tableItem->getHTML();
	}
	echo <<<str
		</div>
  </div>
	<div class="comments" id="itemComments">
		Кооменты<br>coming soon
	</div>
  <div class="navbar navbar-fixed-bottom"> А тут подвал </div>
</body>
</html>
str;
?> 