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
$strikeit = "";
$lunas = 0;
$tampilkankartu = 1;
if ( $aturankeuangan == 3 && $aturankartuujian == 1 && ( $jenis == "UTS" || $jenis == "UAS" ) )
{
    $lunas = getstatusminimalpembayaranmahasiswa( $idmahasiswaupdate, $tahunupdate, $semesterupdate, $jenis );
    $tampilkankartu = 0;
    if ( 0 <= $lunas[LUNAS] )
    {
        $tampilkankartu = 1;
    }
}
getpenandatangan( );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,fakultas.*,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN ,\r\n dosen.NAMA AS NAMADOSEN\r\n FROM mahasiswa LEFT JOIN dosen ON\r\n      mahasiswa.IDDOSEN=dosen.ID\r\n ,prodi,mspst,departemen LEFT JOIN fakultas on\r\n departemen.IDFAKULTAS=fakultas.ID\r\n\r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\n AND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
echo "\r\n<div style='page-break-after:always'>\r\n<center>\r\n  \r\n";
if ( $UNIVERSITAS == "UNILAK" )
{
    include( "headerkartuujianunilak.php" );
}
else if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
{
    include( "headerkartuujianuniversitasborobudur.php" );
}
else if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
{
    include( "headerkartuujianuntag.php" );
}
else
{
    include( "headerkartuujian.php" );
}
if ( $tampilkankartu == 1 )
{
    if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
    {
        include( "proseskhsuniversitasborobudur.php" );
    }
    else
    {
        if ( $UNIVERSITAS == "UNIVERSITAS 17 AGUSTUS 1945" )
        {
            include( "proseskartuujianuntag.php" );
        }
        else
        {
            $q = "SELECT tbkmk.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmk.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n      \r\n      FROM makul,mspst,tbkmk, prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n  AND makul.ID='{$idmakulupdate}'\r\nAND mspst.IDX=prodi.ID\r\nAND departemen.ID=prodi.IDDEPARTEMEN\r\nAND tbkmk.THSMSTBKMK='".( $tahunupdate - 1 )."{$semesterupdate}'\r\nAND mspst.IDX='{$idprodiupdate}'\r\n  ";
            $q = "SELECT pengambilanmk.*,tbkmk.NAKMKTBKMK NAMA,SKSMAKUL AS SKS FROM pengambilanmk,mspst,tbkmk\r\n\t\t\t\tWHERE\r\n\r\n        mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n        mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n        mspst.KDPTIMSPST=tbkmk.KDPTITBKMK AND\r\n         mspst.IDX='{$d['IDPRODI']}' AND\r\n        pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK AND\r\n        pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n \t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
            $h2 = doquery($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h2 ) )
            {
                $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
                echo "\r\n         \r\n      <table class=borderline width=600>\r\n        <tr align=center style='font-weight:bold;'>\r\n          <td>NO</td>\r\n          <td>KODE MK</td>\r\n          <td>MATA KULIAH</td>\r\n          <td>SKS</td>\r\n          <td>SMT</td>\r\n          <td>KELAS</td>\r\n          <td>TT. PENGAWAS</td>\r\n        </tr>\r\n      ";
                $i = 0;
                $totalsks = 0;
                while ( $d2 = sqlfetcharray( $h2 ) )
                {
                    ++$i;
                    echo "\r\n        <tr>\r\n          <td align=center>{$i}</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>\r\n          <td align=center>{$d2['SEMESTERMAKUL']}&nbsp;</td>\r\n          <td align=center>{$d2['KELAS']}&nbsp;</td>\r\n          <td>&nbsp;</td>\r\n        </tr>\r\n      ";
                    $totalsks += $d2[SKS];
                }
                echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks} &nbsp;</td>\r\n          <td>&nbsp;</td>\r\n          <td>&nbsp;</td>\r\n          <td>&nbsp;</td>\r\n        </tr>\r\n      ";
                echo "</table>";
            }
            if ( $UNIVERSITAS == "UNILAK" )
            {
                include( "footerkartuujianunilak.php" );
            }
            else
            {
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
                echo "\r\n    \r\n \r\n    <br> \r\n    <table  width=600 border='1'>\r\n      <tr valign=top>\r\n        <td width=30%>    </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30% nowrap>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        {$jabatanbaak}\r\n        <br><br><br><br>\r\n        {$namabaak}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
            }
        }
    }
}
else
{
    echo "\r\n    <table border=1 style='border:solid;width:50%; border-color:#FF0000;'>\r\n      <tr align=center valign=middle>\r\n        <td style='font-size:16pt;color:#FF0000'>\r\n        <br><b>Mahasiswa ini belum melunasi kewajiban keuangan <br>\r\n        {$lunas['STATUS']}\r\n        <br><br></td>\r\n      <tr>\r\n      </table>  \r\n    ";
}
echo "\r\n    \r\n \r\n</center>\r\n</div>\r\n";
?>
