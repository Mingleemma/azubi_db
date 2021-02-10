<?php
/**
 * Created by PhpStorm.
 * User: bryan
 * Date: 12/7/2017
 * Time: 6:41 PM
 */

class frameworkError extends Exception {

    /**
     * frameworkError constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Something bad happened, sorry about that.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = "<strong>" .
            "Lehrer-db encountered an error in line $this->line of $this->file: "
            . "<blockquote style='color:red;font-weight:bold;'>" . $this->message . "</blockquote>" .
            " We're sorry about that." .
            "</strong>";
            // new Logger("Marketplace encountered an error in line $this->line of $this->file","error","unknown",$this->message);
    }

    public static function garbage(){
        die("nothing to see here!");
    }

}
