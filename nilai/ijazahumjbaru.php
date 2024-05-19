<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$akreditasi = 0;
$NO_SERIIJAZAH = $tglakreditasi2 = "";
$q = "SELECT NOIJATRLSM,TGLRETRLSM,KDJENTRLSM,KDPSTTRLSM FROM trlsm WHERE NIMHSTRLSM='{$d['ID']}' AND STMHSTRLSM ='L'";
$hi = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hi ) )
{
    $di = sqlfetcharray( $hi );
    $NO_SERIIJAZAH = $di[NOIJATRLSM];
    $tmpy = explode( "-", $di[TGLRETRLSM] );
    $tglyudisium = "{$tmpy['2']}-{$tmpy['1']}-{$tmpy['0']}";
    $q = "SELECT *,DATE_FORMAT(TGLBAMSPST,'%d-%m-%Y') AS TGL \r\n         ,DATE_FORMAT(TGLSKMSPST,'%d-%m-%Y') AS TGL2 FROM mspst WHERE  KDJENMSPST='{$di['KDJENTRLSM']}' AND  KDPSTMSPST='{$di['KDPSTTRLSM']}'";
    $hi = mysqli_query($koneksi,$q);
    $di = sqlfetcharray( $hi );
    echo mysqli_error($koneksi);
    if ( $di[KDSTAMSPST] != "" )
    {
        $akreditasi = 1;
        $terakreditasi = "\"Terakreditasi\"";
        $peringkatakreditasi = "{$di['KDSTAMSPST']}";
        $noakreditasi = $di[NOMBAMSPST];
        $tglakreditasi = "{$di['TGL']}";
        $tmptgl = explode( "-", $di[TGL] );
        $tglakreditasi2 = "{$tmptgl['0']} ".$arraybulan[$tmptgl[1] - 1]." {$tmptgl['2']}";
        $kodejenjangprodi = $di[KDJENMSPST];
    }
    else
    {
        $akreditasi = 0;
        $terakreditasi = "\"\"";
        $peringkatakreditasi = "";
        $noakreditasi = $di[NOMSKMSPST];
        $tglakreditasi = "{$di['TGL2']}";
        $tmptgl = explode( "-", $di[TGL2] );
        $tglakreditasi2 = "{$tmptgl['0']} ".$arraybulan[$tmptgl[1] - 1]." {$tmptgl['2']}";
        $kodejenjangprodi = $di[KDJENMSPST];
    }
}
$bodyijazah .= "\r\n    <center   style='page-break-after:always;'> \r\n    <table width=1000  >\r\n\r\n    <tr valign=top>\r\n    <td colspan=2 align=left   class=loseborder >\r\n      <b>Nomor Sertifikat : {$noseriijazah}</b>\r\n      <br><i>Certificate Number</i>\r\n      <br><br><br><br> <br><br> <br><br> \r\n      \r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td width=250 align=left  class=loseborder >\r\n      <b>Diberikan kepada</b>\r\n      <br><i>Conferred on</i>\r\n      </td>\r\n      <td  class=loseborder ><b> : {$d['NAMA']}</b>\r\n      \r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Tempat dan Tanggal Lahir</b>\r\n      <br><i>Place and Date of Birth</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: {$d['TEMPAT']}, {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}\r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Nomor Pokok Mahasiswa (NPM)</b>\r\n      <br><i>Student Registration Number</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: {$d['ID']} \r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Tanggal Kelulusan</b>\r\n      <br><i>Graduation Date</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}\r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Program Pendidikan</b>\r\n      <br><i>Degree Program</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: ".$arraynamajenjang[$d[TINGKAT]]."</b><br>\r\n      <i>&nbsp;&nbsp;{$d['NAMAJENJANG2']}</i>\r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Fakultas</b>\r\n      <br><i>Faculty</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: {$d['NAMAF']}</b><br>\r\n      <i>&nbsp;&nbsp;{$d['NAMAF2']}</i>\r\n    </td>\r\n    </tr>\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Program Studi</b>\r\n      <br><i>Study Program</i>\r\n      </td>\r\n      <td  class=loseborder >\r\n      <b>: {$d['NAMAP']}</b><br>\r\n      <i>&nbsp;&nbsp;{$d['NAMAP2']}</i>\r\n    </td>\r\n    </tr>\r\n\r\n    <tr valign=top>\r\n    <td align=left   class=loseborder >\r\n      <b>Status</b>\r\n      <br><i>Status</i>\r\n      </td>\r\n      <td  class=loseborder >";
if ( $akreditasi == 1 )
{
    $bodyijazah .= "\r\n        <b>: TERAKREDITASI</b><br>\r\n        <i>&nbsp;&nbsp;Accredited by</i>\r\n\r\n         \r\n        <br><b>&nbsp;&nbsp;DEPARTEMEN PENDIDIKAN NASIONAL REPUBLIK INDONESIA</b><br>\r\n        <i>&nbsp;&nbsp;The Department of Nasional Education of the Republic of Indonesia</i><br>\r\n\r\n        <b>&nbsp;&nbsp;BADAN AKREDITASI NASIONAL PERGURUAN TINGGI</b><br>\r\n        <i>&nbsp;&nbsp;Through the National Accreditation Board of Higher Education</i><br>\r\n\r\n        <b>&nbsp;&nbsp;NOMOR / TANGGAL   :  {$noakreditasi} / {$tglakreditasi2}</b><br>\r\n        <i>&nbsp;&nbsp;Number / Date</i><br>\r\n\r\n        ";
}
else
{
    $bodyijazah .= "\r\n        <b>: IJIN BERDASARKAN SURAT KEPUTUSAN</b><br>\r\n        <i>&nbsp;&nbsp;Permit Under the Decree of</i><br>\r\n        \r\n        <b>&nbsp;&nbsp;DIREKTORAT JENDERAL PENDIDIKAN TINGGI</b><br>\r\n        <i>&nbsp;&nbsp;Directorate General of Higher Education</i><br>\r\n\r\n        <b>&nbsp;&nbsp;DEPARTEMEN PENDIDIKAN NASIONAL REPUBLIK INDONESIA</b><br>\r\n        <i>&nbsp;&nbsp;The Department of National Education of the Republic of Indonesia</i><br>\r\n\r\n        <b>&nbsp;&nbsp;NOMOR / TANGGAL   :  {$noakreditasi} / {$tglakreditasi2}</b><br>\r\n        <i>&nbsp;&nbsp;Number / Date</i><br>\r\n        ";
}
$bodyijazah .= "\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n      <td align=left colspan=2 class=loseborder nowrap>\r\n\r\n        <b>Ijazah ini diserahkan setelah yang bersangkutan memenuhi semua persyaratan yang ditentukan dan kepadanya dilimpahkan segala wewenang</b><br>\r\n        <i>This degree is conferred affter the person mentioned has fulfilled all the neccessary requirements set forth by the University, with all the honor, previlige</i><br>\r\n        <b>hak, dan tanggung jawab yang berhubungan dengan ijazah yang dimilikinya, serta berhak memakai gelar akademik {$d['GELAR']}</b><br>\r\n        <i>right, and obligations pertaining to that degree, along with the right to use the degree of {$d['GELAR2']}</i>\r\n        \r\n      </td>\r\n    </tr>\r\n    <tr><td colspan=2 class=loseborder>\r\n      <table width=100%>\r\n      <tr valign=top>\r\n        <td width=50% class=loseborder>\r\n      \r\n          <br><b>Dekan,</b><br>\r\n          <i>Dean</i>\r\n          <br><br><br><br> \r\n          <b><U>{$d['DEKAN']}</U><br>\r\n          NIDN. {$d['NIPDEKAN']}</b>\r\n        </td>\r\n        <td  class=loseborder>\r\n      \r\n        </td>\r\n        <td width=30% class=loseborder>\r\n          ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}, <br>\r\n          <b> Rektor,</b><br>\r\n          <i>Rector</i>\r\n          <br><br><br><br> \r\n          <b><u>{$d2['REKTOR']}</u><br>\r\n          NIDN. {$d2['NIPREKTOR']}</b>\r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </td></tr></table>\r\n\r\n\r\n<!-- \r\n    <tr >\r\n    <td align=left style='font-family:  Monotype Corsiva;font-size:16pt;' class=loseborder >\r\n      <b>dengan ini menyatakan bahwa : </b>\r\n      <br><br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n    <td align=center style=' font-size:12pt;' class=loseborder>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:28pt;'>\r\n      {$d['NAMA']}</font><br><br>\r\n      <b>NPM : <i>{$d['ID']}</i></b> <br><br>\r\n        <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      lahir di {$d['TEMPAT']} tanggal {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      telah menyelesaikan dengan baik dan memenuhi segala syarat<br>\r\n      pendidikan pada Program Studi {$d['NAMAP']} <br>\r\n      Fakultas {$d['NAMAF']} <br>\r\n      Status terakreditasi nomor {$d['NOMBAMSPST']} <br>\r\n      Oleh sebab itu kepadanya diberikan gelar <br><br>\r\n      </b>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:24pt;'>\r\n      {$d['GELAR']}\r\n      </font>\r\n       <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      <br><br>\r\n      beserta segala hak dan kewajiban yang melekat pada gelar tersebut.\r\n      <br>\r\n      Tanggal kelulusan  {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    <br><br>\r\n    <table width=800>\r\n      <tr valign=top>\r\n        <td width=30% class=loseborder>\r\n        <i>\r\n          <br>Dekan,\r\n          <br><br><br><br><br><br>\r\n          <b><U>{$d['DEKAN']}</U><br>\r\n          {$d['NIPDEKAN']}</b>\r\n        </td>\r\n        <td  class=loseborder>\r\n        {$d['FOTO']} \r\n        </td>\r\n        <td width=30% class=loseborder>\r\n          ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}, <br>\r\n          <i>\r\n          Rektor,\r\n          <br><br><br><br><br><br>\r\n          <b><u>{$d2['REKTOR']}</u><br>\r\n          {$d2['NIPREKTOR']}</b>\r\n        </td>\r\n      </tr>\r\n      -->\r\n    </table>\r\n    </center>\r\n    \r\n    ";
?>
