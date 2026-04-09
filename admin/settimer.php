<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subjectId']) && isset($_POST['exam_time'])) {
    $subjectId = (int)$_POST['subjectId'];
    $timeInSeconds = (int)$_POST['exam_time'] * 60;
    $timeUpdate = $exam->updateSubjectTimer($subjectId, $timeInSeconds);
}
?>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card text-center wide" style="max-width: 700px; padding: 40px;">

        <h2 class="glass-card-title">⏱️ Set Subject Timers</h2>
        <p class="glass-card-subtitle">Define individual exam durations (in minutes) for each subject.</p>

        <?php if (isset($timeUpdate)) { echo $timeUpdate; } ?>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-hover" style="color: #fff;">
                <thead style="background: rgba(0,0,0,0.4);">
                    <tr>
                        <th width="50%">Subject</th>
                        <th width="30%">Current Timer</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $subjects = $exam->getAllSubjects();
                if ($subjects) {
                    while ($result = $subjects->fetch_assoc()) {
                        $subjId = $result['subjectId'];
                        $current_time_minutes = $exam->getSubjectExamTime($subjId) / 60;
                ?>
                    <tr>
                        <form action="" method="post">
                            <td style="vertical-align: middle; font-weight: bold; font-size: 16px;">
                                <?php echo $result['subjectName']; ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <input type="hidden" name="subjectId" value="<?php echo $subjId; ?>">
                                <input class="glass-input" type="number" step="any" name="exam_time" min="1" value="<?php echo $current_time_minutes; ?>" required style="margin-bottom: 0;">
                            </td>
                            <td style="vertical-align: middle;">
                                <button type="submit" class="glass-btn mt-0" style="padding: 10px 15px; font-size: 14px;">💾 Save</button>
                            </td>
                        </form>
                    </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='3'>No subjects found.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include '../inc/footer.php'; ?>
