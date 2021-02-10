<?php
/**
 * Created by PhpStorm.
 * User: astro
 * Date: 06-Jan-18
 * Time: 12:05
 */

class frameworkJob extends tableDataObject {

    const TABLENAME = 'marketplacejobs';

    public function activate(){

        $jobrecord =& $this->recordObject;

        if(!isset($jobrecord->queuedata)){
            $totalwork = $this->getInitialBatch();
            $jobrecord->numtoprocess = count($totalwork);
            $jobrecord->queuedata = serialize($totalwork);
        }



        $jobrecord->active = true;
        $jobrecord->queuewait = false;
        $this->store();
        $runresult = $this->run();

        // end of queue, asses and store the job...
		if(count(unserialize($jobrecord->queuedata)) > 0){
			// still pending work
			$jobrecord->queuewait = 1;
		} else {
			// work finished
			$this->endbatch($jobrecord);
		}
	    $this->store();

        print_r($this);


    }

    /**
     * @param $jobrecord
     *
     * @throws frameworkError
     */
    public function endbatch($jobrecord){
        $jobrecord->queuewait = null;
        $jobrecord->processed = null;
        $jobrecord->lastrun = date('Y-m-d H:i:s');
        $jobrecord->lastprocessed = null;
        $jobrecord->queuedata = null;
        $jobrecord->numtoprocess = null;
        if($jobrecord->deactivateafter == 1){
            $jobrecord->active = 0;
        }
        if(isset($jobrecord->triggerjob)){
            $jobtotrigger = new frameworkJob($jobrecord->triggerjob);
            $jobtotrigger->recordObject->active = 1;
            $jobtotrigger->store();
        }
    }


    /*
     * overriding the store() method to pass in a flag to force nulls!
     */
    /**
     * @param bool $forenulls
     *
     * @return $this|void
     * @throws frameworkError
     */
    public function store($forenulls = true){
    	parent::store($forenulls);
    }

    // ------------------------------------------------------------

    /**
     * @return mixed
     */
    public static function getNext(){
    	global $marketplacedb;
    	$waitingq = "select * from " . self::TABLENAME .  " where queuewait = 1 order by lasttimestamp limit 1";
    	$marketplacedb->prepare($waitingq);



    	/*
    	 * First, grab the oldest job from the queue; if the queue is empty, then grab
    	 * the job next scheduled to run...
    	 */
    	if($nextjob = $marketplacedb->singleRecord()){
    		return $nextjob;
	    } else {
		    $nextactiveq = "select * from " . self::TABLENAME . " where 
					 (lastrun < (date_sub(now(),interval frequencyminutes MINUTE)) or lastrun is null) and active = 1 order by lastrun limit 1";
		    $marketplacedb->prepare($nextactiveq);

		    /*
		     * this will either return the next job or null
		     */
		    return $marketplacedb->singleRecord();
	    }
	}

}