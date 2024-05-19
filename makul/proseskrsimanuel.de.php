<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

getpenandatangan( );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
echo "\r\n<table width=800 style='page-break-after:always;'>\r\n   <tr>\r\n    <td align=center colspan=2><br><b>KARTU RENCANA STUDI (KRS)<br><br></td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center>\r\n    \r\n    <table width=100% >\r\n      <tr>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n       <tr>\r\n        <td>Semester</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Nama Wali</td>\r\n        <td>:</td>\r\n        <td>".$arraydosen[$d[IDDOSEN]]."</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center>\r\n    <table  >\r\n      <tr>\r\n        <td>NIM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n       <tr>\r\n        <td>Jurusan</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]." {$d['NAMAP']}</td>\r\n      </tr>\r\n  \r\n\r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr valign=top>\r\n    <td colspan=2 align=center>\r\n    <table width=100%>\r\n    <tr valign=top>\r\n    <td width=80%>\r\n    \r\n    \r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.* ,\r\n \t\t\t\tSKSMAKUL AS SKS,\r\n \t\t\t\ttbkmk.NAKMKTBKMK AS NAMA \r\n\t\t\t\tFROM pengambilanmk,tbkmk,msmhs\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n       <table border=1 width=100% style='border-collapse:collapse;'>\r\n        <tr align=center style='font-weight:bold;'>\r\n          <td rowspan=2>Nomor</td>\r\n          <td colspan=2>Mata Kuliah</td>\r\n           <td rowspan=2>Kredit</td>\r\n         </tr>\r\n        <tr align=center style='font-weight:bold;'>\r\n           \r\n          <td>Kode </td>\r\n          <td>Nama</td>\r\n           \r\n         </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr>\r\n          <td align=center>{$i}</td>\r\n          <td>{$d2['IDMAKUL']}</td>\r\n          <td nowrap>{$d2['NAMA']}</td>\r\n          <td align=center>{$d2['SKS']}</td>\r\n          </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3 align=right><b>JUMLAH  </td>\r\n          <td align=center><b>{$totalsks}</td>\r\n            \r\n        </tr>\r\n      ";
    echo "</table>";
}
echo "\r\n      <br><br>\r\n       <table border=1 width=100% style='border-collapse:collapse;'>\r\n        <tr align=center style='font-weight:bold;'>\r\n          <td rowspan=2>Nomor</td>\r\n          <td colspan=2>Mata Kuliah</td>\r\n           <td rowspan=2>Kredit</td>\r\n         </tr>\r\n        <tr align=center style='font-weight:bold;'>\r\n           \r\n          <td>Kode </td>\r\n          <td>Nama</td>\r\n           \r\n         </tr>\r\n      ";
$ii = 1;
while ( $ii <= 5 )
{
    echo "\r\n        <tr>\r\n          <td align=center width=10%>&nbsp;</td>\r\n          <td width=15%>&nbsp;</td>\r\n          <td nowrap>&nbsp;</td>\r\n          <td align=center width=10%>&nbsp;</td>\r\n          </tr>\r\n      ";
    ++$ii;
}
echo "\r\n        <tr>\r\n          <td colspan=3 align=right><b>JUMLAH  </td>\r\n          <td align=center><b> </td>\r\n            \r\n        </tr>\r\n      ";
echo "</table>";
echo "\r\n    </td>\r\n    <td valign=top>\r\n      <table border=1 width=90% cellpadding=8>\r\n        <tr valign=middle align=center>\r\n          <td>KRS</td>\r\n          <td>PKRS</td>\r\n        </tr>\r\n        <tr valign=middle align=center>\r\n          <td>Tandatangan</td>\r\n          <td>Paraf</td>\r\n        </tr>\r\n        <tr valign=bottom align=center>\r\n          <td><br><br><br>Mahasiswa</td>\r\n          <td><br><br><br>Mahasiswa</td>\r\n        </tr>\r\n        <tr valign=bottom align=center>\r\n          <td><br><br><br>Wali</td>\r\n          <td><br><br><br>Wali</td>\r\n        </tr>\r\n        <tr valign=bottom align=center>\r\n          <td><br><br><br>SBA</td>\r\n          <td><br><br><br>SBA</td>\r\n        </tr>\r\n      </table>\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    \r\n    ";
$q = "SELECT penandatangan.* from penandatangan,mahasiswa \r\n   WHERE \r\n   mahasiswa.IDPRODI=penandatangan.IDPRODI AND\r\n   mahasiswa.ID='{$idmahasiswaupdate}'";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    if ( $dttd[JABATAN2] != "" && $dttd[NAMA2] != "" )
    {
        $jabatanbaak = $dttd[JABATAN2];
        $namabaak = $dttd[NAMA2];
    }
}
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2>\r\n    <br><Br><Br>\r\n    <table  width=100%>\r\n      <tr valign=top>\r\n        <td width=30%>{$jabatanbaak}\r\n        <br><br><br><br><br><br>\r\n        {$namabaak}\r\n        </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30%>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n        <br><br><br><br><br><br> \r\n        {$d['NAMA']}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
?>
