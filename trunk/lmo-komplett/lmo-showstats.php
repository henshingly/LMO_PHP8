<?
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
if($file!=""){
  $stat1=isset($_GET['stat1'])?$_GET['stat1']:0;
  $stat2=isset($_GET['stat2'])?$_GET['stat2']:0;
  if ($stat1==0 && $stat2!=0) {
    $stat1=$stat2;
    $stat2=0;
  }
  $adds=$_SERVER['PHP_SELF']."?action=stats&amp;file=".$file."&amp;stat1=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td align="right">
            <acronym title="<?=$text[57]." ".$teams[$i]?>"><?
    if($i!=$stat1 && $i<>$stat2){?>
            <a href="<?=$adds.$i?>&amp;stat2=<?=$stat2?>"><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }     ?></acronym>
          </td>          
          <td><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
  
               ?>&nbsp;<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$i]?>">&nbsp;<?
    } else {
      echo "&nbsp;";
    }   ?></td>
        </tr><?
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if($stat1==0){?>
        <tr>
          <td align="center">&nbsp;<br><?=$text[24]?><br>&nbsp;</td>
        </tr><?
  } else {
    $endtab = $anzst;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz0[intval(substr($tab0[$x], 34))] = $x+1;
    }?>
        <tr>
          <th align="right"><?=$teams[$stat1];?></th>
          <th align="center"><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$stat1].".gif") && file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$stat2].".gif")) {   
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$stat1].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$stat1].".gif");
               ?><img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$stat1])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$stat1]?>"><?
      }
      echo "&nbsp;:&nbsp;";
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$stat2].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$stat2].".gif");
                 ?><img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$stat2])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$stat2]?>"><?
      }
    } ?></th><? 
      if($stat2>0){ ?>
          <th align="left"><?=$teams[$stat2];?></th><? 
      }?>
        </tr>
<?
  $serie1="&nbsp;";
  if ($ser1[$stat1]>0) {
    $serie1=$ser1[$stat1]." ".$text[474]."<br>".$ser2[$stat1]." ".$text[75];
  } elseif ($ser3[$stat1]>0) {
    $serie1=$ser3[$stat1]." ".$text[475]."<br>".$ser4[$stat1]." ".$text[76];
  } elseif ($ser2[$stat1]>=$ser4[$stat1]) {
    $serie1=$ser2[$stat1]." ".$text[75];
  } else {
    $serie1=$ser4[$stat1]." ".$text[76];
  }
  if ($stat2>0) {
    $chg1="k.A.";
    $chg2="k.A.";
    if (!empty($spiele[$stat1])&&!empty($spiele[$stat2])) {
      $ax=(100*$siege[$stat1]/$spiele[$stat1])+(100*$nieder[$stat2]/$spiele[$stat2]);
      $bx=(100*$siege[$stat2]/$spiele[$stat2])+(100*$nieder[$stat1]/$spiele[$stat1]);
      $cx=($etore[$stat1]/$spiele[$stat1])+($atore[$stat2]/$spiele[$stat2]);
      $dx=($etore[$stat2]/$spiele[$stat2])+($atore[$stat1]/$spiele[$stat1]);
      $ex=$ax+$bx;
      $fx=$cx+$dx;
    }
    if (isset($ex) && ($ex>0) && isset($fx) &&($fx>0)) {
      $ax=round(10000*$ax/$ex);
      $bx=round(10000*$bx/$ex);
      $cx=round(10000*$cx/$fx);
      $dx=round(10000*$dx/$fx);
      $chg1=number_format((($ax+$cx)/200),2,",",".");
      $chg2=number_format((($bx+$dx)/200),2,",",".");
    }
    $serie2="&nbsp;";
    if ($ser1[$stat2]>0) {
      $serie2=$ser1[$stat2]." ".$text[474]."<br>".$ser2[$stat2]." ".$text[75];
    } else if ($ser3[$stat2]>0) {
      $serie2=$ser3[$stat2]." ".$text[475]."<br>".$ser4[$stat2]." ".$text[76];
    } else if ($ser2[$stat2]>=$ser4[$stat2]) {
      $serie2=$ser2[$stat2]." ".$text[75];
    } else {
      $serie2=$ser4[$stat2]." ".$text[76];
    }
  

?>
        <tr>
          <td align="right"><?= $chg1; ?>%</td>
          <th align="center"><?= $text[60]; ?></th>
          <td valign="top" align="left"><?= $chg2; ?>%</td>
        </tr>
<? } ?>
        <tr>
          <td align="right"><?=$platz0[$stat1];?></td>
          <th><?=$text[61];?></th>
          <? if($stat2>0){ ?><td align="left"><?=$platz0[$stat2];?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?=$punkte[$stat1]; if($minus==2){":".$negativ[$stat1];} ?></td>
          <th><?= $text[37]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?=$punkte[$stat2]; if($minus==2){":".$negativ[$stat2];} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?=$spiele[$stat1];?></td>
          <th><?= $text[63]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?=$spiele[$stat2];?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$stat1]){echo number_format($punkte[$stat1]/$spiele[$stat1],2,",","."); if($minus==2){":".number_format($negativ[$stat1]/$spiele[$stat1],2,",",".");}} ?></td>
          <th><?= $text[37].$text[64]; ?></th>
          <? if($stat2>0){if($spiele[$stat2]){ ?><td align="left"><? echo number_format($punkte[$stat2]/$spiele[$stat2],2,",","."); if($minus==2){":".number_format($negativ[$stat2]/$spiele[$stat2],2,",",".");}} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $etore[$stat1].":".$atore[$stat1]; ?></td>
          <th><?= $text[38]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?= $etore[$stat2].":".$atore[$stat2]; ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$stat1]){ echo number_format($etore[$stat1]/$spiele[$stat1],2,",",".").":".number_format($atore[$stat1]/$spiele[$stat1],2,",",".");} ?></td>
          <th><?= $text[38].$text[64]; ?></th>
          <? if($stat2>0){ ?><td align="left"><? if($spiele[$stat2]){ echo number_format($etore[$stat2]/$spiele[$stat2],2,",",".").":".number_format($atore[$stat2]/$spiele[$stat2],2,",",".");} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$stat1]){echo $siege[$stat1]." (".number_format($siege[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
          <th><?= $text[67]; ?></th>
          <? if($stat2>0){ ?><td align="left"><? if($spiele[$stat2]){echo $siege[$stat2]." (".number_format($siege[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $maxs0[$stat1]; ?></td>
          <th valign="top"><?= $text[68]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?= $maxs0[$stat2]; ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$stat1]){echo $nieder[$stat1]." (".number_format($nieder[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
          <th><?= $text[69]; ?></th>
          <? if($stat2>0){ ?><td align="left"><? if($spiele[$stat2]){echo $nieder[$stat2]." (".number_format($nieder[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $maxn0[$stat1]; ?></td>
          <th valign="top"><?= $text[70]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?= $maxn0[$stat2]; ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $serie1; ?></td>
          <th valign="top"><?= $text[71]; ?></th>
          <? if($stat2>0){ ?><td align="left"><?= $serie2; ?></td><? } ?>
        </tr>
<?
    }
?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
  
               ?><img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$i]?>">&nbsp;<?
    } else {
      echo "&nbsp;";
    }   ?></td>
          <td align="left">
            <acronym title="<?=$text[57]." ".$teams[$i]?>"><?
    if($i!=$stat1 && $i!=$stat2){
               ?><a href="<?=$adds.$stat1?>&amp;stat2=<?=$i?>"><?=$teamk[$i]?></a><?
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
  if ($einzustats == 1) {
    $strs = ".l98";
    $stre = ".l98.php";
    $str = basename($file);
    $file16 = str_replace($strs, $stre, $str);
    $temp11 = basename($diroutput);
    if (file_exists("$temp11/$file16")) {
      require(PATH_TO_LMO."/$temp11/$file16");?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="5"><h1><?=$text[4009]?></h1></td>
  </tr>
<tr>
<tr>
  <td align="center">
    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <th colspan="4" align="center"><?=$text[63]?> </th>
      </tr>
      <tr>
        <td align="right"> <?=$text[516]?> </td>
        <td align="right"> <?=$text[4006]?> </td>
        <td align="center"> <?=$text[4008]?> </td>
        <td align="left"> <?=$text[4007]?> </td>
        
      </tr>
      <tr>
        <td align="right"> <?=$ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></td>
        <td align="right"> <?=$gzusieg1?><?if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?> </td>
        <td align="center"> <?=$gzuunent?><?if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?> </td>
        <td align="left"> <?=$gzusieg2?><?if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?> </td>
      </tr><?
    if ($gbeide>0) {?>
      <tr>
        <td align="right" colspan="2"><?=$text[4012]?></td>
        <td colspan="2" align="center"><?=$gbeide?><?if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></td>
      </tr><?
    }?>
      <tr>
        <th colspan="4" align="center"><?=$text[38]?> </th>
      </tr>
      <tr>
        <td align="right"> <?=$text[516]?> </td>
        <td align="right"> <?=$text[4010]?> </td>
        <td>&nbsp;</td>
        <td align="left"> <?=$text[4011]?> </td>
      </tr>
      <tr>
        <td align="right"> <?=$gzutore?> </td>
        <td align="right"> <?=$gheimtore?><?if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v%)";}?> </td>
        <td>&nbsp;</td>
        <td align="left"> <?=$ggasttore?><?if ($gdstore>0) {echo " (".(100-$v)."%)";}?> </td>
      </tr>
      <tr>
        <td align="right"><?=$text[517]?> <?=$gdstore?> </td>
        <td align="right"><?=$text[517]?> <?=$dsheimtore?> </td>
        <td>&nbsp;</td>
        <td align="left"><?=$text[517]?> <?=$dsgasttore?> </td>
      </tr>
      <tr>
        <th colspan="4" align="center"><?=$text[4013]?></th>
      </tr>
      <tr>
        <td align="right"><?=$hheimsieg?> - </td>
        <td align="left"><?=$hgastsieg?></td>
        <td colspan="2" align="left"><?=$hheimsiegtor?>:<?=$hgastsiegtor?> (<?=$spieltagflag?>.<?=$text[4014]?>)</td>
      </tr><?
    if ($hheimsiegtor1>0) {?>
      <tr>
        <td align="right"><?=$hheimsieg1?> - </td>
        <td align="left"><?=$hgastsieg1?></td>
        <td colspan="2" align="left"><?=$hheimsiegtor1?>:<?=$hgastsiegtor1?> (<?=$text[4014]?>.<?=$spieltagflag1?>)</td>
      </tr><?
	    if ($counteranz>2) {
	      $counteranz0=$counteranz-2;?>
    	<tr>
        <td>&nbsp;</td>
        <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz0?> <?=$text[4016]?></small></td>
      </tr><?
	    }
    }?>
      <tr>
        <th colspan="4" align="center"><?=$text[4017]?></th>
      </tr>
      <tr>
        <td align="right"><?=$aheimsieg?> - </td>
        <td align="left"><?=$agastsieg?></td>
        <td colspan="2" align="left"><?=$aheimsiegtor?>:<?=$agastsiegtor?> (<?=$spieltagflag2?>.<?=$text[4014]?>)</td>
      </tr>  <?
    if ($agastsiegtor1>0) {?>
      <tr>
        <td align="right"><?=$aheimsieg1?> - </td>
        <td align="left"><?=$agastsieg1?></td>
        <td colspan="2" align="left"><?=$aheimsiegtor1?>:<?=$agastsiegtor1?>  (<?=$spieltagflag3?>.<?=$text[4014]?>)</td>
      </tr><?
	    if ($counteranz1>2) {
	      $counteranz4=$counteranz1-2;?>
      <tr> 
        <td>&nbsp;</td>
        <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz4?> <?=$text[4016]?></small></td>
      </tr><?
	    }
    }?>
  
      <tr>
        <th colspan="4" align="center"><?=$text[4018]?>  <?=$text[38]?></th>
      </tr>
      <tr>
        <td align="right"><?=$htorreichm1?> - </td>
        <td align="left"><?=$htorreichm2?></td>
        <td colspan="2" align="left"><?=$htorreicht1?>:<?=$htorreicht2?>  (<?=$spieltagflag4?>.<?=$text[4014]?>)</td>
      </tr><?
    if ($spieltagflag5<>0) {?>
      <tr>
        <td align="right"><?=$htorreichm3?> - </td>
        <td align="left"><?=$htorreichm4?></td>
        <td colspan="2" align="left"><?=$htorreicht3?>:<?=$htorreicht4?>  (<?=$spieltagflag5?>.<?=$text[4014]?>)</td>
      </tr><?
	    if ($counteranz5>2) {
	      $counteranz6=$counteranz5-2;?>
  	  <tr>
         <td>&nbsp;</td>
         <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz6?> <?=$text[4019]?></small></td>
       </tr><?
    	}
    }?>
      </table>
    </td>
  </tr>
</table><?
  } //if (file_exists)
} //if (zustats)
?>
 
<? } ?>