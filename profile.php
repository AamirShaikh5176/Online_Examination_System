<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
  $userId = Session::get("userId");
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userProfile = $user->getUserPData($userId, $_POST);
}
?>

<div class="glass-wrapper container">
    <div class="glass-card">

        <h3 class="glass-card-title">👤 Update Your Profile</h3>

        <?php
        if (isset($userProfile)) {
            echo "<div class='glass-msg success' style='display:block; margin-bottom: 20px;'>".$userProfile."</div>";
        }
        ?>

        <form action="" method="post">

            <?php
            $getData = $user->getUserProfile($userId);
            if ($getData) {
                while ($result = $getData->fetch_assoc()) {
            ?>

            <input type="text" class="glass-input" name="name"
                   value="<?php echo $result['name']; ?>" placeholder="👤 Name">

            <input type="text" class="glass-input" name="userName"
                   value="<?php echo $result['userName']; ?>" placeholder="🆔 Username">

            <input name="email" class="glass-input" type="email"
                   value="<?php echo $result['email']; ?>" placeholder="📧 Email">

            <input type="submit" id="profileUpdate" class="glass-btn mt-2" value="🚀 Update Info">

            <?php } } ?>

        </form>

    </div>
</div>

<?php include 'inc/footer.php'; ?>