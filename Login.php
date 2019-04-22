
<?php session_start(); ?>
<html>
<head>
<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style.css">
<title>Blog-Login</title>
</head>
<body>
<?php


       $emailid= $pass="";
	   $emailidErr= $passErr= "";
	   $Errfound = false;
	if($_SERVER["REQUEST_METHOD"]=="POST")
{
   $emailid= $_POST["emailid"];
	if(empty($emailid))
	{  $emailidErr="*Email is mandatory";
	    $Errfound = true;
	}
	else
		if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) 
	{
	$emailidErr = "Invalid email format";
	$Errfound = true;	
	}
	$pass = $_POST["pass"];
	if(empty($pass))
	{  $passErr = "*password is mandatory";
	   $Errfound = true;
	 }
	 else 
		if(!preg_match('/^[a-zA-Z0-9]/', $pass))
	{
	 $passErr= " *Only letters and numbers allowed";
	    $Errfound= true;
	}	
}  $thispage = htmlspecialchars($_SERVER["PHP_SELF"])
?>	 
<div class="login-box">
    
        <h1>Login Here</h1>
 
 <form action= "<?= $thispage ?>" method ="POST" >


 <label>Email id:</label> <input type="email" id="emailid" name= "emailid" placeholder="Enter email-id" value="<?= $emailid ?>"/><span><font color="red"> <?=  $emailidErr; ?></font></span>
<br>
<label>Password:<label>	<input type="password" id="pass" name="pass" placeholder="Enter password" value="<?= $pass ?>"/><span><font color="red" ><?=  $passErr; ?></font></span>
<input type="submit" name="login" value="Login">
<label>New User?</label>  <a href="Register.php">Create Account </a>
<br>
</form>

<?php
      
	  if(!$Errfound  and $_SERVER["REQUEST_METHOD"] =="POST")
  {	  	
     $host = 'localhost';
	$user = 'root';
	$password= '';
	$db= 'mydb';

	$con= mysqli_connect($host,$user, $password,$db);
	
	
	$sql= "SELECT username FROM mytab WHERE email= '$emailid' AND password = '$pass' ";
	
	
	$result= mysqli_query($con, $sql);
	
	while($row= mysqli_fetch_array($result))
	{
		$username= $row['username'];
		
	}	
	$count = mysqli_num_rows($result);

	
if($count == 1)
	
	{	
		$_SESSION['username']= $username;
	header("Location: home.php");
  }else
	echo "<p> LOGIN Failed</p>";
  }
  ?>

</div>
</body>
</html>
