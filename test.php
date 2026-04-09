<?php include 'inc/header.php'; ?>
<?php
Session::checkSession();

if (!isset($_SESSION['exam_id'])) {
    $_SESSION['exam_id'] = uniqid();
}

$subjectId = isset($_SESSION['subjectId']) ? (int)$_SESSION['subjectId'] : 1;

if (isset($_GET['q'])) {
    $quesnumber = (int) $_GET['q'];
} else {
    // 2. FIX FIRST QUESTION SELECTION
    $firstQuestion = $exam->getQuestion($subjectId);
    if ($firstQuestion) {
        header("Location:test.php?q=" . $firstQuestion['quesNo']);
        exit();
    } else {
        echo "<script>alert('No questions available.'); window.location='index.php';</script>";
        exit();
    }
}

$total = $exam->getTotalRows($subjectId);
$question = $exam->getQuestionNumber($quesnumber);
$relativeQNum = $exam->getRelativeQuestionNumber($subjectId, $quesnumber);

// 7. EDGE CASE HANDLING: If query somehow directs to a missing question gap
if (!$question) {
    header("Location:final.php");
    exit();
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $process = $pro->getProcessData($_POST);
}
?>

<div class="glass-wrapper">
    <div class="glass-card wide">

        <!-- Header -->
        <div class="text-center" style="margin-bottom: 25px;">
            <h4 class="glass-card-title" style="margin-bottom: 10px;">📝 Question <?php echo $relativeQNum . " of " . $total; ?></h4>
            <div id="examTimer" class="glass-option" style="display: inline-block; padding: 8px 20px; font-weight: bold; justify-content: center; background: rgba(0,234,255,0.1); border-color: rgba(0,234,255,0.3);">⏳ Time Left: --:--</div>
        </div>

        <!-- Question -->
        <div style="font-size: 18px; font-weight: 500; margin-bottom: 25px; line-height: 1.6;">
            <span class="text-highlight">Q<?php echo $relativeQNum; ?>:</span> <?php echo $question['ques']; ?>
        </div>

        <!-- Form -->
        <form id="examForm" method="post" action="">
            <?php
            $answer = $exam->getAnswer($quesnumber);
            if ($answer) {
                while ($result = $answer->fetch_assoc()) {
                    ?>
                    <label class="glass-option" style="cursor: pointer; display: flex;">
                        <input type="radio" name="ans" value="<?php echo $result['id']; ?>" />
                        <span style="font-size: 16px;"><?php echo $result['ans']; ?></span>
                    </label>
                <?php }
            } ?>

            <br />

            <input type="submit" name="submit" class="glass-btn mt-2" value="🚀 Continue" />

            <input type="hidden" name="quesnumber" value="<?php echo $quesnumber; ?>" />
        </form>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const totalExamTimeInSeconds = <?php echo $exam->getSubjectExamTime($subjectId); ?>;
        const timerDisplay = document.getElementById("examTimer");
        const examForm = document.getElementById("examForm");

        // Prevent browser back button navigation during the test
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            alert("Warning: You cannot go back during the test!");
            history.pushState(null, null, location.href);
        };

        // Track if the user is legitimately navigating to the next question
        let isLegitNavigation = false;
        if (examForm) {
            examForm.addEventListener("submit", function() {
                isLegitNavigation = true;
            });
        }

        // Prevent tab changing / window switching during the test
        document.addEventListener("visibilitychange", function() {
            if (document.hidden && !isLegitNavigation) {
                alert("Warning: You are not allowed to switch tabs or minimize the window during the test!");
            }
        });

        // 5. & 6. PREVENT OLD TIMER REUSE (Unique Exam Session Control)
        const currentExamSessionId = "<?php echo $_SESSION['exam_id']; ?>";
        const savedSessionId = localStorage.getItem('exam_session_id');

        // Reset timer explicitly if mismatch
        if (savedSessionId !== currentExamSessionId) {
            localStorage.removeItem('exam_end_time');
            localStorage.setItem('exam_session_id', currentExamSessionId);
        }

        // Fallback if no database time exists just in case
        const dbTime = totalExamTimeInSeconds || 600;

        // Initialize or read end time
        let endTimeStr = localStorage.getItem('exam_end_time');
        let endTime = 0;

        if (!endTimeStr) {
            // Calculate initial end time
            endTime = Date.now() + (dbTime * 1000);
            localStorage.setItem('exam_end_time', endTime.toString());
        } else {
            endTime = parseInt(endTimeStr, 10);
        }

        // Prevent multiple submissions
        let isSubmitting = false;

        const timerInterval = setInterval(function () {
            const now = Date.now();
            const distance = endTime - now;

            if (distance <= 0) {
                clearInterval(timerInterval);
                timerDisplay.innerHTML = "⏳ Time's Up!";

                if (!isSubmitting) {
                    isSubmitting = true;
                    alert("Time is over! Auto-submitting the exam.");

                    // Ensure at least one option is selected to bypass PHP validation errors
                    const radios = document.querySelectorAll('input[type="radio"][name="ans"]');
                    let isChecked = false;
                    radios.forEach(r => { if (r.checked) isChecked = true; });

                    if (!isChecked && radios.length > 0) {
                        radios[0].checked = true; // Auto select first valid option if missed
                    }

                    if (examForm) {
                        // Add timeout flag to inform backend to not load next question
                        const timeOutFlag = document.createElement("input");
                        timeOutFlag.type = "hidden";
                        timeOutFlag.name = "timeout";
                        timeOutFlag.value = "1";
                        examForm.appendChild(timeOutFlag);

                        // Safely trigger the form submission via the existing submit button wrapper
                        const submitButton = document.querySelector('input[type="submit"][name="submit"]');
                        if (submitButton) {
                            submitButton.click();
                        } else {
                            HTMLFormElement.prototype.submit.call(examForm);
                        }
                    }
                }
                return;
            }

            const minutes = Math.floor(distance / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const displayMin = minutes < 10 ? "0" + minutes : minutes;
            const displaySec = seconds < 10 ? "0" + seconds : seconds;

            timerDisplay.innerHTML = "⏳ Time Left: " + displayMin + ":" + displaySec;

            if (distance < 30000) {
                timerDisplay.classList.add("danger");
            } else {
                timerDisplay.classList.remove("danger");
            }
        }, 1000);
    });
</script>

<?php include 'inc/footer.php'; ?>