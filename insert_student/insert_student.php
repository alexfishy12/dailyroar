<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
	exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
    header("Location: GA_Home.php");
    exit;
}
include("../dbconfig.php");


if(isset($_SESSION['account_type']) && $_SESSION['account_type']== "FA" ) {
    $sql = "SELECT * FROM csemaildb.Curriculum";
    $sql2 = "SELECT * FROM csemaildb.ClassStanding";
    $sqlactive = "SELECT * FROM csemaildb.ActiveProgram";
    $resultactive = mysqli_query($con, $sqlactive);
    $result = mysqli_query($con, $sql);
    $result2 = mysqli_query($con, $sql);
    $result3 = mysqli_query($con, $sql);
    $result4 = mysqli_query($con, $sql2);
    $count = mysqli_num_rows($result);

   

    
echo "<a href='../Faculty_Home.php' class='btn'>Home</a><br>";   

echo "<br><font size=4><b>Add a Student</b></font>";
echo "<form name='input' action='enter_student.php' method='post' >";
echo "<br> First Name: <input type='text' name='first_name' required='required'>";
echo "<br> Last Name: <input type='text' name='last_name' required='required'>";
echo "<br> Active Program: <select name='active_program' required='required'>";
if ($count > 0){
	
	echo "<option value = ' '></option>";
	while ($Active = mysqli_fetch_array($resultactive)){
		echo '<option value = "' .$Active["ID"]. '">' .$Active["ActiveProgram"].'</option>';
	}
}
echo "</select>";

echo "<br> Major 1: <select name='major1' required='required'>";
if ($count > 0){
	
	echo "<option value = ' '></option>";
	while ($Major1 = mysqli_fetch_array($result)){
		echo '<option value = "' .$Major1["ID"]. '">' .$Major1["Curriculum"].'</option>';
	}
}
echo "</select>";

echo "<br> Major 2: <select name='major2' required='required'>";
if ($count > 0){
	
	echo "<option value = ' '></option>";
	while ($Major2 = mysqli_fetch_array($result2)){
		echo '<option value = "' .$Major2["ID"]. '">' .$Major2["Curriculum"].'</option>';
	}
}
echo "</select>";

echo "<br> Minor: <select name='minor' required='required'>";
if ($count > 0){
	
	echo "<option value = ' '></option>";
	while ($Minor = mysqli_fetch_array($result3)){
		echo '<option value = "' .$Minor["ID"]. '">' .$Minor["Curriculum"].'</option>';
	}
}
echo "</select>";


echo "<br> Class Standing: <select name='class_stand' required='required'>";
if ($count > 0){
	
	echo "<option value = ' '></option>";
	while ($Standing = mysqli_fetch_array($result4)){
		echo '<option value = "' .$Standing["ID"]. '">' .$Standing["Standing"].'</option>';
	}
}
echo "</select>";

echo "<br> Email Address: <input type='text' name='email' required='required'>";
echo "<br><input type='submit' value='Submit'>";
echo "</form>";
}
    
    
else {
echo '<br>You are not logged in with a Faculty Account. Please Login with a Faculty account!';
}









?>