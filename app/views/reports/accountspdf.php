<?php

require_once(APPROOT.'/html2pdf/html2pdf.class.php');

ob_start();



?>

<body style="font-size: 12px; font-family: Arial; line-height: 25.2px; text-align: justify;">
<table width="800px" border="1" style="  border-collapse: collapse;">
    <tr style="font-weight: bold">
        <td width="10">#</td>
        <td width="300">Account Name</td>
        <td width="200">Account Number</td>
        <td width="200">Account Type</td>
    </tr>
    <?php  foreach($data as $key=>$get):   ?>
        <tr>
            <td><?php  echo $key+1 ?></td>
            <td><?php echo $get->accountname  ?></td>
            <td><?php  echo $get->accounttype ?></td>
            <td><?php  echo $get->accountnumber ?></td>
        </tr>
    <?php   endforeach;    ?>
</table>

</body>
<?php
$content = ob_get_clean();

try
{
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(5, 5, 5, 5));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    // send the PDF
    //$pdffile = $html2pdf->Output('pdf/'.$shopnumber.'.pdf','F');//,'D');
    $pdffile = $html2pdf->Output(APPROOT.'/pdfs/accounts.pdf','F');//,'D');

    $fp = fopen(APPROOT.'/pdfs/accounts.pdf','r');

    $path = APPROOT.'/pdfs/accounts.pdf';
    Header('Content-Type: application/pdf');
    Header('Content-Description: File Transfer');
    Header('Content-Disposition: inline; filename='.basename($path));
    Header('Content-Transfer-Encoding: binary');
    Header('Expires: 0');
    Header('Cache-Control: must-revalidate, post-check=0, precheck=0');
    Header('Pragma: public');
    Header('Content-Length: '.filesize($path));
    ob_clean();
    flush();
    readfile($path);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>

