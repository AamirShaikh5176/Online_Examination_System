<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $addQuestion = $exam->getAddQuestion($_POST);
}

// Pre-calculate local question target counts for the JS UI toggle
$subjectCounts = array();
$subs = $exam->getAllSubjects();
if ($subs) {
    while ($s = $subs->fetch_assoc()) {
        $subjectCounts[$s['subjectId']] = $exam->getTotalRows($s['subjectId']) + 1;
    }
}
$subjectCountsJson = json_encode($subjectCounts);
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center" style="max-width: 600px; padding: 30px;">

        <h2 class="glass-card-title">📝 Add Question</h2>

        <?php if (isset($addQuestion)) { echo "<div class='glass-msg success' style='display:block; margin-bottom: 20px;'>$addQuestion</div>"; } ?>

        <form action="" method="post">

            <input class="glass-input" id="displayQuesNo" readonly type="text" name="quesNo" value="Select Subject First" style="font-weight: bold; color: rgba(255,255,255,0.7); text-align: center;">

            <select class="glass-input" id="subjectSelect" name="subjectId" required style="cursor: pointer;">
                <option value="">-- Select Subject --</option>
                <?php
                // Reset internal pointer safely
                $subs = $exam->getAllSubjects();
                if ($subs) {
                    while ($result = $subs->fetch_assoc()) {
                        echo '<option value="'.$result['subjectId'].'">'.$result['subjectName'].'</option>';
                    }
                }
                ?>
            </select>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const counts = <?php echo $subjectCountsJson; ?>;
                const subjectSelect = document.getElementById("subjectSelect");
                const displayQuesNo = document.getElementById("displayQuesNo");

                subjectSelect.addEventListener("change", function() {
                    const sid = this.value;
                    if(sid && counts[sid]) {
                        displayQuesNo.value = "Target: Question #" + counts[sid] + " (for this subject)";
                    } else {
                        displayQuesNo.value = "Select Subject First";
                    }
                });
            });
            </script>

            <input class="glass-input" type="text" name="ques" placeholder="Enter Question" required>

            <input class="glass-input" type="text" name="ans1" placeholder="Choice 1">
            <input class="glass-input" type="text" name="ans2" placeholder="Choice 2">
            <input class="glass-input" type="text" name="ans3" placeholder="Choice 3">
            <input class="glass-input" type="text" name="ans4" placeholder="Choice 4">

            <input class="glass-input" type="number" name="rightAns" min="1" max="4" placeholder="Correct Answer (1-4)" required>

            <button type="submit" class="glass-btn mt-2">🚀 Submit Question</button>
        </form>

    </div>
</div>

<?php include '../inc/footer.php'; ?>