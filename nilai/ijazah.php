<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$bodyijazah .= "\r\n    <center   style='page-break-after:always;'> \r\n    <table width=1000  >\r\n    <tr >\r\n    <td align=center style='font-family:  Monotype Corsiva;font-size:16pt;' class=loseborder >\r\n      <b>dengan ini menyatakan bahwa : </b>\r\n      <br><br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n    <td align=center style=' font-size:12pt;' class=loseborder>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:28pt;'>\r\n      {$d['NAMA']}</font><br><br>\r\n      <b>NPM : <i>{$d['ID']}</i></b> <br><br>\r\n        <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      lahir di {$d['TEMPAT']} tanggal {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      telah menyelesaikan dengan baik dan memenuhi segala syarat<br>\r\n      pendidikan pada Program Studi {$d['NAMAP']} <br>\r\n      Fakultas {$d['NAMAF']} <br>\r\n      Status terakreditasi nomor {$d['NOMBAMSPST']} <br>\r\n      Oleh sebab itu kepadanya diberikan gelar <br><br>\r\n      </b>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:24pt;'>\r\n      {$d['GELAR']}\r\n      </font>\r\n       <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      <br><br>\r\n      beserta segala hak dan kewajiban yang melekat pada gelar tersebut.\r\n      <br>\r\n      Tanggal kelulusan  {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    <br><br>\r\n    <table width=800>\r\n      <tr valign=top>\r\n        <td width=30% class=loseborder>\r\n        <i>\r\n          <br>Dekan,\r\n          <br><br><br><br><br><br>\r\n          <U>{$d['DEKAN']}</U><br>\r\n          {$d['NIPDEKAN']}\r\n        </td>\r\n        <td  class=loseborder>\r\n        {$d['FOTO']}\r\n        </td>\r\n        <td width=30% class=loseborder>\r\n          ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}, <br>\r\n          <i>\r\n          Rektor,\r\n          <br><br><br><br><br><br>\r\n          <u>{$d2['REKTOR']}</u><br>\r\n          {$d2['NIPREKTOR']}\r\n        </td>\r\n      </tr>\r\n    </table>\r\n    </center>\r\n    \r\n    ";
?>