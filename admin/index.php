<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'../inc/header.php');
?>

<style>
/* Buttons Grid */
.control-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

/* Buttons */
.control-btn {
    padding: 20px;
    border-radius: 15px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: 0.3s;
    display: block;
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.15);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Hover Effects */
.control-btn:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    color: white;
}

/* Different Colors */
.home { background: linear-gradient(45deg, #43cea2, #185a9d); }
.users { background: linear-gradient(45deg, #36d1dc, #5b86e5); }
.add { background: linear-gradient(45deg, #ff9966, #ff5e62); }
.manage { background: linear-gradient(45deg, #7f00ff, #e100ff); }
.timer { background: linear-gradient(45deg, #f12711, #f5af19); }
.subjects { background: linear-gradient(45deg, #a8e063, #56ab2f); }
.logout { background: linear-gradient(45deg, #ff416c, #ff4b2b); }

/* Icons */
.control-btn i {
    font-size: 28px;
    margin-bottom: 10px;
    display: block;
}
</style>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card wide" style="max-width: 900px; padding: 40px;">

        <h2 class="glass-card-title">🚀 Admin Control Panel</h2>
        <p class="glass-card-subtitle">Manage your system efficiently</p>

        <div class="control-grid">
            
            <a class="control-btn users" href="users.php">
                <i class="fa fa-user-circle"></i>
                Manage Users
            </a>

            <a class="control-btn add" href="quesadd.php">
                <i class="fa fa-question-circle"></i>
                Add Question
            </a>

            <a class="control-btn manage" href="queslist.php">
                <i class="fa fa-list"></i>
                Manage Questions
            </a>

            <a class="control-btn subjects" href="subjects.php">
                <i class="fa fa-book"></i>
                Manage Subjects
            </a>

            <a class="control-btn timer" href="settimer.php">
                <i class="fa fa-clock-o"></i>
                Set Timer
            </a>

            <a class="control-btn logout" href="?action=logout">
                <i class="fa fa-sign-out"></i>
                Logout
            </a>

        </div>

    </div>
</div>

<?php include '../inc/footer.php'; ?>