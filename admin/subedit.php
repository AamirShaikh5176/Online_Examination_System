<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php
if (!isset($_GET['subid'])) {
    header("Location: subjects.php");
    exit();
}
$subjectId = (int)$_GET['subid'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_subject'])) {
    $subjectName = $_POST['subjectName'];
    $updateSub = $exam->updateSubjectName($subjectId, $subjectName);
}

$subjectData = $exam->getSubjectById($subjectId);
if (!$subjectData) {
    header("Location: subjects.php");
    exit();
}
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center" style="max-width: 500px; padding: 30px;">

        <h2 class="glass-card-title">✏️ Edit Subject</h2>

        <?php if (isset($updateSub)) { echo trim($updateSub); } ?>

        <form action="" method="post" style="margin-top: 20px;">
            <label style="display: block; text-align: left; margin-bottom: 5px; font-weight: bold;">Subject Name:</label>
            <input type="text" name="subjectName" class="glass-input" value="<?php echo htmlspecialchars($subjectData['subjectName']); ?>" required>
            
            <button type="submit" name="update_subject" class="glass-btn mt-2">💾 Update Details</button>
            <br/><br/>
            <a href="subjects.php" style="color: #00eaff;">← Back to Subjects</a>
        </form>

    </div>
</div>

<?php include '../inc/footer.php'; ?>
