]
<?php
require('fpdf/fpdf.php');
include('includes/config.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Data Paket Wisata', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);

// Ambil data dari database
$sql = "SELECT PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures FROM TblTourPackages";
$query = $dbh->prepare($sql);
$query->execute();
$data = $query->fetchAll(PDO::FETCH_ASSOC);

// Cetak data
foreach ($data as $row) {
    $pdf->Cell(0, 10, 'Package Name: ' . $row['PackageName'], 0, 1);
    $pdf->Cell(0, 10, 'Package Type: ' . $row['PackageType'], 0, 1);
    $pdf->Cell(0, 10, 'Package Location: ' . $row['PackageLocation'], 0, 1);
    $pdf->Cell(0, 10, 'Package Price: ' . $row['PackagePrice'], 0, 1);
    $pdf->Cell(0, 10, 'Package Features: ' . $row['PackageFetures'], 0, 1);
    $pdf->Ln(5);
}

$pdf->Output();
