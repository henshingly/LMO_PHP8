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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if(($action=="admin") && ($todo=="open")){
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
?>
<table class="lmosta" cellspacing="10" cellpadding="10" border="0">
  <tr>
    <td align="center" class="lmost1"><?=$text[294]?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" align="right"><?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
        </tr>
        <tr>
          <td class="lmost5" align="left"><? require(PATH_TO_LMO."/lmo-admindir.php"); ?></td>
        </tr>
        <tr>
          <td class="lmost5" align="right"><?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>