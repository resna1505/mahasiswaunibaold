<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\t\r\n\r\n* {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.bordertop {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\twidth:700px;\r\n\t}\r\n\r\n.bordertop td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tfont-size:12px;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.makeborder td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n</style>\r\n\r\n";
getpenandatangan( );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n\r\n\r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
echo "\r\n<center>\r\n<table width=700 style='page-break-after:always;'>\r\n<!--  <tr>\r\n    <td align=center colspan=2 class=loseborder><b>{$namakantor}</td>\r\n  </tr>\r\n  -->\r\n  <tr>\r\n    <td align=center colspan=2><b style='font-size:24px;'>KARTU RENCANA STUDI <br><br></td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none;>\r\n    \r\n    <table class=loseborder width=100%>\r\n    ";
if ( $NOLABELFAKULTAS != 1 && $POLTITEKNIK == 0 )
{
    echo "\r\n      <tr>\r\n        <td width=17%>FAKULTAS</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>";
}
echo "\r\n      <tr>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>JENJANG</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n      <tr>\r\n        <td>TA</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none; >\r\n    <table class=loseborder width=100% >\r\n      <tr>\r\n        <td width=17%>NIM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>ANGKATAN</td>\r\n        <td>:</td>\r\n        <td>{$d['ANGKATAN']}</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style= border:none;>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmksp.*,\r\n\t\t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS,\r\n\t\t\t\tjadwalkuliahkurikulumsp.HARI,\r\n\t\t\t\tjadwalkuliahkurikulumsp.JAM,\r\n\t\t\t\tjadwalkuliahkurikulumsp.JAMSELESAI,\r\n\t\t\t\tjadwalkuliahkurikulumsp.RUANGAN\r\n\t\t\t\tFROM msmhs,tbkmksp,pengambilanmksp LEFT JOIN jadwalkuliahkurikulumsp ON\r\n\t\t\t\t(\r\n        pengambilanmksp.IDMAKUL=jadwalkuliahkurikulumsp.IDMAKUL AND\r\n        pengambilanmksp.TAHUN=jadwalkuliahkurikulumsp.TAHUN AND\r\n        pengambilanmksp.SEMESTER=jadwalkuliahkurikulumsp.SEMESTER AND\r\n        pengambilanmksp.KELAS=jadwalkuliahkurikulumsp.KELAS AND\r\n        pengambilanmksp.JENISKELAS=jadwalkuliahkurikulumsp.JENISKELAS AND\r\n        SUBSTR(pengambilanmksp.JAM,1,8)=jadwalkuliahkurikulumsp.JAM AND \r\n\t\t\t\tjadwalkuliahkurikulumsp.IDPRODI='{$d['IDPRODI']}'\r\n        )\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n        <br>\r\n      <table class='bordertop' cellpadding='0' cellspacing='0'>\r\n        <tr align=center class='trborderthin' style='font-weight:bold;'>\r\n          <td >NO</td>\r\n          <td >KODE MK</td>\r\n          <td >MATA KULIAH</td>\r\n          <td >SKS</td>\r\n          ";
    if ( $STEIINDONESIA != 1 )
    {
        echo "\r\n          <td >SMT</td>\r\n          <td >KETERANGAN</td>";
    }
    else
    {
        echo "\r\n          <td >HARI</td>\r\n          <td >JAM</td>\r\n          <td >RUANGAN</td>\r\n          ";
    }
    echo "\r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr>\r\n          <td align=center >{$i}&nbsp;</td>\r\n          <td >{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap >{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center >{$d2['SKS']}&nbsp;</td>";
        if ( $STEIINDONESIA != 1 )
        {
            echo "\r\n\r\n          <td align=center >{$semesterx}&nbsp;</td>\r\n          <td >&nbsp;</td>";
        }
        else
        {
            echo "\r\n          <td>{$d2['HARI']}&nbsp;</td>\r\n          <td>{$d2['JAM']}-{$d2['JAMSELESAI']}&nbsp;</td>\r\n          <td>{$d2['RUANGAN']}&nbsp;</td>\r\n          ";
        }
        echo "\r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>";
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
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style=border:none;>\r\n    <br><Br><Br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style=border:none;>";
if ( $UNIVERSITAS != "UNILAK" )
{
    echo "{$jabatanbaak}";
    if ( $gambarttd == "" )
    {
        echo "\r\n\t\t\t\t\t\t\t\t<br><br><br><br><br> <br><br>";
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
echo "\r\n        </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30% style=border:none;>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n        <br><br><br><br><br><br> \r\n        {$d['NAMA']}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table></center>\r\n";
?>
