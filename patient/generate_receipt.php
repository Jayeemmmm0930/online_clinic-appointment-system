<?php
require_once('../TCPDF/tcpdf.php'); 

function generatePDFReceipt($html, $filename, $patientId, $patientRow, $serviceRow, $row, $scheduleRow) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Receipt');
    $pdf->SetSubject('Receipt');
    $pdf->SetKeywords('Receipt, PDF');

    // Set margins
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);


    $pdf->SetAutoPageBreak(TRUE, 10);


    $pdf->AddPage();


    $pdf->SetFont('helvetica', '', 10);

 
    $bg_image = '../health.png';
    $pdf->Image($bg_image, 50, 50, 100, 100, '', '', '', false, 300, '', false, false, 0);

   
    $pdf->SetFillColor(255, 255, 255);

    $pdf->Rect(0, 0, 210, 30, 'F');


    $image_file = '../images.png'; 
    $pdf->Image($image_file, 10, 15, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false);


    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(120, 10, 'APPOINTMENT RECEIPT', 0, 1, 'C', 0, '', 1);


    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(180, 5, 'REPUBLIC OF THE PHILIPPINES', 0, 1, 'C');
    $pdf->Cell(180, 5, 'CLINIC APPOINTMENT SYSTEM', 0, 1, 'C');
    $pdf->Cell(180, 5, 'KORONADAL CITY, SOUTH COTABATO', 0, 1, 'C');
    $pdf->Cell(180, 5, 'ONLINE APPOINTMENT', 0, 1, 'C');


    $pdf->SetFont('helvetica', '', 13);
    $pdf->Ln(10);
    $pdf->SetX(20);
    $pdf->Cell(0, 8, 'Patient Information', 1, 1, 'L', 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetX(20); 
    $pdf->Cell(100, 8, 'Patient ID:', 0, 0, 'L');
    $pdf->Cell(0, 8, $patientId, 0, 1, 'L');
    $pdf->SetX(20); 
    $pdf->Cell(100, 8, 'Name:', 0, 0, 'L');
    $pdf->Cell(0, 8, $patientRow['firstname'] . ' ' . $patientRow['middleinitial'] . ' ' . $patientRow['lastname'], 0, 1, 'L');

  
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', '', 13);
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(0, 8, 'Appointment Information', 1, 1, 'L', 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(100, 8, 'Appointment Type:', 0, 0, 'L');
    $pdf->Cell(0, 8, $serviceRow['type'], 0, 1, 'L');
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(100, 8, 'Time Slot:', 0, 0, 'L');
    $pdf->Cell(0, 8, $row['time_slot'], 0, 1, 'L');
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(100, 8, 'Date of Appointment:', 0, 0, 'L');
    $pdf->Cell(0, 8, $scheduleRow['date_schedule'], 0, 1, 'L');

 
    $pdf->Ln(8);
    $pdf->SetFont('helvetica', '', 13);
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(0, 8, 'Transaction Information', 1, 1, 'L', 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetX(20); // Move to the right by 100 units
    $pdf->Cell(100, 8, 'Transaction Number:', 0, 0, 'L');
    $pdf->Cell(0, 8, $row['transaction_number'], 0, 1, 'L');

    // Output PDF
    $pdf->Output($filename, 'I'); 
}




include("../querys/db_config.php");

if (isset($_GET['transaction_id'])) {
    $transactionId = $_GET['transaction_id'];

    $sql = "SELECT * FROM tbl_transaction WHERE id = '$transactionId'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $serviceId = $row['fk_service_id'];
        $patientId = $row['fk_patient_id'];
        $scheduleId = $row['fk_schedule_id'];

        // Retrieve service information
        $serviceQuery = mysqli_query($connection, "SELECT type, fee FROM tbl_service WHERE id = '$serviceId'");
        if ($serviceQuery && mysqli_num_rows($serviceQuery) > 0) {
            $serviceRow = mysqli_fetch_assoc($serviceQuery);
        } else {
            echo "Error: Service information not found.";
            exit;
        }

        // Retrieve schedule information
        $scheduleQuery = mysqli_query($connection, "SELECT date_schedule, slots FROM tbl_schedule WHERE id = '$scheduleId'");
        if ($scheduleQuery && mysqli_num_rows($scheduleQuery) > 0) {
            $scheduleRow = mysqli_fetch_assoc($scheduleQuery);
        } else {
            echo "Error: Schedule information not found.";
            exit;
        }

        // Retrieve patient information
        $patientQuery = mysqli_query($connection, "SELECT firstname, middleinitial, lastname FROM tbl_patient WHERE id = '$patientId'");
        if ($patientQuery && mysqli_num_rows($patientQuery) > 0) {
            $patientRow = mysqli_fetch_assoc($patientQuery);
        } else {
            echo "Error: Patient information not found.";
            exit;
        }

        // Generate PDF receipt
        generatePDFReceipt('', 'receipt.pdf', $patientId, $patientRow, $serviceRow, $row, $scheduleRow);
    } else {
        echo "Transaction not found.";
    }
} else {
    echo "Transaction ID not provided.";
}
?>
