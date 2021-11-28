<?php
require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/db.php');
session_start();
$userInfo = [
	'admin' => ['username' => 'admin', 'name' => 'Hoàng Xuân Phi', 'password' => '12345678', 'work' => 'Leader at ACworks Vietnam', 'email' => 'phi.hx@acworks.co.jp'],
	'hacker' => ['username' => 'hacker', 'name' => 'Hacker man', 'password' => '12345678', 'work' => 'Hacker at ACworks Vietnam', 'email' => 'hacker@acworks.co.jp'],
];	
$action = $_GET['action'] ?? null;

switch ($action) {
	case 'logout':
		unset($_SESSION['login']);
		header('Location: ' . '/user.php'); exit;
		break;
	case 'comment':
		try{
			$sql = "INSERT INTO comments (username, comment, created_at) VALUES (?, ?, ?)";
			$stmt = $conn->prepare($sql);
			// $stmt->execute([$_SESSION['login']['username'], htmlentities($_POST['comment'], ENT_QUOTES, 'UTF-8'), time()]);
			// $stmt->execute([$_SESSION['login']['username'], $conn->quote($_POST['comment']), time()]);
			$stmt->execute([$_SESSION['login']['username'], $_POST['comment'], time()]);
		} catch (Exception $e) {
			print_r($e->getMessage());
		}
		header('Location: ' . '/user.php'); exit;
		break;
	default:
		$stmt = $conn->prepare("SELECT * FROM comments");
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$comments = $stmt->fetchAll();
		
		if(!empty($_POST)) {
			if(isset($userInfo[$_POST['username']])  && $_POST['password'] == $userInfo[$_POST['username']]['password']) {
				$_SESSION['login'] = $userInfo[$_POST['username']];
			}else{
				echo "<span class='error'>Sorry, username or password is not correct.</span>";
			}
		}
		break;
}
$isLogin = isset($_SESSION['login']) && !empty($_SESSION['login']);
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	*{box-sizing: border-box;}
	table{
		margin-top:20px;
		width: 100%;
	}
	table, th, td {
	  border: 1px solid black;
	}
	span.success{
		width: 100%;
	    display: block;
	    padding: 10px;
	    background: #188d27;
	    color: #fff;
	    font-size: 20px;
	    text-align: center;
	}
    span.error{
		width: 100%;
	    display: block;
	    padding: 10px;
	    background: #e1182b;
	    color: #fff;
	    font-size: 20px;
	    text-align: center;
	}
	body {font-family: Arial, Helvetica, sans-serif;}
	
	/* Full-width input fields */
	input[type=text], input[type=password] {
	  width: 100%;
	  padding: 12px 20px;
	  margin: 8px 0;
	  display: inline-block;
	  border: 1px solid #ccc;
	  box-sizing: border-box;
	}
	
	/* Set a style for all buttons */
	button {
	  background-color: #04AA6D;
	  color: white;
	  padding: 14px 20px;
	  margin: 8px 0;
	  border: none;
	  cursor: pointer;
	  width: 100%;
	}
	
	button:hover {
	  opacity: 0.8;
	}
	
	/* Extra styles for the cancel button */
	.cancelbtn {
	  width: auto;
	  padding: 10px 18px;
	  background-color: #f44336;
	}
	
	/* Center the image and position the close button */
	.imgcontainer {
	  text-align: center;
	  margin: 24px 0 12px 0;
	  position: relative;
	}
	
	img.avatar {
	  width: 40%;
	  border-radius: 50%;
	}
	
	.container {
	  padding: 16px;
	}
	
	span.psw {
	  float: right;
	  padding-top: 16px;
	}
	
	/* The Modal (background) */
	.modal {
	  display: none; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	  padding-top: 60px;
	}
	
	/* Modal Content/Box */
	.modal-content {
	  background-color: #fefefe;
	  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
	  border: 1px solid #888;
	  width: 600px; /* Could be more or less, depending on screen size */
	}
	
	/* The Close Button (x) */
	.close {
	  position: absolute;
	  right: 25px;
	  top: 0;
	  color: #000;
	  font-size: 35px;
	  font-weight: bold;
	}
	
	.close:hover,
	.close:focus {
	  color: red;
	  cursor: pointer;
	}
	.card {
	  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	  max-width: 300px;
	  margin: auto;
	  text-align: center;
	  font-family: arial;
	}
	
	.title {
	  color: grey;
	  font-size: 18px;
	}
	
	a.logoutbutton {
	  border: none;
	  outline: 0;
	  display: inline-block;
	  padding: 8px;
	  color: white;
	  background-color: #000;
	  text-align: center;
	  cursor: pointer;
	  width: 100%;
	  font-size: 18px;
	}
	
	a {
	  text-decoration: none;
	  font-size: 22px;
	  color: black;
	}
	
	a:hover {
	  opacity: 0.7;
	}
	
	/* Add Zoom Animation */
	.animate {
	  -webkit-animation: animatezoom 0.6s;
	  animation: animatezoom 0.6s
	}
	
	@-webkit-keyframes animatezoom {
	  from {-webkit-transform: scale(0)} 
	  to {-webkit-transform: scale(1)}
	}
	  
	@keyframes animatezoom {
	  from {transform: scale(0)} 
	  to {transform: scale(1)}
	}
	
	/* Change styles for span and cancel button on extra small screens */
	@media screen and (max-width: 300px) {
	  span.psw {
	     display: block;
	     float: none;
	  }
	  .cancelbtn {
	     width: 100%;
	  }
	}
</style>
</head>
<body>

<?php if($isLogin):?>

<h2 style="text-align:center">My Profile</h2>
<div class="card">
	<img src="https://www.w3schools.com/w3images/team2.jpg" alt="John" style="width:100%">
	<h1><?=$_SESSION['login']['name']?></h1>
	<p class="title"><?=$_SESSION['login']['work']?></p>
	<p><?=$_SESSION['login']['email']?></p>
	<p><a class="logoutbutton" href="?action=logout">Logout</a></p>
</div>
<div style="width:500px;margin: 0 auto;">
	<h2>Comments</h2>
	
	<form action="?action=comment" method="post">
		<input type="text" name="comment" value="" placeholder="Type your comment here..."><br>
		<input type="submit" value="Submit">
	</form> 
	
	<table>
		<?php foreach($comments as $comment):?>
		<tr>
			<td><p style="padding:10px;"><?=$comment['comment']?></p></td>	
		</tr>
		<?php endforeach;?>
	</table>
</div>

<?php else:?>

<form class="modal-content animate" action="" method="post">
	<div class="container">
		<label for="username"><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="username" required>
		
		<label for="password"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" required>
		
		<button type="submit">Login</button>
		<label>
			<input type="checkbox" checked="checked" name="remember"> Remember me
		</label>
	</div>
</form>

<?php endif;?>

</body>
</html>

