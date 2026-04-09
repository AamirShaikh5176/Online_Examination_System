<?php include 'inc/header.php'; ?>

<div class="glass-wrapper">
    <div class="glass-card">

        <h2 class="glass-card-title">📝 Create Account</h2>
        <p class="glass-card-subtitle">Join Online Examination System</p>

        <div class="text-center">
            <img src="img/regi.png" width="90px" class="animate-float" style="margin-bottom: 25px;">
        </div>

        <form>

            <input type="text" class="glass-input" id="name" name="name"
                   placeholder="👤 Enter Full Name" pattern="[a-zA-Z ]+" title="Only letters and spaces allowed" required>

            <input type="text" class="glass-input" id="userName" name="userName"
                   placeholder="🆔 Username (no spaces)" pattern="[a-zA-Z0-9]+" minlength="3" maxlength="20" title="Alphanumeric, 3-20 chars" required>

            <input type="email" class="glass-input" id="email" name="email"
                   placeholder="📧 Email Address" required>

            <input type="password" name="password" id="password"
                   class="glass-input" placeholder="🔒 Password" minlength="6" pattern="(?=.*[a-zA-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s])\S+" title="Mix of letters, numbers, and special characters, no spaces allowed" required>

            <button type="submit" id="registersubm" value="Signup" class="glass-btn mt-2">
                🚀 Register
            </button>

            <a class="glass-link-btn mt-3" href="index.php">
                Already Registered? Login
            </a>

        </form>

        <div id="state" class="mt-3"></div>

    </div>
</div>

<?php include 'inc/footer.php'; ?>