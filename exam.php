<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center wide" style="max-width: 900px; padding: 40px;">

        <h2 class="glass-card-title">📚 Choose a Subject</h2>
        <p class="glass-card-subtitle">Select the subject you want to take an exam on.</p>

        <div class="row mt-4" style="text-align: left;">
            <?php
            $subjects = $exam->getAllSubjects();
            if ($subjects) {
                while ($result = $subjects->fetch_assoc()) {
                    // Count how many questions exist for this subject to display to the user
                    $subjId = $result['subjectId'];
                    $qCount = $exam->getTotalRows($subjId);
            ?>
            <div class="col-md-6 mb-4">
                <div class="glass-option" style="display: block; padding: 25px; transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'" onclick="window.location.href='starttest.php?subj=<?php echo $result['subjectId']; ?>'">
                    <h4 style="color: #00eaff; margin-bottom: 10px; font-weight: 600;">
                        📖 <?php echo $result['subjectName']; ?>
                    </h4>
                    <p style="color: rgba(255,255,255,0.7); margin-bottom: 0;">
                        Questions Available: <strong><?php echo $qCount; ?></strong>
                    </p>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p>No subjects available yet.</p></div>";
            }
            ?>
        </div>

    </div>
</div>

<?php include 'inc/footer.php'; ?>