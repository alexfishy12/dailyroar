<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="icon" type="image/x-icon" href="/dailyroar/assets/Kean_University_Logo_Nav.svg.png">

<title><?php echo ($title); ?></title>

<!-- CSS Only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src= "/dailyroar/libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="/dailyroar/libraries/jquery-3.6.0.min.js"></script>
  <script src="/dailyroar/uploadCSV/uploadCSV.js"></script>
  <link rel="stylesheet" href="/dailyroar/CSS/faculty_home_page.css">
  <script src= "/dailyroar/libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="/dailyroar/libraries/jquery-3.6.0.min.js"></script>

<header>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" >
    <div class="container-fluid">
      <a class="navbar-brand" style="cursor: pointer;">

        <img id="logo" src="../assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="50" width="50" href="../Faculty_Home.php">

      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="/dailyroar/Faculty_Home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dailyroar/send_email/email.php">Email</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Modify Data
            </a>
            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="../insert_student/insert_student.php">Manually Insert Student</a></li>
              <li><a class="dropdown-item" href="../update_students/update_student.php">Update Student Information</a></li>
              <li><a class="dropdown-item" href="../uploadCSV/upload_CSV.php">Upload Students CSV</a></li>

            </ul>
          </li>


        </ul>
      </div>
    </div>
  </nav>
</header>