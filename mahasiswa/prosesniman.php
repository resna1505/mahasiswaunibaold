<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata  '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $statusawal != "" )
{
    $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
    $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
    $href .= "statusawal={$statusawal}&";
    $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
}
if ( $status != "" )
{
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
    else
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
    }
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $tahuna != "" && $semestera != "" )
{
    $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
    $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
    $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
    $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
    $href .= "semestera={$semestera}&tahuna={$tahuna}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa ,msmhs \r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT NIMHSMSMHS,NMMHSMSMHS,KDJEKMSMHS,\r\n\tTPLHRMSMHS,DATE_FORMAT(TGLHRMSMHS,'%d-%m-%Y') AS TGLHRMSMHS,\r\n  STPIDMSMHS,SKSDIMSMHS,BTSTUMSMHS\r\n\t\r\n  FROM mahasiswa ,msmhs \r\n\tWHERE mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printjudulmenucetak( "**DAFTAR MAHASISWA BARU UNTUK PERMOHONAN NIMAN**" );
    $q = "SELECT NMDOSMSDOS,NMPTIMSPTI,NMPSTMSPST,KDPTIMSPST ,KDJENMSPST,KDPSTMSPST ,\r\n\t\t\tNOKPSMSPST,KOTAAMSPTI\r\n      FROM mspst,mspti , msdos\r\n      WHERE \r\n       \r\n      mspti.KDPTIMSPTI=mspst.KDPTIMSPST AND\r\n      msdos.NODOSMSDOS=NOKPSMSPST AND\r\n      IDX='{$idprodi}'";
    $hp = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $hp ) )
    {
        $dp = sqlfetcharray( $hp );
        $kodept = $dp[KDPTIMSPST];
        $kodejenjang = $dp[KDJENMSPST];
        $kodeps = $dp[KDPSTMSPST];
        $namaps = $dp[NMPSTMSPST];
        $namapt = $dp[NMPTIMSPTI];
        $nipketuaps = $dp[NOKPSMSPST];
        $namaketuaps = $dp[NMDOSMSDOS];
        $kotapt = $dp[KOTAAMSPTI];
    }
    printmesgcetak( "\r\n      <table>\r\n        <tr>\r\n          <td>PERGURUAN TINGGI</td>\r\n          <td>:</td>\r\n          <td>{$kodept} {$namapt}</td>\r\n        </tr>\r\n        <tr>\r\n          <td>PROGRAM STUDI</td>\r\n          <td>:</td>\r\n          <td>{$kodeps} {$namaps}</td>\r\n        </tr>\r\n        <tr>\r\n          <td>JENJANG</td>\r\n          <td>:</td>\r\n          <td>{$kodejenjang}-".$arrayjenjang[$kodejenjang]."</td>\r\n        </tr>\r\n        <tr>\r\n          <td>SEMESTER AWAL</td>\r\n          <td>:</td>\r\n          <td>{$tahuna}/{$semestera}</td>\r\n        </tr>\r\n      </table>\r\n      " );
    echo "\r\n \t\t\t<table cellpadding=2 cellspacing=2 style='border-collapse:collapse;' {$border} class=for{$aksi}>\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n\t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>NAMA MAHASISWA</td>\r\n\t\t\t\t<td>JK.</td>\r\n\t\t\t\t<td>TEMPAT LAHIR</td>\r\n\t\t\t\t<td>TGL. LAHIR</td>\r\n\t\t\t\t<td>STATUS</td>\r\n\t\t\t\t<td>SKS</td> \r\n\t\t\t\t<td>BATAS STUDI</td> \r\n\t\t\t\t<td>NIMAN</td> \r\n\t\t\t</tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $d[UMUR] <= 15 && $aksi != "cetak" )
        {
            $kelas = "style='background-color:#ffff00'";
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left> {$d['NIMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NMMHSMSMHS']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['KDJEKMSMHS']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['TPLHRMSMHS']}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['TGLHRMSMHS']}</td>\r\n \t\t\t\t\t<td align=left>".$arraystatusmhsbaru[$d[STPIDMSMHS]]."</td>\r\n \t\t\t\t\t<td align=center>{$d['SKSDIMSMHS']}</td> \r\n \t\t\t\t\t<td align=center>{$d['BTSTUMSMHS']}</td> \r\n \t\t\t\t\t<td align=left>{$d['NIMAN']}</td> \r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    echo "</table>\r\n    <br><br>\r\n      <table width=600>\r\n        <tr valign=top>\r\n          <td width=50%>\r\n          <br>Diperiksa dan Disetujui Oleh :\r\n          <br><br><br><br><br>\r\n          Ketua P.S. : {$namaketuaps} <br>\r\n          NIP {$nipketuaps}\r\n          </td>\r\n           \r\n          <td>{$kotapt}, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']} <br>\r\n          Diketahui Oleh :\r\n          <br><br><br><br><br>\r\n          Pemb./Wk.Bid.Akd.</td>\r\n        </tr>\r\n       </table>\r\n    \r\n    ";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
