<?php include 'inc/header.php'; ?>
<?php
 Session::checkSession();
 $subjectId = isset($_SESSION['subjectId']) ? (int)$_SESSION['subjectId'] : 1;
 $total = $exam->getTotalRows($subjectId); 

$subjectName = "Your Exam";
// Find subject name for the header title
$allSubs = $exam->getAllSubjects();
if ($allSubs) {
    while($s = $allSubs->fetch_assoc()) {
        if ($s['subjectId'] == $subjectId) {
            $subjectName = $s['subjectName'];
        }
    }
}
?>

<div class="glass-wrapper container">
    <div class="glass-card wide">

        <h3 class="glass-card-title">
            📊 <?php echo $subjectName; ?> - Answers (<?php echo $total; ?>)
        </h3>

        <?php
        $getQues = $exam->getqueData($subjectId);
        if ($getQues) {
            $rqNum = 0;
            while ($question = $getQues->fetch_assoc()) {
                $rqNum++;
        ?>
            <div class="glass-option" style="flex-direction: column; align-items: flex-start; margin-bottom: 20px; cursor: default;">
                <h5 style="margin-bottom: 15px; font-weight: 600; font-size: 18px;">
                    <span class="text-highlight">Q<?php echo $rqNum; ?>:</span> <?php echo $question['ques']; ?>
                </h5>

                <?php
                $quesnumber = $question['quesNo'];
                $answer = $exam->getAnswer($quesnumber);
                if ($answer) {
                    while ($result = $answer->fetch_assoc()) {
                ?>
                    <div style="padding: 10px; width: 100%; border-radius: 8px; margin-bottom: 5px; background: rgba(0,0,0,0.15);">
                        <?php
                        if ($result['rightAns'] == '1') {
                            echo "<span style='color: #00ff88; font-weight: bold;'>✔ ".$result['ans']." (Correct Answer)</span>";
                        } else {
                            echo "<span style='color: rgba(255,255,255,0.8);'>".$result['ans']."</span>";
                        }
                        ?>
                    </div>
                <?php } } ?>
            </div>
        <?php } } ?>

        <!-- Button -->
        <div class="text-center" style="margin-top: 30px;">
            <a href="starttest.php" class="glass-btn">
                🚀 Start Exam Again
            </a>
        </div>

    </div>
</div>

<?php include 'inc/footer.php'; ?>