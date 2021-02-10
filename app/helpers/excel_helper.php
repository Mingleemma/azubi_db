<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function writeToExcel($data){

  $filename = APPROOT.'/uploads/menteeRegistration.xlsx';
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
  $i = $reader->getActiveSheet()->getHighestRow()+1;
  $sheet = $reader->getActiveSheet();
  $sheet->setCellValue('A' . $i, $data->firstname);
  $sheet->setCellValue('B' . $i, $data->lastname);
  $sheet->setCellValue('C' . $i, $data->gender);
  $sheet->setCellValue('D' . $i, $data->housenumber);
  $sheet->setCellValue('E' . $i, $data->postaladdress);
  $sheet->setCellValue('F' . $i, $data->dateofbirth);
  $sheet->setCellValue('G' . $i, $data->nationality);
  $sheet->setCellValue('H' . $i, $data->nationality2);
  $sheet->setCellValue('I' . $i, $data->telephone);
  $sheet->setCellValue('J' . $i, $data->email);
  $sheet->setCellValue('K' . $i, $data->schoolname);
  $sheet->setCellValue('L' . $i, $data->schoolform);
  $sheet->setCellValue('M' . $i, $data->location);
  $sheet->setCellValue('N' . $i, $data->classroom);
  $sheet->setCellValue('O' . $i, $data->graduationclass);
  $sheet->setCellValue('P' . $i, $data->doeseducationworkerknow);
  $sheet->setCellValue('Q' . $i, $data->educationworkerfirstname);
  $sheet->setCellValue('R' . $i, $data->educationworkerlastname);
  $sheet->setCellValue('S' . $i, $data->educationworkerhousenumber);
  $sheet->setCellValue('T' . $i, $data->educationworkerpostaladdress);
  $sheet->setCellValue('U' . $i, $data->educationworkeremail);
  $sheet->setCellValue('V' . $i, $data->educationworkertelephone);
  $sheet->setCellValue('W' . $i, $data->reasonforjoining);
  $sheet->setCellValue('X' . $i, $data->hobby);
  $sheet->setCellValue('Y' . $i, $data->favoritesport);
  $sheet->setCellValue('Z' . $i, $data->videopath);
  $sheet->setCellValue('AA' . $i, $data->usertype);
  $sheet->setCellValue('AB' . $i, $data->employer);
  $sheet->setCellValue('AC' . $i, $data->employerlocation);
  $sheet->setCellValue('AD' . $i, $data->graduation);
  $sheet->setCellValue('AE' . $i, $data->educationlevel);
  $sheet->setCellValue('AF' . $i, $data->apprenticeship);
  $sheet->setCellValue('AG' . $i, $data->photocopyid);
  $sheet->setCellValue('AH' . $i, $data->additionalinfo);
  $sheet->setCellValue('AI' . $i, $data->expectation);
  $sheet->setCellValue('AJ' . $i, $data->referral);
  $sheet->setCellValue('AK' . $i, $data->jobtitle);
  $sheet->setCellValue('AL' . $i, $data->yearofbirth);
  $sheet->setCellValue('AM' . $i, date('Y-m-d'));

  $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($reader, 'Xlsx');
  return $writer->save($filename);

}


function createExcelFile(){

  $spreadsheet = new Spreadsheet();
  $sheet = $spreadsheet->getActiveSheet();

  $sheet->setCellValue('A1', 'First Name');
  $sheet->setCellValue('B1', 'Last Name');
  $sheet->setCellValue('C1', 'Gender');
  $sheet->setCellValue('D1', 'Mentee Street House Num');
  $sheet->setCellValue('E1', 'Mentee Postal Add');
  $sheet->setCellValue('F1', 'Date Of Birth');
  $sheet->setCellValue('G1', 'Nationality');
  $sheet->setCellValue('H1', 'Nationality2');
  $sheet->setCellValue('I1', 'Mentee Mobile Number');
  $sheet->setCellValue('J1', 'Mentee Email');
  $sheet->setCellValue('K1', 'Name Of School');
  $sheet->setCellValue('L1', 'Mentee School Form');
  $sheet->setCellValue('M1', 'School Location');
  $sheet->setCellValue('N1', 'Mentee Classroom');
  $sheet->setCellValue('O1', 'Mentee Graduation Class');
  $sheet->setCellValue('P1', 'Does Education Worker Know');
  $sheet->setCellValue('Q1', 'Education Worker Firstname');
  $sheet->setCellValue('R1', 'Education Worker Lastname');
  $sheet->setCellValue('S1', 'Education Worker Street House Num');
  $sheet->setCellValue('T1', 'Education Worker Postal Add');
  $sheet->setCellValue('U1', 'Education Worker Email');
  $sheet->setCellValue('V1', 'Education Worker Tel');
  $sheet->setCellValue('W1', 'Reason For Joining');
  $sheet->setCellValue('X1', 'Hobby');
  $sheet->setCellValue('Y1', 'Favorite Sport');
  $sheet->setCellValue('Z1', 'Student Video');
  $sheet->setCellValue('AA1', 'Type');
  $sheet->setCellValue('AB1', 'Mentor Employer');
  $sheet->setCellValue('AC1', 'Mentor Employer Location');
  $sheet->setCellValue('AD1', 'Mentor Graduation');
  $sheet->setCellValue('AE1', 'Mentor Education Level');
  $sheet->setCellValue('AF1', 'Mentor Apprenticeship');
  $sheet->setCellValue('AG1', 'Mentor Photocopy Id');
  $sheet->setCellValue('AH1', 'Additional Information');
  $sheet->setCellValue('AI1', 'Mentor Expectation');
  $sheet->setCellValue('AJ1', 'Referral');
  $sheet->setCellValue('AK1', 'Mentor Job Title');
  $sheet->setCellValue('AL1', 'Year of Birth');
  $sheet->setCellValue('AM1', 'Date Created');

  $sheet->setTitle('Menteedata');
  $writer = new Xlsx($spreadsheet);
  $writer->save(APPROOT . '/uploads/menteeRegistration.xlsx');
}


 ?>
