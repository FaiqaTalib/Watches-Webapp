<?php include('../config/db.php'); ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — TimeZone Watches</title><link rel="stylesheet" href="../assets/css/style.css"/>
</head>
<body>
<?php


session_start();
include('../config/db.php');

  if (empty($email) || empty($pass)) {

      echo "<script>alert('all fields requires');</script>";
  }

if(isset($_POST['submit'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $query ="SELECT * FROM `users` WHERE email = '$email'";
  $res = mysqli_query($admin ,$query);
  $user  = mysqli_fetch_array($res , MYSQLI_ASSOC);
  if($user){
    if(password_verify($pass, $user['password'])){
    $_SESSION['userid']=$user['id'];
    $_SESSION['role']=$user['role'];
    $_SESSION['username']=$user['username'];
      if($user['role']=='admin'){
        header("location: ../../admin panel/pages/");
    }
    else{
        header("location: index.php");
    }

    }else{
      
      echo "<script>alert('incorrected password');</script>";
    }
  }else{
       echo "<script>alert('incorrected email');</script>";

  }

}
?>







<div class="auth-page">
  <div class="auth-left">
    <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=900&h=1200&fit=crop" alt="Luxury Watch">
    <div class="auth-left-overlay">
      <div class="auth-left-quote">
        Time is the most precious luxury <em>you can wear.</em>
      </div>
    </div>
  </div>

  <div class="auth-right">
    <div class="auth-box">
      <div class="auth-logo">Time<span>Zone</span></div>
      <div class="auth-tagline">Luxury Timepieces</div>
      <div class="auth-title">Welcome Back</div>
      <div class="auth-subtitle">
        Don't have an account? <a href="register.php">Create one →</a>
      </div>

      <div class="error-msg" id="errorMsg">Invalid email or password. Please try again.</div>



      <div class="auth-form">
        <form method="post">
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-input" id="email" placeholder="your@email.com">
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-input" id="password" placeholder="••••••••">
        </div>
        <div class="remember-row">
          <label class="remember-label">
            <input type="checkbox"> Remember me
          </label>
          <!-- <a href="#" class="forgot-link">Forgot password?</a> -->
        </div>
        <input class="submit-btn" name="submit" type="submit" value="Sign IN"> 
        </form>

      </div>

      
  </div>
</div>

<script src="../assets/js/app.js"></script>
<script>
function handleLogin() {
  const email = document.getElementById('email').value.trim();
  const pass = document.getElementById('password').value;
  const err = document.getElementById('errorMsg');

  if (!email || !pass) {
    err.textContent = 'Please fill in all fields.';
    err.classList.add('show'); return;
  }
  if (!email.includes('@')) {
    err.textContent = 'Please enter a valid email address.';
    err.classList.add('show'); return;
  }
  if (pass.length < 6) {
    err.textContent = 'Password must be at least 6 characters.';
    err.classList.add('show'); return;
  }

  // Demo login
  User.set({ name: email.split('@')[0], email });
  showToast('Welcome back!');

}

document.querySelectorAll('.form-input').forEach(input => {
  input.addEventListener('keydown', e => { if (e.key === 'Enter') handleLogin(); });
});
</script>
</body>
</html>
