<?php include('../config/db.php'); ?>
<title>Register — TimeZone Watches</title>
<link rel="stylesheet" href="../assets/css/style.css" />

</head>











<body>






<?php 



$error = "";

if(isset($_POST['submit'])){

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $pass  = $_POST['password'];
    $cpass = $_POST['c_password'];
    $role = "user"; 

    $emailcheck = mysqli_query($admin,"SELECT * FROM users WHERE email='$email'");

    if(empty($name) || empty($email) || empty($phone) || empty($pass) || empty($cpass)){
        echo "<script>alert('All fields are required');</script>";
    }

    elseif(!preg_match("/^03[0-9]{9}$/", $phone)){
        echo "<script>alert('Phone must be like 03XXXXXXXXX');</script>";
    }

    elseif(strlen($pass) < 8){
        echo "<script>alert('Password must be at least 8 characters');</script>";
    }

    elseif($pass != $cpass){
        echo "<script>alert('Confirm Password does not match');</script>";
    }

    elseif(mysqli_num_rows($emailcheck) > 0){
        echo "<script>alert('Email Already Registered');</script>";
    }

    else{
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username,email,password, role) 
                  VALUES('$name','$email','$hashpass','$role')";

        $res = mysqli_query($admin,$query);

        if($res){
            header('location: login.php');
            exit();
        } else {
            echo "<script>alert('User registration Unsuccessful');</script>";
        }
    }
}
?>




  <div class="auth-page">
    <div class="auth-left">
      <img src="https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=900&h=1200&fit=crop" alt="Luxury Watch">
      <div class="auth-left-overlay">
        <div class="auth-left-quote">
          Join a world of <em>precision & luxury.</em>
        </div>
      </div>
    </div>

    <div class="auth-right">
      <div class="auth-box">
        <div class="auth-logo">Time<span>Zone</span></div>
        <div class="auth-tagline">Luxury Timepieces</div>
        <div class="auth-title">Create Account</div>
        <div class="auth-subtitle">Already have an account? <a href="login.php">Sign in →</a></div>

        <div class="error-msg" id="errorMsg" style="background-color:red ; width: 10px;">

          <?php echo $error; ?>

        </div>
        <form method="post">
            <div class="form-group ">
              <label class="form-label">Full Name</label>
              <input type="text" class="form-input col-full" name="name" id="fname" placeholder="John">
            </div>

          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-input" id="email" name="email" placeholder="your@email.com">
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-input" id="phone" name="phone" placeholder="03000-0000">
          </div>
          <!-- <div class="form-group"> -->
                <!-- <label class="tz-label">Role</label> -->
          <!-- <select name="role" class="form-select">
        <option value="student" selected>user</option>
        <option value="admin">Admin</option>
    </select><br></div> -->
          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" class="form-input" id="password" name="password" placeholder="Min. 8 characters"
              oninput="checkStrength(this.value)">
            <div class="password-strength">
              <div class="strength-bar" id="s1"></div>
              <div class="strength-bar" id="s2"></div>
              <div class="strength-bar" id="s3"></div>
              <div class="strength-bar" id="s4"></div>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-input" id="confirm" name="c_password" placeholder="Repeat password">
          </div>
          <div class="terms-row">
            <input type="checkbox" id="terms">
            <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>. I
              consent to receiving order updates via email.</label>
          </div>
          <input type="submit" value="Create Account →" class="submit-btn" name="submit">
        </form>
      </div>
    </div>
  </div>


  <script src="../assets/js/app.js"></script>


  <script>
    function checkStrength(val) {
      const bars = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val)) score++;
      if (/[0-9]/.test(val)) score++;
      if (/[^A-Za-z0-9]/.test(val)) score++;
      const colors = ['#c0392b', '#e67e22', '#f1c40f', '#27ae60'];
      bars.forEach((b, i) => {
        b.style.background = i < score ? colors[score - 1] : 'var(--border)';
      });
    }

  </script>