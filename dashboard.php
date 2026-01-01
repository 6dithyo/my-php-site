<?php
session_start();
include 'php/db.php';
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Get user details
$stmt = $conn->prepare("SELECT username, email, height, weight, dob, notes FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Compute age
$age = date_diff(date_create($user['dob']), date_create('today'))->y;

// Compute BMI
$bmi = round($user['weight'] / pow(($user['height'] / 100), 2), 1);
$bmiStatus = ($bmi < 18.5) ? "Underweight" : (($bmi < 25) ? "Normal" : "Overweight");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>FitTrack — Dashboard</title>
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<!-- Top Navigation -->
<div class="topbar">
  <div class="logo">🏋️‍♂️ FitTrack</div>
  <a href="logout.php" class="logout-btn">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
  </a>
</div>

<div class="dashboard">

  <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?> 👋</h1>

  <!-- Profile Summary -->
  <div class="cards">
    <div class="card"><h3>Height</h3><p><?php echo $user['height']; ?> cm</p></div>
    <div class="card"><h3>Weight</h3><p><?php echo $user['weight']; ?> kg</p></div>
    <div class="card"><h3>BMI</h3><p><?php echo "$bmi ($bmiStatus)"; ?></p></div>
    <div class="card"><h3>Age</h3><p><?php echo $age; ?> years</p></div>
  </div>

  <!-- Workout Progress Logging -->
  <div class="section">
    <h2>Log Workout Progress</h2>
    <form action="php/save_progress.php" method="POST" class="form-inline">
      <input type="text" name="workout" placeholder="Workout name" required>
      <input type="number" name="sets" placeholder="Sets" required>
      <input type="number" name="reps" placeholder="Reps" required>
      <input type="number" step="0.1" name="lift_weight" placeholder="Weight lifted (kg)" required>
      <button type="submit">Save</button>
    </form>
  </div>

  <!-- Workout Chart -->
  <div class="section chart">
    <h2>Your Progress Over Time</h2>
    <canvas id="progressChart"></canvas>
  </div>

  <!-- Update Profile -->
  <div class="section">
    <h2>Update Profile</h2>
    <form action="php/update_profile.php" method="POST" class="form-inline">
      <input type="number" name="height" value="<?php echo $user['height']; ?>" placeholder="Height (cm)">
      <input type="number" name="weight" value="<?php echo $user['weight']; ?>" placeholder="Weight (kg)">
      <input type="date" name="dob" value="<?php echo $user['dob']; ?>">
      <button type="submit">Update</button>
    </form>
  </div>

  <!-- Personal Notes -->
  <div class="section">
    <h2>Personal Notes</h2>
    <form id="noteForm">
      <textarea id="noteText" rows="4"><?php echo htmlspecialchars($user['notes']); ?></textarea>
      <button type="button" class="btn" onclick="saveNote()">Save Note</button>
    </form>
    <p id="saveStatus" class="muted"></p>
  </div>

  <!-- Calorie Tracker -->
  <div class="section">
    <h2>Calorie Tracker — Today</h2>
    <div class="calorie-panel">
      <form id="mealForm" action="php/save_meal.php" method="POST" class="form-inline">
        <input type="text" name="meal_name" placeholder="Meal (Breakfast/Lunch)" required>
        <input type="number" name="calories" placeholder="Calories" required>
        <input type="number" step="0.1" name="protein" placeholder="Protein (g)">
        <input type="number" step="0.1" name="carbs" placeholder="Carbs (g)">
        <input type="number" step="0.1" name="fat" placeholder="Fat (g)">
        <button type="submit">Add Meal</button>
      </form>

      <div class="today-summary">
        <div class="today-total">
          <div class="muted">Today</div>
          <div id="todayCalories" style="font-size:22px;font-weight:700">0 kcal</div>
        </div>
        <div class="meal-list-wrapper">
          <ul id="mealList"></ul>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
// Progress Chart Loader
fetch('php/get_progress.php')
  .then(res => res.json())
  .then(data => {
    new Chart(document.getElementById('progressChart'), {
      type: 'line',
      data: {
        labels: data.dates,
        datasets: [{
          label: 'Weight Lifted (kg)',
          data: data.weights,
          borderColor: '#ff7b00',
          backgroundColor: 'rgba(255,123,0,0.2)',
          tension: 0.3
        }]
      },
      options: { maintainAspectRatio: false }
    });
  });

// Notes Save
function saveNote(){
  const note = document.getElementById('noteText').value;
  fetch('php/save_note.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'note=' + encodeURIComponent(note)
  })
  .then(res => res.text())
  .then(txt => document.getElementById('saveStatus').textContent = txt)
  .catch(err => alert('Error saving note'));
}

// Load Meals
function loadMeals() {
  fetch('php/get_meals.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById('todayCalories').textContent =
        (data.total_calories || 0) + ' kcal';

      const list = document.getElementById('mealList');
      list.innerHTML = '';

      if (!data.meals || data.meals.length === 0) {
        list.innerHTML = '<li class="muted">No meals logged today.</li>';
      } else {
        data.meals.forEach(m => {
          const time = new Date(m.meal_time).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
          const li = document.createElement('li');
          li.innerHTML = `<strong>${m.meal_name}</strong> — ${m.calories} kcal <span class="muted">(${time})</span>`;
          list.appendChild(li);
        });
      }
    });
}
loadMeals();

// Add Meal Handler
document.getElementById('mealForm').addEventListener('submit', function(e){
  e.preventDefault();
  fetch('php/save_meal.php', { method:'POST', body:new FormData(this) })
    .then(()=> { loadMeals(); this.reset(); })
    .catch(()=> alert('Failed to save meal'));
});
</script>

</body>
</html>
