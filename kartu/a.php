<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n* {\r\n\tmargin:0px;\r\n\tpadding:0px;\r\n\t}\r\n\r\n.deleteborder td {\r\n\tborder:none;\r\n\tpadding:0px 5px;\r\n\t}\r\n\r\n</style>\r\n\r\n";
@touch( "../nilai/ttd.cfg" );
$arrayttd = file( "../nilai/ttd.cfg" );
$nipdirektur = trim( $arrayttd[0] );
$namadirektur = trim( $arrayttd[1] );
$nipkabag = trim( $arrayttd[2] );
$namakabag = trim( $arrayttd[3] );
$jabatandirektur = trim( $arrayttd[4] );
$jabatankabag = trim( $arrayttd[5] );
$namabaak = trim( $arrayttd[6] );
$jabatanbaak = trim( $arrayttd[7] );
$nipbaak = trim( $arrayttd[8] );
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,mspst,departemen LEFT JOIN fakultas on\r\n departemen.IDFAKULTAS=fakultas.ID\r\n\r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\n AND\r\nmspst.IDX=prodi.ID\r\nAND mahasiswa.ID='{$idmahasiswaupdate}'\r\n ";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
}
echo "\r\n<table width=100% style='page-break-after:always;'>\r\n<!--  <tr>\r\n    <td align=center colspan=2 style=border:none;><b>{$namakantor}</td>\r\n  </tr>\r\n  -->\r\n  <tr>\r\n    <td align=center colspan=2 style=border:none;><br><b>KARTU UJIAN {$jenis} ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}<br><br></td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center style=border:none;>\r\n    \r\n    <table width=100% class=deleteborder >\r\n      <tr>\r\n        <td width=20%>NPM</td>\r\n        <td>:</td>\r\n        <td>{$idmahasiswaupdate}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>NAMA</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMA']}</td>\r\n      </tr>\r\n      <tr>\r\n        <td>TA</td>\r\n        <td>:</td>\r\n        <td>".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}</td>\r\n      </tr>\r\n    </table>\r\n    \r\n    </td>\r\n    <td align=center style=border:none;>\r\n    <table  width=100% class=deleteborder>\r\n    ";
if ( $NOLABELFAKULTAS != 1 )
{
    echo "\r\n      <tr>\r\n        <td width=20%>FAKULTAS </td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAF']}</td>\r\n      </tr>\r\n      ";
}
echo "\r\n      <tr>\r\n        <td>JURUSAN</td>\r\n        <td>:</td>\r\n        <td>{$d['NAMAP']}</td>\r\n      </tr>\r\n        <tr>\r\n        <td>JENJANG</td>\r\n        <td>:</td>\r\n        <td>".$arrayjenjang[$d[TINGKAT]]."</td>\r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n\r\n\r\n  </tr>\r\n  <tr>\r\n    <td colspan=2 align=center style=border:none;>\r\n    ";
$q = "SELECT tbkmk.NAKMKTBKMK NAMA,makul.ID,\r\n      mspst.IDX AS IDPRODI,\r\n     tbkmk.*,SKSMKTBKMK AS SKS ,     \r\n      SEMESTBKMK  +0 AS SEMESTER ,\r\n prodi.NAMA as NAMAP ,prodi.TINGKAT,prodi.ID AS IDPRODI,\r\n  \r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n      \r\n      FROM makul,mspst,tbkmk, prodi,departemen LEFT JOIN fakultas ON departemen.IDFAKULTAS=fakultas.ID\r\n      \r\n\tWHERE \r\n  makul.ID=tbkmk.KDKMKTBKMK AND\r\n \r\n  mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n  mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n  mspst.KDPTIMSPST=tbkmk.KDPTITBKMK\r\n  AND makul.ID='{$idmakulupdate}'\r\nAND mspst.IDX=prodi.ID\r\nAND departemen.ID=prodi.IDDEPARTEMEN\r\nAND tbkmk.THSMSTBKMK='".( $tahunupdate - 1 )."{$semesterupdate}'\r\nAND mspst.IDX='{$idprodiupdate}'\r\n  ";
$q = "\r\n    \t\tSELECT \r\n\t\t\t\tpengambilanmk.*,tbkmk.NAKMKTBKMK NAMA,\r\n \t\t\t\tSKSMAKUL AS SKS\r\n\t\t\t\tFROM pengambilanmk,mspst,tbkmk\r\n\t\t\t\tWHERE\r\n\r\n        mspst.KDPSTMSPST=tbkmk.KDPSTTBKMK AND\r\n        mspst.KDJENMSPST=tbkmk.KDJENTBKMK AND\r\n        mspst.KDPTIMSPST=tbkmk.KDPTITBKMK AND\r\n         mspst.IDX='{$d['IDPRODI']}' AND\r\n        pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK AND\r\n        pengambilanmk.THNSM=tbkmk.THSMSTBKMK AND\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$idmahasiswaupdate}'\r\n \t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.IDMAKUL\r\n\r\n    ";
$h2 = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h2 ) )
{
    $semesterx = ( $tahunupdate - 1 - $d[ANGKATAN] ) * 2 + $semesterupdate;
    echo "\r\n        <br><br>\r\n      <table {$border} class=data{$cetak} width=100%>\r\n        <tr align=center style='font-weight:bold;'>\r\n          <td>NO</td>\r\n          <td>KODE MK</td>\r\n          <td>MATA KULIAH</td>\r\n          <td>SKS</td>\r\n          <td>SMT</td>\r\n          <td>KELAS</td>\r\n          <td>TT. PENGAWAS</td>\r\n        </tr>\r\n      ";
    $i = 0;
    $totalsks = 0;
    while ( $d2 = sqlfetcharray( $h2 ) )
    {
        ++$i;
        echo "\r\n        <tr>\r\n          <td align=center>{$i}&nbsp;</td>\r\n          <td>{$d2['IDMAKUL']}&nbsp;</td>\r\n          <td nowrap>{$d2['NAMA']}&nbsp;</td>\r\n          <td align=center>{$d2['SKS']}&nbsp;</td>\r\n          <td align=center>{$d2['SEMESTERMAKUL']}&nbsp;</td>\r\n          <td align=center>{$d2['KELAS']}&nbsp;</td>\r\n          <td>&nbsp;</td>\r\n        </tr>\r\n      ";
        $totalsks += $d2[SKS];
    }
    echo "\r\n        <tr>\r\n          <td colspan=3><b>JUMLAH SKS DIAMBIL</td>\r\n          <td align=center><b>{$totalsks}</td>\r\n          <td ></td>\r\n          <td></td>\r\n          <td></td>\r\n        </tr>\r\n      ";
    echo "</table>";
}
echo "\r\n    \r\n    </td>\r\n  </tr>\r\n  <tr valign=top>\r\n    <td align=center colspan=2 style=border:none;>\r\n    <br><Br><Br>\r\n    <table  width=100%>\r\n      <tr valign=top>\r\n        <td width=30% style=border:none;>\r\n        \r\n        \r\n        </td>\r\n \r\n        <td> </td>\r\n \r\n        <td width=30% style=border:none;>{$lokasikantor}, {$waktu['mday']} ".$arraybulan[$waktu[mon] - 1]." {$waktu['year']}<br>\r\n        {$jabatanbaak}\r\n        <br><br><br><br><br><br> \r\n        {$namabaak}\r\n        \r\n        </td>\r\n \r\n      </tr>\r\n \r\n    </table>\r\n    \r\n    </td>\r\n \r\n\r\n\r\n  </tr>  \r\n<table>\r\n";
?>
