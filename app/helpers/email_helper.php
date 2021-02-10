<?php
/**
 * Created by PhpStorm.
 * User: cassie
 * Date: 5/3/18
 * Time: 4:14 PM
 */
    function sendEmail($senderemail, $receiveremail, $subject, $message, $customer, $atttach=true, $attachtype=null)
    {
        $error = 'Error';
        $success = 'Success';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com"; //"smtp.mailgun.org";
        $mail->Port       = 465;
        $mail->Username   = USERNAME;
        $mail->Password   = PASSWORD;

        $mail->From = $senderemail;
        $mail->FromName = $customer;
        $mail->Sender = $senderemail;

        $mail->AddAddress($receiveremail);
        $mail->Subject = $subject;

        $mail->IsHTML(true);
        $mail->Body = $message;

        if ($atttach == true){
            if (is_null($attachtype)){
                $mail->addAttachment(APPROOT.'/uploads/menteeRegistration.xlsx');
            }else{
                $mail->addAttachment(EMENTORINGUPLOAD . '/public/uploads/calendarimport.ics');
            }
        }

        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return $success;
        }


    }
