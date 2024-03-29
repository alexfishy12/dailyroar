<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- CSS Only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script src= "../_libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../_libraries/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../_CSS/content.css">
  <link rel="icon" href="../_assets/Keanu_head.svg">
  <script src= "../_libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../_libraries/jquery-3.6.0.min.js"></script>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <!--<a class="navbar-brand" style="cursor: pointer;" href="../Faculty_Home.php">
        <img id="logo" src="../_assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="50" width="50">
      </a>-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">

          <li class="nav-item">
            <a class="nav-link" href="../Faculty_Home.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Emails
            </a>
            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="../send_email/email.php">Compose</a></li>
              <li><a class="dropdown-item" href="../sent_inbox/index.php">Sent Inbox</a></li>

            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Student Data
            </a>
            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="../insert_student/insert_student.php">Insert New</a></li>
              <li><a class="dropdown-item" href="../update_students/update_student.php">Update/Delete Existing</a></li>
              <li><a class="dropdown-item" href="../uploadCSV/upload_CSV.php">Upload CSV</a></li>

            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Settings
            </a>
            <ul class="dropdown-menu">

              <li><a class="dropdown-item" href="../settings/active_semester.php">Active Semester</a></li>
              <li><a class="dropdown-item" href="../settings/create_user.php">Create New User</a></li>

            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>


        </ul>
      </div>
    </div>
  </nav>
</header>