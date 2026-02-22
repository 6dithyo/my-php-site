<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password | FitTrack</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
  background: url('assets/images/login-bg-3.jpg') center/cover no-repeat;
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
  text-align: center;
}

h1 {
  margin-bottom: 10px;
  font-size: 26px;
  font-weight: 600;
}

p {
  color: var(--muted);
  font-size: 14px;
  margin-bottom: 24px;
  line-height: 1.5;
}

/* ================= FORM ================= */
input {
  width: 100%;
  padding: 14px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(0,0,0,0.3);
  color: #fff;
  font-size: 15px;
  font-family: inherit;
  margin-bottom: 20px;
}

input:focus {
  border-color: var(--accent);
  outline: none;
  background: rgba(0,0,0,0.5);
}

button {
  width: 100%;
  padding: 16px;
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

.footer {
  margin-top: 24px;
  font-size: 14px;
  color: var(--muted);
}

.footer a {
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
}
</style>
</head>
<body>

<main>
  <h1>Reset Password</h1>
  <p>Enter your email address to receive a reset link.</p>

  <form action="php/forgot_password.php" method="POST">
    <input type="email" name="email" placeholder="Email Address" required>
    <button type="submit">Send Reset Link</button>
  </form>

  <div class="footer">
    Remembered? <a href="login.php">Login here</a>
  </div>
</main>

</body>
</html>
