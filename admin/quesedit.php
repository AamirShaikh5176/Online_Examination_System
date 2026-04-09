<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php
if (!isset($_GET['qNo'])) {
    header("Location: queslist.php");
    exit();
}
$quesNo = (int)$_GET['qNo'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_question'])) {
    $updateQuestion = $exam->updateQuestion($_POST);
}

// Fetch existing question base data
$questionData = $exam->getQuestionNumber($quesNo);
if (!$questionData) {
    header("Location: queslist.php");
    exit();
}

// Fetch existing answers array
$answersData = $exam->getAnswer($quesNo);
$answers = array();
$rightAnsIndex = 0;
if ($answersData) {
    $i = 1;
    while ($ans = $answersData->fetch_assoc()) {
        $answers[$i] = $ans['ans'];
        if ($ans['rightAns'] == '1') {
            $rightAnsIndex = $i;
        }
        $i++;
    }
}
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center" style="max-width: 600px; padding: 30px;">

        <h2 class="glass-card-title">✏️ Edit Question</h2>

        <?php if (isset($updateQuestion)) { echo $updateQuestion; } ?>

        <form action="" method="post">

            <input class="glass-input" readonly type="text" value="Editing Question #<?php echo $exam->getRelativeQuestionNumber($questionData['subjectId'], $questionData['quesNo']); ?>" style="font-weight: bold; color: rgba(255,255,255,0.7); text-align: center;">
            <input type="hidden" name="quesNo" value="<?php echo $questionData['quesNo']; ?>">

            <select class="glass-input" name="subjectId" required style="cursor: pointer;">
                <option value="">-- Select Subject --</option>
                <?php
                $subjects = $exam->getAllSubjects();
                if ($subjects) {
                    while ($result = $subjects->fetch_assoc()) {
                        $selected = ($result['subjectId'] == $questionData['subjectId']) ? "selected" : "";
                        echo '<option value="'.$result['subjectId'].'" '.$selected.'>'.$result['subjectName'].'</option>';
                    }
                }
                ?>
            </select>

            <input class="glass-input" type="text" name="ques" placeholder="Enter Question" value="<?php echo htmlspecialchars($questionData['ques']); ?>" required>

            <input class="glass-input" type="text" name="ans1" placeholder="Choice 1" value="<?php echo htmlspecialchars($answers[1] ?? ''); ?>" required>
            <input class="glass-input" type="text" name="ans2" placeholder="Choice 2" value="<?php echo htmlspecialchars($answers[2] ?? ''); ?>" required>
            <input class="glass-input" type="text" name="ans3" placeholder="Choice 3" value="<?php echo htmlspecialchars($answers[3] ?? ''); ?>" required>
            <input class="glass-input" type="text" name="ans4" placeholder="Choice 4" value="<?php echo htmlspecialchars($answers[4] ?? ''); ?>" required>

            <input class="glass-input" type="number" name="rightAns" min="1" max="4" placeholder="Correct Answer (1-4)" value="<?php echo $rightAnsIndex; ?>" required>

            <button type="submit" name="update_question" class="glass-btn mt-2">💾 Update Question</button>
            <br/><br/>
            <a href="queslist.php" style="color: #00eaff;">← Back to Manage Questions</a>
        </form>

    </div>
</div>

<?php include '../inc/footer.php'; ?>
