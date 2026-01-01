<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Forgot Password — FitTrack</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<main class="card">
  <h1>Reset Password</h1>

  <form action="php/forgot_password.php" method="POST">
    <input class="input" type="email" name="email" placeholder="Enter your email" required>
    <button class="cta">Continue</button>
  </form>

  <p class="muted" style="margin-top:16px;text-align:center">
    Remembered? <a href="login.php" style="color:#ffb86b">Login</a>
  </p>
</main>

</body>
</html>
