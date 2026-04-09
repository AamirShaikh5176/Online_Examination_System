<?php 

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');

class Exam{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

  public function getAllSubjects(){
    $query = "SELECT * FROM tbl_subjects ORDER BY subjectId ASC";
    $result = $this->db->select($query);
    return $result;
  }

  public function addSubject($subjectName){
      $subjectName = mysqli_real_escape_string($this->db->link, $subjectName);
      if(empty($subjectName)){
          return "<div class='alert alert-danger'>Subject Name must not be empty!</div>";
      }
      $query = "INSERT INTO tbl_subjects(subjectName) VALUES('$subjectName')";
      $insert = $this->db->insert($query);
      if ($insert) {
          return "<div class='alert alert-success'>Subject Created Successfully!</div>";
      }else{
          return "<div class='alert alert-danger'>Failed to create subject.</div>";
      }
  }

  public function deleteSubject($subjectId){
      $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
      $query = "DELETE FROM tbl_subjects WHERE subjectId = '$subjectId'";
      // Optionally could also delete questions bound to this subject...
      $del = $this->db->delete($query);
      if ($del) {
          return "<div class='alert alert-success'>Subject Deleted!</div>";
      }else{
          return "<div class='alert alert-danger'>Failed to delete subject.</div>";
      }
  }

  public function getSubjectById($subjectId) {
      $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
      $query = "SELECT * FROM tbl_subjects WHERE subjectId = '$subjectId'";
      $result = $this->db->select($query);
      if($result && $result->num_rows > 0) {
          return $result->fetch_assoc();
      }
      return false;
  }

  public function updateSubjectName($subjectId, $subjectName) {
      $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
      $subjectName = mysqli_real_escape_string($this->db->link, $subjectName);

      if(empty($subjectName)){
          return "<div class='alert alert-danger'>Subject Name must not be empty!</div>";
      }

      $query = "UPDATE tbl_subjects SET subjectName = '$subjectName' WHERE subjectId = '$subjectId'";
      $updated = $this->db->update($query);

      if($updated){
          return "<div class='glass-msg success'>Subject Updated Successfully!</div>";
      } else {
          return "<div class='alert alert-danger'>Failed to Update Subject.</div>";
      }
  }
  
  public function updateQuestion($data) {
    $quesNo = mysqli_real_escape_string($this->db->link, $data['quesNo']);
    $ques   = mysqli_real_escape_string($this->db->link, $data['ques']);
    $subjectId = isset($data['subjectId']) ? mysqli_real_escape_string($this->db->link, $data['subjectId']) : 1;
    
    // Arrays covering choices
    $ans    = array();
    $ans[1] = $data['ans1'];
    $ans[2] = $data['ans2'];
    $ans[3] = $data['ans3'];
    $ans[4] = $data['ans4'];
    $rightAns = mysqli_real_escape_string($this->db->link, $data['rightAns']);

    // 1. Update tbl_ques Base Record
    $qquery = "UPDATE tbl_ques SET ques = '$ques', subjectId = '$subjectId' WHERE quesNo = '$quesNo'";
    $qupdate = $this->db->update($qquery);

    // 2. Fetch existing tbl_ans records sequentially to overwrite them (ordered by id)
    $aquery = "SELECT id FROM tbl_ans WHERE quesNo = '$quesNo' ORDER BY id ASC";
    $result = $this->db->select($aquery);
    
    if ($result) {
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            $ansId = $row['id'];
            $ansText = mysqli_real_escape_string($this->db->link, $ans[$i]);
            $isRight = ($rightAns == $i) ? 1 : 0;
            
            $aupdateQuery = "UPDATE tbl_ans SET ans = '$ansText', rightAns = '$isRight' WHERE id = '$ansId'";
            $this->db->update($aupdateQuery);
            $i++;
        }
    }
    
    return "<div class='glass-msg success'>Question Details Synthesized & Updated Properly!</div>";
  }
   
  public function getAddQuestion($data){
    // Auto-calculate the next absolute question number directly from DB
    $query = "SELECT MAX(quesNo) as maxQ FROM tbl_ques";
    $result = $this->db->select($query);
    $quesNo = ($result && $row = $result->fetch_assoc()) ? ((int)$row['maxQ'] + 1) : 1;

    $ques   = mysqli_real_escape_string($this->db->link, $data['ques']);
    $subjectId = isset($data['subjectId']) ? mysqli_real_escape_string($this->db->link, $data['subjectId']) : 1;
    $ans    = array();
    $ans[1] = $data['ans1'];
    $ans[2] = $data['ans2'];
    $ans[3] = $data['ans3'];
    $ans[4] = $data['ans4'];
    $rightAns = mysqli_real_escape_string($this->db->link, $data['rightAns']);
   

    $query = "INSERT INTO tbl_ques(quesNo, ques, subjectId) VALUES('$quesNo','$ques','$subjectId')";
    $insert_row = $this->db->insert($query);

    if ($insert_row) {
       foreach ($ans as $key => $ansName) {
          if ($ansName != '') {
             if ($rightAns == $key) {
                $rquery = "INSERT INTO tbl_ans(quesNo, rightAns, ans) VALUES('$quesNo','1','$ansName')";
             }else{
                $rquery = "INSERT INTO tbl_ans(quesNo, rightAns, ans) VALUES('$quesNo','0','$ansName')";
             }
             $rinsert = $this->db->insert($rquery);
             if ($rinsert) {
                continue;
             }else{
                die('Error...');
             }
          }
       }
       $msg = "<div class='alert alert-success'>Data Inserted Successfuly!</div>";
       return $msg;
    }
  }

  public function getqueData($subjectId = null){
    if($subjectId) {
        $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
        $query = "SELECT tbl_ques.*, tbl_subjects.subjectName FROM tbl_ques LEFT JOIN tbl_subjects ON tbl_ques.subjectId = tbl_subjects.subjectId WHERE tbl_ques.subjectId = '$subjectId' ORDER BY quesNo ASC";
    } else {
        $query = "SELECT tbl_ques.*, tbl_subjects.subjectName FROM tbl_ques LEFT JOIN tbl_subjects ON tbl_ques.subjectId = tbl_subjects.subjectId ORDER BY tbl_ques.quesNo ASC";
    }
    $result = $this->db->select($query);
    return $result;
  }

  public function getdelresult($quesNo){
    $tables = array("tbl_ques","tbl_ans");
    foreach ($tables as $table) {
       $delqs     = "DELETE FROM $table WHERE quesNo = '$quesNo'";
       $delresult = $this->db->delete($delqs);
    }
    if ($delresult) {
       $msg = "<div class='alert alert-success'>Question Deleted Successfully!</div>";
       return $msg;
    }else{
       $msg = "<div class='alert alert-danger'>Data Not Deleted.</div>";
       return $msg;
    }
  }

  public function getTotalRows($subjectId = null){
    if($subjectId) {
        $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
        $query = "SELECT COUNT(*) as count FROM tbl_ques WHERE subjectId = '$subjectId'";
    } else {
        $query = "SELECT COUNT(*) as count FROM tbl_ques";
    }
    
    $getResult = $this->db->select($query);
    if ($getResult && $row = $getResult->fetch_assoc()) {
        return $row['count'];
    }
    return 0;
  }

  public function getQuestion($subjectId = null){
    if($subjectId) {
        $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
        $query = "SELECT * FROM tbl_ques WHERE subjectId = '$subjectId' ORDER BY quesNo ASC LIMIT 1";
    } else {
        $query = "SELECT * FROM tbl_ques ORDER BY quesNo ASC LIMIT 1";
    }
    $result     = $this->db->select($query);
    if ($result && $result->num_rows > 0) {
        $resultData = $result->fetch_assoc();
        return $resultData;
    }
    return null;
  }

  public function getQuestionNumber($quesNo){
    $query      = "SELECT * FROM tbl_ques WHERE quesNo = '$quesNo'";
    $result     = $this->db->select($query);
    $resultData = $result->fetch_assoc();
    return $resultData;
  }

  public function getRelativeQuestionNumber($subjectId, $quesNo){
      $query      = "SELECT COUNT(*) as rCount FROM tbl_ques WHERE subjectId = '$subjectId' AND quesNo <= '$quesNo'";
      $result     = $this->db->select($query);
      if ($result && $row = $result->fetch_assoc()) {
          return $row['rCount'];
      }
      return 1;
  }

  public function getAnswer($quesnumber){
    $query = "SELECT * FROM tbl_ans WHERE quesNo = '$quesnumber'";
    $result = $this->db->select($query);
    return $result;

  }

  public function getSubjectExamTime($subjectId){
    $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
    $query = "SELECT exam_time FROM tbl_subjects WHERE subjectId = '$subjectId'";
    $result = $this->db->select($query);
    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (int)$row['exam_time'];
    }
    return 600;
  }

  public function updateSubjectTimer($subjectId, $time){
      $subjectId = mysqli_real_escape_string($this->db->link, $subjectId);
      $time = (int)$time;
      $query = "UPDATE tbl_subjects SET exam_time = '$time' WHERE subjectId = '$subjectId'";
      $update = $this->db->update($query);

      if ($update) {
         return "<div class='glass-msg success'>Timer Updated Successfully!</div>";
      } else {
         return "<div class='alert alert-danger'>Timer Failed to Update.</div>";
      }
  }
}
?>