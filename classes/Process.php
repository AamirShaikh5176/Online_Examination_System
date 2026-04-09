<?php 

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Session.php');
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

class Process{
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function getProcessData($data){
        if (!isset($data['ans']) || !isset($data['quesnumber'])) {
            return;
        }

        $selectAns  = $this->fm->validation($data['ans']);
        $quesnumber = $this->fm->validation($data['quesnumber']);
        $selectAns  = mysqli_real_escape_string($this->db->link, $selectAns);
        $quesnumber = mysqli_real_escape_string($this->db->link, $quesnumber);
        $subjectId  = isset($_SESSION['subjectId']) ? (int)$_SESSION['subjectId'] : 1;

        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = '0';
        }

        $total = $this->getTotal($subjectId);
        $right = $this->rightAns($quesnumber);

        if ($right !== null && $right == $selectAns) {
            $_SESSION['score']++;
        }

        // Fetch NEXT question number using >
        $queryNext = "SELECT quesNo FROM tbl_ques WHERE quesNo > '$quesnumber' AND subjectId = '$subjectId' ORDER BY quesNo ASC LIMIT 1";
        $nextResult = $this->db->select($queryNext);

        if ($nextResult && $nextResult->num_rows > 0) {
            if (isset($data['timeout']) && $data['timeout'] == '1') {
                header("Location:final.php");
                exit();
            }
            $nextRow = $nextResult->fetch_assoc();
            $nextQ = $nextRow['quesNo'];
            header("Location:test.php?q=" . $nextQ);
            exit();
        } else {
            header("Location:final.php");
            exit();
        }
    }

    private function getTotal($subjectId){
        $query  = "SELECT COUNT(*) as total FROM tbl_ques WHERE subjectId = '$subjectId'";
        $result = $this->db->select($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }

    private function rightAns($quesnumber){
        $query  = "SELECT * FROM tbl_ans WHERE quesNo = '$quesnumber' AND rightAns = '1'";
        $result = $this->db->select($query);

        // Safety check — avoids fatal error if no row found
        if (!$result || $result->num_rows === 0) {
            return null;
        }

        $row = $result->fetch_assoc();
        return $row['id'];
    }
}
?>