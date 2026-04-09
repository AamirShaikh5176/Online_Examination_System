<?php include 'inc/header.php'; ?>
<?php
  Session::checkLogin();
?>

<div class="glass-wrapper">
    <div class="glass-card text-center">

        <h2 class="glass-card-title">📝 Online Exam System</h2>
        <p class="glass-card-subtitle">Simple MCQ Based Online Examination System</p>

        <img src="img/bgtest.png" width="90px" class="animate-float" style="margin: 10px 0 20px;" />

        <form action="index.php" method="post"> 
            <input type="email" class="glass-input" id="email" name="email" placeholder="📧 Enter Email">
            <input type="password" name="password" id="password" class="glass-input" placeholder="🔒 Password">
            
            <button type="submit" id="loginsubm" value="Signup" class="glass-btn mt-2">
                🚀 Log In
            </button>
        </form>

        <a href="register.php" class="glass-link-btn mt-3">
            New User? Signup for Free
        </a>

        <!-- Messages (UNCHANGED functionality) -->
        <div class="glass-msg empty" style="display: none;">Fields must not be empty</div>
        <div class="glass-msg disable" style="display: none;">User ID Disable!</div>
        <div class="glass-msg error" style="display: none;">Email or Password did not match.</div>

    </div>
</div>

<?php include 'inc/footer.php'; ?>