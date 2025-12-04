<?php
// backend/issuance_print.php

// 1. Corrected path
require_once "config.php"; 
// 2. Corrected path
require_once "fpdf186/fpdf.php"; 

session_start();

$id = $_GET['id'] ?? null;
if (!$id) die("Invalid Request ID.");

$residentEmail = $_SESSION['email'] ?? null;
if (!$residentEmail) die("Unauthorized access.");

try {
    $issuance = $client->bms_db->issuances->findOne([
        "_id" => new MongoDB\BSON\ObjectId($id),
        "resident_email" => $residentEmail
    ]);

    if (!$issuance) die("Issuance record not found or access denied.");

    $status = $issuance['status'];
    // Check if the document status is 'Ready'
    if (trim(strtolower($status)) !== 'ready') { 
        die("Error: Document status is '{$status}'. Only Ready documents can be printed.");
    }
    
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

function formatDateText($date) {
    if (!$date) return '—';
    return date("jS \d\a\y \o\f F, Y", strtotime($date));
}

class PDF extends FPDF {
    // Page header
    function Header() {
        // --- CORRECTED IMAGE PATH: '../assets/img/...' from the backend folder ---
        $this->Image('../assets/img/cdologo.png', 10, 10, 25);
        $this->Image('../assets/img/barangaygusalogo.png', 175, 10, 25);

        $this->SetY(12);
        $this->SetFont('Times','',10);
        $this->Cell(0,5,'Republic of the Philippines',0,1,'C');
        $this->Cell(0,5,'Province of Misamis Oriental',0,1,'C');
        $this->Cell(0,5,'City of Cagayan de Oro',0,1,'C');
        $this->SetFont('Times','B',11);
        $this->Cell(0,5,'BARANGAY GUSA',0,1,'C');

        $this->Ln(5);
        $this->SetFont('Times','B',14);
        $this->Cell(0,8,'BARANGAY CERTIFICATION',0,1,'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Times','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
}

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Times','',12);

// --- Content Section ---

// Document Type Title
$pdf->SetFont('Times','B',16);
$pdf->Cell(0,10, strtoupper($issuance['document_type']), 0, 1, 'C');
$pdf->Ln(15);


// Main Text Body
$pdf->SetFont('Times','',12);

// Indent first paragraph
$pdf->Cell(15); 
$pdf->Write(7, "TO WHOM IT MAY CONCERN:");
$pdf->Ln(10);


// Certification Details
$pdf->Cell(20); 
$pdf->Write(7, "This is to certify that ");

$pdf->SetFont('Times','B',12);
// Name comes from the issuance record
$pdf->Write(7, strtoupper($issuance['resident_name'])); 
$pdf->SetFont('Times','',12);
$pdf->Write(7, ", is a bonafide resident of Barangay Gusa, Cagayan de Oro City.");
$pdf->Ln(10);


// Request Purpose
$pdf->Cell(20); 
$pdf->Write(7, "This certification is being issued upon the request of the aforementioned person for the purpose of: ");
$pdf->SetFont('Times','B',12);

// Handle Multi-line Purpose
$pdf->Ln(10);
$pdf->Cell(30); // Indentation for the purpose block
$pdf->SetFont('Times','I',12);
$pdf->MultiCell(150, 6, trim($issuance['purpose']), 0, 'J'); 
$pdf->Ln(10);


// Final Statement
$pdf->SetFont('Times','',12);
$pdf->Cell(20); 
$pdf->Write(7, "Issued this ");

$pdf->SetFont('Times','B',12);
$pdf->Write(7, formatDateText(date("Y-m-d")));
$pdf->SetFont('Times','',12);
$pdf->Write(7, " in Barangay Gusa, Cagayan de Oro City, Philippines.");
$pdf->Ln(20);


// --- Signatures ---
$pdf->SetX(120);
$pdf->SetFont('Times','B',12);
$pdf->Cell(0, 5, 'HON. [BARANGAY CAPTAIN NAME]', 0, 1, 'L');
$pdf->SetX(120);
$pdf->SetFont('Times','',12);
$pdf->Cell(0, 5, 'Barangay Captain', 0, 1, 'L');


// Output PDF
$pdf->Output('I', str_replace(' ', '_', $issuance['document_type']) . '_' . $id . '.pdf');
?>