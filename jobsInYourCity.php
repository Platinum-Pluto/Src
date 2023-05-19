<?php
session_start();
require 'dbcon.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>

  <!--DONE BACKEND-->

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job search</title>
  <?php getModeNorm(); ?>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script src="script.js" defer></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

  <?php $vall = 1; ?>


  <script>
    function showMessage() {
      alert("User Login Required");
    }
  </script>


  <style>
    .global_button {
      background-color: transparent;
      border-color: transparent;
    }

    .global_button i {
      color: rgb(53, 137, 247);
    }

    .global_button:hover {
      background-color: transparent;
      border-color: transparent;
      box-shadow: none;
    }

    .global_button:focus {
      box-shadow: none !important;
      outline: none;
      background-color: transparent !important;
      border-color: transparent !important;
      outline-color: transparent !important;

    }

    .btn-primary-outline {
      background-color: transparent;
      border-color: transparent;
    }

       <?php

       $sql = "SELECT theme FROM settings";
       $result = $con->query($sql);
       $row = $result->fetch_assoc();
       $switchmode = $row['theme'];


       cssreturner($switchmode); ?>
  </style>




</head>
<!-- <h1>This is the title </h1> -->
<!-- Nav Bar Start -->
<nav <?php getNavMode() ?>>
  <div class="container-fluid">
    <img style="margin-right:2%;" src="./img/logo.png" alt="">
    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active link-primary" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-info" href="discoverjobs.php">Discover jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-success" href="jobsInYourCity.php">Jobs In your City</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-danger" href="findSalaries.php">Find Salaries</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active link-warning" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <form action="code.php" method="POST">
            <input type="hidden" name="modechange" value="jobsInYourCity.php">
            <button type="submit" class="btn-primary-outline"><i style="font-size: 20px;
            cursor: pointer;
            left: 42%" <?php getTheme() ?>></i></button>
          </form>
        </li>
      </ul>
      <!-- Nav left side end  -->
      <span class="navbar-text">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <!-- Google translate -->

          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle global_button" type="button" id="dropdownMenuButton"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-globe"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="google_translate_element">
              <div dir="ltr" class="skiptranslate goog-te-gadget">
                <span style="white-space: nowrap;">
                  <a class="goog-logo-link" href="http://translate.google.com" target="_blank">
                  </a>
                </span>
              </div>
            </div>
          </div>

          <script>
            $(document).ready(function () {
              $('.dropdown-toggle').click(function () {
                $('#google_translate_element').toggle();
              });
            });

            function googleTranslateElementInit() {
              new google.translate.TranslateElement({
                pageLanguage: 'en'
              }, 'google_translate_element');
            }
          </script>



          <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



          <!-- Google translate -->
          </li>

          <li>
            <a class="nav-link link-success" href="userlogin.php">Upload your resume </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active link-danger" href="signup.php">Sign in </a>
          </li>
          <h3>|</h3>
          <li class="nav-item">
            <a class="nav-link active link-warning " href="userlogin.php">Log in </a>
          </li>
          <h3>|</h3>
          <li class="nav-item">
            <a class="nav-link link-info" href="Admin_index.php">Employers/Post job </a>
          </li>
        </ul>
      </span>
    </div>
  </div>
</nav>
<!-- Nav Bar End -->



<body class='bodystyle'>

  <form method="POST">
    <div class="input-group rounded">
      <input type="text" class="form-control rounded" placeholder="Search City" aria-label="Search"
        aria-describedby="search-addon" name="searchCity">
      <button type="submit" name="search" class="btn btn-primary">Search</button>
    </div>
  </form>



<div class="container py-3">
    <div class="row">
    <?php
    if (isset($_POST['search'])) {
      $searchCity = $_POST['searchCity'];
      $result = searchCity($searchCity);
      if ($result->num_rows > 0) {
        echo "<h2 class='match'>Matching Results: $result->num_rows Found</h2>";
        echo "<br><br><br>";
        foreach ($result as $results) {
          ?>
          <?php $vall = 0; ?>
          <div class="col-md-3">
            <div class="job-card">
              <img src="./img/logo.png" alt="Job Image" class="job-image">
              <div class="job-info">
                <p class="job-title">
                  <?= $results['Company_Name']; ?>
                </p>
                <p class="job-description">
                <h6 class="job-description">
                  <?= $results['Job_Title']; ?>
                </h6>
                </p>
                <details>
                  <summary class="job-description">More Information</summary>
                  <p class="job-description">
                    Location :
                    <?= $results['Location']; ?><br>
                    Salary :
                    <?= $results['Salary']; ?><br>
                    Qualification:
                    <?= $results['Qualification']; ?><br>
                    Job Description:
                    <?= $results['Job_Description']; ?>
                  </p>
                </details><br>
                <div class="job-cta">
                  <button onclick="showMessage()" class="btn btn-danger btn-sm">Apply Now</button>
                </div>
              </div>
            </div>
          </div>
          <?php
        }

      } else {
        $vall = 1;
        echo "<h2>No matching results found</h2>";
      }
    }

    ?>
  </div>
</div>


</body>


<!-- Footer Start -->
  <footer style="<?php foot($vall) ?>">

  <div class="fotcontent">
    <a style="font-size: 200%;" href="" class="fa-fade">Contract</a>

  </div>
  <div class="social">
    <a href="#" class="fa-brands fa-facebook fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-twitter fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-instagram fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-linkedin fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-snapchat fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-google fa-fade fa-sm"></a>
    <a href="#" class="fa-brands fa-yahoo fa-fade fa-sm"></a>

  </div>
</footer>
<!--  Footer End -->
<script src="https://kit.fontawesome.com/b2e0266282.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</html>