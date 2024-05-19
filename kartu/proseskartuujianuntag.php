<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "\r\n    \t\tSELECT \r\n\t\t\t\tpengambilanmk.*,tbkmk.NAKMKTBKMK NAMA,\r\n \t\t\t\tSKSMAKUL AS SKS\r\n\t\t\t\tFROM pengambilanmk,mspst,tbkmk\r\n\t\t\t\tWHERE\r\n\r\n        mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n        mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n        mspst.KDPTIMSPST=tbkmk.KDPTITBKMK AND\r\n         mspst.IDX='{$d['IDPRODI']}' AND\r\n        pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK AND\r\n        pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n \t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n         \r\n      <table class=borderline width=700>\r\n        <tr style='align=center style='font-weight:bold;'>\r\n            <td  rowspan=2>NO</td>  \r\n          <td rowspan=2>KODE  </td>\r\n          <td rowspan=2>MATA KULIAH</td>\r\n            <td  rowspan=2>SKS</td>\r\n          <!-- <td>SMT</td> -->\r\n          <td  rowspan=2>RUANG</td>\r\n          <td>PARAF PENGAWAS</td>\r\n        </tr>\r\n\r\n        <tr>\r\n           <td>{$jenis}</td>\r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr>\r\n           <td align=center>{$i}</td>  \r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n           <td align=center>{$d2['SKS']}&nbsp;</td>\r\n          <!-- <td align=center>{$d2['SEMESTERMAKUL']}&nbsp;</td> -->\r\n          <td align=center>&nbsp;</td> \r\n          <td valign=bottom align=left>{$i}.....................</td> \r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n         \r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks} &nbsp;</td>\r\n          <td>&nbsp;</td>\r\n          <td>&nbsp;</td> \r\n         \r\n        </tr>\r\n        \r\n      ";
    echo "</table>";
}
echo "\r\n    \r\n \r\n \r\n    <table  width=700>\r\n\r\n            <tr valign=top>\r\n        <td width=30% align=center>\r\n          Mengetahui PA\r\n            <br><br><br><br> ";
if ( $d[NAMADOSEN] != "" )
{
    echo "\r\n              ({$d['NAMADOSEN']})    ";
}
else
{
    echo "\r\n              (\r\n              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \r\n              )    ";
}
echo "\r\n        \r\n          \r\n        </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30% nowrap align=center>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        {$jabatanbaak}\r\n        <br><br><br><br> \r\n        {$namabaak}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n       <tr valign=top>\r\n        <td colspan=3 align=left>\r\n           Catatan:\r\n           <ol>\r\n              <li>Kartu Ujian ini berlaku untuk satu semester</li>\r\n              <li>Tanpa memperlihatkan kartu ini mahasiswa tidak diperbolehkan mengikuti ujian </li>\r\n              <li>Kolom ruang diisi nomor ruang pada saat ujian oleh pengawas </li>\r\n              <li>Kolom tanda tangan didapat oleh pengawas ujian </li>\r\n             </ol>\r\n        </td>\r\n \r\n  \r\n      </tr>\r\n    </table>";
?>
