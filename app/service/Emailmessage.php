<?php
/**
 * Created by PhpStorm.
 * User: cassie
 * Date: 7/31/18
 * Time: 4:12 PM
 */
class Emailmessage{

    public static function sendmenteemail($firstname, $email)
    {

        $subject = 'My Mentor Bewerbung';
        $customer = 'My Mentor';
        $imagepath = URLROOT . '/reg-assets/img/sig.jpg';
        $message = "<div style='font-family: Arial, sans-serif;font-size:13px'> Hey " . $firstname . ",<br/><br/>
			schön, dich letzte Woche in unserem Mentee-Training kennengelernt zu haben.&#9786;<br/>
			Heute startet offiziell deine Zeit mit My Mentor!<br/><br/>
			Um deinen persönlichen Account zu aktivieren und dir einen ersten Eindruck von deinem Mentor sowie der Plattform zu verschaffen,<br/>
			klicke auf den untenstehenden Link und lege dein Passwort fest.<br/> <br/><br/>
			Wir freuen uns auf die nächsten Monate mit dir und stehen dir bei Rückfragen gerne zur Verfügung.<br/><br/>
			Viel Spaß & liebe Grüße <br/>
			Christine & Carmen <br/>
			Dein My Mentor-Team <br/><br/>
			<div style='border:none;border-bottom:solid 2px #000;margin-bottom:3px'></div>
			<p style='font-style:italic;font-weight:bolder;font-size: 13px; font-family: Arial, sans-serif; color: rgb(31, 73, 125)'>Tipps für den ersten Videochat und die Nutzung der My Mentor-Plattform:</p>
			<div style='font-size: 13px;margin-bottom:3px ;font-family: Arial, sans-serif; color: rgb(31, 73, 125)'>
			-	Verwende bitte ausschließlich <strong>Mozilla Firefox als Browser</strong> für unsere Plattform – egal ob für die Lerninhalte oder den (Video) –chat.<br/>
			<span style='font-style:italic'>(Wir arbeiten noch daran, dass My Mentor in Kürze auch mit Internet Explorer und Safari problemlos funktioniert.)</span><br/>
			-	Aktiviere Kamera und Mikrofon vor jedem Anruf/Chat<br/>
			-	Sollte sich der Videochat beim ersten Anrufversuch nicht automatisch aktivieren/nicht annehmbar sein, versuche es ein zweites Mal. <br/>
			(Manchmal benötigt der Verbindungsaufbau einen zweiten Versuch und läuft dann in der Regel stabil)<br/>
			-	Solltest du technische Probleme oder inhaltliche Rückfragen haben, melde dich gerne jederzeit bei uns!</div>
			<p><img src='" . $imagepath . "' /></p>
			<p style='color: #1f4994;font-size:12px'>My Finance Coach Stiftung GmbH | Seidlstraße 24-24a | 80335 München <br><br>
			Telefon: +49-89-1220-8416/8403 | Telefax: +49-89-1220-8403<br>
			E-Mail: <a href='mailto:mymentor@myfinancecoach.org'>mymentor@myfinancecoach.org</a><br>
			Web: <a href='www.myfinancecoach.org/mymentor'>www.myfinancecoach.org/mymentor</a>
			<br></p>
			<p style='color: #a6a6a6; font-size: 10px'>My Finance Coach Stiftung GmbH, Sitz München, HRB 172075, Amtsgericht München
			Geschäftsführung: Dr. Bettina von Jagow
			Die Information in dieser eMail ist vertraulich und ausschließlich für den Adressaten bestimmt. Jeglicher Zugriff auf diese eMail durch andere Personen als den Adressaten ist untersagt. Sollten Sie nicht der für diese eMail bestimmte Adressat sein, ist Ihnen jede Veröffentlichung, Vervielfältigung oder Weitergabe wie auch das Ergreifen oder Unterlassen von Maßnahmen im Vertrauen auf erlangte Information untersagt. Bitte löschen Sie diese eMail und informieren Sie den Absender, falls Sie diese eMail irrtümlich erhalten haben.<br>
			<span style='color: #7ca890'>Bitte berücksichtigen Sie die Umwelt - müssen Sie diese E-Mail wirklich ausdrucken?</span>
			</p></div>";

        return sendEmail(MFCSENDEREMAIL, $email, $subject, $message, $customer, false);
    }

    public static function sendmentoremail($email)
    {

        $subject = 'My Mentor Bewerbung';
        $customer = 'My Mentor';
        $imagepath = URLROOT . '/reg-assets/img/sig.jpg';
        $message = "<div style='font-family:Arial, sans-serif; font-size:13px'> Lieber Mentor,<br/><br/>
			schön, dich letzte Woche in unserem Training kennengelernt zu haben.<br/>
			Heute startet offiziell deine Zeit mit deinem Mentee und My Mentor!<br/>
			Um deinen persönlichen Account zu aktivieren und dir einen ersten Eindruck von deinem Mentee sowie<br/> der Plattform zu verschaffen, <br/>
			klicke auf den untenstehenden Link und lege dein Passwort fest<br/><br/><br/>
			Wir freuen uns auf die nächsten Monate mit dir,<br/>
			bei Rückfragen stehen wir dir gerne jederzeit zur Verfügung.<br/><br/>
			Viel Spaß & liebe Grüße <br/>
			Christine & Carmen <br/>
			Dein My Mentor-Team <br/><br/>
			<div style='border:none;border-bottom:solid 2px #000;margin-bottom:3px'></div>
			<p style='font-style:italic;font-weight:bolder;font-size: 13px; font-family: Arial, sans-serif; color: rgb(31, 73, 125)'>Tipps für den ersten Videochat und die Nutzung der My Mentor-Plattform:</p>
			<div style='font-size: 13px;margin-bottom:3px ;font-family: Arial, sans-serif; color: rgb(31, 73, 125)'>
			-	Verwende bitte ausschließlich <strong>Mozilla Firefox als Browser</strong> für unsere Plattform – egal ob für die Lerninhalte oder den (Video) –chat.<br/>
			<span style='font-style:italic'>(Wir arbeiten noch daran, dass My Mentor in Kürze auch mit Internet Explorer und Safari problemlos funktioniert.)</span><br/>
			-	Aktiviere Kamera und Mikrofon vor jedem Anruf/Chat<br/>
			-	Sollte sich der Videochat beim ersten Anrufversuch nicht automatisch aktivieren/nicht annehmbar sein, versuche es ein zweites Mal. <br/>
			(Manchmal benötigt der Verbindungsaufbau einen zweiten Versuch und läuft dann in der Regel stabil)<br/>
			-	Solltest du technische Probleme oder inhaltliche Rückfragen haben, melde dich gerne jederzeit bei uns!</div>
			<p><img src='" . $imagepath . "' /></p>
			<p style='color: #1f4994;font-size:12px'>My Finance Coach Stiftung GmbH | Seidlstraße 24-24a | 80335 München <br><br>
			Telefon: +49-89-1220-8416/8403 | Telefax: +49-89-1220-8403<br>
			E-Mail: <a href='mailto:mymentor@myfinancecoach.org'>mymentor@myfinancecoach.org</a><br>
			Web: <a href='www.myfinancecoach.org/mymentor'>www.myfinancecoach.org/mymentor</a>
			<br></p>
			<p style='color: #a6a6a6; font-size: 10px'>My Finance Coach Stiftung GmbH, Sitz München, HRB 172075, Amtsgericht München
			Geschäftsführung: Dr. Bettina von Jagow
			Die Information in dieser eMail ist vertraulich und ausschließlich für den Adressaten bestimmt. Jeglicher Zugriff auf diese eMail durch andere Personen als den Adressaten ist untersagt. Sollten Sie nicht der für diese eMail bestimmte Adressat sein, ist Ihnen jede Veröffentlichung, Vervielfältigung oder Weitergabe wie auch das Ergreifen oder Unterlassen von Maßnahmen im Vertrauen auf erlangte Information untersagt. Bitte löschen Sie diese eMail und informieren Sie den Absender, falls Sie diese eMail irrtümlich erhalten haben.<br>
			<span style='color: #7ca890'>Bitte berücksichtigen Sie die Umwelt - müssen Sie diese E-Mail wirklich ausdrucken?</span>
			</p></div>";

        return sendEmail(MFCSENDEREMAIL, $email, $subject, $message, $customer, false);
    }
}
