<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 

if($file!="" && $todo=="einsicht" && $tipp_tippeinsicht==1){
  $tipp_showzus=0;
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  if(!isset($st) || $st=="" || $st==0){$st=$stx;}
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");

  if(!isset($tipp_anzseite)){$tipp_anzseite=20;}
  if(!isset($anztipper)){$anztipper=0;}
  if(!isset($von)){$von=0;}
  if(!isset($start)){$start=0;}
  if($start>=$anztipper){$start=0;}
  if($tipp_anzseite<1){$tipp_anzseite=20;}
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <?PHP if($_SESSION["lmotipperok"]==5){echo $lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;}}else{echo $text['tipp'][158];} ?>
  </td></tr>
<?PHP if($tipp_einsichterst==1){ ?><tr><td class="lmost4" align="center"><?PHP echo $text['tipp'][220]." ".$text['tipp'][216]; ?></td></tr><?PHP } ?>
<?PHP if($tipp_einsichterst==2){ ?><tr><td class="lmost4" align="center"><?PHP echo $text['tipp'][220]." ".$text['tipp'][217]; ?></td></tr><?PHP } ?>
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  $addr=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;start=".$start."&amp;st=";
  $addt=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=&amp;nick=";
  $addt3=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;st=".$st."&amp;start=";
  
  echo "<td align=\"right\" valign=\"top\" class=\"lmost1\" colspan=\"3\" rowspan=\"4\">";
  if($lmtype==1){echo $text[370];}else{echo $text[2];}echo ":";
  echo "&nbsp;</td>";
  for($i=1;$i<=$anzst;$i++){
    if($lmtype==1){
      if($i==$anzst){$j=$text[364];$k=$text[365];}
      elseif($i==$anzst-1){$j=$text[362];$k=$text[363];}
      elseif($i==$anzst-2){$j=$text[360];$k=$text[361];}
      elseif($i==$anzst-3){$j=$text[358];$k=$text[359];}
      else{$j=$i;$k=$text[366];}
      }
    else{$j=$i;$k=$text[9];}


    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "class=\"lmost0\"><a href=\"".$addr.$i."\" title=\"".$k."\">".$j."</a>";
      }
    else{
      echo "class=\"lmost1\">".$j;
      }
    echo "&nbsp;</td>";
    if(($anzst>49) && (($anzst%4)==0)){
      if(($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)){echo "</tr><tr>";}
      }
    elseif(($anzst>38) && (($anzst%3)==0)){
      if(($i==$anzst/3) || ($i==$anzst/3*2)){echo "</tr><tr>";}
      }
    elseif(($anzst>25) && (($anzst%2)==0)){
      if($i==$anzst/2){echo "</tr><tr>";}
      }
    }
?>
</tr></table></td>
  </tr>
<?PHP $tipp_anzseiten=$anztipper/$tipp_anzseite;
    if($tipp_anzseiten>1){
    ?> 
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td align=\"right\" valign=\"top\" class=\"lmost1\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for($i=0;$i<$tipp_anzseiten;$i++){
      $von=$i*$tipp_anzseite;
      $bis=($i+1)*$tipp_anzseite-1;
      if($bis>=$anztipper){$bis=$anztipper-1;}
      if($von!=$start){echo "<td class=\"lmost0\"><nobr><a href=\"".$addt3.$von."\">";}
      else{echo "<td class=\"lmost1\"><nobr>";}
      $k1=strtolower(substr($tippernick[intval(substr($tab0[$von],-6))],0,3));
      $k2=strtolower(substr($tippernick[intval(substr($tab0[$bis],-6))],0,3));
      echo $k1."-".$k2;
      if($von!=$start){echo "</a>";}
      echo "&nbsp;</nobr></td>";
      if(($i+1)%10==0){echo "</tr><tr>";}
      }
?>
    </tr></table></td>
  </tr>
<?PHP } // ende if($tipp_anzseiten>1) ?>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
<?PHP 
$tab1=array("");
$nw=0;
$ende=$start+$tipp_anzseite;
if($ende>$anztipper){$ende=$anztipper;}
if(!isset($tab0)){$tab0=array("");}
//if($anztipper<1){exit;}
for($l=$start-1;$l<=($ende+2);$l++){
  if($l>=$start && $l<$ende){$k=intval(substr($tab0[$l],-6));}
  if($lmtype==0){$anzmodus=1;}else{$anzmodus=$modus[$st-1];} ?>
  <tr>
  <td align="right" class="lmocross4">
  <?PHP
  if($l>=$start && $l<$ende){echo "<nobr>".$tippernick[$k]."</nobr>"; } // Nickname links
  elseif($l==$ende && $anztipper>0){echo "<nobr>".$text['tipp'][188]."</nobr>"; } // Tipptendenz 
  elseif($l==($ende+1) && $anztipper>0 && $tipp_tippmodus==1){echo "<nobr>"."�-".$text['tipp'][30]."</nobr>"; } // Durchschnittstipp ?>
  </td>
  <?PHP
  $punktetipper=0;
  for($i=0;$i<$anzsp;$i++){
    if($teama[$st-1][$i]>0 && $teamb[$st-1][$i]>0){
      for($n=0;$n<$anzmodus;$n++){
        if($l==$start){
          if($tipp_einsichterst==1){
            $plus=0;
            if($lmtype==0){$btip[$i]=tippaenderbar($mterm[$st-1][$i],$datum1[$st-1],$datum2[$st-1]);}
            else{$btip[$i][$n]=tippaenderbar($mterm[$st-1][$i][$n],$datum1[$st-1],$datum2[$st-1]);}
            }
          elseif($tipp_einsichterst==2){
            if($lmtype!=0){
              if($goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_"){$btip[$i][$n]=false;}
              else{$btip[$i][$n]=true;}
              }
            else{
              if($goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_"){$btip[$i]=false;}
              else{$btip[$i]=true;}
              }
            }
          else{ // Tipps immer anzeigen
            if($lmtype!=0){$btip[$i][$n]=false;}
            else{$btip[$i]=false;}
            }
          }
        if($l==($start-1) || $l==($ende+2)){?>
          <td align="center" valign="center" class="lmocross4"><nobr>
          <?PHP 
          if($n==0){echo $teamk[$teama[$st-1][$i]]."<br>";}
          if($lmtype!=0){
            echo $goala[$st-1][$i][$n].":".$goalb[$st-1][$i][$n];
            if($mtipp[$st-1][$i][$n]==1){echo $text['tipp'][230];$nw=1;}
            }
          else{
            echo $goala[$st-1][$i].":".$goalb[$st-1][$i];
            if($mtipp[$st-1][$i]==1){echo $text['tipp'][230];$nw=1;}
            }
          if($n==0){echo "<br>".$teamk[$teamb[$st-1][$i]];}
          ?>
          </nobr></td>
          <?PHP
          }
        elseif($l<$ende){
          if(($lmtype==0 && $btip[$i]==true) || ($lmtype!=0 && $btip[$i][$n]==true)){ ?>
            <td align="center" class="lmocross5">
            <?PHP
            }
          else{
            if($lmtype!=0){ 
              if($tippa[$k][$i][$n]==-1){$tippa[$k][$i][$n]="_";}
              if($tippb[$k][$i][$n]==-1){$tippb[$k][$i][$n]="_";}
              }
            else{
              if($tippa[$k][$i]==-1){$tippa[$k][$i]="_";}
              if($tippb[$k][$i]==-1){$tippb[$k][$i]="_";}
              }
            $punktespiel=-1;
            if($lmtype!=0){
              if($tippa[$k][$i][$n]!="_"){
                if($tipp_jokertipp==1 && $jksp2[$k]==($i+1).($n+1)){$jkspfaktor=$tipp_jokertippmulti;}
                else{$jkspfaktor=1;}
                if($goala[$st-1][$i][$n]!="_"){
                  $punktespiel=tipppunkte($tippa[$k][$i][$n], $tippb[$k][$i][$n], $goala[$st-1][$i][$n], $goalb[$st-1][$i][$n], 0, $mspez[$st-1][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i][$n]);
                  }
                }
              else{$jkspfaktor=1;}
              }
            else{
              if($tippa[$k][$i]!="_"){
                if($tipp_jokertipp==1 && $jksp2[$k]==$i+1){$jkspfaktor=$tipp_jokertippmulti;}
                else{$jkspfaktor=1;}
                if($goala[$st-1][$i]!="_"){
                  $punktespiel=tipppunkte($tippa[$k][$i], $tippb[$k][$i], $goala[$st-1][$i], $goalb[$st-1][$i], $msieg[$st-1][$i], $mspez[$st-1][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i]);
                  }
                }
              else{$jkspfaktor=1;}
              }
            if($tipp_tippmodus==1){ // Ergebnis-Tippmodus
              if($punktespiel>$tipp_rtor*$jkspfaktor){ ?>
                <td align="center" class="lmost7">
                <?PHP
                }
              else{ ?>
                <td align="center" class="lmocross5">
                <?PHP
                }
              echo "<nobr>";
              $dummy1="";$dummy2="";$dummy3="";$dummy4="";
              if($punktespiel==$tipp_rergebnis*$jkspfaktor || $punktespiel==($tipp_rergebnis+$tipp_rremis)*$jkspfaktor){$dummy1="<b>";$dummy4="</b>";}
              elseif($punktespiel==$tipp_rtendenzdiff*$jkspfaktor || $punktespiel==($tipp_rtendenzdiff+$tipp_rremis)*$jkspfaktor){$dummy2="<b>";$dummy3="</b>";}
              if($jkspfaktor>1){echo "<p class='error'>";}
              if($lmtype!=0){ 
                if($tipp_rtor>0 && ($punktespiel==$tipp_rtor*$jkspfaktor || $punktespiel==($tipp_rtendenz+$tipp_rtor)*$jkspfaktor)){
                  if($goala[$st-1][$i][$n]==$tippa[$k][$i][$n]){$dummy1="<b>";$dummy2="</b>";}
                  elseif($goalb[$st-1][$i][$n]==$tippb[$k][$i][$n]){$dummy3="<b>";$dummy4="</b>";}
                  }
                echo $dummy1.$tippa[$k][$i][$n].$dummy2.":".$dummy3.$tippb[$k][$i][$n].$dummy4;
                }
              else{
                if($tipp_rtor>0 && ($punktespiel==$tipp_rtor*$jkspfaktor || $punktespiel==($tipp_rtendenz+$tipp_rtor)*$jkspfaktor)){
                  if($goala[$st-1][$i]==$tippa[$k][$i]){$dummy1="<b>";$dummy2="</b>";}
                  elseif($goalb[$st-1][$i]==$tippb[$k][$i]){$dummy3="<b>";$dummy4="</b>";}
                  }
                echo $dummy1.$tippa[$k][$i].$dummy2.":".$dummy3.$tippb[$k][$i].$dummy4;
                }
              if($jkspfaktor>1){echo "";}
              echo " <small>";
              if($punktespiel>=0){echo $punktespiel;}else{echo "&nbsp;";}
              echo "</small></nobr>";
              }
            else{ // Tendenz-Modus
              if($punktespiel>0){ ?>
                <td align="center" class="lmost7">
                <?PHP
                }
              else{ ?>
                <td align="center" class="lmocross5">
                <?PHP
                }
              if($jkspfaktor>1){echo "<p class='error'>";}
              if($lmtype!=0){ 
                if($tippa[$k][$i][$n]=="_" || $tippb[$k][$i][$n]=="_"){echo "_";}
                elseif($tippa[$k][$i][$n]==$tippb[$k][$i][$n]){echo "0";}
                elseif($tippa[$k][$i][$n]>$tippb[$k][$i][$n]){echo "1";}
                elseif($tippa[$k][$i][$n]<$tippb[$k][$i][$n]){echo "2";}
                }
              else{
                if($tippa[$k][$i]=="_" || $tippb[$k][$i]=="_"){echo "_";}
                elseif($tippa[$k][$i]==$tippb[$k][$i]){echo "0";}
                elseif($tippa[$k][$i]>$tippb[$k][$i]){echo "1";}
                elseif($tippa[$k][$i]<$tippb[$k][$i]){echo "2";}
                }
              if($jkspfaktor>1){echo "";}
              } 
            if($punktespiel>0){$punktetipper+=$punktespiel;}
            } ?>
          </td>
          <?PHP
          }
        elseif($l==$ende){?>
          <td align="center" class="lmocross4"><nobr>
          <?PHP 
          if($anztipper>0){
            if($lmtype==0 && $btip[$i]==false){
              echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
              }
            elseif($lmtype!=0 && $btip[$i][$n]==false){
              echo $tendenz1[$i][$n]."-".$tendenz0[$i][$n]."-".$tendenz2[$i][$n];
              }
            }
          ?>
          </nobr></td>
          <?PHP
          }
        elseif($l==($ende+1)){?>
          <td align="center" class="lmocross4"><nobr>
          <?PHP 
          if($anztipper>0 && $tipp_tippmodus==1){
            if($lmtype==0 && $btip[$i]==false){
              if($anzgetippt[$i]>0){
                if($toregesa[$i]<10 && $toregesb[$i]<10){$nachkomma=1;}
                else{$nachkomma=0;}
                echo number_format(($toregesa[$i]/$anzgetippt[$i]),$nachkomma,".",",").":".number_format(($toregesb[$i]/$anzgetippt[$i]),$nachkomma,".",",");
                }
              }
            elseif($lmtype!=0 && $btip[$i][$n]==false){
              if($anzgetippt[$i][$n]>0){
                if($toregesa[$i][$n]<10 && $toregesb[$i][$n]<10){$nachkomma=1;}
                else{$nachkomma=0;}
                echo number_format(($toregesa[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",").":".number_format(($toregesb[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",");
                }
              }
            }
          ?>
          </nobr></td>
          <?PHP
          }
        } // ende for($n=0;$n<$anzmodus;$n++)
      }
    } // ende for($i=0;$i<$anzsp;$i++) ?>
  <td class="lmocross4"><nobr>
  <?PHP if($l>=$start && $l<$ende){echo "= ".$punktetipper." ".$text[37];} ?>
  </nobr></td>
  <td class="lmocross4"><nobr>
  <?PHP if($tipp_tipptabelle1==1 && $l>=$start && $l<$ende && $lmtype==0){echo "<a href=\"".$addt.htmlentities($tippernick[$k])."\" title=\"".$text['tipp'][181]." ".$tippernick[$k]."\">".$text['tipp'][172]."</a>"; } ?>
  </nobr></td>
  </tr>
  <?PHP
  } // ende for($l=$start-1;$l<=$ende;$l++) ?>
</table></td></tr>
<?PHP 
    if($tipp_anzseiten>1 && $tipp_anzseiten<11){
    ?> 
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
    echo "<td align=\"right\" valign=\"top\" class=\"lmost1\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for($i=0;$i<$tipp_anzseiten;$i++){
      $von=$i*$tipp_anzseite;
      $bis=($i+1)*$tipp_anzseite-1;
      if($bis>=$anztipper){$bis=$anztipper-1;}
      if($von!=$start){echo "<td class=\"lmost0\"><nobr><a href=\"".$addt3.$von."\">";}
      else{echo "<td class=\"lmost1\"><nobr>";}
      $k1=strtolower(substr($tippernick[intval(substr($tab0[$von],-6))],0,3));
      $k2=strtolower(substr($tippernick[intval(substr($tab0[$bis],-6))],0,3));
      echo $k1."-".$k2;
      if($von!=$start){echo "</a>";}
      echo "&nbsp;</nobr></td>";
      if(($i+1)%10==0){echo "</tr><tr>";}
      }
?>
    </tr></table></td>
  </tr>
<?PHP } // ende if($tipp_anzseiten>1) ?>
</table>
<?PHP
} // ende if(($file!="") && ($todo=="einsicht"))?>