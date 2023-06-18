<?php
session_start();
$conn = mysqli_connect('localhost','root','','part2');
  if(isset($_POST['login'])){
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['phoneNumber'];
    
    $query = "SELECT * FROM member WHERE phone_number = '$phoneNumber' AND password = '$password'";
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) == 1){
        $data = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $data['member_id'];
        header('location:index.php');
    }
    else{
        $_SESSION['error'] = "Username or password invalid";
        header('location:index.php');
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sponsor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/S1525629_divash_thapa.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center  me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.webp" alt="">
        <h1>Sponsors</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="../PhotoFolio/index.html" class="active">Sponsor</a></li>
          <?php if(isset($_SESSION['id'])):?>
            <li><a href="logout.php" class="active">Logout</a></li>
          <?php endif?>
      </nav><!-- .navbar -->    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex flex-column justify-content-center align-items-center" data-aos="fade" data-aos-delay="1500">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <h2>Dynamic Website</h2>
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">
    <div class="container">
      <?php if(isset($_SESSION['error'])):?>
        <div class="alert alert-danger">
          <?php echo $_SESSION['error']; unset($_SESSION['error']);?>
        </div>
      <?php endif?>
      <?php if(isset($_SESSION['id'])):?>
        <?php
          $memberPaymentsQuery = "SELECT member.member_id, member.phone_number, payment.date, SUM(payment.amount) as total
          FROM member
          INNER JOIN payment ON member.member_id = payment.member_id
          GROUP BY payment.member_id";
          $res = mysqli_query($conn,$memberPaymentsQuery); 
        ?>
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Member ID</th>
              <th>Phone number</th>
              <th>Date</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($res as $i => $data):?>
              <tr>
                <td><?php echo ++$i?></td>
                <td><?php echo $data['member_id']?></td>
                <td><?php echo $data['phone_number']?></td>
                <td><?php echo $data['date']?></td>
                <td>$<?php echo $data['total']?></td>
              </tr>
            <?php endforeach?>
          </tbody>

        </table>
      <?php else:?>
        <h1>Login</h1>
        <form id="loginForm" action="process.php" method="post">
          <div class="form-group">
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" maxlength="10" placeholder="98XXXXXXX" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
          </div>
          <input type="submit" value="Login" name="login" class="btn btn-primary">
        </form>
      <?php endif?>
      
    </div>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Webmaster</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
      var phoneNumber = document.getElementById("phoneNumber").value;
      if (!isValidPhoneNumber(phoneNumber)) {
        event.preventDefault(); // Prevent form submission
        alert("Invalid phone number. Please enter only numbers.");
      }
      if(length(phoneNumber) != 10){
        event.preventDefault(); // Prevent form submission
        alert("Should have 10 numbers.");
      }
    });

    function isValidPhoneNumber(phoneNumber) {
      return /^\d+$/.test(phoneNumber);
    }

  </script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>