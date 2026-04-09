<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
  
  if (!isset($_GET['subj'])) {
      header("Location: exam.php");
      exit();
  }
  
  $subjectId = (int)$_GET['subj'];
  $_SESSION['subjectId'] = $subjectId;
  
  // 1 & 2. NEW TEST INITIALIZATION
  $_SESSION['exam_id'] = uniqid();

  $question = $exam->getQuestion($subjectId);
  $total    = $exam->getTotalRows($subjectId);
  
  // Get subject name for display
  $subjectName = "Selected Subject";
  $allSubs = $exam->getAllSubjects();
  if ($allSubs) {
      while($s = $allSubs->fetch_assoc()) {
          if ($s['subjectId'] == $subjectId) {
              $subjectName = $s['subjectName'];
          }
      }
  }
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center wide">

        <h2 class="glass-card-title">📝 Welcome to Online Examination</h2>
        <p class="glass-card-subtitle">Test Your Knowledge: <strong><?php echo $subjectName; ?></strong></p>

        <div class="glass-option" style="justify-content: center;">
            <strong>Total Questions:</strong> &nbsp; <?php echo $total; ?>
        </div>

        <div class="glass-option" style="justify-content: center;">
            <strong>Question Type:</strong> &nbsp; Multiple Choice (MCQ)
        </div>

        <br/>

        <?php if ($question && $total > 0): ?>
        <a href="test.php?q=<?php echo $question['quesNo']; ?>" class="glass-btn mt-2">
            🚀 Proceed
        </a>
        <?php else: ?>
        <button class="glass-btn mt-2" disabled style="opacity:0.5; cursor:not-allowed;">
            ❌ No Questions Available
        </button>
        <?php endif; ?>

    </div>
</div>

<?php include 'inc/footer.php'; ?>