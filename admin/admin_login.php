<?php
session_start();
$msg = "";
if (isset($_GET['registered'])) $msg = "Registration successful! Please login.";
if (isset($_GET['err']) && $_GET['err'] == 'invalid') $msg = "Invalid email or password.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trainer Login | FitTrack</title>

<style>
/* ================= CSS VARIABLES ================= */
:root {
  --accent: #ff7b00;
  --accent-2: #ff9a36;
  --text: #ffffff;
  --muted: rgba(255,255,255,0.7);
  --glass-bg: rgba(255,255,255,0.08);
  --glass-border: rgba(255,255,255,0.14);
  --radius: 22px;
  --shadow: 0 18px 50px rgba(0,0,0,0.55);
  font-family: 'Poppins', sans-serif;
  color-scheme: dark;
}

/* ================= RESET ================= */
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }

/* ================= BACKGROUND ================= */
body {
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  color: #fff;
  background: #121212;
}

body::before {
  content: "";
  position: fixed;
  inset: 0;
  background: url('../assets/images/gym_hero_new.jpg') center/cover no-repeat;
  filter: brightness(0.4);
  z-index: -2;
}

/* ================= CARD ================= */
main {
  width: min(400px, 92vw);
  padding: 40px;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
  );
  border-radius: var(--radius);
  border: 1px solid var(--glass-border);
  box-shadow: var(--shadow);
  backdrop-filter: blur(20px);
}

h1 {
  text-align: center;
  margin-bottom: 24px;
  font-size: 26px;
  font-weight: 600;
}

/* ================= FORM ================= */
label {
  display: block;
  margin-bottom: 14px;
}

input {
  width: 100%;
  padding: 14px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(0,0,0,0.3);
  color: #fff;
  font-size: 15px;
  font-family: inherit;
}

input:focus {
  border-color: var(--accent);
  outline: none;
  background: rgba(0,0,0,0.5);
}

button {
  width: 100%;
  padding: 16px;
  margin-top: 20px;
  border-radius: 14px;
  border: none;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  color: #fff;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  transition: transform 0.2s;
}

button:hover {
  transform: translateY(-2px);
}

/* ================= UTILS ================= */
.msg {
  text-align: center;
  color: #4cd137;
  background: rgba(76, 209, 55, 0.1);
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 14px;
}
.err {
  color: #ff5555;
  background: rgba(255,0,0,0.1);
}

.footer {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
  color: var(--muted);
}

.footer a {
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<main>
  <h1>Trainer Login</h1>
  
  <?php if($msg): ?>
    <div class="msg <?php if(strpos($msg, 'Invalid')!==false) echo 'err'; ?>">
      <?= htmlspecialchars($msg) ?>
    </div>
  <?php endif; ?>

  <form action="php/admin_auth.php" method="POST">
    <input type="hidden" name="action" value="login">

    <label>
      <input type="email" name="email" placeholder="Email Address" required>
    </label>

    <label style="position:relative;">
      <input type="password" name="password" id="password" placeholder="Password" required>
      <span onclick="togglePassword()" style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer; font-size:18px;">👁️</span>
    </label>

    <button type="submit">Login</button>

    <div class="footer">
      <a href="../forgot.php" style="display:block; margin-bottom:10px; font-size:13px; color:var(--text-muted);">Forgot Password?</a>
      New Trainer? <a href="admin_register.php">Register here</a>
    </div>
  </form>
</main>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</body>
</html>
