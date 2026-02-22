<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'trainer') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trainer Dashboard | FitTrack</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #ff7b00;
  --text: #ffffff;
  --text-muted: rgba(255,255,255,0.7);
  --glass-bg: rgba(255,255,255,0.08);
  --glass-border: rgba(255,255,255,0.14);
  --radius: 16px;
  --blur: blur(12px);
  font-family: 'Inter', system-ui, sans-serif;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: #111;
    color: var(--text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.bg-layer {
    position: fixed; inset: 0; z-index: -2;
    background: url('assets/images/fit2.jpg') center/cover;
}
.bg-overlay {
    position: fixed; inset: 0; z-index: -1;
    background: rgba(10,10,12,0.75);
    backdrop-filter: blur(8px);
}
.container {
    max-width: 1200px; width: 95%; margin: 30px auto;
}
header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px; background: rgba(255,255,255,0.05);
    border: 1px solid var(--glass-border); border-radius: var(--radius);
    margin-bottom: 30px;
}
h1 { font-size: 24px; color: var(--primary); }
.trainer-code {
    background: rgba(255,123,0,0.2); border: 1px solid var(--primary);
    padding: 5px 10px; border-radius: 6px; font-family: monospace; letter-spacing: 1px;
}
.grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;
}
.card {
    background: var(--glass-bg); border: 1px solid var(--glass-border);
    border-radius: var(--radius); padding: 20px;
    transition: transform 0.2s; cursor: pointer;
}
.card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.12); }
.member-name { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
.member-stat { font-size: 14px; color: var(--text-muted); }

/* Modal */
.modal {
    display: none; position: fixed; inset: 0; z-index: 100;
    justify-content: center; align-items: center;
    background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);
}
.modal-content {
    background: #1a1a1c; border: 1px solid var(--glass-border);
    width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto;
    border-radius: var(--radius); padding: 30px; position: relative;
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
.close-btn {
    position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: var(--text-muted);
}
.close-btn:hover { color: #fff; }
.modal-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;
}
h3 { color: var(--primary); margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 5px; }
.list-item {
    background: rgba(255,255,255,0.05); padding: 10px; border-radius: 8px; margin-bottom: 8px; font-size: 14px;
}
@media(max-width: 768px) { .modal-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>

<div class="bg-layer"></div>
<div class="bg-overlay"></div>

<div class="container">
    <header>
        <div>
            <h1>Trainer Dashboard</h1>
            <div style="margin-top:5px; font-size:14px; color:var(--text-muted);">
                Your Invite Code: <span id="trainerCode" class="trainer-code">LOADING</span>
            </div>
        </div>
        <a href="logout.php" style="color:#fff; text-decoration:none; font-weight:600;">Logout</a>
    </header>

    <div id="membersGrid" class="grid">
        <div style="grid-column:1/-1; text-align:center; color:var(--text-muted);">Loading members...</div>
    </div>
</div>

<!-- Modal -->
<div id="memberModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">×</span>
        <h2 id="mName">Member Name</h2>
        <p id="mStats" style="color:var(--text-muted); margin-bottom:20px;">Stats...</p>
        
        <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:10px; margin-bottom:20px;">
            <strong>Notes:</strong> <span id="mNotes" style="font-style:italic; color:#ccc;"></span>
        </div>

        <div class="modal-grid">
            <div>
                <h3>Recent Meals</h3>
                <div id="mMeals"></div>
            </div>
            <div>
                <h3>Recent Workouts</h3>
                <div id="mWorkouts"></div>
            </div>
        </div>
    </div>
</div>

<script>
async function loadDashboard() {
    try {
        const res = await fetch('php/api_trainer.php');
        const data = await res.json();
        
        if (data.error) {
            alert(data.error);
            return;
        }

        document.getElementById('trainerCode').innerText = data.trainer_code;
        renderMembers(data.members);
    } catch (err) { console.error(err); }
}

function renderMembers(members) {
    const grid = document.getElementById('membersGrid');
    grid.innerHTML = '';
    
    if (members.length === 0) {
        grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:40px; color:var(--text-muted);">No members linked yet. Share your code!</div>';
        return;
    }

    members.forEach(m => {
        const card = document.createElement('div');
        card.className = 'card';
        card.onclick = () => openMember(m.id);
        card.innerHTML = `
            <div class="member-name">${m.username}</div>
            <div class="member-stat">Height: ${m.height}cm • Weight: ${m.weight}kg</div>
            <div class="member-stat">Joined: ${new Date(m.created_at).toLocaleDateString()}</div>
        `;
        grid.appendChild(card);
    });
}

async function openMember(id) {
    const modal = document.getElementById('memberModal');
    modal.style.display = 'flex';
    
    // Clear previous
    document.getElementById('mName').innerText = 'Loading...';
    document.getElementById('mStats').innerText = '';
    document.getElementById('mNotes').innerText = '';
    document.getElementById('mMeals').innerHTML = '';
    document.getElementById('mWorkouts').innerHTML = '';

    try {
        const res = await fetch(`php/api_member_details.php?member_id=${id}`);
        const data = await res.json();
        
        if (data.error) {
            alert(data.error);
            closeModal();
            return;
        }
        
        const m = data.member;
        document.getElementById('mName').innerText = m.username;
        document.getElementById('mStats').innerText = `Height: ${m.height}cm • Weight: ${m.weight}kg`;
        document.getElementById('mNotes').innerText = m.notes || 'No notes.';

        // Meals
        const mealDiv = document.getElementById('mMeals');
        if (data.meals && data.meals.length > 0) {
            data.meals.forEach(meal => {
                mealDiv.innerHTML += `
                    <div class="list-item">
                        <strong>${meal.meal_name}</strong> <br>
                        <span style="color:var(--text-muted)">${meal.calories} kcal • ${new Date(meal.meal_time).toLocaleDateString()}</span>
                    </div>`;
            });
        } else {
             mealDiv.innerHTML = '<div style="color:var(--text-muted)">No recent meals.</div>';
        }

        // Workouts
        const workDiv = document.getElementById('mWorkouts');
        if (data.workouts && data.workouts.length > 0) {
            data.workouts.forEach(w => {
                 workDiv.innerHTML += `
                    <div class="list-item" style="border-left:2px solid #00c6ff;">
                        <strong>${w.workout}</strong> <br>
                        <span style="color:var(--text-muted)">${w.sets}x${w.reps} • ${new Date(w.date).toLocaleDateString()}</span>
                    </div>`;
            });
        } else {
             workDiv.innerHTML = '<div style="color:var(--text-muted)">No recent workouts.</div>';
        }

    } catch(err) { console.error(err); }
}

function closeModal() {
    document.getElementById('memberModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('memberModal');
    if (event.target == modal) {
        closeModal();
    }
}

loadDashboard();
</script>

</body>
</html>
