<?php
// Include the main TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Extend TCPDF with a custom header and footer
class MYPDF extends TCPDF {

    // Custom Header
    public function Header() {
        $logo = '01.jpg.png'; // Ensure this file exists in the correct path
        $this->Image($logo, 10, 10, 30);
        
        $this->SetY(25);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 10, 'TechSpace - Financial Report', 0, 1, 'C');

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

    // Load Revenue Data
    public function LoadRevenueData() {
        require "connect.php";
        $select = "SELECT RID, RDesc, RAmount, RType FROM revenue";
        $query = mysqli_query($conn, $select);
        if (!$query) {
            die("Database Query Failed: " . mysqli_error($conn));
        }
        $data = [];
        $totalRevenue = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
            $totalRevenue += $row['RAmount'];  // Add revenue amount to the total
        }
        return ['data' => $data, 'totalRevenue' => $totalRevenue];
    }

    // Load Expense Data and Calculate Total Expense
    public function LoadExpenseData() {
        require "connect.php";
        $select = "SELECT EID, EDesc, EAmount, EType FROM expense";
        $query = mysqli_query($conn, $select);
        if (!$query) {
            die("Database Query Failed: " . mysqli_error($conn));
        }
        $data = [];
        $totalExpense = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $data[] = $row;
            $totalExpense += $row['EAmount'];  // Add expense amount to the total
        }
        return ['data' => $data, 'totalExpense' => $totalExpense];
    }

    // Generate table for Revenue
    public function GenerateRevenueTable($header, $data) {
        $this->SetFillColor(0, 51, 102);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('', 'B');

        $w = array(30, 90, 40, 30); // Added column width for "Type"
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['RID'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['RDesc'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Cell($w[2], 6, $row['RAmount'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Cell($w[3], 6, $row['RType'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    // Generate table for Expense
    public function GenerateExpenseTable($header, $data) {
        $this->SetFillColor(0, 51, 102);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('', 'B');

        // Define column widths
        $w = array(30, 90, 40, 30); // Added column width for "Type"
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();

        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');

        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row['EID'], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row['EDesc'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Cell($w[2], 6, $row['EAmount'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Cell($w[3], 6, $row['EType'], 'LR', 0, 'C', $fill); // Centered this column
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TechSpace');
$pdf->SetTitle('Financial Report');
$pdf->SetMargins(10, 40, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$pdf->SetY($pdf->GetY() + 10);

// Revenue Table
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Revenue Details', 0, 1, 'L');
$pdf->Ln(5); // Space before table
$pdf->SetFont('helvetica', '', 9);
$revenueHeader = array('Revenue ID', 'Description', 'Amount', 'Type'); // Header includes "Type"
$revenueData = $pdf->LoadRevenueData();
$pdf->GenerateRevenueTable($revenueHeader, $revenueData['data']);

// Expense Table
$pdf->Ln(15); // Increased spacing before next table
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Expense Details', 0, 1, 'L');
$pdf->Ln(5); // Space before table
$pdf->SetFont('helvetica', '', 9);
$expenseData = $pdf->LoadExpenseData()['data'];
$pdf->GenerateExpenseTable(array('Expense ID', 'Description', 'Amount', 'Type'), $expenseData);

// Calculate total revenue and total expense
$totalRevenue = $revenueData['totalRevenue'];
$totalExpense = $pdf->LoadExpenseData()['totalExpense'];

// Calculate Net Profit or Loss
$netProfitLoss = $totalRevenue - $totalExpense;

// Display Total Revenue, Total Expense, and Net Profit/Loss based on condition
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Total Revenue: ' . number_format($totalRevenue, 2), 0, 1, 'L');
$pdf->Cell(0, 10, 'Total Expenses: ' . number_format($totalExpense, 2), 0, 1, 'L');

// Only display "Net Profit" if there's a profit, else display "Net Loss"
if ($netProfitLoss > 0) {
    $pdf->Cell(0, 10, 'Net Profit: ' . number_format($netProfitLoss, 2), 0, 1, 'L');
} else {
    $pdf->Cell(0, 10, 'Net Loss: ' . number_format(abs($netProfitLoss), 2), 0, 1, 'L');
}

$pdf->Output('Financial_Report.pdf', 'I');
?>
