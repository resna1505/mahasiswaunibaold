<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
echo "<table class=\"table table-striped2 table-bordered table-hover\">";
$q = "SELECT \r\n\tmahasiswa.IDPRODI,mahasiswa.ID,mahasiswa.NAMA,\r\n  prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$idupdate}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printmesg( $errmesg );
    $d = sqlfetcharray( $h );
    $q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}'";
    $h2 = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
    }
    else
    {
        #echo "<br>";
        printtitle( "Data Lulus/Cuti/Non-aktif/Keluar/DO belum ada. Semua field di bawah ini tidak merepresentasikan data mahasiswa yang sebenarnya." );
    }


    $tmp = explode( "-", $d2[TGLLSTRLSM] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
    $tmp = explode( "-", $d2[TGLRETRLSM] );
    $tglsk[thn] = $tmp[0];
    $tglsk[tgl] = $tmp[2];
    $tglsk[bln] = $tmp[1];
    $tmp = $d2[THSMSTRLSM];
    $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester = $tmp[4];
    $tmp = $d2[BLAWLTRLSM];
    $bulanawal = $tmp[0].$tmp[1];
    $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
    if ( file_exists( "foto/{$d['ID']}" ) )
    {
        $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=100><br>\r\n\t\t\t";
    }
   echo "\r\n\t\t<br>\r\n \r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>Tahun/Semester Data</td>\r\n\t\t\t<td>".$arraysemester[$semester]." {$tahun} \r\n \r\n \r\n  </td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Status Aktifitas Mahasiswa</td>\r\n\t\t\t<td> ".$arraystatusmahasiswa[$d2[STMHSTRLSM]]."</td>\r\n\t\t</tr>"."\r\n      <tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>{$dtk['tgl']}-{$dtk['bln']}-{$dtk['thn']} </td>\r\n\t\t</tr>     \r\n    <tr class=judulform>\r\n\t\t\t<td>SKS Lulus</td>\r\n\t\t\t<td>{$d2['SKSTTTRLSM']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>IPK Akhir</td>\r\n\t\t\t<td>{$d2['NLIPKTRLSM']}</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>No. SK Yudisium</td>\r\n\t\t\t<td>{$d2['NOSKRTRLSM']}</td>\r\n\t\t</tr>\r\n     <tr >\r\n\t\t\t<td>Tanggal SK</td>\r\n\t\t\t<td>{$tglsk['tgl']}-{$tglsk['bln']}-{$tglsk['thn']} </td>\r\n\t\t</tr> \t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>No. Seri Ijazah</td>\r\n\t\t\t<td>{$d2['NOIJATRLSM']}</td>\r\n\t\t</tr>\r\n      <tr >\r\n\t\t\t<td>Jalur Skripsi/Non</td>\r\n\t\t\t<td> ".$arrayjalurskripsi[$d2[STLLSTRLSM]]."</td>\r\n\t\t</tr>\t\t\r\n      <tr >\r\n\t\t\t<td> Skripsi Individu/Kelompok</td>\r\n\t\t\t<td> ".$arrayskripsiindividu[$d2[JNLLSTRLSM]]."</td>\r\n\t\t</tr>\t\t\r\n\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Awal Bimbingan</td>\r\n\t\t\t<td>".$arraybulan[$bulanawal - 1]." {$tahunawal} \r\n   </td>\r\n\t\t</tr>\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Akhir Bimbingan</td>\r\n\t\t\t<td>".$arraybulan[$bulanakhir - 1]." {$tahunakhir}  \r\n   </td>\r\n\t\t</tr>\t\t\t\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 1</td>\r\n\t\t\t<td>{$d2['NODS1TRLSM']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 2</td>\r\n\t\t\t<td>{$d2['NODS2TRLSM']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 3</td>\r\n\t\t\t<td>{$d2['NODS3TRLSM']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 4</td>\r\n\t\t\t<td>{$d2['NODS4TRLSM']}</td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 5</td>\r\n\t\t\t<td>{$d2['NODS5TRLSM']}</td>\r\n\t\t</tr>\r\n \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n\r\n\t\t";
	
}
?>
