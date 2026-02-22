<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$msg = "";
if (isset($_GET['err'])) {
    if ($_GET['err'] == 'empty') $msg = "Please fill all fields.";
    if ($_GET['err'] == 'code_taken') $msg = "Trainer code already taken.";
    if ($_GET['err'] == 'db') $msg = "Database error. Try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>I am a Trainer | Join FitTrack</title>

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
  color: #ff5555;
  background: rgba(255,0,0,0.1);
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 20px;
  font-size: 14px;
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
  <h1>Trainer Registration</h1>
  
  <?php if($msg): ?>
    <div class="msg"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form action="php/admin_auth.php" method="POST">
    <input type="hidden" name="action" value="register">

    <label>
      <input type="text" name="username" placeholder="Full Name" required>
    </label>

    <label>
      <input type="email" name="email" placeholder="Email Address" required>
    </label>

    <label>
      <input type="text" name="trainer_code" placeholder="Create your Trainer Code (e.g. TRAINER2024)" required>
    </label>

    <label>
      <input type="password" name="password" placeholder="Password" required>
    </label>

    <button type="submit">Register as Trainer</button>

    <div class="footer">
      Already registered? <a href="admin_login.php">Login here</a>
    </div>
  </form>
</main>

</body>
</html>
