<?php
ini_set('max_execution_time', 1200);

$con = mysql_connect('localhost','root','root')  or die('Could not connect to the server!');

mysql_select_db('selfcare')  or die('Could not select a database.');

mysql_query('SET names utf8');


require_once 'phpexcel/PHPExcel/IOFactory.php';
require_once 'phpexcel/PHPExcel/Writer/IWriter.php';

$filename = 'uploads/0365.xlsx';

$inputFileType = 'Excel2007';



$sheetname = 'EUR';
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
//$objReader->setReadDataOnly(true);
$objReader->setLoadSheetsOnly($sheetname);
$objPHPExcel = $objReader->load($filename);



//$objPHPExcel = PHPExcel_IOFactory::load('../macro/'.$filename);



foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	$worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
   
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
    $nrColumns = ord($highestColumn) - 64;
    

     
   

    for ($row = 1; $row <= $highestRow; ++ $row){
      
      for ($col = 0; $col< $highestColumnIndex; ++ $col) {
   
    $firstname = mysql_real_escape_string($worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue());
	  $lastname = mysql_real_escape_string($worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue());
	  $address = mysql_real_escape_string($worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue());
	  $dob = mysql_real_escape_string($worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue());	
	  $school = mysql_real_escape_string($worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue()); 
    $schoolocation = mysql_real_escape_string($worksheet->getCellByColumnAndRow(6, $row)->getFormattedValue()); 
    $class = mysql_real_escape_string($worksheet->getCellByColumnAndRow(7, $row)->getFormattedValue()); 
    $graduteclass = mysql_real_escape_string($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue());
    $educatorknow = mysql_real_escape_string($worksheet->getCellByColumnAndRow(9, $row)->getFormattedValue()); 

    $efirstname = mysql_real_escape_string($worksheet->getCellByColumnAndRow(10, $row)->getFormattedValue());
    $elastname = mysql_real_escape_string($worksheet->getCellByColumnAndRow(11, $row)->getFormattedValue());
    $eaddress = mysql_real_escape_string($worksheet->getCellByColumnAndRow(12, $row)->getFormattedValue());
    $etelephone = mysql_real_escape_string($worksheet->getCellByColumnAndRow(13, $row)->getFormattedValue());

    $hobbies = mysql_real_escape_string($worksheet->getCellByColumnAndRow(14, $row)->getFormattedValue());
    $sports = mysql_real_escape_string($worksheet->getCellByColumnAndRow(16, $row)->getFormattedValue());
    $url = mysql_real_escape_string($worksheet->getCellByColumnAndRow(16, $row)->getFormattedValue());



		
      }


      if($firstname != ''){

      $insert = mysql_query("INSERT INTO basicinformation (firstname,surname, dateofbirth
        hobbies,fullname,type,emailaddress,telephone,class,graduationclass,educatorknowledge,sports,school,
        schoolocation, address) values ('$firstname', '$lastname', '$dob', '$hobbies', '', 'Mentee', '', '',
         '$class', '$graduteclass', '$educatorknow', '$sports', '$school', '$schoolocation', '$address')");

      $bid = mysql_insert_id();
     
     


      }
	
	  
}




 }



$date = date('Y-m');

 $getofficeprices = mysql_query("Select * from officeprices where month = '$month'  and year = '$year' ");

 while($get = mysql_fetch_array($getofficeprices)){

      $pofferid = $get['offerid'];

      $getprices = mysql_query("Select * from officeprices where offerid = '$pofferid'
      and month = '$month' and year = '$year' ");
      $p = mysql_fetch_array($getprices);


      $listedprice = $p['listprice'];
      $erprice  = $p['erprice'];


      $updatebiinglog =  mysql_query("UPDATE billinglog set  listprice='$listedprice',
      erprice = '$erprice' where offerid = '$pofferid' and date_created like '%$date%'  ");

       $updateaccounts =  mysql_query("UPDATE accounts set listprice='$listedprice',
        erprice = '$erprice' where offerid = '$pofferid' and date_created like '%$date%'  ");
 }



?>

     