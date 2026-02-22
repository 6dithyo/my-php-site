<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FitTrack — Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
/* ================= CSS VARIABLES ================= */
:root {
  --primary: #ff7b00;
  --primary-hover: #e06c00;
  --text: #ffffff;
  --text-muted: rgba(255,255,255,0.7);
  --glass-bg: rgba(255,255,255,0.08);
  --glass-border: rgba(255,255,255,0.14);
  --card-shadow: 0 12px 30px rgba(0,0,0,0.3);
  --radius: 16px;
  --blur: blur(12px);
  font-family: 'Inter', system-ui, sans-serif;
}

/* ================= RESET & BASE ================= */
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: #111;
    color: var(--text);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
}

/* Background Slideshow (Match Login) */
.bg-layer {
    position: fixed;
    inset: 0;
    z-index: -2;
    background-size: cover;
    background-position: center;
    transition: background-image 0.5s ease-in-out;
}
.bg-overlay {
    position: fixed;
    inset: 0;
    z-index: -1;
    background: rgba(10,10,12,0.65);
    backdrop-filter: blur(8px);
}

/* ================= LAYOUT ================= */
.container {
    max-width: 1200px;
    width: 95%;
    margin: 30px auto;
    padding-bottom: 50px;
}

/* Header */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    backdrop-filter: var(--blur);
}
header h1 { font-size: 24px; font-weight: 700; color: var(--primary); }
.btn-logout {
    color: var(--text);
    text-decoration: none;
    font-weight: 600;
    background: rgba(255,255,255,0.1);
    padding: 8px 16px;
    border-radius: 8px;
    transition: background 0.2s;
}
.btn-logout:hover { background: rgba(255,255,255,0.2); }

/* Grid System */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 24px;
}

/* Cards */
.card {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    padding: 24px;
    box-shadow: var(--card-shadow);
    backdrop-filter: var(--blur);
}

/* Stats Row */
.stats-container {
    grid-column: span 12;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}
.stat-card {
    text-align: center;
    padding: 20px;
    background: rgba(255,255,255,0.05); /* Slightly different bg */
}
.stat-card h3 { font-size: 32px; color: var(--primary); margin: 10px 0; }
.stat-card p { color: var(--text-muted); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }

/* Main Columns */
.col-left { grid-column: span 12; display: flex; flex-direction: column; gap: 24px; }
.col-right { grid-column: span 12; display: flex; flex-direction: column; gap: 24px; }

@media(min-width: 992px) {
    .col-left { grid-column: span 7; } /* Meals are wider */
    .col-right { grid-column: span 5; } /* Workouts */
}

/* Section Titles */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.section-title { font-size: 20px; font-weight: 600; }

/* Lists */
.list-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 400px;
    overflow-y: auto;
    padding-right: 5px; /* For scrollbar space */
}
.list-item {
    background: rgba(0,0,0,0.2);
    padding: 15px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 3px solid var(--primary);
}
.list-item-content { display: flex; flex-direction: column; gap: 4px; }
.item-title { font-weight: 600; font-size: 16px; }
.item-meta { font-size: 13px; color: var(--text-muted); }
.btn-delete {
    background: none; border: none; color: #ff4d4d; cursor: pointer; opacity: 0.6; padding: 5px;
}
.btn-delete:hover { opacity: 1; }

/* Forms */
.add-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
input, textarea, select {
    background: rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 12px;
    border-radius: 8px;
    flex: 1;
    min-width: 120px;
}
input:focus { outline: none; border-color: var(--primary); }
button.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    white-space: nowrap;
}
button.btn-primary:hover { background: var(--primary-hover); transform: translateY(-1px); }

/* Notes */
textarea.notes-box {
    width: 100%;
    min-height: 150px;
    resize: vertical;
    font-family: inherit;
    line-height: 1.5;
}

/* Theme Switcher */
.theme-picker {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--glass-bg);
    padding: 10px;
    border-radius: 30px;
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    display: flex;
    gap: 10px;
    z-index: 100;
}
.theme-dot {
    width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid rgba(255,255,255,0.2);
}
.theme-dot:hover { transform: scale(1.1); }

/* Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }

/* Utility */
.text-primary { color: var(--primary); }

/* CHAT BUBBLES */
.chat-msg {
    padding: 10px 14px; 
    border-radius: 12px;
    max-width: 80%;
    font-size: 14px;
    margin-bottom: 8px;
    line-height: 1.4;
    position: relative;
    word-wrap: break-word;
}
.chat-sent {
    align-self: flex-end;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    border-bottom-right-radius: 2px;
    box-shadow: 0 4px 15px rgba(255, 123, 0, 0.3);
}
.chat-received {
    align-self: flex-start;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.1);
    color: #e0e0e0;
    border-bottom-left-radius: 2px;
}
</style>
</head>
<body>

<div class="bg-layer" id="bgLayer" style="background-image: url('assets/images/fit2.jpg');"></div>
<div class="bg-overlay"></div>

<div class="container">
    <header>
        <div>
            <h1>FitTrack</h1>
            <div id="userHeaderDetails" style="font-size:14px; color:var(--text-muted); margin-top:5px;">
                Welcome, <span id="userNameDisplay">Member</span>
                <span id="userEmailDisplay" style="font-size:12px; opacity:0.7; margin-left:10px;"></span>
            </div>
        </div>
        <div style="display:flex; gap:15px; align-items:center;">
             <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </header>

    <div class="dashboard-grid">
        
        <!-- Stats -->
        <div class="stats-container card">
            <div class="stat-card">
                <p>Height</p>
                <h3 id="statHeight">--</h3>
                <span style="font-size:12px; opacity:0.6;">cm</span>
            </div>
            <div class="stat-card">
                <p>Weight</p>
                <h3 id="statWeight">--</h3>
                <span style="font-size:12px; opacity:0.6;">kg</span>
            </div>
             <div class="stat-card">
                <p>BMI</p>
                <h3 id="statBMI">--</h3>
                <span style="font-size:12px; opacity:0.6;">Index</span>
            </div>
            <div class="stat-card" style="border: 1px solid var(--primary);">
                <p>Calories Today</p>
                <h3 id="statCalories">0</h3>
                <span style="font-size:12px; opacity:0.6;">kcal</span>
            </div>
        </div>

        <!-- Left Column: Meals -->
        <div class="col-left">
            <div class="card">
                <div class="section-header">
                    <div class="section-title">Log Meal</div>
                </div>
                <form id="mealForm" class="add-form">
                    <input type="text" id="mealName" placeholder="Meal Name (e.g. Oatmeal)" required style="flex:2;">
                    <input type="number" id="mealCals" placeholder="Kcal" required style="flex:1;">
                    <input type="number" id="mealProtein" placeholder="Prot (g)" style="flex:1;">
                    <input type="number" id="mealCarbs" placeholder="Carbs (g)" style="flex:1;">
                    <input type="number" id="mealFat" placeholder="Fat (g)" style="flex:1;">
                    <button type="submit" class="btn-primary">Add</button>
                </form>
            </div>

            <div class="card" style="flex:1;">
                <div class="section-header">
                    <div class="section-title">Today's Meals</div>
                </div>
                <div id="mealList" class="list-group">
                    <!-- Dynamic Meals Here -->
                    <div style="text-align:center; padding:20px; color:var(--text-muted);">Loading...</div>
                </div>
            </div>
        </div>

        <!-- Right Column: Workouts & Notes -->
        <div class="col-right">
             <div class="card">
                <div class="section-header">
                    <div class="section-title">Log Workout</div>
                </div>
                <form id="workoutForm" class="add-form">
                    <input type="text" id="workoutName" placeholder="Exercise (e.g. Bench Press)" required style="flex:2;">
                    <input type="number" id="workoutSets" placeholder="Sets" style="flex:1;">
                    <input type="number" id="workoutReps" placeholder="Reps" style="flex:1;">
                     <input type="number" id="workoutWeight" placeholder="Kg" style="flex:1;">
                    <button type="submit" class="btn-primary">Add</button>
                </form>
            </div>

             <div class="card">
                <div class="section-header">
                    <div class="section-title">Recent Workouts</div>
                </div>
                <div id="workoutList" class="list-group" style="max-height:250px;">
                    <!-- Dynamic Workouts Here -->
                     <div style="text-align:center; padding:20px; color:var(--text-muted);">Loading...</div>
                </div>
            </div>

            <div class="card" style="flex:1;">
                 <div class="section-header">
                    <div class="section-title">My Trainer</div>
                </div>
                <div id="trainerSection">
                    <p style="color:var(--text-muted); margin-bottom:10px; font-size:13px;">Enter code to connect with a trainer.</p>
                    <form id="linkTrainerForm" style="display:flex; gap:10px;">
                        <input type="text" id="trainerCodeInput" placeholder="Code" required style="min-width:80px;">
                        <button type="submit" class="btn-primary" style="padding:10px;">Link</button>
                    </form>
                </div>
            </div>

            <div class="card" style="flex:1;">
                 <div class="section-header">
                    <div class="section-title">Personal Notes</div>
                    <button id="saveNoteBtn" class="btn-primary" style="padding: 5px 15px; font-size:12px;">Save</button>
                </div>
                <textarea id="notesArea" class="notes-box" placeholder="Jot down your progress, goals, or thoughts..."></textarea>
                <div id="noteStatus" style="font-size:12px; color:var(--primary); margin-top:5px; height:15px; opacity:0; transition:opacity 0.5s;">Saved!</div>
            </div>
        </div>

    </div>
    </div>
</div>

<!-- ================= CHAT WIDGET (MEMBER) ================= -->
<div id="chatWidget" style="position:fixed; bottom:80px; right:20px; z-index:1000; display:flex; flex-direction:column; align-items:flex-end;">
    
    <!-- Chat Window -->
    <div id="chatWindow" class="card" style="width:320px; height:400px; display:none; flex-direction:column; padding:0; overflow:hidden; margin-bottom:15px;">
        <div style="background:var(--primary); padding:15px; color:white; font-weight:600; display:flex; justify-content:space-between; align-items:center;">
            <span>Trainer Chat</span>
            <span onclick="toggleChat()" style="cursor:pointer;">✕</span>
        </div>
        
        <div id="msgArea" style="flex:1; background:rgba(0,0,0,0.5); padding:15px; overflow-y:auto; display:flex; flex-direction:column; gap:10px;">
            <div style="text-align:center; color:#aaa; font-size:13px; margin-top:20px;">Fetching messages...</div>
        </div>

        <form id="sendMsgForm" style="padding:10px; background:rgba(255,255,255,0.05); display:flex;">
            <input type="text" id="msgInput" placeholder="Message..." style="border-radius:0; border:none; background:transparent;" autocomplete="off">
            <button type="submit" style="width:auto; padding:0 15px; border-radius:4px;">➤</button>
        </form>
    </div>

    <!-- Chat Button -->
    <button onclick="toggleChat()" style="width:60px; height:60px; border-radius:50%; background:var(--primary); border:none; color:white; font-size:24px; box-shadow:0 10px 20px rgba(0,0,0,0.3); cursor:pointer; display:flex; align-items:center; justify-content:center;">
        💬
    </button>
</div>

<div class="theme-picker">
    <div class="theme-dot" style="background: url('assets/images/fit2.jpg') center/cover;" onclick="changeBg('assets/images/fit2.jpg')"></div>
    <div class="theme-dot" style="background: url('assets/images/gympic4.jpeg') center/cover;" onclick="changeBg('assets/images/gympic4.jpeg')"></div>
    <div class="theme-dot" style="background: url('assets/images/gympic5.jpeg') center/cover;" onclick="changeBg('assets/images/gympic5.jpeg')"></div>
</div>

<script>
// ================= STATE =================
let state = {
    meals: [],
    workouts: [],
    user: {}
};

// ================= API CALLS =================
async function fetchData() {
    try {
        const res = await fetch('php/api_dashboard.php');
        const data = await res.json();
        
        if (data.error) {
            console.error(data.error);
            return;
        }

        state.user = data.user || {};
        state.meals = data.meals || [];
        state.workouts = data.workouts || [];
        
        // Update Header
        if(state.user.username) {
            document.getElementById('userNameDisplay').innerText = state.user.username;
            document.getElementById('userEmailDisplay').innerText = state.user.email;
        }

        renderStats();
        renderMeals();
        renderWorkouts();
        renderNotes();

    } catch (err) {
        console.error("Failed to load dashboard data", err);
    }
}

async function addMeal(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('meal', document.getElementById('mealName').value);
    formData.append('calories', document.getElementById('mealCals').value);
    formData.append('protein', document.getElementById('mealProtein').value);
    formData.append('carbs', document.getElementById('mealCarbs').value);
    formData.append('fat', document.getElementById('mealFat').value);

    try {
        const res = await fetch('php/api_meal.php', { method: 'POST', body: formData });
        const result = await res.json();

        if (result.success) {
            document.getElementById('mealForm').reset();
            fetchData(); // Refresh all to get accurate totals
        } else {
            alert(result.message);
        }
    } catch (err) { console.error(err); }
}

async function addWorkout(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('workout', document.getElementById('workoutName').value);
    formData.append('sets', document.getElementById('workoutSets').value);
    formData.append('reps', document.getElementById('workoutReps').value);
    formData.append('weight', document.getElementById('workoutWeight').value);

    try {
        const res = await fetch('php/api_workout.php', { method: 'POST', body: formData });
        const result = await res.json();
        
        if (result.success) {
            document.getElementById('workoutForm').reset();
            fetchData(); 
        } else {
            alert(result.message);
        }
    } catch (err) { console.error(err); }
}

async function deleteItem(type, id) {
    if(!confirm("Are you sure?")) return;
    try {
        const endpoint = type === 'meal' ? 'php/api_meal.php' : 'php/api_workout.php';
        await fetch(endpoint, { 
            method: 'DELETE', 
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `id=${id}` 
        });
        fetchData();
    } catch(err) { console.error(err); }
}

async function saveNotes() {
    const notes = document.getElementById('notesArea').value;
    const formData = new FormData();
    formData.append('notes', notes);

    try {
        await fetch('php/save_note.php', { method: 'POST', body: formData });
        const status = document.getElementById('noteStatus');
        status.style.opacity = '1';
        setTimeout(() => status.style.opacity = '0', 2000);
    } catch(err) { console.error(err); }
}

// ================= RENDERERS =================
function renderStats() {
    if(state.user.height) document.getElementById('statHeight').innerText = state.user.height;
    if(state.user.weight) document.getElementById('statWeight').innerText = state.user.weight;
    if(state.user.bmi) document.getElementById('statBMI').innerText = state.user.bmi;
    
    // Calculate total calories
    const totalCals = state.meals.reduce((acc, m) => acc + parseInt(m.calories), 0);
    document.getElementById('statCalories').innerText = totalCals;
}

function renderMeals() {
    const list = document.getElementById('mealList');
    list.innerHTML = '';
    
    if (state.meals.length === 0) {
        list.innerHTML = '<div style="text-align:center; color:var(--text-muted); padding:10px;">No meals logged today.</div>';
        return;
    }

    state.meals.forEach(meal => {
        const div = document.createElement('div');
        div.className = 'list-item';
        div.innerHTML = `
            <div class="list-item-content">
                <span class="item-title">${meal.meal_name}</span>
                <span class="item-meta">${meal.calories} kcal • P: ${meal.protein}g • C: ${meal.carbs}g • F: ${meal.fat}g</span>
            </div>
            <button class="btn-delete" onclick="deleteItem('meal', ${meal.id})">✕</button>
        `;
        list.appendChild(div);
    });
}

function renderWorkouts() {
    const list = document.getElementById('workoutList');
    list.innerHTML = '';

    if (state.workouts.length === 0) {
        list.innerHTML = '<div style="text-align:center; color:var(--text-muted); padding:10px;">No recent workouts.</div>';
        return;
    }

    state.workouts.forEach(w => {
        const div = document.createElement('div');
        div.className = 'list-item';
        div.style.borderLeftColor = '#00c6ff'; // Different accent for workouts
        div.innerHTML = `
            <div class="list-item-content">
                <span class="item-title">${w.workout}</span>
                <span class="item-meta">${w.sets} sets x ${w.reps} reps @ ${w.lift_weight}kg</span>
            </div>
            <button class="btn-delete" onclick="deleteItem('workout', ${w.id})">✕</button>
        `;
        list.appendChild(div);
    });
}

function renderNotes() {
    document.getElementById('notesArea').value = state.user.notes || '';
}

function changeBg(url) {
    document.getElementById('bgLayer').style.backgroundImage = `url('${url}')`;
}

// ================= INIT =================
document.getElementById('mealForm').addEventListener('submit', addMeal);
document.getElementById('workoutForm').addEventListener('submit', addWorkout);
document.getElementById('saveNoteBtn').addEventListener('click', saveNotes);

// ================= TRAINER LINKING =================
async function checkTrainer() {
    // In a real app, we'd fetch this from api_dashboard.php
    // For now, let's just use the form submission
}

document.getElementById('linkTrainerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const code = document.getElementById('trainerCodeInput').value;
    const formData = new FormData();
    formData.append('code', code);
    
    try {
        const res = await fetch('php/api_link_trainer.php', { method: 'POST', body: formData });
        const data = await res.json();
        alert(data.message);
        if(data.success) {
            document.getElementById('trainerSection').innerHTML = `<p style="color:#4dff94;">✅ Linked to trainer!</p>`;
        }
    } catch(err) { console.error(err); }
});

// ================= CHAT LOGIC =================
let isChatOpen = false;
let trainerId = null; 

// Initial check for trainer
async function initChat() {
    // We need to know who the trainer is. 
    // Usually we would get this from 'fetchData' if we return user details including assigned_trainer_id
    // For now, let's assume 'state.user.assigned_trainer_id' exists after fetchData
}

function toggleChat() {
    const win = document.getElementById('chatWindow');
    isChatOpen = !isChatOpen;
    win.style.display = isChatOpen ? 'flex' : 'none';
    if(isChatOpen) {
        scrollToBottom();
        // Start polling
        loadMemberMessages();
    }
}

async function loadMemberMessages() {
    if(!state.user.assigned_trainer_id) {
        document.getElementById('msgArea').innerHTML = '<div style="text-align:center; padding:20px; color:#aaa;">Link a trainer first to chat!</div>';
        return;
    }
    trainerId = state.user.assigned_trainer_id;

    const res = await fetch(`php/api_chat.php?action=fetch&other_id=${trainerId}`);
    const data = await res.json();
    const area = document.getElementById('msgArea');
    area.innerHTML = '';

    if(data.messages) {
        data.messages.forEach(msg => {
            const div = document.createElement('div');
            // Check sender. If sender_id == my id (state.user.id) -> sent
            const isMe = msg.sender_id == state.user.id;
            
            div.className = isMe ? 'chat-msg chat-sent' : 'chat-msg chat-received';
            div.innerText = msg.message;
            area.appendChild(div);
        });
        scrollToBottom();
    }
}

function scrollToBottom() {
    const area = document.getElementById('msgArea');
    area.scrollTop = area.scrollHeight;
}

document.getElementById('sendMsgForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if(!trainerId) return;
    
    const inp = document.getElementById('msgInput');
    const msg = inp.value.trim();
    if(!msg) return;

    const fd = new FormData();
    fd.append('receiver_id', trainerId);
    fd.append('message', msg);

    await fetch('php/api_chat.php?action=send', { method:'POST', body:fd });
    inp.value = '';
    loadMemberMessages();
});

// Poll for messages if open
setInterval(() => {
    if(isChatOpen && trainerId) {
        loadMemberMessages();
    }
}, 5000);

// Load data on start
fetchData().then(() => {
    // user data loaded
    if(!state.user.assigned_trainer_id) {
         // Maybe hide chat button or show tooltip?
    }
});

</script>
</body>
</html>
