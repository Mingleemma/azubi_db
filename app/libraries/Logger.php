<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 2/23/2018
 * Time: 7:11 AM
 */


/**
 * Class Logger
 *
 * This class needs no actual methods for writing logs.
 *
 * Simply create a new Logger object, set the properties, and
 * new Logger($message) - Logger will do only a little to set defaults
 * if needed before calling store.
 *
 * Log categories are maintained in the table logcategories simply
 * to enforce specific values in that log column. For reference, look at
 * that table, but initial categories are
 * -- 'administrator action'
 * -- 'customer action'
 * -- 'system - general'
 * -- 'system - scheduled'
 * -- 'information' (default if not set)
 *
 * The only requirement is that
 * logmessage must be set by the caller.
 *
 */
class Logger extends tableDataObject {

    const TABLENAME = 'systemlog';

    /**
     * Logger constructor.
     *
     * @param $logmessage
     * @param null $logcategory
     * @param null $user
     * @param null $diagnostic
     *
     * @throws frameworkError
     */
    public function __construct($logmessage,$logcategory = null,$user = null,$diagnostic = null){

        parent::__construct();

        $ro =& $this->recordObject;

        foreach (['logmessage','user','logcategory','diagnostic'] as $logproperty){
            if ($$logproperty != null){
                $ro->$logproperty = $$logproperty;
            }
        }
        $this->store();
    }

}