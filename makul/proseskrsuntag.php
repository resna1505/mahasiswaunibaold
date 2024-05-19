<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\t\r\ntr.juduldatacetak, td {\r\n\tborder:none;\r\n\t}\r\n\r\n.bordertop {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\t}\r\n\r\n.bordertop td {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\tfont-size:12px;\r\n\tpadding:5px;\r\n\t}\r\n\t\r\n.makeborder td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n</style>\r\n\r\n\r\n";
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
$q = "SELECT mahasiswa.*,dosen.NAMA AS NAMADOSEN,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa LEFT JOIN dosen ON mahasiswa.IDDOSEN=dosen.ID\r\n \r\n \r\n \r\n ,prodi,mspst,departemen LEFT JOIN fakultas ON\r\n departemen.IDFAKULTAS=fakultas.ID\r\n \r\n \r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $dosenwali = $d[IDDOSEN];
}
echo "\r\n<table width=900 style='page-break-after:always;margin:auto;'>\r\n \r\n  <tr>\r\n    <td align=center colspan=2 style= border:none;>\r\n   <b style='font-size:18pt;'>KARTU RENCANA STUDI <br> (KRS) </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style= border:none;>\r\n    \r\n    <table width=100% class= makeborder>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>   \r\n      <tr>\r\n        <td   nowrap>No. Induk / NIRM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n       <tr>\r\n        <td  nowrap>Tahun Akademik</td>\r\n        <td>:</td>\r\n        <td> ".( $tahunupdate - 1 )."/{$tahunupdate} - ".$arraysemester[$semesterupdate]."</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style= border:none;>\r\n    <table  width=100% class= makeborder>\r\n       <tr>\r\n        <td>Fakultas</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']} </td>\r\n      </tr>\r\n       <tr>\r\n        <td>Jurusan</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']} / ".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n       <tr>\r\n        <td>P.A.</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMADOSEN']} </td>\r\n      </tr>\r\n\r\n     </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style= border:none;>\r\n    ";
$q = "\r\n    \t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\ttbkmk.NAKMKTBKMK  AS NAMA,\r\n\t\t\t\tSKSMAKUL AS SKS  \r\n\t\t\t\tFROM msmhs,tbkmk,pengambilanmk \r\n\t\t\t\t\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n\t\t\t\tAND pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  \r\n\t\t\t\tAND  pengambilanmk.THNSM=tbkmk.THSMSTBKMK  \r\n\t\t\t\tAND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\tAND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\r\n\t\t\t\tAND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA\r\n\r\n\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n     \r\n      <table class=bordertop width=100% cellpadding=0 cellspacing=0 >\r\n        <tr align=center>\r\n          <!-- <td  ><b>NO</td> -->\r\n          <td><b>KODE MK</td>\r\n          <td><b>MATA KULIAH</td>\r\n          <td><b>SKS</td>  \r\n          <td><b>NAMA DOSEN</td> \r\n          <td><b>KET</td> \r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        $namadosenpengajar = "";
        $q = "SELECT dosen.ID,dosen.NAMA FROM dosen,dosenpengajar\r\n        WHERE\r\n        dosen.ID=dosenpengajar.IDDOSEN AND\r\n        '{$d2['IDMAKUL']}'=dosenpengajar.IDMAKUL AND\r\n\t\t\t\t'{$d2['TAHUN']}'=dosenpengajar.TAHUN AND\r\n\t\t\t\t'{$d2['SEMESTER']}'=dosenpengajar.SEMESTER AND \r\n\t\t\t\t'{$d2['KELAS']}'=dosenpengajar.KELAS AND\r\n\t\t\t\tdosenpengajar.IDPRODI='{$d['IDPRODI']}'\r\n        LIMIT 0,1";
        $h3 = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h3 ) )
        {
            $d3 = sqlfetcharray( $h3 );
            $namadosenpengajar = $d3[NAMA];
        }
        echo "\r\n        <tr class='trborderthin'>\r\n          <!-- <td align=center>{$i}&nbsp;</td> -->\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>       \r\n \r\n\t\t  <td>{$namadosenpengajar}</td> \r\n\t\t  <td>&nbsp;</td> \r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=2><b>JUMLAH SKS </td>\r\n          <td align=center><b>{$totalsks}&nbsp;</td>  \r\n          <td >&nbsp;</td>\r\n          <td >&nbsp;</td>\r\n \r\n        </tr>\r\n      ";
    echo "</table>";
}
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style= border:none;>\r\n    <br>\r\n    <table  width=100% >\r\n      <tr valign=top>\r\n        <td width=50% style= 'border:none;' class=loseborder  align=center> \r\n        Tanda Tangan<br>\r\n        Penasehat Akademik\r\n        <br><br><br><br>\r\n        ( ";
if ( $d[NAMADOSEN] == "" )
{
    echo "\r\n        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  \r\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n        )";
}
else
{
    echo "{$d['NAMADOSEN']}";
}
echo "\r\n        </td>\r\n \r\n  \r\n \r\n        <td width=50% style = 'border:none;' class=loseborder   align=center>\r\n        Jakarta, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n         Mahasiswa \r\n                <br><br><br><br>\r\n        ( \r\n        \r\n        {$d['NAMA']}\r\n         )\r\n       \r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>";
echo "\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
?>
