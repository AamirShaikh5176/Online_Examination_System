<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/Exam.php');
$exam = new Exam();
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subject'])) {
    $subjectName = $_POST['subjectName'];
    $addSubject = $exam->addSubject($subjectName);
}

if (isset($_GET['del'])) {
    $delid = (int)$_GET['del'];
    $delSubject = $exam->deleteSubject($delid);
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
.table thead {
    background: rgba(0,0,0,0.4);
}
.table th, .table td {
    color: #fff;
    text-align: center;
    vertical-align: middle;
}
.table tbody tr {
    transition: 0.3s;
}
.table tbody tr:hover {
    background: rgba(255,255,255,0.1);
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
    margin-right: 5px;
}
.btn-edit:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.4);
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
}
.btn-delete:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.4);
    color: white;
    text-decoration: none;
}
</style>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card wide" style="max-width: 800px; padding: 40px;">

        <h2 class="glass-card-title">📚 Manage Subjects</h2>

        <?php if (isset($addSubject)) { echo $addSubject; } ?>
        <?php if (isset($delSubject)) { echo $delSubject; } ?>

        <form action="" method="post" style="display: flex; gap: 15px; margin-bottom: 30px;">
            <input type="text" name="subjectName" class="glass-input" style="margin-bottom: 0;" placeholder="Enter New Subject Name" required>
            <button type="submit" name="add_subject" class="glass-btn" style="width: auto; padding: 0 30px;">➕ Add</button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="60%">Subject Name</th>
                        <th width="30%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $subjectData = $exam->getAllSubjects();
                    if ($subjectData) {
                        $i = 0;
                        while ($result = $subjectData->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['subjectName']; ?></td>
                        <td>
                            <a class="btn-edit"
                               href="subedit.php?subid=<?php echo $result['subjectId']; ?>">
                                ✏️ Edit
                            </a>
                            <a class="btn-delete"
                               onclick="return confirm('Delete this subject? This might affect existing questions.')"
                               href="?del=<?php echo $result['subjectId']; ?>">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php } } else { ?>
                    <tr><td colspan="3">No Subjects Found.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include '../inc/footer.php'; ?>
