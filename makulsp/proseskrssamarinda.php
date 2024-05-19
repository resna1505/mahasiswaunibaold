<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.bordertop {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\twidth:600px;\r\n\t}\r\n\r\n.bordertop td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tfont-size:12px;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.makeborder td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n</style>\r\n\r\n\r\n";
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
echo "\r\n<table width=100% style='page-break-after:always;'  >\r\n \r\n  <tr>\r\n    <td align=center colspan=2 style= border:none;>\r\n\r\n\r\n    <div align=center >\r\n    <table width=100%>\r\n    <tr>\r\n    <td  class=loseborder><img src='../kartu/logosamarinda.jpg'   height=100>\r\n    </td>\r\n    <td nowrap align=center  class=loseborder style='font-weight:bold;font-size:12pt;'> \r\n    <font style='font-family:Bodoni MT Black;font-size:18pt'>SEKOLAH TINGGI ILMU KESEHATAN MUHAMMADIYAH SAMARINDA</font><BR>\r\n    <font style='font-family:Book Antiqua;font-size:16pt'>Jln. Ir. H. Juanda No. 15 Tlp. 0541-748511</font><BR>\r\n        <font style='font-family:Bodoni MT Black;font-size:18pt'>S A M A R I N D A</font><br>\r\n        <font style='font-family:Bodoni MT Black;font-size:18pt'>KARTU RENCANA STUDI SEMESTER PENDEK</font>\r\n    </td></tr></table>\r\n    </div>    \r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center width=300 style= border:none;>\r\n    &nbsp;\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n\r\n<!--\r\n    <table width=100% class= makeborder>\r\n    ";
if ( $NOLABELFAKULTAS != 1 && $POLTITEKNIK == 0 )
{
    echo "\r\n      <tr>\r\n        <td width=20%>FAKULTAS</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>";
}
echo "\r\n    </table>\r\n\r\n-->\r\n    <table  width=100% class= makeborder>\r\n      <tr>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td width=20%>Nomor Induk Mahasiswa</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Program Studi</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]." {$d['NAMAP']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=3 ><b style='font-family: Book Antiqua;font-size:16pt;  '>MATA KULIAH YANG AKAN DIAMBIL</td>\r\n       </tr>   \r\n \r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style= border:none;>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmksp.*,\r\n\t\t\t\ttbkmksp.NAKMKTBKMK  AS NAMA,tbkmksp.NODOSTBKMK  ,\r\n\t\t\t\tSKSMAKUL AS SKS,\r\n\t\t\t\tjadwalkuliahkurikulum.HARI,\r\n\t\t\t\tjadwalkuliahkurikulum.JAM,\r\n\t\t\t\tjadwalkuliahkurikulum.JAMSELESAI,\r\n\t\t\t\tjadwalkuliahkurikulum.RUANGAN\r\n\t\t\t\tFROM msmhs,tbkmksp,pengambilanmksp LEFT JOIN jadwalkuliahkurikulum ON\r\n\t\t\t\t(\r\n        pengambilanmksp.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND\r\n        pengambilanmksp.TAHUN=jadwalkuliahkurikulum.TAHUN AND\r\n        pengambilanmksp.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND\r\n        pengambilanmksp.KELAS=jadwalkuliahkurikulum.KELAS AND\r\n        pengambilanmksp.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND\r\n        SUBSTR(pengambilanmksp.JAM,1,8)=jadwalkuliahkurikulum.JAM AND \r\n\t\t\t\tjadwalkuliahkurikulum.IDPRODI='{$d['IDPRODI']}'\r\n        )\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmksp.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmksp.THNSM=tbkmksp.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmksp.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmksp.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmksp.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n        <br><Br> \r\n      <table {$border} class=data{$cetak} width=100% cellpadding=0 cellspacing=0 >\r\n        <tr align=center>\r\n          <td style=background-color:1px solid #000;><b>NO</td>\r\n          <td><b>KODE MK</td>\r\n          <td><b>MATA KULIAH</td>\r\n          <td><b>SKS</td>\r\n          \r\n          <td ><b>DOSEN PENGAMPU</td>\r\n  \r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        $dosenpengampu = getnamafromtabel( $d2[NODOSTBKMK], "dosen" );
        echo "\r\n        <tr class='trborderthin'>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>      \r\n\r\n          <td align=left>{$dosenpengampu}</td> \r\n          \r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS YANG DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td> \r\n        </tr>\r\n      ";
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
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=30% style= 'border:none;' class=loseborder> \r\n        Pembimbing Akademik\r\n        <br><br><br><br>  \r\n        ".getnamafromtabel( $dosenwali, "dosen" )."<br>\r\n        NIDN {$dosenwali}<br>\r\n        </td>\r\n \r\n        <td class=loseborder></td>\r\n \r\n        <td width=30% style = 'border:none;' class=loseborder>Samarinda, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n        <br>\r\n        Mahasiswa<br><br><br><br>  \r\n        {$d['NAMA']}<br>\r\n        {$d['ID']}<br>\r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
?>
