<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT \r\n\tmahasiswa.*,prodi.JENIS \r\n\tFROM mahasiswa,prodi WHERE \r\n\tmahasiswa.ID='{$id}'\r\n\tAND prodi.ID=mahasiswa.IDPRODI\r\n\t";
$idupdate = $id;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Rincian Data Mahasiswa" );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Rincian Data Mahasiswa" );
        printmesgcetak( $errmesg );
    }
    $d = sqlfetcharray( $h );
    $ipkuap = $d[IPKUAP];
    $jenis = $d[JENIS];
    $tmp = explode( "-", $d[TANGGAL] );
    $d[thn] = $tmp[0];
    $d[tgl] = $tmp[2];
    $d[bln] = $tmp[1];
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form{$cetak}>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklengkap.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=hidden name=id value='{$id}'>\r\n \t\t\t\t \r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    if ( file_exists( "foto/{$d['ID']}" ) )
    {
        $fotosaatini = "\r\n\t\t\t\r\n\t\t\t<img src='foto/{$d['ID']}' border=0 width=200><br>\r\n\t\t\t";
    }
    $angkatan = $d[ANGKATAN];
    echo "\r\n \t\t<table class=form{$cetak}>"."<tr valign=top>\r\n\t\t\t<td width=200  class=judulform{$cetak}>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n\t\t\t<td rowspan=15 align=left>{$fotosaatini}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Angkatan</td>\r\n\t\t\t<td>{$d['ANGKATAN']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Wali</td>\r\n\t\t\t<td>".$arraydosendep[$d[IDDOSEN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>NIM Mahasiswa</td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa</td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Alamat</td>\r\n\t\t\t<td>{$d['ALAMAT']}</td>\r\n\t\t</tr>"."<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>{$d['TEMPAT']} / {$d['tgl']} ".$arraybulan[$d[bln] - 1]." {$d['thn']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d[KELAMIN]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Agama</td>\r\n\t\t\t<td>".$arrayagama[$d[AGAMA]]."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>No Telepon/HP</td>\r\n\t\t\t<td>{$d['TELEPON']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Asal Sekolah</td>\r\n\t\t\t<td>{$d['ASAL']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Lulus</td>\r\n\t\t\t<td>{$d['TAHUNLULUS']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Status</td>\r\n\t\t\t<td>".$arraystatusmahasiswa[$d[STATUS]]."</td>\r\n\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Judul Tugas Akhir/Skripsi</td>\r\n\t\t\t<td>{$d['TA']}</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Dosen Pembimbing</td>\r\n\t\t\t<td>".str_replace( "\n", "<br>", $d[DOSENTA] )."</td>\r\n\t\t</tr>";
    include( "mahasiswa2lengkap.php" );
    include( "kelulusanlengkap.php" );
    echo "\r\n\t\t\t</table>\r\n\t\t\t\t\t<br style='page-break-after:always'>\r\n\t\t\t\r\n\t\t";
    include( "prosesriwayatpendidikan.php" );
    $q = "\r\n\t\t\t\tSELECT \r\n\t\t\t\tpengambilanmk.*,\r\n\t\t\t\tmakul.NAMA,\r\n\t\t\t\tmakul.SKS \r\n\t\t\t\tFROM pengambilanmk,makul\r\n\t\t\t\tWHERE\r\n\t\t\t\tpengambilanmk.IDMAHASISWA='{$id}'\r\n\t\t\t\tAND\r\n\t\t\t\tpengambilanmk.IDMAKUL=makul.ID\r\n\t\t\t\tORDER BY \r\n\t\t\t\tpengambilanmk.TAHUN,pengambilanmk.SEMESTER\r\n\t\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        printmesg( "Data Pengambilan M-K belum ada" );
    }
    else
    {
        printjudulmenukecil( "Data Mata Kuliah Yang Telah Diambil" );
        echo "\r\n\t\t\t\t\t<table {$border} class=form{$cetak}>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t\t<td>Nama M-K</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t\t\t\t<td>Sem M-K</td>\r\n\t\t\t\t\t\t<td>Kelas</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
        $i = 1;
        $semlama = "";
        while ( $d = sqlfetcharray( $h ) )
        {
            $semesterx = "".( ( $d[TAHUN] - 1 - $angkatan ) * 2 + $d[SEMESTER] )."";
            $tmp = "";
            if ( $semlama != $semesterx )
            {
                if ( $semlama != "" )
                {
                    $tmp = "\r\n\t\t\t\t\t\t\t\t<tr class=juduldata{$cetak} >\r\n\t\t\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester {$semlama}</td>\r\n\t\t\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\r\n\t\t\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t\t\t</tr>";
                }
                $semlama = $semesterx;
                echo "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata{$cetak}>\r\n\t\t\t\t\t\t\t\t<td colspan=7>Semester {$semesterx}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr {$kelas}{$cetak}>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td>{$d['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SKS']}</td>\r\n\t\t\t\t\t\t<td align=center>".( $d[TAHUN] - 1 )."/{$d['TAHUN']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['SEMESTERMAKUL']} </td>\r\n\t\t\t\t\t\t<td align=center>{$d['KELAS']} </td>\r\n\t\t\t\t\t</tr>";
            $totalsks += $d[SKS];
            $total += $semesterx;
            ++$i;
        }
        if ( $semlama != "" )
        {
            echo "\r\n\t\t\t\t\t\t<tr class=juduldata{$cetak} >\r\n\t\t\t\t\t\t\t<td align=right colspan=3>Total SKS Semester {$semlama}</td>\r\n\t\t\t\t\t\t\t<td align=center>{$total[$semlama]}</td>\r\n\t\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t\t</tr>";
        }
        echo " \r\n\t\t\t\t\t<tr class=juduldata{$cetak}>\r\n\t\t\t\t\t\t<td align=right colspan=3>Total SKS</td>\r\n\t\t\t\t\t\t<td align=center>{$totalsks}</td>\r\n\t\t\t\t\t\t<td colspan=3></td>\r\n\t\t\t\t\t</tr>";
        echo "\r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t<br style='page-break-after:always'>\r\n\t\t\t\t";
    }
    $d[ID] = $id;
    printjudulmenukecil( "<br><br>\r\n \tTranskrip Nilai Mahasiswa\r\n \t " );
    $nilaidiambil = 0;
    $konversisemua = 0;
    @$konf = @file( "../nilai/konfig" );
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
    $d[IPKUAP] = $ipkuap;
    $d[JENIS] = $jenis;
    $q = "\r\n\t\t\t\tSELECT NAMA,SYARAT FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC\r\n\t\t\t";
    $hkonversi = mysqli_query($koneksi,$q);
    while ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
    {
        $konpredikat[] = $dkonversi;
    }
    include( "../nilai/prosestranskrip.php" );
}
else
{
    $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
    $aksi = "";
}
?>
