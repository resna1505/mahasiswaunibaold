<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$bodyijazah .= "\r\n    <center   style='page-break-after:always;'> \r\n    <table width=1000  >\r\n    <tr >\r\n    <td align=center style=' font-size:12pt;'  class=loseborder >\r\n      <font style='  ;font-size:20pt;'> Sekolah Tinggi Ilmu Kesehatan (STIkes) </font>\r\n      <br>\r\n      <font style=' font-size:40pt;'> MITRA RIA HUSADA </font>\r\n      <br>\r\n    </td>\r\n    </tr>    \r\n    <tr >\r\n    <td align=center style=' font-size:12pt;'  class=loseborder >\r\n\t<br><font style='  ;font-size:16pt;'> TERAKREDITASI </font>\r\n      <br>\r\n      <font style=' font-size:12pt;'> \r\n  Berdasarkan SK Badan Akreditasi Nasional Perguruan Tinggi Departemen Pendidikan Nasional Republik Indonesia<br>\r\n<b>Nomor: {$d['NOMBAMSPST']}  </b>\r\n      \r\n       </font>\r\n      <br><br>\r\n    </td>\r\n    </tr>    \r\n    \r\n\r\n    \r\n    <tr >\r\n    <td align=center style=' font-size:14pt;' class=loseborder >\r\n       Dengan ini menyatakan bahwa :  \r\n      <br><br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n    <td align=center style=' font-size:12pt;' class=loseborder>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:28pt;'>\r\n      {$d['NAMA']}</font><br><br>\r\n      <!-- <b>NPM : <i>{$d['ID']}</i></b> <br><br> -->\r\n        <font style='  font-size:12pt;'>\r\n      lahir di {$d['TEMPAT']} tanggal {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      telah  dinyatakan lulus pada Program Studi {$d['NAMAP']} \r\n      sehingga kepadanya diberikan <br><br>\r\n      \r\n      <font style=' font-size:30pt; font-family:Cambria;'>\r\n      I J A Z A H\r\n      </font> <br><br>\r\n\r\n      \r\n      Dengan sebutan <br><br>\r\n      </b>\r\n      <font style=' font-size:24pt;'>\r\n      {$d['GELAR']}\r\n      </font>\r\n       <font style=' font-size:12pt;'>\r\n      <br><br>\r\n      Beserta segala hak dan kewajiban yang berhubungan dengan sebutan profesi tersebut.\r\n      <br>\r\n      Diberikan di Jakarta pada tanggal {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    <br><br>\r\n    <table width=800>\r\n      <tr valign=top>\r\n        <td width=70% class=loseborder>\r\n          <br>Ketua,\r\n          <br><br><br><br><br><br>\r\n          <font style='font-family:Monotype Corsiva;font-size:18px;'>{$d2['REKTOR']}<font>\r\n        </td>\r\n        <td  class=loseborder>\r\n        {$d['FOTO']}\r\n        </td>\r\n        <td width=30% class=loseborder>\r\n          ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}, <br>\r\n          <i>\r\n          Puket 1 Bidang Akademik,\r\n          <br><br><br><br><br><br>\r\n           <font style='font-family:Monotype Corsiva;font-size:18px;'>{$d['NAMAPUKET1AKADEMIK']}<font> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n    </center>\r\n    \r\n    ";
?>