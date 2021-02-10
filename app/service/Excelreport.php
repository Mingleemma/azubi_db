<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 1/27/2020
 * Time: 11:28 AM
 */

class Excelreport
{

    public static function payments($startdate, $enddate){

        $allpayments =   Payments::getAllpaymentsbyDate($startdate,$enddate);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("office PHPExcel php")
            ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Account Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Account Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Account Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Payment Date');

        for ($i = 'A'; $i != $objPHPExcel->getActiveSheet()->getHighestColumn(); $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $i = 2;

        foreach($allpayments as $get){

            $acdata = Accounts::getAccountTypebyAccountNumber($get->accountnumber);
            $accounttype = isset($acdata->accounttype) ? $acdata->accounnttype : '';

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $get->fullname);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $get->accountnumber);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $accounttype);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $get->amount);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i,  $get->dateofpayment);

            $i++;

        }


        $objPHPExcel->getActiveSheet()->setTitle('SheetOne');

        ob_end_clean();
        header( "Content-type: application/vnd.ms-excel" );
        header('Content-Disposition: attachment; filename="payments.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;

    }

}