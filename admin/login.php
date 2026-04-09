<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/loginheader.php');
include_once ($filepath.'/../classes/Admin.php');
$ad = new Admin();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminData = $ad->getAdminData($_POST);
}
?>

<div class="glass-wrapper container">
    <div class="glass-card text-center">
        
        <h2 class="glass-card-title">🔐 Admin Login</h2>
        <p class="glass-card-subtitle">Manage Online Examination System</p>

        <img src="../img/bgtest.png" width="90px" class="animate-float" style="margin: 10px 0 20px;" />

        <form action="" method="post">
            <input type="text" class="glass-input" name="adminUser" placeholder="👤 Enter Username" required>

            <input type="password" name="adminPass" class="glass-input" placeholder="🔒 Enter Password" required>

            <button type="submit" name="login" value="Login" class="glass-btn mt-2">
                🚀 Login
            </button>
        </form>

        <?php
        if (isset($adminData)) {
            echo "<div class='glass-msg error' style='display:block; margin-top:20px;'>$adminData</div>";
        }
        ?>
    </div>
</div>

<?php include '../inc/footer.php'; ?>