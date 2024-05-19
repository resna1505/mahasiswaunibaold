<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\ntd {border:none;}\r\n\r\n.borderline {\r\n\t  border-top:1px solid black;\r\n\t  border-right:1px solid black;\r\n\t  border-spacing:inherit;\r\n\t  }\r\n\t  \r\n.borderline td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n</style>\r\n";
getpenandatangan( );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas on\r\n departemen.IDFAKULTAS=fakultas.ID\r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\n mspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
echo "\r\n<div style='page-break-after:always'>\r\n<center><b>KARTU UJIAN {$jenis} ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}<br><br> ";
if ( $UNIVERSITAS == "UNILAK" )
{
    include( "../kartu/headerkartuujianunilak.php" );
}
else
{
    include( "../kartu/headerkartuujian.php" );
}
echo "\r\n \r\n    ";
$q = "\r\n    \t\tSELECT \r\n\t\t\t\tpengambilanmksp.*,tbkmksp.NAKMKTBKMK NAMA,\r\n \t\t\t\tSKSMAKUL AS SKS\r\n\t\t\t\tFROM pengambilanmksp,mspst,tbkmksp\r\n\t\t\t\tWHERE\r\n\r\n        mspst.KDPSTMSPST=tbkmksp.KDPSTTBKMK AND\r\n        mspst.KDJENMSPST=tbkmksp.KDJENTBKMK AND\r\n        mspst.KDPTIMSPST=tbkmksp.KDPTITBKMK AND\r\n         mspst.IDX='{$d['IDPRODI']}' AND\r\n        pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK AND\r\n        pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK AND\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswaupdate}'\r\n \t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n \r\n      <table class=borderline width=600>\r\n        <tr align=center style='font-weight:bold;'>\r\n          <td>NO</td>\r\n          <td>KODE MK</td>\r\n          <td>MATA KULIAH</td>\r\n          <td>SKS</td>\r\n          <td>SMT</td>\r\n          <td>KELAS</td>\r\n          <td>TT. PENGAWAS</td>\r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr>\r\n          <td align=center>{$i}</td>\r\n          <td>{$d2['IDMAKUL']}</td>\r\n          <td nowrap>{$d2['NAMA']}</td>\r\n          <td align=center>{$d2['SKS']}</td>\r\n          <td align=center>{$d2['SEMESTERMAKUL']}</td>\r\n          <td align=center>{$d2['KELAS']}</td>\r\n          <td></td>\r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}</td>\r\n          <td ></td>\r\n          <td></td>\r\n          <td></td>\r\n        </tr>\r\n      ";
    echo "</table>";
}
$q = "SELECT penandatangan.* from penandatangan,mahasiswa \r\n   WHERE \r\n   mahasiswa.IDPRODI=penandatangan.IDPRODI AND\r\n   mahasiswa.ID='{$idmahasiswaupdate}'";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    if ( $dttd[JABATAN2] != "" && $dttd[NAMA2] != "" )
    {
        $jabatanbaak = $dttd[JABATAN2];
        $namabaak = $dttd[NAMA2];
        $gambarttd = $dttd[FILE2];
        $idprodix = $dttd[IDPRODI];
        $field = "FILE2";
    }
}
if ( $UNIVERSITAS == "UNILAK" )
{
    include( "../kartu/footerkartuujianunilak.php" );
}
else
{
    echo "\r\n    \r\n \r\n    <table  width=600>\r\n      <tr valign=top>\r\n        <td width=30% style=border:none;>\r\n        \r\n        \r\n        </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30% style=border:none;>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        {$jabatanbaak}\r\n        <br><br><br><br><br><br> \r\n        {$namabaak}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
}
echo "\r\n    \r\n </center>\r\n</div>\r\n";
?>
