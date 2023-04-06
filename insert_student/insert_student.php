<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: ../index.php");
	exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
    header("Location: ../GA_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: ../index.php");  
}
include("../dbconfig.php");
include("../faculty_nav.php");
echo '<link href="../CSS/font_family.css" rel="stylesheet">';
echo '<link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />';


if(isset($_SESSION['account_type']) && $_SESSION['account_type']== "FA" ) {

	$sqlActive = "SELECT * FROM csemaildb.ActiveProgram";
	$sqlCurriculum = "SELECT * FROM csemaildb.Curriculum ";
    $sqlClassStanding = "SELECT * FROM csemaildb.ClassStanding";
  

	$resultActive = mysqli_query($con, $sqlActive);
	$resultCurriculum = mysqli_query($con, $sqlCurriculum);
    $resultClassStanding = mysqli_query($con, $sqlClassStanding);

 


    $countCurriculum = mysqli_num_rows($resultCurriculum);
	$countActiveProgram = mysqli_num_rows($resultActive);
	$countClassStanding = mysqli_num_rows($resultClassStanding);

	



echo "<body class='retro'>"; ?>

<div class="nes-container with-title is-centered">
	<p class="title"> Manually Insert a Student </p>
	
		<form name = "input" action = "enter_student.php" method = "post" >

			<div class="nes-field is-inline">
				<label for="inline_field">First Name: </label>
				<input type="text" id="inline_field" class="nes-input is-success" name = "first_name" required>
			</div>


			<div class="nes-field is-inline">
			<label for="inline_field">Last Name: </label>
			<input type="text" id="inline_field" class="nes-input is-success" name = "last_name" required>
			</div>

		
			<div class="nes-select">
			<label for="inline_field"> Active Program: </label>
			<select required id="default_select" name = "active_program" >
				<option value=""</option>

						<?php

							if ($countActiveProgram > 0)
							{
								while ($activePorgramRow = mysqli_fetch_array($resultActive))
								{
									echo '<option value = "' .$activePorgramRow["ID"]. '">' .$activePorgramRow["ActiveProgram"].'</option>';
								}
							}
						?>
			</select>
			</div>


			<div class="nes-select">
			<label for="inline_field"> Major One: </label>
			<select  id="default_select" name='major1' required >
				<option value="" </option>

						<?php
							if ($countCurriculum > 0)
							{
								while ($MajorRow= mysqli_fetch_array($resultCurriculum))
								{
									echo '<option value = "' .$MajorRow["ID"]. '">' .$MajorRow["Curriculum"].'</option>';
								}
							}
													
						?>
			</select>
			</div>


			<div class="nes-select">
			<label for="nes_field"> Major Two: </label>
			<select  id="default_select" name='major2' required >
				<option value="" </option>

						<?php
							mysqli_data_seek($resultCurriculum,0);
							if ($countCurriculum > 0)
							{
								while ($MajorRow= mysqli_fetch_array($resultCurriculum))
								{
									echo '<option value = "' .$MajorRow["ID"]. '">' .$MajorRow["Curriculum"].'</option>';
								}
							}
														
						?>
			</select>
			</div>



			<div class="nes-select">
			<label for="nes_field"> Minor: </label>
			<select  id="default_select" name='minor' required >
				<option value="" </option>

						<?php
							mysqli_data_seek($resultCurriculum,0);
							if ($countCurriculum > 0)
							{
								while ($MajorRow= mysqli_fetch_array($resultCurriculum))
								{
									echo '<option value = "' .$MajorRow["ID"]. '">' .$MajorRow["Curriculum"].'</option>';
								}
							}					
						?>
			</select>
			</div>


			<div class="nes-select">
			<label for="nes_field"> Class Standing: </label>
			<select  id="default_select" name='class_standing' required >
				<option value="" </option>

						<?php
							if ($countClassStanding > 0)
							{
								while ($classStandingRow= mysqli_fetch_array($resultClassStanding))
								{
									echo '<option value = "' .$classStandingRow["ID"]. '">' .$classStandingRow["Standing"].'</option>';
								}
							}
													
						?>
			</select>
			</div>


			<div class="nes-field is-inline">
			<label for="nes_field"> Email Address: </label>
			<input type="email" id="inline_field" class="nes-input is-success" name='email' required>
			</div>


			<br>
			<br>
			<input type='submit' value='Submit'>
			
			<br>
		</form>
</div>


<?php
}
else
	echo '<br> Please Login with a Faculty account!';
?>

</body>
