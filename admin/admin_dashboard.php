<?php
session_start();
// Basic Admin Auth Check
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'trainer'])) {
    header("Location: admin_login.php");
    exit;
}
include "../includes/admin_db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trainer Dashboard | FitTrack</title>
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
}

/* Background Slideshow (Match Login) */
.bg-layer {
    position: fixed;
    inset: 0;
    z-index: -2;
    background: url('../assets/images/fit2.jpg') center/cover;
}
.bg-overlay {
    position: fixed;
    inset: 0;
    z-index: -1;
    background: rgba(10,10,12,0.85); /* Darker overlay for admin focus */
    backdrop-filter: blur(8px);
}

/* ================= LAYOUT ================= */
.container {
    max-width: 1400px;
    width: 95%;
    margin: 30px auto;
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 30px;
    height: 85vh;
}

@media(max-width: 900px) {
    .container { grid-template-columns: 1fr; height: auto; }
}

/* ================= HEADER ================= */
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background: rgba(255,255,255,0.05);
    border-bottom: 1px solid var(--glass-border);
    backdrop-filter: var(--blur);
}
header h1 { font-size: 24px; font-weight: 700; color: var(--primary); }
.btn-logout {
    color: var(--text);
    text-decoration: none;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
    transition: background 0.2s;
}
.btn-logout:hover { background: rgba(255,255,255,0.2); }

/* ================= SIDEBAR (Members List) ================= */
.sidebar {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    padding: 20px;
    backdrop-filter: var(--blur);
    display: flex;
    flex-direction: column;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 15px;
    color: var(--primary);
}

.member-list {
    flex: 1;
    overflow-y: auto;
    list-style: none;
}

.member-item {
    padding: 15px;
    margin-bottom: 10px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.2s;
    border: 1px solid transparent;
}

.member-item:hover, .member-item.active {
    background: rgba(255,255,255,0.1);
    border-color: var(--primary);
}

.member-name { font-weight: 600; }
.member-email { font-size: 13px; color: var(--text-muted); }

/* ================= MAIN CONTENT (Tabs: Stats / Chat) ================= */
.main-content {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius);
    padding: 24px;
    backdrop-filter: var(--blur);
    display: flex;
    flex-direction: column;
}

.chat-box {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-top: 20px;
    background: rgba(0,0,0,0.3);
    border-radius: 12px;
    padding: 20px;
    overflow: hidden;
}

.messages-area {
    flex: 1;
    overflow-y: auto;
    margin-bottom: 15px;
    padding-right: 10px;
    display: flex; /* Flex container for messages */
    flex-direction: column;
}

.msg {
    padding: 10px 14px;
    border-radius: 12px;
    max-width: 75%;
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 8px;
    position: relative;
    word-wrap: break-word;
}

.msg.sent {
    align-self: flex-end;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: white;
    border-bottom-right-radius: 2px;
    box-shadow: 0 4px 15px rgba(255, 123, 0, 0.3);
    margin-left: auto;
}

.msg.received {
    align-self: flex-start;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.1);
    color: #e0e0e0;
    border-bottom-left-radius: 2px;
    margin-right: auto;
}

.chat-input {
    display: flex;
    gap: 10px;
}

.chat-input input {
    flex: 1;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: #fff;
}

.chat-input button {
    padding: 12px 20px;
    background: var(--primary);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}

/* ================= HELPERS ================= */
.hidden { display: none; }
.placeholder-msg {
    text-align: center;
    color: var(--text-muted);
    font-size: 16px;
    margin-top: 100px;
}

</style>
</head>
<body>

<div class="bg-layer"></div>
<div class="bg-overlay"></div>

<header>
    <h1>Trainer Dashboard</h1>
    <div>
        <span style="margin-right:20px;">
            Hello, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a href="admin_logout.php" class="btn-logout">Logout</a>
    </div>
</header>

<div class="container">
    
    <!-- MEMBERS LIST -->
    <aside class="sidebar">
        <div class="section-title">Your Members</div>
        <ul class="member-list" id="memberList">
            <!-- Populated via JS -->
            <li class="placeholder-msg" style="margin-top:20px; font-size:14px;">Loading members...</li>
        </ul>
    </aside>

    <!-- MAIN PANEL -->
    <main class="main-content">
        <div id="noSelection" class="placeholder-msg">
            Select a member to view stats & chat.
        </div>

        <div id="memberPanel" class="hidden" style="height:100%; display:flex; flex-direction:column;">
            <h2 id="selectedMemberName" style="margin-bottom:20px; color:var(--primary);">Member Name</h2>
            
            <div style="display:flex; gap:20px; margin-bottom:20px;">
                <button onclick="showSection('chat')" style="flex:1; padding:10px; background:rgba(255,255,255,0.1); border:1px solid var(--primary); color:white; border-radius:8px;">💬 Chat</button>
                <button onclick="showSection('stats')" style="flex:1; padding:10px; background:rgba(255,255,255,0.1); border:1px solid white; color:white; border-radius:8px;">📊 Stats (Logs)</button>
            </div>

            <!-- CHAT SECTION -->
            <div id="chatSection" class="chat-box">
                <div class="messages-area" id="messagesArea">
                    <!-- Messages go here -->
                </div>
                <form id="chatForm" class="chat-input">
                    <input type="text" id="messageInput" placeholder="Type a message..." autocomplete="off">
                    <button type="submit">Send</button>
                </form>
            </div>

            <!-- STATS SECTION -->
            <div id="statsSection" class="hidden" style="flex:1; overflow-y:auto;">
                <h3 style="margin-bottom:10px;">Recent Meals</h3>
                <div id="mealsList"></div>
                
                <h3 style="margin-top:20px; margin-bottom:10px;">Recent Workouts</h3>
                <div id="workoutsList"></div>
            </div>
        </div>
    </main>

</div>

<script>
let currentMemberId = null;
const trainerId = <?= $_SESSION['user_id'] ?>;

async function loadMembers() {
    const res = await fetch('../php/api_trainer.php?action=get_members');
    const data = await res.json();
    const list = document.getElementById('memberList');
    list.innerHTML = '';
    
    if(data.members && data.members.length > 0) {
        data.members.forEach(m => {
            const li = document.createElement('li');
            li.className = 'member-item';
            li.innerHTML = `<div class="member-name">${m.username}</div><div class="member-email">${m.email}</div>`;
            li.onclick = () => selectMember(m.id, m.username, li);
            list.appendChild(li);
        });
    } else {
        list.innerHTML = '<li class="placeholder-msg" style="font-size:14px;">No members connected yet. Share your Trainer Code!</li>';
    }
}

async function selectMember(id, name, el) {
    currentMemberId = id;
    document.getElementById('selectedMemberName').innerText = name;
    document.getElementById('noSelection').classList.add('hidden');
    document.getElementById('memberPanel').classList.remove('hidden');
    document.getElementById('memberPanel').style.display = 'flex';
    
    // Highlight active
    document.querySelectorAll('.member-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');
    
    // Load data
    loadMessages();
    loadStats();
    showSection('chat'); // Default to chat
}

function showSection(sec) {
    if(sec === 'chat') {
        document.getElementById('chatSection').classList.remove('hidden');
        document.getElementById('statsSection').classList.add('hidden');
    } else {
        document.getElementById('chatSection').classList.add('hidden');
        document.getElementById('statsSection').classList.remove('hidden');
    }
}

async function loadMessages() {
    if(!currentMemberId) return;
    const res = await fetch(`../php/api_chat.php?action=fetch&other_id=${currentMemberId}`);
    const data = await res.json();
    const area = document.getElementById('messagesArea');
    area.innerHTML = '';
    
    if(data.messages) {
        data.messages.forEach(msg => {
            const div = document.createElement('div');
            div.className = `msg ${msg.sender_id == trainerId ? 'sent' : 'received'}`;
            div.innerText = msg.message;
            area.appendChild(div);
        });
        area.scrollTop = area.scrollHeight;
    }
}

async function loadStats() {
    if(!currentMemberId) return;
    const res = await fetch(`../php/api_trainer.php?action=get_member_stats&member_id=${currentMemberId}`);
    const data = await res.json();
    
    // Meals
    const mealDiv = document.getElementById('mealsList');
    mealDiv.innerHTML = data.meals.map(m => `
        <div style="background:rgba(255,255,255,0.05); padding:10px; margin-bottom:8px; border-radius:8px;">
            <b>${m.meal_name}</b> - ${m.calories} kcal<br>
            <span style="font-size:12px; color:#aaa;">${m.meal_time}</span>
        </div>
    `).join('') || '<div style="color:#aaa;">No recent meals</div>';
    
    // Workouts
    const workDiv = document.getElementById('workoutsList');
    workDiv.innerHTML = data.workouts.map(w => `
        <div style="background:rgba(255,255,255,0.05); padding:10px; margin-bottom:8px; border-radius:8px;">
            <b>${w.workout}</b> - ${w.lift_weight}kg x ${w.reps}<br>
            <span style="font-size:12px; color:#aaa;">${w.created_at}</span>
        </div>
    `).join('') || '<div style="color:#aaa;">No recent workouts</div>';
}

document.getElementById('chatForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if(!currentMemberId) return;
    const inp = document.getElementById('messageInput');
    const msg = inp.value.trim();
    if(!msg) return;
    
    const fd = new FormData();
    fd.append('receiver_id', currentMemberId);
    fd.append('message', msg);
    
    await fetch('../php/api_chat.php?action=send', { method:'POST', body:fd });
    inp.value = '';
    loadMessages();
});

// Auto-refresh chat every 5s if member selected
setInterval(() => {
    if(currentMemberId && !document.getElementById('chatSection').classList.contains('hidden')) {
        loadMessages();
    }
}, 5000);

loadMembers();
</script>

</body>
</html>
