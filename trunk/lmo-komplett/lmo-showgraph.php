<?PHP
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
if(($file!="") && ($kurve==1)){
  $addp=$_SERVER['PHP_SELF']."?action=graph&amp;file=".$file."&amp;stat1=";
  $stat1=isset($_GET['stat1'])?$_GET['stat1']:0;
  $stat2=isset($_GET['stat2'])?$_GET['stat2']:0;
  if ($stat1==0 && $stat2!=0 || $stat1==$stat2) {
    $stat1=$stat2;
    $stat2=0;
  }
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?=$text[23]." ".$teams[$i]?>"><?
    if($i!=$stat1){?>
            <a href="<?=$addp.$i?>" ><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
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
    $tabtype=0;
    require(PATH_TO_LMO."/lmo-calcgraph.php");
    $dummy=URL_TO_LMO."/lmo-paintgraph.php?pganz=";
    if($stat2>0){$dummy=$dummy."2";}else{$dummy=$dummy."1";}
    $dummy=$dummy."&pgteam1=".rawurlencode($teams[$stat1]);
    if($stat2>0){$dummy=$dummy."&pgteam2=".rawurlencode($teams[$stat2]);}
    $dummy=$dummy."&pgteams=".$anzteams;
    $dummy=$dummy."&pgst=".$anzst;
    $dummy=$dummy."&pgch=".$champ;
    $dummy=$dummy."&pgcl=".$anzcl;
    $dummy=$dummy."&pgck=".$anzck;
    $dummy=$dummy."&pguc=".$anzuc;
    $dummy=$dummy."&pgar=".$anzar;
    $dummy=$dummy."&pgab=".$anzab;
    $dummy=$dummy."&pgplatz1=";
    for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$stat1][$j].",";}
    $dummy=$dummy."0";
    if($stat2>0){
      $dummy=$dummy."&pgplatz2=";
      for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$stat2][$j].",";}
      $dummy=$dummy."0";
      }
    $dummy=$dummy."&pgtext1=".$text[135];
    $dummy=$dummy."&pgtext2=".$text[136];?>
        <tr>
          <td><img src="<?PHP echo $dummy; ?>" border="0" alt="<?=$text[133]?>"></td>
        </tr>
<?PHP } ?>

  </table></td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td><?
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
              $imgdata = getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
  
               ?>&nbsp;<img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt="<?=$teamk[$i]?>">&nbsp;<?
    } else {
      echo "&nbsp;";
    }   ?></td>
          <td align="right">
            <acronym title="<?=$text[23]." ".$teams[$i]?>"><?
    if($i!=$stat2){?>
            <a href="<?=$addp.$stat1."&amp;stat2=".$i?>" ><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>          
        </tr><?
  }?>
      </table></td>
  </tr>
</table>

<?PHP } ?>