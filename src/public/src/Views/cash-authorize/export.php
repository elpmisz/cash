<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . '/../../assets/includes/inc.connect.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

$sql = "SELECT A.id,
IF(A.type = 1,'ฝ่าย','รายบุคคล') AS type_name,
IF(
  A.type = 1,
  CONCAT('ฝ่าย',B.dep_name),
  CONCAT('K.',C.user_name,' ',C.user_surname)
) AS user_name,
DATE_FORMAT(created, '%d/%m/%Y, %H:%i น.') as created
FROM cpl_helpdesk.authorize A
LEFT JOIN cpl.department B 
ON A.user = B.dep_id
LEFT JOIN cpl.emp_user C 
ON A.user = C.user_id
WHERE A.status = 1 ";

$stmt = $dbcon->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();


$spreadsheet = new Spreadsheet();
$writer = new Xlsx($spreadsheet);

$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();

$activeSheet->setCellValue('A1', '#');
$activeSheet->setCellValue('B1', 'ประเภท');
$activeSheet->setCellValue('C1', 'ชื่อ');
$activeSheet->setCellValue('D1', 'วันที่');

foreach (range('A', 'D') as $column) {
  $activeSheet->getColumnDimension($column)->setAutoSize(true);
}

$styleHeader = [
  'font' => [
    'bold' => true,
  ],
  'alignment' => [
    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
  ],
  'borders' => [
    'allBorders' => [
      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    ],
  ]
];

$activeSheet->getStyle('A1:D1')->applyFromArray($styleHeader);

$styleData = [
  'borders' => [
    'allBorders' => [
      'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    ]
  ],
];

$i = 1;
foreach ($result as $row) {
  $i++;
  $activeSheet->setCellValue('A' . $i, $i - 1);
  $activeSheet->setCellValue('B' . $i, $row['type_name']);
  $activeSheet->setCellValue('C' . $i, $row['user_name']);
  $activeSheet->setCellValue('D' . $i, $row['created']);
  $activeSheet->getStyle('A' . $i . ':D' . $i)->applyFromArray($styleData);
}

$date = date('Y-m-d');
$filename = $date . '_helpdesk_authorize.xlsx';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $filename);
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();
