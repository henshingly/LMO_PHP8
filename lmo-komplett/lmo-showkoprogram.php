<?
/** Liga Manager Online 4
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
  *
  */
  
  
if ($file != "") {
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  function gewinn ($gst, $gsp, $gmod, $m1, $m2) {
    $erg = 0;
    if ($gmod == 1) {
      if ($m1[0] > $m2[0]) {
        $erg = 1;
      } elseif($m1[0] < $m2[0]) {
        $erg = 2;
      }
    } elseif($gmod == 2) {
      if (($m1[0]+$m1[1]) > ($m2[0]+$m2[1])) {
        $erg = 1;
      } elseif(($m1[0]+$m1[1]) < ($m2[0]+$m2[1])) {
        $erg = 2;
      } else {
        if ($m2[0] > $m1[1]) {
          $erg = 2;
        } elseif($m2[0] < $m1[1]) {
          $erg = 1;
        }
      }
    } else {
      $erg1 = 0;
      $erg2 = 0;
      for($k = 0; $k < $gmod; $k++) {
        if (($m1[$k] != "_") && ($m2[$k] != "_")) {
          if ($m1[$k] > $m2[$k]) {
            $erg1++;
          } elseif($m1[$k] < $m2[$k]) {
            $erg2++;
          }
        }
      }
      if ($erg1 > ($gmod/2)) {
        $erg = 1;
      } elseif($erg2 > ($gmod/2)) {
        $erg = 2;
      }
    }
    return $erg;
  }?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table cellspacing="0" cellpadding="0" border="0"><?
  for($i = 1; $i <= floor($anzteams/2); $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?=$text[23]." ".$teams[$i]?>"><?
    if($i!=$selteam){?>
            <a href="<?=$addp.$i?>" ><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
       ?></acronym>
          </td>          
          <td><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
  
               ?>&nbsp;<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$i]?>"><?
    } else {
      echo "&nbsp;";
    }   ?></td>
        </tr><?
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if ($selteam == 0) {
    echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text[24]."<br>&nbsp;</td></tr>";
  } else {
    for($j = 0; $j < $anzst; $j++) {
      for($i = 0; $i < (($anzteams/2)+1); $i++) {
        if (($selteam == $teama[$j][$i]) || ($selteam == $teamb[$j][$i])) {?>
        <tr><?
          if ($j == $anzst-1) {
            $l = $text[364];
          } elseif($j == $anzst-2) {
            $l = $text[362];
          } elseif($j == $anzst-3) {
            $l = $text[360];
          } elseif($j == $anzst-4) {
            $l = $text[358];
          } else {
            $l = $j+1;
          }?>
          <th align="right">&nbsp;<a href="<?=$addr.($j+1); ?>" title="<?=$text[377]; ?>"><?=$l; ?></a>&nbsp;</th><?
          $m1 = array($goala[$j][$i][0], $goala[$j][$i][1], $goala[$j][$i][2], $goala[$j][$i][3], $goala[$j][$i][4], $goala[$j][$i][5], $goala[$j][$i][6]);
          $m2 = array($goalb[$j][$i][0], $goalb[$j][$i][1], $goalb[$j][$i][2], $goalb[$j][$i][3], $goalb[$j][$i][4], $goalb[$j][$i][5], $goalb[$j][$i][6]);
          $m = gewinn($j, $i, $modus[$j], $m1, $m2);
          if ($m == 1) {
            echo "<td class=\"lmoTurnierSieger nobr\" align=\"right\">";
          } elseif ($m==2) {
            echo "<td class=\"lmoTurnierVerlierer nobr\" align=\"right\">";
          } else {
            echo "<td class=\"nobr\" align=\"right\">";
          }
          if ($selteam == $teama[$j][$i]) {
            echo "<strong>";
          }
          if (($teamu[$teama[$j][$i]] != "") && ($urlt == 1)) {
            echo "<a href=\"".$teamu[$teama[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\">";
          }
          echo $teams[$teama[$j][$i]];
          if (($teamu[$teama[$j][$i]] != "") && ($urlt == 1)) {
            echo "</a>";
          }
          if ($selteam == $teama[$j][$i]) {
            echo "</strong>";
          }
          if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$j][$i]].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$j][$i]].".gif");
  
               ?>&nbsp;<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teama[$j][$i]])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$teama[$j][$i]]?>"><?
          }
          echo " </td>";?>
          <td class="lmost5" align="center" width="10">-</td><?
          if ($m == 2) {
            echo "<td class=\"lmoTurnierSieger nobr\">";
          } elseif($m==1) {
            echo "<td align='left' class=\"lmoTurnierVerlierer nobr\">";
          } else {
            echo "<td class=\"nobr\" align=\"left\">";
          }
          if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$j][$i]].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$j][$i]].".gif");
  
               ?><img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teamb[$j][$i]])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$teamb[$j][$i]]?>">&nbsp;<?
          }
          if ($selteam == $teamb[$j][$i]) {
            echo "<strong>";
          }
          if (($teamu[$teamb[$j][$i]] != "") && ($urlt == 1)) {
            echo "<a href=\"".$teamu[$teamb[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\">";
          }
          echo $teams[$teamb[$j][$i]];
          if (($teamu[$teamb[$j][$i]] != "") && ($urlt == 1)) {
            echo "</a>";
          }
          if ($selteam == $teamb[$j][$i]) {
            echo "</strong>";
          }
          echo " </td>";
          for($n = 0; $n < $modus[$j]; $n++) {
            if ($datm == 1) {
              if ($mterm[$j][$i][$n] > 0) {
                $dumn1 = "<acronym title=\"".strftime($datf, $mterm[$j][$i][$n])."\">";
                $dumn2 = "</acronym>";
              } else {
                $dumn1 = "";
                $dumn2 = "";
              }
            }
            if ($n == 0) {
              echo "<td width=\"2\">&nbsp;</td>";
            } else {
              echo "<td width=\"8\">|</td>";
            }?>
          <td class="nobr"><?=$dumn1; ?><?=applyFactor($goala[$j][$i][$n],$goalfaktor); ?>&nbsp;:&nbsp;<?=applyFactor($goalb[$j][$i][$n],$goalfaktor); ?>&nbsp;<?=$mspez[$j][$i][$n]; ?><?=$dumn2; ?><?
           /** Mannschaftsicons finden
             */
            $lmo_teamaicon="";
            $lmo_teambicon="";
            if($urlb==1 || $mnote[$j][$i][$n]!=""){
              if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$j][$i]].".gif")) {
                $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$j][$i]].".gif");
                $lmo_teamaicon="<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teama[$j][$i]]).".gif' {$imgdata[3]} alt=''> ";
              }
              if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$j][$i]].".gif")) {
                $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$j][$i]].".gif");
                $lmo_teambicon="<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teamb[$j][$i]]).".gif' {$imgdata[3]} alt=''> ";
              }
            }
            /** Spielbericht verlinken
             */
            if($urlb==1){
              if($mberi[$j][$i][$n]!=""){
                $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong><br><br>";
                echo "<a href='".$mberi[$j][$i][$n]."'  target='_blank' title='".$text[270]."'><img src='img/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'><!--[if IE]><table><tr><td style=\"width: 23em\"><![endif]-->".$lmo_spielbericht.nl2br($text[270])."<!--[if IE]></td></tr></table><![endif]--></span></a>";
              }else{
                echo "&nbsp;&nbsp;&nbsp;";
              }
            }
            /** Notizen anzeigen
             *
             * Da IE kein max-width kann, Workaround lt. http://www.bestviewed.de/css/bsp/maxwidth/
             */
            if ($mnote[$j][$i][$n]!="") {
         
              $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong> ".applyFactor($goala[$j][$i][$n],$goalfaktor).":".applyFactor($goalb[$j][$i][$n],$goalfaktor);
              //Allgemeine Notiz
              
              $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong> ".$mnote[$j][$i][$n];
              
              echo "<a href='#' onclick=\"alert('".mysql_escape_string(strip_tags($lmo_spielnotiz))."');window.focus();return false;\"><span class='popup'><!--[if IE]><table><tr><td style=\"width: 23em\"><![endif]-->".nl2br($lmo_spielnotiz)."<!--[if IE]></td></tr></table><![endif]--></span><img src='img/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
              $lmo_spielnotiz="";
            } else {
              echo "&nbsp;";
            }?>
          </td><? 
          }?>
        </tr><? 
        }
      }
    }
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table cellspacing="0" cellpadding="0" border="0"><?
  for($i = ceil($anzteams/2)+1; $i <= $anzteams; $i++) {?>
        <tr>
          <td><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
  
               ?>&nbsp;<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$i]?>"><?
    } else {
      echo "&nbsp;";
    }   ?></td>
          <td align="left">
            <acronym title="<?=$text[23]." ".$teams[$i]?>"><?
    if($i!=$selteam){?>
            <a href="<?=$addp.$i?>"><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
       ?></acronym>
          </td>
        </tr><?
  }?>
      </table>
    </td>
  </tr>
</table><?
}?>