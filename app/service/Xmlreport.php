<?php
/**
 * Created by PhpStorm.
 * User: oduru
 * Date: 12/31/2019
 * Time: 2:23 PM
 */

class Xmlreport
{

    private function xmlEnvelope($paymentdata = null){
        $xml  = "<ENVELOPE>";
        $xml  .= $this->header($paymentdata);
        $xml  .= $this->body($paymentdata);
        $xml .= "</ENVELOPE>";
        return $xml;
    }

    private function header($paymentdata = null){

        $xml  = "<HEADER>";
        $xml .= "<TALLYREQUEST>Import Data</TALLYREQUEST>";
        $xml .= "</HEADER>";
        return $xml;

    }

    private function body($paymentdata = null){
        $xml  = "<BODY>";
        $xml .= "<IMPORTDATA>";
        $xml  .= $this->requestdesc();
        $xml  .= $this->requestdata($paymentdata);
        $xml .= "</IMPORTDATA>";
        $xml .= "</BODY>";
        return $xml;
    }

    private function requestdesc(){
        $xml  = "<REQUESTDESC>";
        $xml .= "<REPORTNAME>Vouchers</REPORTNAME>";
        $xml .= "<STATICVARIABLES>";
        $xml .= "<SVCURRENTCOMPANY>RL MONEY LENDING VENTURES</SVCURRENTCOMPANY>";
        $xml .= "</STATICVARIABLES>";
        $xml .= "</REQUESTDESC>";
        return $xml;
    }

    private function requestdata($paymentdata = null){
        $xml  = "<REQUESTDATA>";
        $xml .= $this->tallymessage($paymentdata);
        $xml .= "</REQUESTDATA>";
        return $xml;
    }

    private function tallymessage($paymentdata){
        $xml = '';
        foreach($paymentdata as $key=>$get) {
            $count = $get->payid;
            $accountnumber = $get->accountnumber;
            $amount = $get->amount;
            $fullname = $get->fullname;
            $paymentdate = date('Ymd', strtotime($get->dateofpayment));
            $xml .= "<TALLYMESSAGE xmlns:UDF=\"TallyUDF\">";
            $xml .= $this->vouchers($count, $accountnumber, $amount, $fullname, $paymentdate);
            $xml .= "</TALLYMESSAGE>";
        }
        return $xml;
    }

    private function vouchers($count, $accountnumber, $amount, $fullname, $paymentdate){
        $remoteid = '04841fd5-42ef-4f8a-a263-e28feff5c205-0000388b'.rand(1,19999);
        $vchkey =  "04841fd5-42ef-4f8a-a263-e28feff5c205-0000ab29:00000008";
        $vchtype ="Receipt";
        $action ="Create";
        $objview = "Accounting Voucher View";
        $xml = "<VOUCHER  REMOTEID=\"$remoteid\"  VCHKEY=\"$vchkey\"  VCHTYPE=\"$vchtype\"  ACTION=\"$action\" OBJVIEW =\"$objview\">";
        $xml .= $this->oldauditentry();
        $xml .= $this->voucheritems($count, $accountnumber, $amount, $fullname, $paymentdate);
        $xml .= "<PAYROLLMODEOFPAYMENT.LIST> </PAYROLLMODEOFPAYMENT.LIST>";
        $xml .= "<ATTDRECORDS.LIST> </ATTDRECORDS.LIST>";
        $xml .= "<TEMPGSTRATEDETAILS.LIST> </TEMPGSTRATEDETAILS.LIST>";
        $xml .= "<GSTEWAYCONSIGNORADDRESS.LIST> </GSTEWAYCONSIGNORADDRESS.LIST>";
        $xml .= "<GSTEWAYCONSIGNEEADDRESS.LIST> </GSTEWAYCONSIGNEEADDRESS.LIST>";
        $xml .= "</VOUCHER>";
        return $xml;
    }


    private function oldauditentry(){
        $xml = "<OLDAUDITENTRYIDS.LIST TYPE=\"Number\">";
        $xml .= "<OLDAUDITENTRYIDS>-1</OLDAUDITENTRYIDS>";
        $xml .= "</OLDAUDITENTRYIDS.LIST>";
        return $xml;
    }

    private function voucheritems($count, $accountnumber, $amount, $fullname, $paymentdate){

        $today = date('Ymd');
        $xml = "<DATE>".$today."</DATE>";
        $xml .= "<GUID>"."04841fd5-42ef-4f8a-a263-e28feff5c205-0000388b".$count."</GUID>";
        $xml .= "<VOUCHERTYPENAME>Receipt</VOUCHERTYPENAME>";
        $xml .= "<VOUCHERNUMBER>".$count."</VOUCHERNUMBER>";
        $xml .= "<PARTYLEDGERNAME>Cash</PARTYLEDGERNAME>";
        $xml .= "<CSTFORMISSUETYPE></CSTFORMISSUETYPE>";
        $xml .= "<CSTFORMRECVTYPE></CSTFORMRECVTYPE>";
        $xml .= "<FBTPAYMENTTYPE>Default</FBTPAYMENTTYPE>";
        $xml .= "<PERSISTEDVIEW>Accounting Voucher View</PERSISTEDVIEW>";
        $xml .= "<VCHGSTCLASS></VCHGSTCLASS>";
        $xml .= "<ENTEREDBY>admin</ENTEREDBY>";
        $xml .= "<DIFFACTUALQTY>No</DIFFACTUALQTY>";
        $xml .= "<AUDITED>No</AUDITED>";
        $xml .= "<FORJOBCOSTING>No</FORJOBCOSTING>";
        $xml .= "<ISOPTIONAL>No</ISOPTIONAL>";
        $xml .= "<EFFECTIVEDATE>".$paymentdate."</EFFECTIVEDATE>";
        $xml .= "<ISFORJOBWORKIN>No</ISFORJOBWORKIN>";
        $xml .= "<ALLOWCONSUMPTION>No</ALLOWCONSUMPTION>";
        $xml .= "<USEFORINTEREST>No</USEFORINTEREST>";
        $xml .= "<USEFORGAINLOSS>No</USEFORGAINLOSS>";
        $xml .= "<USEFORGODOWNTRANSFER>No</USEFORGODOWNTRANSFER>";
        $xml .= "<USEFORCOMPOUND>No</USEFORCOMPOUND>";
        $xml .= "<ALTERID>".$count."</ALTERID>";
        $xml .= "<EXCISEOPENING>No</EXCISEOPENING>";
        $xml .= "<USEFORFINALPRODUCTION>No</USEFORFINALPRODUCTION>";
        $xml .= "<ISCANCELLED>No</ISCANCELLED>";
        $xml .= "<HASCASHFLOW>Yes</HASCASHFLOW>";
        $xml .= "<ISPOSTDATED>No</ISPOSTDATED>";
        $xml .= "<USETRACKINGNUMBER>No</USETRACKINGNUMBER>";
        $xml .= "<ISINVOICE>No</ISINVOICE>";
        $xml .= "<MFGJOURNAL>No</MFGJOURNAL>";
        $xml .= "<HASDISCOUNTS>No</HASDISCOUNTS>";
        $xml .= "<ASPAYSLIP>No</ASPAYSLIP>";
        $xml .= "<ISCOSTCENTRE>No</ISCOSTCENTRE>";
        $xml .= "<ISSTXNONREALIZEDVCH>No</ISSTXNONREALIZEDVCH>";
        $xml .= "<ISEXCISEMANUFACTURERON>No</ISEXCISEMANUFACTURERON>";
        $xml .= "<ISBLANKCHEQUE>No</ISBLANKCHEQUE>";
        $xml .= "<ISDELETED>No</ISDELETED>";
        $xml .= "<ASORIGINAL>No</ASORIGINAL>";
        $xml .= "<VCHISFROMSYNC>No</VCHISFROMSYNC>";
        //$xml .= "<MASTERID>14463</MASTERID>";
       // $xml .= "<VOUCHERKEY>188128157499400</VOUCHERKEY>";
        $xml .= "<OLDAUDITENTRIES.LIST> </OLDAUDITENTRIES.LIST>";
        $xml .= "<ACCOUNTAUDITENTRIES.LIST> </ACCOUNTAUDITENTRIES.LIST>";
        $xml .= "<AUDITENTRIES.LIST> </AUDITENTRIES.LIST>";
        $xml .= "<DUTYHEADDETAILS.LIST> </DUTYHEADDETAILS.LIST>";
        $xml .= "<SUPPLEMENTARYDUTYHEADDETAILS.LIST> </SUPPLEMENTARYDUTYHEADDETAILS.LIST>";
        $xml .= "<EWAYBILLDETAILS.LIST> </EWAYBILLDETAILS.LIST>";
        $xml .= "<INVOICEDELNOTES.LIST> </INVOICEDELNOTES.LIST>";
        $xml .= "<INVOICEORDERLIST.LIST> </INVOICEORDERLIST.LIST>";
        $xml .= "<INVOICEINDENTLIST.LIST> </INVOICEINDENTLIST.LIST>";
        $xml .= "<ATTENDANCEENTRIES.LIST> </ATTENDANCEENTRIES.LIST>";
        $xml .= "<ORIGINVOICEDETAILS.LIST> </ORIGINVOICEDETAILS.LIST>";
        $xml .= "<INVOICEEXPORTLIST.LIST> </INVOICEEXPORTLIST.LIST>";
        $xml .= $this->allledgeritems($accountnumber, $fullname, $amount);
        return $xml;

    }

    public function allledgeritems($accountnumber, $fullname, $amount){

        $xml = "<ALLLEDGERENTRIES.LIST>";
        $xml .= $this->oldauditentry();
        $xml .= $this->ledgeritems($accountnumber, $fullname, $amount);
        $xml .= "</ALLLEDGERENTRIES.LIST>";
        $xml  .= "<ALLLEDGERENTRIES.LIST>";
        $xml .= $this->oldauditentry();
        $xml .= $this->ledgeritemsowner($amount);
        $xml .= "</ALLLEDGERENTRIES.LIST>";
        return $xml;

    }

    public function  ledgeritems($accountnumber, $fullname, $amount){

        $xml= "<LEDGERNAME>".$accountnumber." ".$fullname."</LEDGERNAME>";
        $xml .= "<GSTCLASS></GSTCLASS>";
        $xml .= "<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>";
        $xml .= "<LEDGERFROMITEM>No</LEDGERFROMITEM>";
        $xml .= "<REMOVEZEROENTRIES>No</REMOVEZEROENTRIES>";
        $xml .= "<ISPARTYLEDGER>No</ISPARTYLEDGER>";
        $xml .= "<ISLASTDEEMEDPOSITIVE>No</ISLASTDEEMEDPOSITIVE>";
        $xml .= "<ISCAPVATTAXALTERED>No</ISCAPVATTAXALTERED>";
        $xml .= "<AMOUNT>".number_format($amount, 2)."</AMOUNT>";
        $xml .= "<SERVICETAXDETAILS.LIST> </SERVICETAXDETAILS.LIST>";
        $xml .= "<BILLALLOCATIONS.LIST> </BILLALLOCATIONS.LIST>";
        $xml .= "<INTERESTCOLLECTION.LIST> </INTERESTCOLLECTION.LIST>";
        $xml .= "<OLDAUDITENTRIES.LIST> </OLDAUDITENTRIES.LIST>";
        $xml .= "<ACCOUNTAUDITENTRIES.LIST> </ACCOUNTAUDITENTRIES.LIST>";
        $xml .= "<AUDITENTRIES.LIST> </AUDITENTRIES.LIST>";
        $xml .= "<INPUTCRALLOCS.LIST> </INPUTCRALLOCS.LIST>";
        $xml .= "<DUTYHEADDETAILS.LIST> </DUTYHEADDETAILS.LIST>";
        $xml .= "<EXCISEDUTYHEADDETAILS.LIST> </EXCISEDUTYHEADDETAILS.LIST>";
        $xml .= "<RATEDETAILS.LIST> </RATEDETAILS.LIST>";
        $xml .= "<RATEDETAILS.LIST> </RATEDETAILS.LIST>";
        $xml .= "<SUMMARYALLOCS.LIST> </SUMMARYALLOCS.LIST>";
        $xml .= "<STPYMTDETAILS.LIST> </STPYMTDETAILS.LIST>";
        $xml .= "<EXCISEPAYMENTALLOCATIONS.LIST> </EXCISEPAYMENTALLOCATIONS.LIST>";
        $xml .= "<TAXBILLALLOCATIONS.LIST> </TAXBILLALLOCATIONS.LIST>";
        $xml .= "<TAXOBJECTALLOCATIONS.LIST> </TAXOBJECTALLOCATIONS.LIST>";
        $xml .= "<TDSEXPENSEALLOCATIONS.LIST> </TDSEXPENSEALLOCATIONS.LIST>";
        $xml .= "<VATSTATUTORYDETAILS.LIST> </VATSTATUTORYDETAILS.LIST>";
        $xml .= "<COSTTRACKALLOCATIONS.LIST> </COSTTRACKALLOCATIONS.LIST>";
        $xml .= "<REFVOUCHERDETAILS.LIST> </REFVOUCHERDETAILS.LIST>";
        $xml .= "<INVOICEWISEDETAILS.LIST> </INVOICEWISEDETAILS.LIST>";
        $xml .= "<VATITCDETAILS.LIST> </VATITCDETAILS.LIST>";
        $xml .= "<ADVANCETAXDETAILS.LIST> </ADVANCETAXDETAILS.LIST>";

        return $xml;

    }

    public function  ledgeritemsowner($amount){

        $xml= "<LEDGERNAME>Cash</LEDGERNAME>";
        $xml .= "<GSTCLASS></GSTCLASS>";
        $xml .= "<ISDEEMEDPOSITIVE>No</ISDEEMEDPOSITIVE>";
        $xml .= "<LEDGERFROMITEM>No</LEDGERFROMITEM>";
        $xml .= "<REMOVEZEROENTRIES>No</REMOVEZEROENTRIES>";
        $xml .= "<ISPARTYLEDGER>No</ISPARTYLEDGER>";
        $xml .= "<ISLASTDEEMEDPOSITIVE>No</ISLASTDEEMEDPOSITIVE>";
        $xml .= "<ISCAPVATTAXALTERED>No</ISCAPVATTAXALTERED>";
        $xml .= "<AMOUNT>".'-'.number_format($amount, 2)."</AMOUNT>";
        $xml .= "<SERVICETAXDETAILS.LIST> </SERVICETAXDETAILS.LIST>";
        $xml .= "<BILLALLOCATIONS.LIST> </BILLALLOCATIONS.LIST>";
        $xml .= "<INTERESTCOLLECTION.LIST> </INTERESTCOLLECTION.LIST>";
        $xml .= "<OLDAUDITENTRIES.LIST> </OLDAUDITENTRIES.LIST>";
        $xml .= "<ACCOUNTAUDITENTRIES.LIST> </ACCOUNTAUDITENTRIES.LIST>";
        $xml .= "<AUDITENTRIES.LIST> </AUDITENTRIES.LIST>";
        $xml .= "<INPUTCRALLOCS.LIST> </INPUTCRALLOCS.LIST>";
        $xml .= "<DUTYHEADDETAILS.LIST> </DUTYHEADDETAILS.LIST>";
        $xml .= "<EXCISEDUTYHEADDETAILS.LIST> </EXCISEDUTYHEADDETAILS.LIST>";
        $xml .= "<RATEDETAILS.LIST> </RATEDETAILS.LIST>";
        $xml .= "<RATEDETAILS.LIST> </RATEDETAILS.LIST>";
        $xml .= "<SUMMARYALLOCS.LIST> </SUMMARYALLOCS.LIST>";
        $xml .= "<STPYMTDETAILS.LIST> </STPYMTDETAILS.LIST>";
        $xml .= "<EXCISEPAYMENTALLOCATIONS.LIST> </EXCISEPAYMENTALLOCATIONS.LIST>";
        $xml .= "<TAXBILLALLOCATIONS.LIST> </TAXBILLALLOCATIONS.LIST>";
        $xml .= "<TAXOBJECTALLOCATIONS.LIST> </TAXOBJECTALLOCATIONS.LIST>";
        $xml .= "<TDSEXPENSEALLOCATIONS.LIST> </TDSEXPENSEALLOCATIONS.LIST>";
        $xml .= "<VATSTATUTORYDETAILS.LIST> </VATSTATUTORYDETAILS.LIST>";
        $xml .= "<COSTTRACKALLOCATIONS.LIST> </COSTTRACKALLOCATIONS.LIST>";
        $xml .= "<REFVOUCHERDETAILS.LIST> </REFVOUCHERDETAILS.LIST>";
        $xml .= "<INVOICEWISEDETAILS.LIST> </INVOICEWISEDETAILS.LIST>";
        $xml .= "<VATITCDETAILS.LIST> </VATITCDETAILS.LIST>";
        $xml .= "<ADVANCETAXDETAILS.LIST> </ADVANCETAXDETAILS.LIST>";

        return $xml;

    }


    public function createXml($paymentdata = null){
        $xml = $this->xmlEnvelope($paymentdata);
        $sxe = new SimpleXMLElement($xml);
        $message =  $sxe->saveXML();
        $filename = 'voucher.xml';
        $xmlpath = XMLPATH.$filename;
        $handle = fopen($xmlpath , "w");
        fwrite($handle, $message);
        fclose($handle);
        $xmlfile = $xmlpath ;
        header('Content-disposition: attachment; filename='.$filename);
        header('Content-type: "text/xml"; charset="utf8"');
        readfile($xmlfile);
    }

}