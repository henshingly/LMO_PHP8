<?php

/**
 * Liga Manager Online 4
 *
 * http://lmo.sourceforge.net/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
 */
require_once (PATH_TO_ADDONDIR . '/tipp/lmo-tipptest.php');
require_once (PATH_TO_LMO . '/includes/PHPMailer.php');
$mail = new PHPMailer(true);

if (isset($xtippername2)) {
    $dumma = $users = array();
    $pswfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;
    
    $datei = fopen($pswfile, 'rb');
    while ($datei && !feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = trim($zeile);
        if ($zeile != '') {
            if ($zeile != '') {
                array_push($users, $zeile);
            }
        }
    }
    fclose($datei);
    
    $xtipperpass = substr(md5(uniqid(rand())), 0, rand(10, 20));

    $dumma = file($pswfile);
    $mail->isMail();
    $mail->isHTML();
    $mail->Subject = $text['tipp'][79];
    $mail->setFrom($aadr);

    for ($i = 0; $i < count($dumma) && $_SESSION['lmotipperok'] == -5; $i++) {
        $dummb = explode('|', $dumma[$i]);
        if ($xtippername2 == $dummb[0] || ($xtippername2 == $dummb[4] && str_contains($dummb[4], '@'))) {
            // User gefunden
            $_SESSION['lmotippername'] = $dummb[0];
            $_SESSION['lmotipperok'] = 0;
            $emailbody = 'Hallo ' . $dummb[0] . '<br /><br />' . $text['tipp'][77] . '<br />' . $text['tipp'][23] . ': ' . $dummb[0] . '<br />' . $text[308] . ': ' . $xtipperpass;
            $mail->Body = iconv('UTF-8', ' ISO-8859-1', $emailbody);
            $mail->addAddress($dummb[4]);
            if ($mail->send()) {
                $mail->ClearAllRecipients();
                $mail->ClearReplyTos();
            } else {
                $mail->ErrorInfo();
                $mail->ClearAllRecipients();
                $mail->ClearReplyTos();
            }
            //Neues PAsswort speichern
            $dummb[1] = password_hash($xtipperpass, PASSWORD_BCRYPT);
            $users[$i] = $dummb[0] . '|' . $dummb[1] . '|' . $dummb[2] . '|' . $dummb[3] . '|' . $dummb[4] . '|' . $dummb[5] . '|' . $dummb[6] . '|' . $dummb[7] . '|' . $dummb[8] . '|' . $dummb[9] . '|' . $dummb[10] . '|EOL';
            require (PATH_TO_ADDONDIR . '/tipp/lmo-tippsaveauth.php');
            $xtippername2 = '';
        }
    }
    if ($_SESSION['lmotipperok'] == -5) {
        $_SESSION['lmotipperok'] = -3;
    }  // Benutzer nicht gefunden
} else {
    $_SESSION['lmotipperok'] = 0;
}  // kein Name angegeben
?>