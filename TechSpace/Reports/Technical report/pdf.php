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
        $this->Cell(0, 10, 'TechSpace - Technical Report', 0, 1, 'C');

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

        // Fixed SQL query with the trailing comma removed
        $select = "SELECT 
                    po.MCID, 
                    po.MachineID, 
                    s.MName, 
                    s.MDate, 
                    po.MCheckDate, 
                    po.MachineCondition,
                    s.MPrice
                FROM machinecondition po
                INNER JOIN machinery s ON po.MachineID = s.MID;";

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

    // Colored Table with Dynamic Column Widths
    public function ColoredTable($header, $data) {
        // Calculate the maximum width for each column based on the header and data content
        $w = [];
        foreach ($header as $col) {
            $w[] = max(strlen($col) * 2, 30); // Minimum width of 30mm, adjust based on column header length
        }

        // Header Styling
        $this->SetFillColor(0, 51, 102); // Dark Blue
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('', 'B');

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
        $tableHeight = 0; // Initialize total height of the table
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row["MCID"], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row["MachineID"], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row["MName"], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row["MCheckDate"], 'LR', 0, 'C', $fill);
            $this->Cell($w[4], 6, $row["MDate"], 'LR', 0, 'C', $fill);
            $this->Cell($w[5], 6, $row["MachineCondition"], 'LR', 0, 'C', $fill);
            $this->Cell($w[6], 6, $row["MPrice"], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
            $tableHeight += 6; // Add the height of each row to tableHeight
        }
        $this->Cell(array_sum($w), 0, '', 'T');

        return $tableHeight; // Return total height of the table
    }
}

// Get custom width and height (from a form or URL params)
$pageWidth = isset($_GET['width']) ? (int)$_GET['width'] : 230; // Default to 270mm
$pageHeight = isset($_GET['height']) ? (int)$_GET['height'] : 297; // Default to 297mm (A4 height)

// Create new PDF document with custom page size (increased width to 270mm, A4 height of 297mm)
$pdf = new MYPDF('P', PDF_UNIT, array($pageWidth, $pageHeight), true, 'UTF-8', false); // Custom width and height

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TechSpace');
$pdf->SetTitle('Technical Report');
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

// Column titles based on the database fields
$header = array('Report ID', 'Machine ID', 'Name', 'Inspection Date', 'Purchased Date', 'Condition', 'Price');

// Load data
$data = $pdf->LoadData();

// Explicitly set Y position to create more space after the header and before the table
$pdf->SetY($pdf->GetY() + 10); // Add space before table printing

// Calculate the table height
$tableHeight = $pdf->ColoredTable($header, $data);

// Calculate the total page height
$pageHeight = 40 + $tableHeight + 40; // 40 is the top and bottom margins

// Add another page if the content exceeds the default page height
if ($pageHeight > $pageHeight) {  // Custom page height
    $pdf->AddPage();
}

// Output PDF
$pdf->Output('technical_report.pdf', 'I');
?>
