<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.bordertop {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\twidth:700px;\r\n\t}\r\n\r\n.bordertop td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tfont-size:12px;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.makeborder td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n</style>\r\n\r\n\r\n";
periksaroot( );
getpenandatangan( );
$q = "SELECT penandatanganumum.FILE4 from penandatanganumum \r\n   WHERE ID=0";
$httd = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $httd ) )
{
    $dttd = sqlfetcharray( $httd );
    $gambarttd = $dttd[FILE4];
    $field = "FILE4";
    $idprodix = "";
}
unset( $dttd );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
echo "\r\n<center>\r\n<table width=700 style='page-break-after:always;'>\r\n <!-- <tr>\r\n    <td align=center colspan=2 style= border:none;><b>{$namakantor}</td>\r\n  </tr>\r\n -->\r\n  <tr>\r\n    <td align=center colspan=2 style= border:none;><br><b>KARTU RENCANA STUDI <br><br></td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none; width=50%>\r\n    \r\n    <table width=100% class= makeborder>\r\n    ";
if ( $NOLABELFAKULTAS != 1 && $POLTITEKNIK == 0 )
{
    echo "\r\n      <tr>\r\n        <td width=25%>FAKULTAS</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>";
}
echo "\r\n      <tr>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>JENJANG</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n      <tr>\r\n        <td>TA</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n    <table  width=100% class= makeborder>\r\n      <tr>\r\n        <td width=34%>NPM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>ANGKATAN</td>\r\n        <td>:</td>\r\n        <td>{$d['ANGKATAN']}</td>\r\n      </tr>\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td >IP ";
$q = "SELECT sksmaksimum.* \r\n            FROM sksmaksimum ,mahasiswa\r\n            WHERE \r\n            mahasiswa.IDPRODI=sksmaksimum.IDPRODI\r\n              AND mahasiswa.ID='{$idmahasiswaupdate}'\r\n            ";
$hs = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hs ) )
{
    $ds = sqlfetcharray( $hs );
    $sksmaksimum = $ds[SKS];
    $semesteracuan = $ds[SEMESTER];
}
$thnlalu = $tahunupdate - 1;
$semlalu = $semesterupdate;
if ( 0 < $semesteracuan )
{
    if ( $semlalu % 2 == 0 )
    {
        $thnlalu = $thnlalu - floor( $semesteracuan / 2 );
        if ( $semesteracuan % 2 == 0 )
        {
            $semlalu = 2;
        }
        else
        {
            $semlalu = 1;
        }
    }
    else
    {
        $thnlalu = $thnlalu - ceil( $semesteracuan / 2 );
        if ( $semesteracuan % 2 == 0 )
        {
            $semlalu = 1;
        }
        else
        {
            $semlalu = 2;
        }
    }
}
if ( $data[semester] == 2 )
{
    $tahunsemesterlalu = ( $data[tahun] - 1 )."1";
}
else
{
    $tahunsemesterlalu = ( $data[tahun] - 2 )."2";
}
$q = "\r\n    \t\t\tSELECT NLIPSTRAKM\r\n    \t\t\tFROM  trakm\r\n    \t\t\tWHERE\r\n    \t\t  NIMHSTRAKM='{$idmahasiswaupdate}' AND\r\n    \t\t  THSMSTRAKM<='{$thnlalu}{$semlalu}'\r\n    \t\t  ORDER BY THSMSTRAKM DESC LIMIT 0,1\r\n    \t\t  \r\n     \t\t";
$hip = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hip ) )
{
    $dip = sqlfetcharray( $hip );
    $ips = $dip[NLIPSTRAKM];
}
else
{
    $ips = "Tidak ada";
}
if ( 0 < $semesteracuan )
{
    echo "{$semesteracuan} Semester Lalu";
}
else
{
    echo "semester ini";
}
echo "</td>\r\n\t\t\t\t\t\t <td>:</td>\r\n             <td ><b>{$ips}</td>\r\n\t\t\t\t\t</tr>\r\n\r\n\r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style= border:none;>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS,\r\n\t\t\t\tjadwalkuliahkurikulum.HARI,\r\n\t\t\t\tjadwalkuliahkurikulum.JAM,\r\n\t\t\t\tjadwalkuliahkurikulum.JAMSELESAI,\r\n\t\t\t\tjadwalkuliahkurikulum.RUANGAN\r\n\t\t\t\tFROM msmhs,tbkmk,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON\r\n\t\t\t\t(\r\n        pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND\r\n        pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND\r\n        pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND\r\n        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND\r\n        pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND\r\n        SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND \r\n\t\t\t\tjadwalkuliahkurikulum.IDPRODI='{$d['IDPRODI']}'\r\n        )\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n        <br><Br> \r\n      <table class='bordertop' cellpadding=0 cellspacing=0 >\r\n        <tr align=center>\r\n          <td style=background-color:1px solid #000;>NO</td>\r\n          <td>KODE MK</td>\r\n          <td>MATA KULIAH</td>\r\n          <td>SKS</td>\r\n          ";
    if ( $STEIINDONESIA != 1 )
    {
        echo "\r\n          <td >SMT</td>\r\n          <td>KETERANGAN</td>";
    }
    else
    {
        echo "\r\n          <td>HARI</td>\r\n          <td>JAM</td>\r\n          <td>RUANGAN</td>\r\n          ";
    }
    echo "\r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr class='trborderthin'>\r\n          <td align=cente>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>          ";
        if ( $STEIINDONESIA != 1 )
        {
            echo "\r\n\r\n          <td align=center>{$semesterx}&nbsp;</td>\r\n\t\t  <td>&nbsp;</td>\r\n          ";
        }
        else
        {
            echo "\r\n          <td>{$d2['HARI']}&nbsp;</td>\r\n          <td>{$d2['JAM']}-{$d2['JAMSELESAI']}&nbsp;</td>\r\n          <td>{$d2['RUANGAN']}&nbsp;</td>\r\n\t\t  \r\n          ";
        }
        echo "\r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td> ";
    if ( $STEIINDONESIA != 1 )
    {
        echo "\r\n          <td >&nbsp;</td>\r\n          <td>&nbsp;</td>";
    }
    else
    {
        echo "\r\n          <td >&nbsp;</td>\r\n          <td>&nbsp;</td>          \r\n          <td>&nbsp;</td>\r\n          ";
    }
    echo "\r\n        </tr>\r\n      ";
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
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style= 'border:none;' class=loseborder>";
if ( $UNIVERSITAS != "UNILAK" )
{
    echo "{$jabatanbaak}";
    if ( $gambarttd == "" )
    {
        echo "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br>";
    }
    else
    {
        echo "\r\n\t\t\t\t\t\t\t\t<br>\r\n\t\t\t\t\t\t\t\t<img src='../nilai/lihat.php?idprodi={$idprodix}&field={$field}' height=80> \r\n\t\t\t\t\t\t\t\t ";
    }
    echo "\r\n                <br>\r\n        {$namabaak}\r\n        ";
}
else
{
    $q = "SELECT ID,NAMA FROM dosen WHERE ID='{$dosenwali}' ";
    $hd = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hd ) )
    {
        $dd = sqlfetcharray( $hd );
        $namadosenwali = $dd[NAMA];
        $nipdosenwali = $dd[ID];
    }
    echo "Diketahui,<br>Dosen Wali,";
    echo "\r\n    \t\t\t\t\t\t\t\t<br><br><br><br><br> ";
    echo "\r\n                    <br>\r\n            <u>{$namadosenwali}</u>\r\n            {$nipdosenwali}\r\n            ";
}
echo "\r\n        </td>\r\n \r\n        <td class=loseborder></td>\r\n \r\n        <td width=30% style = 'border:none;' class=loseborder>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n        <br><br><br><br><br><br> \r\n        {$d['NAMA']}&nbsp;\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table></center>\r\n";
?>
