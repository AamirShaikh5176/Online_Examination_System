<?php 
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/inc/header.php');
include_once ($filepath.'/../classes/User.php');
$user = new User();
?>

<?php 
if (isset($_GET['dis'])) {
    $disid = (int)$_GET['dis'];
    $disuser = $user->disableUser($disid);
}

if (isset($_GET['ena'])) {
    $enaid = (int)$_GET['ena'];
    $enauser = $user->enaUser($enaid);
}

if (isset($_GET['del'])) {
    $delid = (int)$_GET['del'];
    $deluser = $user->delUser($delid);
}
?>

<style>
/* Table */
.table {
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
    color: #fff;
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
/* Buttons */
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
.error {
    color: #ff6b6b;
    font-weight: bold;
}
</style>

<div class="glass-wrapper container" style="min-height: calc(100vh - 80px); padding-top: 40px; padding-bottom: 40px;">
    <div class="glass-card wide" style="max-width: 1000px; padding: 40px;">

        <h2 class="glass-card-title">👥 Manage Users</h2>

        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $userData = $user->getUserData();
                    if ($userData) {
                        $i = 0;
                        while ($result = $userData->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr>
                        <td>
                            <?php
                            if ($result['status'] == '1') {
                                echo "<span class='error'>".$i."</span>";
                            } else {
                                echo $i;
                            }
                            ?>
                        </td>
                        <td><?php echo $result['name']; ?></td>
                        <td><?php echo $result['userName']; ?></td>
                        <td><?php echo $result['email']; ?></td>
                        <td>
                            <a class="btn-delete"
                               onclick="return confirm('Are you sure to delete this user?')"
                               href="?del=<?php echo $result['userId']; ?>">
                                🗑 Delete
                            </a>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include '../inc/footer.php'; ?>