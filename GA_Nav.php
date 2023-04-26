<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title><?php echo ($title); ?></title>

<!-- CSS Only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
  <link rel="icon" href="../assets/Keanu_head.svg">
  <link rel="stylesheet" href="../CSS/content.css">
  <script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>

<header>
  <nav class="navbar navbar-expand-lg navbar-light" >
    <div class="container-fluid">
      <a class="navbar-brand" style="cursor: pointer;" href="../Faculty_Home.php">
        <img id="logo" src="../assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="50" width="50">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="../Faculty_Home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

</html>