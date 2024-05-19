<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tfont-family:Arial, Helvetica, sans-serif;\t\r\n\t}\r\n\r\ntd {border:none;}\r\n\t\r\n.wrapper {\r\n\tposition:relative;\r\n\t}\t\r\n\t\r\n.line {\r\n\tposition:absolute;\r\n\tbottom:40px;\r\n\twidth:100%;\r\n\t}\r\n\t\r\n.makeborder td {\r\n\tborder:none;\r\n\tpadding:2px;\r\n\t}\r\n\t\r\n.wrapheader {width:920px; position:relative; display:inline-block; margin:auto;}\t\r\n\r\n.loseborder { font-family: \"Arial Narrow\", Arial, ";
echo "sans-serif;}\r\n\t\r\n.loseborder img {position:relative; left:-10px; top:-30px;}\r\n\r\n.borderline {\r\n\twidth:920px;\r\n\tborder-top:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\t\r\n.borderline td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-right:1px solid black;\r\n\tpadding:10px 2px;\r\n\t}\r\n\t\r\n</style>\r\n\r\n\r\n";
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
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,departemen.NAMA AS NAMAJ,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
echo "\r\n<center>\r\n<table width=98% style='page-break-after:always;'  >\r\n \r\n \r\n  <tr valign=top>\r\n  \r\n  <td align=center style= border:none;>\r\n  \t\r\n\t<div class=wrapheader>\r\n \r\n\r\n  \t<table class='makeborder' style='float:left;';>\r\n\t\t<tr valign=top>\r\n\t\t<td align=left style= border:none;>\r\n    <table  width=400 class= makeborder>\r\n      <tr>\r\n        <td>Fakultas</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td width=40% nowrap>Jurusan</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAJ']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Program Studi</td>\r\n        <td>:</td>\r\n        <td> {$d['NAMAP']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Jenjang</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]."  </td>\r\n      </tr>\r\n      <tr>\r\n        <td>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr> \r\n    </table>\r\n \r\n    </td>\r\n\t\t<td align=left style= border:none;>\r\n\r\n    <table  width=400 class= makeborder>\r\n      <tr>\r\n        <td width=40% nowrap>NIM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Nama </td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>Angkatan</td>\r\n        <td>:</td>\r\n        <td>{$d['ANGKATAN']}</td>\r\n      </tr>";
$tahunlalu = $tahunupdate;
$semesterlalu = $semesterupdate;
if ( $semesterlalu == 1 )
{
    $semesterlalu = 2;
    $tahunlalu = $tahunlalu - 1;
}
else
{
    $semesterlalu = 1;
}
$ipslalu = "-";
$ipklalu = "-";
$q = "SELECT * FROM trakm WHERE NIMHSTRAKM='{$idmahasiswaupdate}' AND THSMSTRAKM='{$tahunlalu}{$semesterlalu}'";
$hlalu = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $hlalu ) )
{
    $dlalu = sqlfetcharray( $hlalu );
    $ipslalu = $dlalu[NLIPSTRAKM];
    $ipklalu = $dlalu[NLIPKTRAKM];
}
echo "\r\n      <tr>\r\n        <td>IP Semester Lalu</td>\r\n        <td>:</td>\r\n        <td>{$ipslalu} </td>\r\n      </tr>\r\n      <tr>\r\n        <td>IP Kumulatif</td>\r\n        <td>:</td>\r\n        <td>{$ipklalu} </td>\r\n      </tr>\r\n    </table>\r\n    </td>\r\n\t\t</tr>\r\n\t</table>\r\n\t</div>\r\n  </td>\t\r\n  </tr>\r\n  <!-- \r\n\t\t<tr>\r\n\t\t\t<td colspan=3 align=center style='border:none; font-family: Book Antiqua;font-size:16pt;'>MATA KULIAH YANG AKAN DIAMBIL</td>\r\n\t\t</tr>\r\n  </tr>\r\n  -->\r\n  <tr>\r\n    <td colspan=3 align=center style= border:none;>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMA,tbkmk.NODOSTBKMK  ,\r\n\t\t\t\tSKSMAKUL AS SKS,\r\n\t\t\t\tjadwalkuliahkurikulum.HARI,\r\n\t\t\t\tjadwalkuliahkurikulum.JAM,\r\n\t\t\t\tjadwalkuliahkurikulum.JAMSELESAI,\r\n\t\t\t\tjadwalkuliahkurikulum.RUANGAN\r\n\t\t\t\tFROM msmhs,tbkmk,pengambilanmk LEFT JOIN jadwalkuliahkurikulum ON\r\n\t\t\t\t(\r\n        pengambilanmk.IDMAKUL=jadwalkuliahkurikulum.IDMAKUL AND\r\n        pengambilanmk.TAHUN=jadwalkuliahkurikulum.TAHUN AND\r\n        pengambilanmk.SEMESTER=jadwalkuliahkurikulum.SEMESTER AND\r\n        pengambilanmk.KELAS=jadwalkuliahkurikulum.KELAS AND\r\n        pengambilanmk.JENISKELAS=jadwalkuliahkurikulum.JENISKELAS AND\r\n        SUBSTR(pengambilanmk.JAM,1,8)=jadwalkuliahkurikulum.JAM AND \r\n\t\t\t\tjadwalkuliahkurikulum.IDPRODI='{$d['IDPRODI']}'\r\n        )\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n      <table class=borderline cellpadding=0 cellspacing=0 >\r\n        <tr align=center>\r\n          <td style=background-color:1px solid #000;><b>NO</td>\r\n          <td><b>KODE </td>\r\n          <td><b>MATA KULIAH</td>\r\n          <td><b>SKS</td>\r\n          <td><b>SMT</td>\r\n          \r\n          <td ><b>KETERANGAN</td>\r\n  \r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr class='trborderthin'>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>      \r\n\r\n          <td align=center>{$semesterx}</td> \r\n          <td align=left>&nbsp;</td> \r\n          \r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3 align=center><b>JUMLAH SKS YANG DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td>           <td >&nbsp;</td> \r\n        </tr>\r\n      ";
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
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center class=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=920 >\r\n      <tr valign=top>\r\n        <td width=50% style= 'border:none;' class=loseborder align=left> \r\n        Penasihat Akademik\r\n        <br><br><br><br><br>\r\n        ".getnamafromtabel( $dosenwali, "dosen" )."<br>\r\n        NIDN {$dosenwali}<br>\r\n        </td>\r\n \r\n        <td class=loseborder ></td>\r\n \r\n        <td width=20% style = 'border:none;' class=loseborder align=left>Pekanbaru, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}\r\n        <br>\r\n        Mahasiswa<br><br><br><br><br>\r\n        {$d['NAMA']}<br>\r\n        {$d['ID']}<br>\r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n</center>\r\n";
?>
