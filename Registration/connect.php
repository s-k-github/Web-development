
<?php
 $firstname=$_POST['firstname'];
 $lastname=$_POST['lastname'];
 $gender=$_POST['gender'];
 $username=$_POST['username'];
 $password=$_POST['password'];
 $email=$_POST['email'];
 $phonenumber=$_POST['phonenumber'];
 $perfect='1';


	//CONNECTION
	$mysqli=new mysqli('localhost','root','','register');
	if($mysqli->connect_error)
	{
		die('connection failed:'.$mysqli->connect_error);
	}
	$duplicate=mysqli_query($mysqli,"select * from users where username='$username' or email='$email' or phonenumber='$phonenumber'");
	if (mysqli_num_rows($duplicate)>0)
	{
		?>
		<h1>User already exist</h1><?php
		
		$perfect='0';
	}
	if(!preg_match("/^[a-zA-Z-' ]*$/",$firstname))
	{
		?>
		<h1>Please enter valid firstname</h1><?php
		$perfect = '0';
	}
	if(!preg_match("/^[a-zA-Z-' ]*$/",$lastname))
	{
		?>
		<h1>Please enter valid lastname</h1><?php
		$perfect='0';
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		?>
		<h1>invalid email address</h1><?php
		$perfect='0';
	}
	if(!preg_match('/^[0-9]{10}$/', $phonenumber))
    {
		?>
		<h1>Invalid phone number format, must contain 10 numeric digits only</h1><?php
		$perfect='0';
    }
  
	if($perfect=='1')
	{
		include('dashboard.html');
		$currentdate = date('d/m/y');
		$stmt=$mysqli->prepare("insert into users(firstname,lastname,gender,username,password,email,phonenumber,currentdate)
			values(?,?,?,?,?,?,?,?)");
		$stmt->bind_param("ssssssis",$firstname,$lastname,$gender,$username,$password,$email,$phonenumber,$currentdate);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}	
	


	
?>