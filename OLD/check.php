<?php
include('database.php');
session_start();
$user_check=$_SESSION['id'];
$pass_check=$_SESSION['password'];
$printtest="";


 
$sql = mysqli_query($connect,"SELECT first_name FROM users WHERE id='$user_check' AND password='$pass_check'");
 
$row=mysqli_fetch_array($sql,MYSQLI_ASSOC);
 
// TODO - Remove printtest
$login_user=$row['first_name'].$printtest;

if(!isset($user_check))
{
	session_destroy();
}
?>