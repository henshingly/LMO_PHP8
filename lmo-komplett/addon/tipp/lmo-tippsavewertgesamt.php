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
  require_once(PATH_TO_LMO."/lmo-admintest.php");
  $dummb = array("");
  $dummd = array("");
  $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;

  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile2 = fgets($datei,1000);
    $zeile2=chop($zeile2);
    if($zeile2!=""){array_push($dummd,$zeile2);}
    }
  fclose($datei);
  array_shift($dummd);
  $anztipper=count($dummd);

  $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";
  $auswertdatei = fopen($auswertfile,"wb");
  if (!$auswertdatei) {
    echo "<p class='error'>".$text['tipp'][29]." ".$auswertdatei.$text[283]."</p>";
    exit;
    }
  flock($auswertdatei,2);
  $addw="lmo-start.php?action=tipp&amp;todo=wert&amp;all=1";
  echo "<p class='message'>".$text['tipp'][29]." <a target=\"_blank\" href=\"".$addw."\">Gesamt</a> ".$text['tipp'][65]."<br></p>";
  $tippernick = array_pad($array,$anztipper+1,"");
  if($tipp_showname==1){$tippername = array_pad($array,$anztipper+1,"");}
  if($tipp_showemail==1){$tipperemail = array_pad($array,$anztipper+1,"");}
  $tipperteam = array_pad($array,$anztipper+1,"");
  
  for($i=0;$i<$anztipper;$i++){
    $dummb = split("[|]",$dummd[$i]);
    $tippernick[$i]=$dummb[0];
    if($tipp_showname==1){$tippername[$i]=$dummb[3];}
    if($tipp_showemail==1){$tipperemail[$i]=$dummb[4];}
    $tipperteam[$i]=$dummb[5];
    }
  $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert");
  $dummy=array("");
  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==".aus" && strtolower(substr($files,-10))!="gesamt.aus"){array_push($dummy,$files);}
    }
  closedir($verz);
  array_shift($dummy);
  
  $anzligen=count($dummy);
  $anzligenaus=0;
  $liganame=array_pad($array,$anzligen+1,"");
  if($tipp_showzus==1){$punkte=array_pad($array,$anztipper+1,"");}
  $tipppunkte=array_pad($array,$anztipper+1,"");
  $spielegetipptges=array_pad($array,$anztipper+1,"");
  for($i=0;$i<$anztipper;$i++){
    if($tipp_showzus==1){
      $punkte[$i] = array_pad($array,$anzligen+1,"");
      for($p=0;$p<$anzligen;$p++){$punkte[$i][$p] = array_pad(array(""),7,"");}
      }
    $tipppunkte[$i] = array_pad(array("0"),$anzligen+1,"0");
    $spielegetipptges[$i] = array_pad(array("0"),$anzligen+1,"0");
    }

  for($k=0;$k<$anzligen;$k++){

    $ftest=0;
    $ftest1="";
    $ftest1=explode(',',$tipp_ligenzutippen);
    if(isset($ftest1)){
      for($u=0;$u<count($ftest1);$u++){
        if($ftest1[$u]==substr($dummy[$k],0,-4)){$ftest=1;}
        }
      }
    $auswertfile1=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$dummy[$k];
    if($ftest==0 && $tipp_immeralle==0){ // Liga darf nicht in Gesamtwertung einfliessen
      }
    elseif(!file_exists($auswertfile1))
      echo $text['tipp'][17]."<br>";
    else{
      $liganame[$anzligenaus]=$dummy[$k];
      $datei = fopen($auswertfile1,"rb");
      if($datei!=false){
        $tippdaten=array("");
        $sekt="";
        while (!feof($datei)) {
          $zeile = fgets($datei,1000);
          $zeile=chop($zeile);
          $zeile=trim($zeile);
          if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
            $sekt=trim(substr($zeile,1,-1));
            }
          elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
            $schl=trim(substr($zeile,0,strpos($zeile,"=")));
            $wert=trim(substr($zeile,strpos($zeile,"=")+1));
            array_push($tippdaten,$sekt."|".$schl."|".$wert."|EOL");
            }
          }
        fclose($datei);
        }  
      array_shift($tippdaten);
      
      for($i=1;$i<=count($tippdaten);$i++){
        $dum=split("[|]",$tippdaten[$i-1]);
        $op1=$dum[0];  // Nick
        $op3=substr($dum[1],2)-1;   // Spieltagsnummer
        $op4=substr($dum[1],0,2);   // PP
        if($op4=="TP"){
          $gef=0;
          for($j=0;$j<$anztipper && $gef==0;$j++){
            if($tippernick[$j]==$op1){
              $tipppunkte[$j][$anzligenaus]+=$dum[2];
              $gef=1;
              }
            }
          }
        elseif($op4=="SG"){
          $gef=0;
          for($j=0;$j<$anztipper && $gef==0;$j++){
            if($tippernick[$j]==$op1){
              $spielegetipptges[$j][$anzligenaus]+=$dum[2];
              $gef=1;
              }
            }
          }
        elseif(substr($op4,0,1)=="P" && $tipp_showzus==1){
          $artpkt=substr($op4,1,1);
          $gef=0;
          for($j=0;$j<$anztipper && $gef==0;$j++){
            if($tippernick[$j]==$op1){
              $punkte[$j][$anzligenaus][$artpkt]+=$dum[2];
              $gef=1;
              }
            }
          }
        }
      $anzligenaus++;
      }
    } // ende for($k=0;$k<$anzligen;$k++)

  fputs($auswertdatei,"[Options]\n");
  fputs($auswertdatei,"AnzLigen=".$anzligenaus."\n");
  for($k=1;$k<=$anzligenaus;$k++){
    fputs($auswertdatei,"TT".$k."=".$liganame[$k-1]."\n");
    }
  for($j=0;$j<$anztipper;$j++){
    fputs($auswertdatei,"\n[".$tippernick[$j]."]\n");
    fputs($auswertdatei,"Team=".$tipperteam[$j]."\n");
    if($tipp_showname==1){fputs($auswertdatei,"Name=".$tippername[$j]."\n");}
    if($tipp_showemail==1){fputs($auswertdatei,"Email=".$tipperemail[$j]."\n");}
    for($k=1;$k<=$anzligenaus;$k++){
      if($tipppunkte[$j][$k-1]==""){$tipppunkte[$j][$k-1]=0;}
      fputs($auswertdatei,"TP".$k."=".$tipppunkte[$j][$k-1]."\n");
      fputs($auswertdatei,"SG".$k."=".$spielegetipptges[$j][$k-1]."\n");
      if($tipp_showzus==1){
        for($p=1;$p<7;$p++){
          if($punkte[$j][$k-1][$p]>0){fputs($auswertdatei,"P".$p.$k."=".$punkte[$j][$k-1][$p]."\n");}
          }
        }
      }
    }
  flock($auswertdatei,3);
  fclose($auswertdatei);

  clearstatcache();
  if($todo!="edit"){$file="";}
?>