<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 12/7/2017
 * Time: 3:03 PM
 */


use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Tests extends Controller {

    /* public function __construct(){
        if(!DEVMODE){
            Core::notfound("Tests disabled in production");
        } else {
            parent::__construct();
        }
    } */

    public function cuscode(){



        for($i=232; $i<=500; $i++){
            $c = new Customernumbers();
            $c->recordObject->code = $i;
            $c->recordObject->status = 0;

            $c->store();

        }

    }

    public function xml(){
        header('Content-type: text/xml');
        $xm =  new Xmlreport();
        $test  = $xm->createXml();
        echo $test;
    }


    public function googlexmltest(){
        $reportdate = '2018-01-01';
        $customers = Google::googleReportQueryXml($reportdate, 'All');
        $custsbycommid = array();
        foreach($customers as $customer){
            if(!isset($custsbycommid[$customer->commid])){
                $custsbycommid[$customer->commid] = array($customer);
            } else {
                array_push($custsbycommid[$customer->commid], $customer);
            }
        }
        //  print_r($customers);
        GoogleXml::createGoogleXmlZip($custsbycommid,$reportdate);
    }

    public function aaazureq(){
        print_r(["<pre>",MsSubscription::getCustomerAzure(456,'2018-02-22','2018-02-23')]);
    }

    public function testmic(){
        //print_r(MicrosoftSubscriptions::generateAccessToken('Global'));
        print_r(MicrosoftSubscriptions::listCustomerMicrosoftSubscriptions('Global', '04ba9f64-6c72-44c1-be19-b67b36f8fbc6'));
    }

    public function emailtest(){
        $senderemail = 'odurusphp@gmail.com';
        $message = 'hi Prince';
        sendEmail($senderemail, $message);


    }

    public function editcustomer(){

        $commid = $_POST['commid'];
        $cid  = $_POST['cid'];

        $customerdata = new Customer($cid);
        $customerdata->recordObject->commid = $commid;
        $customerdata->store();

        print_r($customerdata->recordObject);

    }


    public function azureprices(){
        echo "<pre>";
        foreach(['Global','DE'] as $type){
            echo Services::azurePriceLog($type) ."\n\n";
        }

        $prices = MicrosoftSubscriptions::getAzurePrizes($type= 'DE');

        print_r($prices);
        echo  "</pre>";

    }

    public function mic(){

        $result = MicrosoftSubscriptions:: listCustomerMicrosoftSubscriptions('Global', '04ba9f64-6c72-44c1-be19-b67b36f8fbc6');
        $items = $result->items;
        print_r($result);


        // $obj = MicrosoftSubscriptions::getSubscriptionById('Global', '04ba9f64-6c72-44c1-be19-b67b36f8fbc6','4AA70752-3E1D-4F09-B2D1-04E13E1A4E1D');
        // print_r($obj);

    }

    public function bit(){
        $test = Endpoints::getEndpointDetails('5832bd1538c046fa4507ba96');
        print_r($test);

    }



    function brybit(){
        echo "<pre>";
        $comps = BitDefender::getBitCompanies();
        foreach ($comps->result as $comp){
            echo "<h3>companies</h3>";
            print_r($comp);
            $details = Endpoints::getCompanyDetails($comp->id);
            echo "<h3>details</h3>";
            print_r($details);
            $more = Endpoints::getCustomGroupsList($comp->id);
            echo "<h3>groups</h3>";
            print_r($more);
            echo "<h3>endpoints</h3>";
            $evenmore = Endpoints::getEndpoints($comp->id);
            print_r($evenmore);
            //foreach ($evenmore->result->items as $em){
            $tryit = Endpoints::getCompanyFoldersList($comp->id);
            print_r($tryit);
            //}
            echo "<hr>";
        }
    }

    public function testantispam(){

        // $an = new Antispam();
        // $result = $an->getAntispam('Seerene');
        // echo $result;

        /**
         * Prince: I think with the AntiSpamData model, the normal case will be to use
         * the 'antispam' table - so look at the constructor I added to your model.
         * In cases in a model where you need data from a different table,
         * THAT IS FINE, but do so with static methods - I changed your method, also.
         *
         * I just thought of this. It was bothering me to have table names in our
         * controller code, and this child and parent constructor pattern fixes that.
         * See also the model for frameworkJob. It's fine (well, better than in controllers)
         * to have table names statically coded into these weird models.
         */
        $result = AntispamData::getAntispamCustomers();
        //print_r($result);

        foreach($result as $sp){
            $antispamname = $sp->antispam;
            $an = new Antispam();
            $result = $an->getAntispam($antispamname);
            $xml = new SimpleXMLElement($result);

            $name = $xml->Domain_Group->name;
            $antidate = $xml->Domain_Group->date;
            $licencecount = $xml->Domain_Group->licensecount;
            $weeklyaverage = $xml->Domain_Group->weeklyaverage;

            $antispamdata = new AntispamData();
            $datarow =& $antispamdata->recordObject;
            $datarow->antispam = $name;
            $datarow->antidate = $antidate;
            $datarow->licencecount = $licencecount;
            $datarow->weeklyaverage = $weeklyaverage;
            $datarow->logdate = date('Y-m-d');

            if($datarow->antispam != null){
                $antispamdata->store();
            }

            //$result[] = $clientdata->recordObject;
            //echo $name.'------'.$date.'------'.$licencecount.'-------'.$weeklyaverage.'<br/>';
        }
    }

    public function maxlog(){
        $mx = new MaxAntispamlog();
        $result = $mx->getMaxAntispamlog();
        $xml = new SimpleXMLElement($result);

        $dailyusage = $xml->Max_Daily_Usage;
        $averageusage = $xml->Average_Daily_Usage;

        $maxspamdata = new MaxAntispamData();
        $datarow =& $maxspamdata->recordObject;
        $datarow->dailyusage = $dailyusage;
        $datarow->averageusage = $averageusage;
        $datarow->logdate = date('Y-m-d');

        $maxspamdata->store();

    }

    public function testmonitor(){

        $mo = new Monitoring();
        $result = $mo->getMonitoring();


        foreach($result['result'] as $mon){
            $hostname = $mon['hostname'];
            $hostgroup =  $mon['attributes']['tag_Hostgroup'];

            $monitoringdata = new MonitoringData();
            $datarow =& $monitoringdata->recordObject;
            $datarow->hostname = $hostname;
            $datarow->hostgroup = $hostgroup;
            $datarow->datadate = date('Y-m-d');

            if($datarow->hostname != null){
                $monitoringdata->store();
            }

        };

    }

    public function testuser(){
        /*$testuser = new User();
        $testuser->email = "testuser123";
        $testuser->email = "nobody@nowhere";
        $testuser->password = "blhalahalh";
        $testuser->apikey = "123123testuser";
        $testuser->store(); */

        $testuser = User::getUserByParam("uid",19);

        echo "<pre>";
        print_r($testuser);
        echo "</pre>";

        throw new frameworkError();
    }

    public function customer($cid = null){
        echo "<pre>";
        $c = new Customer($cid);
        $cr =& $c->recordObject;
        $cr->domain = "xxx.00000000.xxx";
        $cr->antispamname = "bbb:" . $cr->antispamname;
        foreach(array('antispamname','bitdefendername','adreportname','clientmanagername','monitoringname') as $fieldname){
            $cr->$fieldname = "xxx:" . $cr->$fieldname;
        }
        // $c->store();
        print_r($c);
    }

    public function getmsusers(){
        echo "<pre>";

        $test =  MicrosoftSubscriptions::getNewMicrosoftPartner('DE');
        print_r($test);

        echo "</pre>";
        throw new frameworkError();
    }



    public function google(){
        $goo = new GoogleSubscriptions(new Google_Client());
        $test  =  $goo->googleSubscription('hitfox.com');
        print_r($test);

    }

    public function info(){
        phpinfo();
        exit();
    }




    public function storemsoprices(){
        echo "<pre>";
        $cs = new CSVxlsx();
        $cs->filename = '0365.xlsx';
        $cs->sheetname = 'EUR';
        $cs->faster = true;
        $cs->headerlines = 3;
        $mspriceArr = $cs->loadFile('0365', '');

        OfficePrice::flagAllForDelete();
        $args = array(
            "tablename" => "officeprices"
        );

        $countinserted = 0;
        foreach ($mspriceArr as $msprice){
            $newmsoprice = new OfficePrice($args);
            $datarow =& $newmsoprice->recordObject;

            $labels = array(
                "offerid",
                "offername",
                "region",
                "validfrom",
                "validto",
                "licensetype",
                "secondarylicensetype",
                "purchaseunit",
                "customertype",
                "listprice",
                "erpprice"
            );

            foreach($labels as $label){
                $datarow->$label = $msprice[$label];
            }

            if(!isset($lastvalidfrom) && trim($datarow->validfrom) != ''){
                $lastvalidfrom = $datarow->validfrom;
                $lastvalidto = $datarow->validto;
            }
            if(trim($datarow->validfrom == '') && isset($lastvalidfrom)){
                $datarow->validfrom = $lastvalidfrom;
                $datarow->validto = $lastvalidto;
            }

            if($datarow->offerid != '' && $datarow->offerid != null) {
                $newmsoprice->store();
                $countinserted++;
            } else {
                echo "<strong>Refusing to insert a bad row: \n";
                print_r($datarow);
                echo "</strong>";
            }

            print_r($newmsoprice->recordObject);

        }
        if($deleteflagged = OfficePrice::deleteFlagged()){
            echo "\n\ndeleted old records\n\n";
        } else {
            echo "\n\nproblem deleting flagged records\n\n";
        }
        echo "<h1>$countinserted price records inserted in DB</h1>";
    }

    public function so(){
        echo "<pre>";
        $offersObj = new SubscriptionOffer(array("tablename"=>"subscriptionoffers"));
        echo "<h1>DE Offers</h1>";
        print_r($offersObj->listDeOffers());
        echo "<h1>Global Offers</h1>";
        print_r($offersObj->listGlobalOffers());
    }

    public function fakemsbilling(){
        echo "<pre>" . date('Y-m-d H:i:s') . "\n\n";
        $custlist = Customer::listCustomers();
        echo count($custlist) . " customers\n\n";

        $types = array('Global','DE','AppUserGlobal');
        foreach ($types as $ctype){
            $tokens[$ctype] = MicrosoftSubscriptions::apiToken($ctype);
        }

        // get our IDs that we need to process to facilitate batching.
        $cc = 0;
        echo date('H:i:s') . "\n";
        foreach($custlist as $customer){
            $queuelist[$cc]['cid'] = $customer->cid;
            $queuelist[$cc]['tenantid'] = $customer->tenantid;
            $cc++;
        }
        $queuedata = serialize($queuelist);
        // throw new frameworkError(print_r(unserialize($queuedata),true));
        echo date('H:i:s') . "\n\n";

        $ccount = 0;
        foreach ($custlist as $customer){
            if(isset($customer->tenantid) && trim($customer->tenantid) != ''
               && in_array($customer->type,$types)) {



                $cmssubs = MicrosoftSubscriptions::listCustomerMicrosoftSubscriptions($customer->type, $customer->tenantid,$tokens[$customer->type]);
                if(isset($cmssubs->items)) {

                    print_r( $cmssubs->items );

                    foreach($cmssubs->items as $item){

                        $logit           = new MsSubscription();
                        $logRecordObj =& $logit->recordObject;

                        $logRecordObj->tenantid = $customer->tenantid;
                        $logRecordObj->comType = $customer->type;

                        if ( $logit->prepareAndStore( $item ) ) {
                            echo "\n\nStored!!\n----------\n\n";
                        }
                    }
                    echo "\n\n" . $customer->tenantid . "\n---------\n";

                }
            }
            $ccount++;
        }
        echo date('Y-m-d H:i:s');
    }



    public function testWhere(){
        echo "<pre>";
        $conds = array(
            'tenantid' => '04ba9f64-6c72-44c1-be19-b67b36f8fbc6',
            'quantity' => 48,
            // 'logtimestamp' => '2018-01-08 19:07:44'
        );

        $testrecord = MsSubscription::getRecordByParams('mssubscriptions',$conds,true);
        print_r($testrecord);

    }



    public function index($classname = "Tests"){
        $getinfo = listmethods($classname);
        $classfilepath = $getinfo['reflector']->getFileName();
        $methods = $getinfo['methods'];
        echo "<h1>$classfilepath</h1><ul>";
        foreach ($methods as $method){
            echo "<li><a target='_blank' href='" . URLROOT . "/$classname/$method'>$method</a></li>";
        }
        echo "</ul>";

    }

    public function controllerMethods(){
        $controllers = glob(APPROOT . '/controllers' . '/*.php');
        foreach ($controllers as $controller){
            $filenamearr = explode("/",$controller);
            $classes[] = explode(".",end($filenamearr))[0];
        }
        sort($classes);
        foreach($classes as $class){
            if($class != 'Tests') {
                echo "<h1>Class: $class</h1><ul>";
                $cmethods = get_class_methods($class);
                foreach ($cmethods as $cmethod) {
                    echo "<li>$cmethod</li>";
                }
                echo "</ul><br><br>";
            }

        }
    }

    public function getmssubsoffers(){
        $subs = MicrosoftSubscriptions::getMSSubscriptionOffers('DE','Global');
        echo "<pre>";
        print_r($subs);
        echo "<hr>";
        $offersarr = $this->analyzeApiResponse($subs);
        print_r($offersarr);
    }

    public function getMsCustomers($type = 'DE'){
        $customers = MicrosoftSubscriptions::getMSCustomers($type);
        echo "<pre>";
        print_r($customers);
        echo "<hr>";
        $customersarr = $this->analyzeApiResponse($customers);
        print_r($customersarr);
    }

    private function analyzeApiResponse($apiresponse){
        $offersarr = array();
        foreach($apiresponse['items'] as $offer){
            foreach($offer as $key => $value){
                if($key == 'id'){
                    $thisid = $value;
                }
                if(is_array($value)){
                    $isarray = "array";
                    $value = serialize($value);
                    $len = strlen($value);
                } else {
                    $isarray = "not array";
                    $len = strlen($value);
                }
                if(!in_array($key,$offersarr)){
                    $offersarr[$key]['is_array'] = $isarray;
                }
                if(!isset($offersarr[$key]['maxlen']) || $offersarr[$key]['maxlen'] < $len){
                    $offersarr[$key]['maxlen'] = $len;
                    $offersarr[$key]['longest'] = $value;
                }
            }
        }
        return $offersarr;
    }

    public function rpass(){
        throw new frameworkError(randomPassword());
    }

    public function fixgoogle(){
        echo "<pre>";
        $customers = Customer::listAll();
        foreach ($customers as $customer){
            if(isset($customer->googleid) && trim($customer->googleid) != ''){
                $cid = $customer->cid;
                $gid = $customer->googleid;
                $gdi = $customer->googlediscount;
                echo "$cid\t$gid\t$gdi\n";
                foreach(explode(",",$gid) as $distinctgid){
                    $googlecustomer = new GoogleCustomer();
                    $gro =& $googlecustomer->recordObject;
                    $gro->cid = $cid;
                    $gro->googleid = $distinctgid;
                    $gro->googlediscount = $gdi;
                    $googlecustomer->store();
                    print_r($gro);
                }
                echo "<hr>";
            }
        }
    }

    public function testjob(){

        $files = glob(APPROOT . '/tasks' . '/*.php');

        foreach ($files as $file) {
            require($file);
        }

        echo "<pre>";
        $logit = new MSOLogJob(5);
        print_r($logit->recordObject);
        $logit->activate();
    }

    public function servertime(){
        echo date('Y-m-d H:i:s');
    }

    public function azprices(){
        echo"<pre>";
        $azps = AzurePrices::listall();
        foreach($azps as $ap){
            $apo = new AzurePrices($ap->priceid);
            print_r($apo);
        }
    }



    public function xmlBill($custarray = null, $searchdate = null){
        /*
         * Now the incoming customer record is an array. Many will have only one
         * customer data object. Some will have more than one, and need to be combined
         * into a single xml file.
         */
        echo "<pre>" . date("Y-m-d h:i:s") . "\n\n";

        $agglineitems = array();
        foreach ($custarray as $cdata) {
            $orreports = array();
            $commid = $cdata->commid;
            $cid = $cdata->cid;
            // todo - gripe about and get fixed the structure used to get these individual pieces of data.
            if ( $getbit = OtherReport::getbitrecords( $searchdate, $cid ) ) {
                $orreports['bitdata'] = $getbit[0];
            }
            if ( $getclient = OtherReport::getclientrecords( $searchdate, $cid ) ) {
                $orreports['clientdata'] = $getclient[0];
            }
            if ( $getanti = OtherReport::getantispamrecords( $searchdate, $cid ) ) {
                $orreports['antispamdata'] = $getanti[0];
            }
            $agglineitems[] = $orreports;
        }
        $lineitems = array();
        if(count($agglineitems) > 0) {
            $xmler     = new XMLBill();
            foreach ($agglineitems as $lineitemgroup) {
                if(count($lineitemgroup) > 0) {
                    // $lineitems[] = $xmler->addOtherReportsProperties( $lineitemgroup );
                    // array_push($lineitems,$xmler->addOtherReportsProperties( $lineitemgroup ));
                    foreach($xmler->addOtherReportsProperties( $lineitemgroup ) as $lineitem){
                        $lineitems[] = $lineitem;
                    }
                }
            }
            if(count($lineitems) > 0) {
                $testxml = $xmler->makeXMLbill( $commid, $lineitems );

                return $testxml;
            } else {
                return false;
            }
        }
    }

    /**
     * Test harness that creates and zips the XML files for other reports
     * for all customers. This will need modification to suit general purposes.
     *
     * Specifically, there needs to be a way to pass the date requested,
     * whether all customers or a specific customer are requested, etc.
     * The trickiest part here is assembling the array for the customer groups
     * by commid.
     */
    public function xmlAll(){

        $fileloc = APPROOT . "/filetmp/xml/";
        $ziploc = APPROOT . "/filetmp/zip/";
        $xmlfiles = array();
        $prefix = 'OTH'.date('Ymd');

        echo "<pre><strong>" . date("Y-m-d h:i:s") . "</strong>\n\n";
        $customers = Customer::listAll();

        /*
         * recreate the array of customer objects to index on commid,
         * to deal with customers that have multiple "accounts"
         */
        $custsbycommid = array();
        foreach($customers as $customer){
            if(!isset($custsbycommid[$customer->commid])){
                $custsbycommid[$customer->commid] = array($customer);
            } else {
                array_push($custsbycommid[$customer->commid], $customer);
            }
        }

        foreach($custsbycommid as $commid => $cust){
            if($commid != '' && null !== $commid) {
                $compname = Customer::getNameByCommid( $commid );
                if ( $thexml = $this->customerOtherReportsXml( $cust, '2018-01' ) ) {
                    echo htmlspecialchars( $thexml ) . "\n\n" . date( "Y-m-d h:i:s" ) . "<hr>";
                    $filename   = $fileloc . $prefix . '  ' . preg_replace( "/[^a-z0-9]/", "", strtolower( $compname ) ) . ".xml";
                    $xmlfiles[] = $filename;
                    file_put_contents( $filename, $thexml );
                }
            }
        }
        $zipout = new ZipArchive();
        if(file_exists($ziploc . $prefix . ".zip")){
            unlink ($ziploc . $prefix . ".zip");
        }
        $zipout->open($ziploc . $prefix . ".zip", ZipArchive::CREATE);
        foreach($xmlfiles as $xmlfile){
            $zipnamearr = explode("/",$xmlfile);
            $zipname = end($zipnamearr);
            $zipout->addFile($xmlfile,$zipname);
        }
        $zipout->close();
        foreach($xmlfiles as $killit){
            unlink($killit);
        }
        echo "<strong>\n\n" . date( "Y-m-d h:i:s" ) . "</strong>" . print_r($xmlfiles,true);
    }

    public function roundup(){
        foreach (array(0.0005,0.54,0.5401,0.09,0.009,0.000000034) as $oval){
            echo "original: $oval / centceil: " . roundCentsUp($oval,2) . "<br>";
        }
    }

    public function fixsd(){
        echo "<pre>";
        global $marketplacedb;
        $qry = "select distinct id,effectiveStartDate from mssubscriptions where effectiveStartDate is not null;";
        $marketplacedb->prepare($qry);
        $res = $marketplacedb->resultSet();
        print_r($res);
    }

    public function roles(){
        echo ("<pre>");
        $users = User::listAll();
        foreach ($users as $user){
            $testu = new User($user->uid);
            if($testu->hasRole("billing administrator")){
                echo "<h1>billing admin:</h1>";
            }
            print_r (array($user->uid,$user->email,$testu->listRoles()));
        }
    }

    public function testlistObjects() {
        echo "<pre>";
        print_r(User::listAll(true));
    }

    public function tdoDelete(){
        echo "<pre>";
        $usertodel = new User(315);
        print_r($usertodel);
        $usertodel->deleteFromDB();
        echo "<hr>";
        print_r($usertodel);

    }

    public function sliu(){
        echo "<pre>";
        print_r($this->loggedInUser->recordObject);
        echo "<p>The logged in user has the following roles:</p>";
        print_r($this->loggedInUser->listRoles());
    }

    public function usercompanies(){
        echo "<pre>";
        $testu = new User(172);
        echo "<h3>Test company lists for " . $testu->recordObject->email . "</h3>";
        echo "<h4>Primary:</h4>";
        print_r($testu->getUserCompanies('primary'));
        echo "<h4>Secondary:</h4>";
        print_r($testu->getUserCompanies('secondary'));
        echo "<h4>All:</h4>";
        print_r($testu->getUserCompanies('all'));
    }

    public function vds(){
        var_dump($_REQUEST);
    }

    public function uwr($role = 'Super administrator'){
        print_r(['<pre>',User::getUsersWithRole($role)]);
    }

    public function setRoles(){
        $tester = new User(315); // known user bryan
        $tester->addRole('locked');
        print_r($tester->listRoles());
    }

    public function zlog(){
        $tlog = new Logger('log message here',
            'system - general',
            'bryan',serialize($_SERVER));
        print_r(['<pre>',$tlog]);
    }

    public function zNation(){
        throw new frameworkError(print_r(["ZOMBIES!!!",$_SESSION],true));
    }

    public function iHateDateCalculations(){
        $now = new DateTime();
        $earlier = new DateTime();
        $later = new DateTime();
        echo $now->format("Y-m-d");

        $earlier->sub(new DateInterval('P1D'));
        $later->add(new DateInterval('P1D'));

        echo "<br>" . $earlier->format("Y-m-d") . " / " . $later->format("Y-m-d") ;


    }

    public function showlog(){
        echo "<pre>";
        $log = Logger::listall();
        $log = array_reverse($log);
        echo "<table>";
        foreach($log as $item){
            echo"<tr><td>$item->logcategory</td>
                <td>$item->user</td>
                <td>$item->logmessage</td>
                <td>$item->timestamp</td></tr>";
        }
        echo "</table>";
    }

    public function zZtestO365(){
        OfficeProcessor::o365XML('2018-02','All','Office 356 DE');
        die("check for xml files");
    }

    public function printer(){
        try {
            // Enter the share name for your USB printer here
            $connector = new WindowsPrintConnector("PrinceUSBPrinter");
            $printer = new Printer($connector);
            $image = EscposImage::load(PUBLIC_PATH.'/logo.png', false);
            $printer -> bitImage($image);
            $printer -> setTextSize(2,2);
            $printer -> setEmphasis(true);
            $printer->text("OFFICIAL RECEIPT\n");
            $printer -> setTextSize(1,1);
            $printer -> setEmphasis(true);
            $printer->text("Cashier: " .strtoupper('Testing Prince'). "\n");
            $printer -> text("\n");
            $printer->text("Cashier: " .strtoupper('Testing Prince'). "\n");
            $printer -> text("\n");
            $printer->text("Cashier: " .strtoupper('Testing Prince'). "\n");
            $printer -> text("\n");


            $printer -> cut();
            /* Close printer */
            $printer -> close();
        } catch(Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }
    }

    public function tprint(){
        //$url = URLROOT.'/tests/printer';
        echo $url = 'http://25cbe74cdf6f.ngrok.io/testprinter/test.php';
        $tes = file_get_contents($url);
        var_dump($tes);
    }

}
