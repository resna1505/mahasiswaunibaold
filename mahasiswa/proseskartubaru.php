<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$konfigkartu = getsettingkartu( );
$gambarbackground = "";
include( "../fungsibarcode128.php" );
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 80 );
$stylecetak = " style='font-family:Arial;font-size:7pt;' ";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $jenisusers == 1 )
{
    $iddosen = $users;
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
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
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
include( "prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT KARTUMAHASISWA,JABATANKARTU,NAMAKARTU,FOTOKARTU FROM sistem LIMIT 0,1";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$kartumahasiswa = $d[KARTUMAHASISWA];
$jabatankartu = $d[JABATANKARTU];
$namakartu = $d[NAMAKARTU];
$fotokartu = $d[FOTOKARTU];
$templateasli = file_get_contents( "{$kartumahasiswa}.html" );
$q = "SELECT COUNT(*) AS JML FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs \r\n\tWHERE \r\n  mahasiswa.ID=msmhs.NIMHSMSMHS\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.TEMPAT,\r\n  DATE_FORMAT(mahasiswa.TANGGAL,'%d-%m-%Y') TANGGALLAHIR,prodi.TINGKAT, \r\n  mahasiswa.KELAMIN  \r\n  FROM {$qtabel2} mahasiswa LEFT JOIN mahasiswa2 ON mahasiswa.ID=mahasiswa2.ID,msmhs,prodi,departemen LEFT JOIN fakultas ON   \r\n  departemen.IDFAKULTAS=fakultas.ID \r\n\r\n\tWHERE 1=1 AND\r\n  mahasiswa.IDPRODI=prodi.ID AND\r\n  prodi.IDDEPARTEMEN=departemen.ID AND\r\n  msmhs.NIMHSMSMHS=mahasiswa.ID\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $baris = 0;
    $kolom = 0;
    do
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            $d2 = $d;
            ++$baris;
            $l = 1;
            createbarcode128( "{$d2['ID']}", "barcode/{$d2['ID']}", "B", 0 );
            $template = $templateasli;
            $template = str_replace( "<!--JABATANTTD-->", "{$jabatankartu}", $template );
            $template = str_replace( "<!--NAMATTD-->", "{$namakartu}", $template );
            $template = str_replace( "<!--LOGOKANTOR-->", "{$dirgambar}/{$logo['0']}", $template );
            $template = str_replace( "<!--NAMAKANTOR-->", "{$namakantor}", $template );
            $template = str_replace( "<!--ALAMATKANTOR-->", "{$alamat}", $template );
            $template = str_replace( "<!--NAMAMAHASISWA-->", $d2[NAMA], $template );
            $template = str_replace( "<!--NIMMAHASISWA-->", $d2[ID], $template );
            $template = str_replace( "<!--PRODIMAHASISWA-->", $arrayjenjang[$d2[TINGKAT]]." ".$arrayprodi[$d2[IDPRODI]], $template );
            $template = str_replace( "<!--TTLMAHASISWA-->", $d2[TEMPAT]."/".$d2[TANGGALLAHIR], $template );
            $template = str_replace( "<!--KELAMINMAHASISWA-->", $arraykelamin[$d2[KELAMIN]], $template );
        }
        if ( !file_exists( "foto/{$d2['ID']}" ) )
        {
            $template = preg_replace( "/<!--FOTO-->.*<!--ENDFOTO-->/", "", $template );
        }
        $template = str_replace( "<!--FOTOMAHASISWA-->", "foto/{$d2['ID']}", $template );
        $template = str_replace( "<!--BARCODEMAHASISWA-->", "barcode/{$d2['ID']}.png", $template );
        if ( $fotokartu != "" && !file_exists( "kartu/{$fotokartu}" ) )
        {
            $template = preg_replace( "/<!--TTD-->.*<!--ENDTTD-->/", "", $template );
        }
        else
        {
            $template = str_replace( "<!--FOTOTTD-->", "kartu/{$fotokartu}", $template );
        }
        echo "     {$template}   ";
        if ( !( $kolom == 0 ) || $kolom == 0 )
        {
            $kolom = 1;
        }
        else
        {
            $kolom = 0;
        }
        if ( $baris % 8 == 0 && 1 < $baris )
        {
        }
    } while ( 1 );
}
?>
