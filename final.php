<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
  if (isset($_SESSION['exam_id'])) {
      unset($_SESSION['exam_id']);
  }
?>

<div class="glass-wrapper">
    <div class="glass-card text-center">

        <style>
        /* Screen Styles for Report */
        .report-box {
            background: rgba(0,0,0,0.2); 
            border-radius: 15px; 
            padding: 25px; 
            margin: 30px 0; 
            text-align: left;
        }
        .report-grid {
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 15px; 
            font-size: 16px; 
            color: rgba(255,255,255,0.9);
        }
        .report-item {
            padding: 10px; 
            background: rgba(255,255,255,0.05); 
            border-radius: 8px;
        }

        /* Print Styles removed in favor of JS printing */
        </style>

        <div id="screenResult">
            <h2 class="glass-card-title text-highlight">🎉 Exam Completed!</h2>
            <p class="glass-card-subtitle text-highlight" style="margin-bottom: 5px;">Here is your final score:</p>

            <?php
            $score = isset($_SESSION['score']) ? $_SESSION['score'] : 0;
            $subjectId = isset($_SESSION['subjectId']) ? (int)$_SESSION['subjectId'] : 1;
            
            // Get total for percentage calculation
            $total = $exam->getTotalRows($subjectId);
            $percentage = ($total > 0) ? round(($score / $total) * 100, 2) : 0;

            // Fetch subject name
            $subjectName = "Your Exam";
            $allSubs = $exam->getAllSubjects();
            if ($allSubs) {
                while($s = $allSubs->fetch_assoc()) {
                    if ($s['subjectId'] == $subjectId) {
                        $subjectName = $s['subjectName'];
                    }
                }
            }

            // Get exam duration for this subject
            $examDuration = $exam->getSubjectExamTime($subjectId) / 60; // in minutes
            $candidateName = Session::get("name");
            if (empty($candidateName)) {
                 $candidateName = "Student";
            }
            ?>

            <!-- Minimal Dashboard Display -->
            <div class="animate-pop" style="font-size: 60px; font-weight: 700; margin: 10px 0 0 0; color: #00eaff; text-shadow: 0 4px 15px rgba(0, 234, 255, 0.4);">
                <?php echo $score; ?> / <?php echo $total; ?>
            </div>
            <div class="animate-pop" style="font-size: 30px; font-weight: 700; margin: 0 0 30px 0; color: #ffeb3b; text-shadow: 0 4px 15px rgba(255, 235, 59, 0.4);">
                (<?php echo $percentage; ?>%)
            </div>
            
            <p style="margin-bottom: 25px; font-weight: 500;">Check your answers or start a new test.</p>
        </div>

        <!-- Hidden Professional Blueprint for PDF Download -->
        <div id="printableResult" style="display: none;">
            
            <div style="text-align: center; margin-bottom: 25px;">
                <h1 style="margin: 0; font-size: 28px; font-weight: 900; letter-spacing: 1px; text-transform: uppercase; font-family: 'Times New Roman', Times, serif; color: #111;">Bharati Vidyapeeth University</h1>
                <h3 style="margin: 5px 0; font-size: 16px; font-weight: normal; color: #333; font-family: Arial, sans-serif;">ONLINE EXAMINATION SYSTEM</h3>
                <h2 style="margin: 15px 0 0 0; font-size: 22px; text-decoration: underline; font-family: 'Times New Roman', Times, serif; color: #000;">OFFICIAL STATEMENT OF MARKS</h2>
            </div>
            
            <div style="border: 2px solid #222; padding: 20px; border-radius: 4px; margin-bottom: 30px; font-family: Arial, sans-serif;">
                <table style="width: 100%; border: none; font-size: 14px; line-height: 1.8;">
                    <tr>
                        <td style="width: 20%; font-weight: bold; color: #333;">Candidate Name</td>
                        <td style="width: 30%; color: #000;">: <strong><?php echo strtoupper($candidateName); ?></strong></td>
                        <td style="width: 20%; font-weight: bold; color: #333;">Date of Issue</td>
                        <td style="width: 30%; color: #000;">: <?php echo date("d F Y"); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; color: #333;">Roll No / Username</td>
                        <td style="color: #000;">: <?php echo Session::get("userName") ? strtoupper(Session::get("userName")) : "N/A"; ?></td>
                        <td style="font-weight: bold; color: #333;">Exam Duration Info</td>
                        <td style="color: #000;">: <?php echo $examDuration; ?> Minutes (Time Limit)</td>
                    </tr>
                </table>
            </div>

            <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: Arial, sans-serif; margin-bottom: 40px; border: 2px solid #222;">
                <thead>
                    <tr style="background-color: #e9ecef; color: #000;">
                        <th style="padding: 12px; border: 1px solid #222; text-align: left;">Course / Subject Title</th>
                        <th style="padding: 12px; border: 1px solid #222;">Maximum Questions</th>
                        <th style="padding: 12px; border: 1px solid #222;">Questions Correct</th>
                        <th style="padding: 12px; border: 1px solid #222;">Percentage Secured</th>
                        <th style="padding: 12px; border: 1px solid #222;">Final Grade Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 15px 12px; border: 1px solid #222; text-align: left; font-weight: bold; font-size: 15px; color: #000;"><?php echo strtoupper($subjectName); ?></td>
                        <td style="padding: 15px 12px; border: 1px solid #222; font-size: 15px; color: #000;"><?php echo $total; ?></td>
                        <td style="padding: 15px 12px; border: 1px solid #222; font-size: 15px; color: #000;"><?php echo $score; ?></td>
                        <td style="padding: 15px 12px; border: 1px solid #222; font-size: 15px; font-weight: bold; color: #000;"><?php echo $percentage; ?>%</td>
                        <td style="padding: 15px 12px; border: 1px solid #222; font-size: 16px; font-weight: bold; color: <?php echo ($percentage >= 50) ? '#1b5e20' : '#b71c1c'; ?>;">
                            <?php echo ($percentage >= 50) ? 'PASS' : 'FAIL'; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div style="margin-top: 60px; display: flex; justify-content: space-between; font-family: Arial, sans-serif; font-size: 12px; color: #666; border-top: 1px dashed #999; padding-top: 10px;">
                <div style="text-align: left;">
                    <strong>Authenticity Note:</strong><br/>
                    This document is a securely computer-generated transcript.<br/>
                    It is processed via the Online Examination System and does not require a physical signature.
                </div>
                <div style="text-align: right;">
                    <strong>System ID Tag:</strong><br/>
                    OES-RES-<?php echo time(); ?><br/>
                    <em>End of Report</em>
                </div>
            </div>

            <?php unset($_SESSION['score']); ?>
        </div>

        <!-- Buttons -->
        <a class="glass-btn no-print" href="viewans.php" style="margin-bottom: 15px; display: block; border: 1px solid rgba(255,255,255,0.2);">
            ✅ View Answer
        </a>

        <button class="glass-btn no-print" onclick="downloadReport()" style="margin-bottom: 15px; display: block; background: linear-gradient(45deg, #11998e, #38ef7d);">
            📥 Download Report
        </button>

        <a class="glass-link-btn no-print" href="exam.php">
            🔄 Start New Exam
        </a>

    </div>
</div>

<script>
// Clear the timer from localStorage since the exam is completed
localStorage.removeItem('exam_end_time');
localStorage.removeItem('exam_session_id');

// Robust Print Function
function downloadReport() {
    var printContent = document.getElementById("printableResult").innerHTML;
    // Inject a simplified payload specifically optimized for printing ink
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Exam Report</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('body { font-family: sans-serif; text-align: center; padding: 40px; color: black; background: white; }');
    printWindow.document.write('.report-box { border: 2px solid #ddd; padding: 30px; border-radius: 10px; margin-top: 20px; text-align: left; }');
    printWindow.document.write('.report-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: left; margin-top: 20px; }');
    printWindow.document.write('.report-item { border: 1px solid #ccc; padding: 15px; border-radius: 5px; background: #fafafa; }');
    printWindow.document.write('.no-print { display: none; }');
    printWindow.document.write('h2, h4, p { margin: 0 0 10px 0; color: black !important; text-shadow: none !important; }');
    printWindow.document.write('span, strong { color: black !important; text-shadow: none !important; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    
    // Automatically trigger print dialog
    setTimeout(function() {
        printWindow.print();
        printWindow.close();
    }, 500);
}
</script>

<?php include 'inc/footer.php'; ?>