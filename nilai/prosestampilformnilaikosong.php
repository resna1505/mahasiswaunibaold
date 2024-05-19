<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\ntd {\r\n\tborder:none;\r\n\tpadding:5px;\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\tfont-size:13px;\r\n\t}\r\n\t\r\n.tdborder {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n.makebordering {\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\t}\r\n\t\t\r\n.trborder td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r";
echo "\n\t\r\n\r\n</style>\r\n\r\n";
periksaroot( );
if ( $jenisusers == 1 && $aturaneditnilaidosen == 1 )
{
    $tanggalselesai = waktueditnilai( $tahunupdate, $semesterupdate, $idprodiupdate );
    $trtanggal = "\r\n          <tr>\r\n            <td><b>Batas Akhir Entri Nilai</td>\r\n            <td><b>: {$tanggalselesai}</td>\r\n          </tr>\r\n        ";
}
$q = "\r\n\t\t\t\tSELECT IDKONVERSI,SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
$hb = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
while ( !sqlnumrows( $hb ) || !( $db = sqlfetcharray( $hb ) ) )
{
    $arraybobotnilai["{$db['SIMBOL']}"] = "{$db['NILAI']}";
}
$q = "\r\n\t\t\t\tSELECT NLAKHTBBNL AS SIMBOL,BOBOTTBBNL AS NILAI,SYARAT \r\n        FROM tbbnl,mspst\r\n\t\t\t\tWHERE\r\n\t\t\t\ttbbnl.KDPTITBBNL=mspst.KDPTIMSPST AND\r\n\t\t\t\ttbbnl.KDJENTBBNL=mspst.KDJENMSPST AND\r\n\t\t\t\ttbbnl.KDPSTTBBNL=mspst.KDPSTMSPST AND\r\n\t\t\t\t\r\n\t\t\t\tTHSMSTBBNL='".( $tahunupdate - 1 )."{$semesterupdate}' AND\r\n \t\t\t\tIDX='{$idprodiupdate}'\r\n         ORDER BY BOBOTTBBNL DESC\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
unset( $arraybobotnilai );
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $arraybobotnilai["{$d['SIMBOL']}"] = "{$d['NILAI']}";
}
$q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t\t";
$h = mysqli_query($koneksi,$q);
unset( $arraybobotnilai );
while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
{
    $arraybobotnilai["{$d['SIMBOL']}"] = "{$d['NILAI']}";
}
if ( is_array( $arraybobotnilai ) )
{
    echo "\r\n          <script>\r\n            function setbobot(nilai,bobot) { ";
    foreach ( $arraybobotnilai as $k => $v )
    {
        echo "\r\n                if (nilai.value=='{$k}') {\r\n                  bobot.value='{$v}';\r\n                } else\r\n                ";
    }
    echo "\r\n               {\r\n               }\r\n            }\r\n          </script>\r\n          \r\n          ";
}
if ( $aksi != "cetak" )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
}
if ( $jenisusers == 1 )
{
    $iddosen = $users;
}
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi != "cetak" )
{
    printjudulmenu( "DAFTAR PENETAPAN NILAI AKHIR" );
    printmesg( $errmesg );
}
else
{
    include( "proseskop.php" );
    echo $tmpkop;
    printjudulmenucetak( "<center>DAFTAR PENETAPAN NILAI AKHIR" );
    printmesgcetak( $errmesg );
}
$q = "SELECT departemen.NAMA AS NAMADEP,fakultas.NAMA AS NAMAFAK\r\n     FROM prodi,departemen,fakultas\r\n     WHERE prodi.IDDEPARTEMEN=departemen.ID AND\r\n     departemen.IDFAKULTAS=fakultas.ID AND\r\n     prodi.ID='{$idprodiupdate}' ";
$hd = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
$dd = sqlfetcharray( $hd );
$namadepartemen = $dd[NAMADEP];
$namafak = $dd[NAMAFAK];
echo "\r\n    <table width=95% cellpading=0 cellspacing=0>\r\n    <tr><td width=55%>\r\n    <table  class=form> \r\n     {$trtanggal}\r\n     <tr>\r\n\t\t\t<td class=judulform>FAKULTAS</td>\r\n\t\t\t<td>:  {$namafak}</td>\r\n\t\t</tr>\r\n     <tr>\r\n\t\t\t<td class=judulform>JURUSAN</td>\r\n\t\t\t<td>:  {$namadepartemen}</td>\r\n\t\t</tr>\r\n     <tr>\r\n\t\t\t<td class=judulform>PROGRAM STUDI</td>\r\n\t\t\t<td>:  ".$arrayprodidep[$idprodiupdate]."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>SEMESTER/TAHUN AKADEMIK</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]." ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t</table>\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t<table  class=form> \r\n     <tr  >\r\n\t\t\t<td class=judulform>KODE MATA KULIAH</td>\r\n\t\t\t<td>: {$idmakulupdate} </td>\r\n\t\t</tr>\r\n     <tr  >\r\n\t\t\t<td class=judulform>NAMA MATA KULIAH</td>\r\n\t\t\t<td>:  ".getnamamk( "{$idmakulupdate}", "".( $tahunupdate - 1 )."{$semesterupdate}", $idprodiupdate )."</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>KELAS</td>\r\n\t\t\t<td>: {$kelasupdate}</td>\r\n\t\t</tr> \r\n        <tr class=judulform>\r\n\t\t\t<td class=judulform>DOSEN </td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr> \r\n\t\t</table>\r\n\t\t</td>\r\n\t\t</tr></table>\r\n\t\t";
$q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\t\t\t\tpengambilanmk.SIMBOL,pengambilanmk.BOBOT\r\n\t\t\t\tFROM mahasiswa,pengambilanmk \r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n \t\t\t\t{$qprodidep5}\r\n \r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t\t\t<table class=form >\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetaktampilformnilaikosong.php'>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
    }
    echo "<table {$border}  width=95% class= makebordering cellpading=0 cellspacing=0>";
    echo "\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td class='tdborder'>No</td>\r\n\t\t\t\t\t\t<td class='tdborder'>NIM</td>\r\n\t\t\t\t\t\t<td class='tdborder'>Nama</td>";
    echo "\r\n\t\t\t\t\t\t<td colspan=7 class='tdborder'>Nilai </td> \r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
    $i = 1;
    $totalbobot = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        if ( session_is_registered_sikad( "prodis" ) && $_SESSION[prodis] != "" )
        {
            $q = "SELECT COUNT(tbkmk.KDPSTTBKMK) AS JML \r\n             FROM tbkmk,msmhs WHERE\r\n \t\t\t\t       tbkmk.KDKMKTBKMK='{$idmakulupdate}'\r\n\t\t\t\t      AND tbkmk.THSMSTBKMK=concat('".( $tahunupdate - 1 )."','{$semesterupdate}')\r\n \t\t\t\t      AND msmhs.NIMHSMSMHS='{$d['ID']}'\r\n\t\t\t\t      AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK\r\n\t\t\t\t      AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK\t\t\t\t  \r\n              {$qprodideptbkmk}\r\n            ";
            $hxx = mysqli_query($koneksi,$q);
            $dxx = sqlfetcharray( $hxx );
            if ( $dxx[JML] <= 0 )
            {
                continue;
            }
        }
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t\t\t<tr class= trborder  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}&nbsp;</td>\r\n\t\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}&nbsp;</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}&nbsp;</td>";
        $totalnilaiakhir += $nilaiakhir;
        $simbolakhir = $d[SIMBOL];
        $nilaiekakhir = $d[BOBOT];
        echo "\r\n\t\t\t\t\t\t\t<td>A</td>\r\n\t\t\t\t\t\t\t<td>B</td>\r\n\t\t\t\t\t\t\t<td>C</td>\r\n\t\t\t\t\t\t\t<td>D</td>\r\n\t\t\t\t\t\t\t<td>E</td>\r\n\t\t\t\t\t\t\t<td>T</td>\r\n\t\t\t\t\t\t\t<td>K</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
        $totalbobotsemua += $nilaiekakhir;
        $totalbobot += $d[BOBOT];
        ++$i;
    }
    echo "</table>\r\n\t\t\t\t<br>\r\n\t\t\t\t<table width=95%>\r\n\t\t\t\t  <tr>\r\n\t\t\t\t  <td> REKAPITULASI DPNA </td>\r\n          </tr>\r\n\t\t\t\t  <tr>\r\n\t\t\t\t  <td> \r\n          NILAI A = .......... Orang <br>\r\n          NILAI B = .......... Orang <br>\r\n          NILAI C = .......... Orang <br>\r\n          NILAI D = .......... Orang <br>\r\n          NILAI E = .......... Orang <br>\r\n          NILAI T = .......... Orang <br>\r\n          NILAI K = .......... Orang <br>\r\n          </td>\r\n          </tr>\r\n\t\t\t\t</table>\r\n\t\t\t\t<br>\r\n\t\t\t\t<table width=95%>\r\n\t\t\t\t  <tr>\r\n\t\t\t\t  <td align=right>Penanggung Jawab Mata Kuliah </td>\r\n          </tr>\r\n\t\t\t\t  <tr>\r\n\t\t\t\t  <td align=right> \r\n              <br><br><br><br>\r\n               <u>{$iddosenupdate}</u><br>\r\n               ".getnamafromtabel( $iddosenupdate, "dosen" )."\r\n          </td>\r\n          </tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t<br><br>";
}
else
{
    $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
    printmesg( $errmesg );
}
?>
