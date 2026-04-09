<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php
if (isset($_GET['delque'])) {
    $quesNo = (int)$_GET['delque'];
    $delresult = $exam->getdelresult($quesNo);
}
?>

<style>
/* Table */
.table {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
    color: #fff;
    margin-top: 20px;
}

.table tbody tr:hover {
    background: rgba(255,255,255,0.1);
    transition: 0.3s;
}

/* Edit Button */
.btn-edit {
    background: linear-gradient(45deg, #1d976c, #93f9b9);
    border: none;
    padding: 6px 14px;
    border-radius: 20px;
    color: #000;
    font-weight: bold;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
    margin-right: 5px;
}

.btn-edit:hover {
    transform: scale(1.1);
    color: #000;
    text-decoration: none;
}

/* Delete Button */
.btn-delete {
    background: linear-gradient(45deg, #ff416c, #ff4b2b);
    border: none;
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-delete:hover {
    transform: scale(1.1);
    color: white;
    text-decoration: none;
}
</style>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card wide" style="max-width: 900px; padding: 40px;">

        <?php if (isset($delresult)) { echo "<div class='glass-msg success' style='display:block; margin-bottom: 20px;'>$delresult</div>"; } ?>

        <?php if (!isset($_GET['subj'])): ?>
            
            <h2 class="glass-card-title">📚 Select a Subject</h2>
            <p class="glass-card-subtitle">Choose a subject to manage its mapped questions.</p>

            <div class="row mt-4">
                <?php
                $subjects = $exam->getAllSubjects();
                if ($subjects) {
                    while ($result = $subjects->fetch_assoc()) {
                        $subjId = $result['subjectId'];
                        $qCount = $exam->getTotalRows($subjId);
                ?>
                <div class="col-md-6 mb-4">
                    <div class="glass-option" style="display: block; padding: 25px; transition: transform 0.3s; cursor: pointer;" 
                         onmouseover="this.style.transform='scale(1.03)'" 
                         onmouseout="this.style.transform='scale(1)'" 
                         onclick="window.location.href='?subj=<?php echo $subjId; ?>'">
                        <h4 style="color: #00eaff; margin-bottom: 10px; font-weight: 600;">
                            📖 <?php echo $result['subjectName']; ?>
                        </h4>
                        <p style="color: rgba(255,255,255,0.7); margin-bottom: 0;">
                            Live Questions: <strong><?php echo $qCount; ?></strong>
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

        <?php else: ?>
            
            <?php
                $subjectId = (int)$_GET['subj'];
                $subjectData = $exam->getSubjectById($subjectId);
                $subjName = $subjectData ? $subjectData['subjectName'] : 'Unknown Subject';
            ?>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="glass-card-title" style="margin-bottom: 0;">📋 Questions: <?php echo $subjName; ?></h2>
                <a href="queslist.php" class="glass-btn mt-0" style="width: auto; padding: 8px 20px; font-size: 14px; background: rgba(255,255,255,0.1);">← Back to Subjects</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $questionData = $exam->getqueData($subjectId);
                    if ($questionData && $questionData->num_rows > 0) {
                        $i = 0;
                        while ($result = $questionData->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['ques']; ?></td>
                        <td>
                            <a class="btn-edit" href="quesedit.php?qNo=<?php echo $result['quesNo']; ?>">
                               ✏️ Edit
                            </a>
                            <a class="btn-delete"
                               onclick="return confirm('Delete this question?')"
                               href="?delque=<?php echo $result['quesNo']; ?>&subj=<?php echo $subjectId; ?>">
                               🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='3' style='color: rgba(255,255,255,0.5); text-align: center;'>No questions added for this subject yet.</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            
        <?php endif; ?>

    </div>
</div>

<?php include '../inc/footer.php'; ?>