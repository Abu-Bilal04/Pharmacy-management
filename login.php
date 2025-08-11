<?php include "include/server.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rukayyah Pharmacy - Login</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- iziToast -->
  <link href="iziToast/css/iziToast.min.css" rel="stylesheet" />
  <script src="iziToast/js/iziToast.min.js" type="text/javascript"></script>

  <style>
    body {
      background: linear-gradient(135deg, #4f46e5, #3b82f6);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Open Sans', sans-serif;
    }
    .login-container {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }
    .login-image {
      background: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/Login-ill.jpg') center/cover no-repeat;
      position: relative;
      min-height: 100%;
    }
    .login-image::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom right, rgba(59,130,246,0.6), rgba(99,102,241,0.6));
    }
    .login-image-text {
      position: relative;
      z-index: 1;
      color: white;
    }
  </style>
</head>
<body>

<?php if (isset($_GET['msg']) && $_GET['msg'] == "error") { ?>
<script>
  iziToast.error({
    title: '',
    message: 'Error, try again',
    position: 'topCenter',
    animateInside: true
  });
</script>
<?php } ?>

<div class="login-container row g-0">
  
  <!-- Left Image Panel -->
  <div class="col-md-6 d-none d-md-block login-image p-5 d-flex align-items-center justify-content-center text-center">
    <div class="login-image-text">
      <h4 class="fw-bold mb-3">"Attention is the new currency"</h4>
      <p class="lead">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
    </div>
  </div>

  <!-- Right Form Panel -->
  <div class="col-md-6 p-5">
    <div class="mb-4">
      <h4 class="fw-bold">Welcome Back</h4>
      <p class="text-muted">Enter your username and password to log in</p>
    </div>
    
    <form method="POST">
      <div class="mb-3">
        <input type="text" name="username" placeholder="Username" 
          class="form-control form-control-lg" required />
      </div>
      <div class="mb-4">
        <input type="password" name="password" placeholder="Password" 
          class="form-control form-control-lg" required />
      </div>
      <button name="login" class="btn btn-primary btn-lg w-100">
        Log in
      </button>
    </form>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
