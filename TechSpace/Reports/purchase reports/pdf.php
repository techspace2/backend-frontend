<?php
// Include the main TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Extend TCPDF with a custom header and footer
class MYPDF extends TCPDF {

    // Custom Header
    public function Header() {
        // Add logo
        $logo = '01.jpg.png'; // Ensure this file exists in the correct path
        $this->Image($logo, 10, 10, 30); // (file, x, y, width)
        
        // Move below the logo for title
        $this->SetY(25); // Adjusted to create more space between logo and header
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'TechSpace - Purchases Report', 0, 1, 'C');

        // Subtitle
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'C');
    }

    // Custom Footer
    public function Footer() {
        $this->SetY(-20);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, 'TechSpace Inc. | No, 25, Rheinland Place, Wadduwa Kaluthara, Sri Lanka. | Contact: info@techspace.com', 0, 1, 'C');
        $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 0, 'C');
    }

    // Load table data from database
    public function LoadData() {
        require "connect.php";

        $select = "SELECT 
                    po.POrderID, 
                    po.SupplierID, 
                    s.SupllierName, 
                    s.SupplierEmail, 
                    s.SupplierContact, 
                    po.POrderName,  
                    po.POrderQuantity, 
                    po.POrderPrice, 
                    po.POrderStatus 
                FROM purchaseorder po
                INNER JOIN supplier s ON po.SupplierID = s.SupplierID;";

        $query = mysqli_query($conn, $select);
        if (!$query) {
            die("Database Query Failed: " . mysqli_error($conn));
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
        }

        return $data;
    }

    // Colored Table with Fixed Column Widths
    public function ColoredTable($header, $data) {
        // Header Styling
        $this->SetFillColor(0, 51, 102); // Dark Blue
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('', 'B');

        // Set smaller column widths to fit inside the page
        $w = array(18, 18, 30, 40, 25, 35, 25, 25, 35); // Reduced column widths

        // Print table headers
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 6, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        // Reset text color and font
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        // Print table rows
        $fill = 0;
        $tableHeight = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row["POrderID"], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row["SupplierID"], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row["SupllierName"], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row["SupplierEmail"], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, $row["SupplierContact"], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], 6, $row["POrderName"], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row["POrderQuantity"], 'LR', 0, 'C', $fill);
            $this->Cell($w[7], 6, $row["POrderPrice"], 'LR', 0, 'C', $fill);
            $this->Cell($w[8], 6, $row["POrderStatus"], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
            $tableHeight += 6; // Add the height of each row to tableHeight
        }
        $this->Cell(array_sum($w), 0, '', 'T');

        return $tableHeight;
    }
}

// Create new PDF document with custom page size (increased width to 250mm, A4 height of 297mm)
$pdf = new MYPDF('P', PDF_UNIT, array(270, 297), true, 'UTF-8', false); // 250mm width, 297mm height

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TechSpace');
$pdf->SetTitle('Department Operation Report');
$pdf->SetSubject('Operations');
$pdf->SetKeywords('TCPDF, PDF, TechSpace, Report, Operations');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(10, 40, 10); // Increased top margin for more space
$pdf->SetHeaderMargin(15);
$pdf->SetFooterMargin(10);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15); // Adjusted for better fit

// Set font
$pdf->SetFont('helvetica', '', 9); // Smaller font size for better fit

// Add a page in **Portrait mode (custom size)**
$pdf->AddPage();

// Column titles
$header = array('PO ID', 'S ID', 'Supplier Name', 'Email', 'Contact', 'Order Name', 'Order Qty', 'Price', 'Status');

// Load data
$data = $pdf->LoadData();

// Explicitly set Y position to create more space after the header and before the table
$pdf->SetY($pdf->GetY() + 10); // Add space before table printing

// Calculate the table height
$tableHeight = $pdf->ColoredTable($header, $data);

// Calculate the total page height
$pageHeight = 40 + $tableHeight + 40; // 40 is the top and bottom margins

// Add another page if the content exceeds the default page height
if ($pageHeight > 297) {  // A4 page height in mm is 297
    $pdf->AddPage();
}

// Output PDF
$pdf->Output('Purchases_report.pdf', 'I');
?>
