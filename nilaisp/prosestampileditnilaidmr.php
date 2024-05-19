<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
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
    printjudulmenu( "Import Data Nilai Dari File DMR" );
    printmesg( $errmesg );
}
else
{
    printjudulmenucetak( "Data Nilai" );
    printmesgcetak( $errmesg );
}
echo "<table  class=data{$cetak}>"."<tr  >\r\n\t\t\t<td class=judulform>Mata Kuliah</td>\r\n\t\t\t<td>: {$idmakulupdate}, ".getnamafromtabel( $idmakulupdate, "makul" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Tahun Akademik</td>\r\n\t\t\t<td>: ".( $tahunupdate - 1 )."/{$tahunupdate}\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Semester</td>\r\n\t\t\t<td>: ".$arraysemester[$semesterupdate]."\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td class=judulform>Dosen Pengajar</td>\r\n\t\t\t<td>: {$iddosenupdate}, ".getnamafromtabel( $iddosenupdate, "dosen" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>Kode Kelas</td>\r\n\t\t\t<td>: {$kelasupdate}</td>\r\n\t\t</tr>"."\r\n\t\t</table>\r\n\t\t\r\n\t\t";
if ( $konversisemua == 1 )
{
    $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
    $h = mysqli_query($koneksi,$q);
    do
    {
        if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
        {
            $kon[] = $d;
        }
    } while ( 1 );
}
printjudulmenukecil( "Pilih Komponen Nilai" );
$q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\tWHERE IDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n\t\t<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "formtambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."<table class=data>\r\n \t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Nama Komponen</td>\r\n\t\t\t\t\t<td>Bobot (%)</td>\r\n\t\t\t\t\t<td >Pilih Import</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
    $i = 1;
    $totalbobot = 0;
    $ceksaatini = $datacek[import];
    if ( $datacek[import] == "" )
    {
        $ceksaatini = 0;
    }
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        if ( $ceksaatini == $d[IDKOMPONEN] )
        {
            $stcss = "checked";
        }
        echo "\r\n\t\t\t\t\t<tr {$kelas}  align=center>\r\n\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t\t<td align=left >{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td  >{$d['BOBOT']}</td>\r\n\t\t\t\t\t\t<td align=center>".createinputradio( "datacek[import]", $d[IDKOMPONEN], "", "{$stcss}", " class=masukan size=4" )."</td>\r\n \t\t\t\t\t</tr>\r\n\t\t\t\t";
        $stcss = "";
        $totalbobot += $d[BOBOT];
        ++$i;
    }
    echo " \r\n\t\t\t\t<tr class=juduldata align=center>\r\n\t\t\t\t\t<td colspan=2 align=right>Total Bobot</td>\r\n\t\t\t\t\t<td>{$totalbobot}</td>\r\n\t\t\t\t\t<td colspan=2></td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
    echo "</table>\r\n\t\t\t<br><br>\r\n\t\t\t<table  class=data{$cetak}>"."<tr  >\r\n\t\t\t<td class=judulform>File Nilai DMR</td>\r\n\t\t\t<td>\r\n\t\t\t\t<input type=file  name=filenilai class=masukan> \r\n\t\t\t\t<input type=submit value=Import name=aksi2 class=masukan>\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t";
    if ( $konversisemua == 1 )
    {
        $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversiumum\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
        $h = mysqli_query($koneksi,$q);
        do
        {
            if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
            {
                $kon[] = $d;
            }
        } while ( 1 );
    }
    printjudulmenukecil( "Rincian Data Nilai Mahasiswa" );
    $q = "\r\n\t\t\tSELECT IDKOMPONEN,NAMA,BOBOT FROM komponen\r\n\t\t\tWHERE \r\n\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\tORDER BY BOBOT\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        printmesg( "Komponen nilai untuk mata kuliah ini belum ada" );
    }
    else
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $kp[] = $d;
        }
        if ( $konversisemua == 0 )
        {
            $q = "\r\n\t\t\t\tSELECT SIMBOL,NILAI,SYARAT FROM konversi\r\n\t\t\t\tWHERE \r\n\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY NILAI DESC\r\n\t\t\t";
            $h = mysqli_query($koneksi,$q);
            do
            {
                if ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
                {
                    $kon[] = $d;
                }
            } while ( 1 );
        }
        $q = "\r\n\t\t\t\tSELECT mahasiswa.NAMA,mahasiswa.ID \r\n\t\t\t\tFROM mahasiswa,pengambilanmk\r\n\t\t\t\tWHERE \r\n\t\t\t\tmahasiswa.ID=pengambilanmk.IDMAHASISWA\r\n\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\tORDER BY mahasiswa.ID\r\n\t\t\t";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            if ( $aksi != "cetak" )
            {
                echo "\r\n\t\t\t\t\t\t<table class=form>\r\n\t\t\t\t\t\t<tr><td>\r\n\t\t\t\t\t<form target=_blank action='cetaktampilnilai.php'>\r\n\t\t \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."\r\n\t\t\t\t\t</form>\r\n\t\t\t\t\t\t</td></tr></table>";
            }
            echo "<table {$border} class=data{$cetak}>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t\t<td>NIM</td>\r\n\t\t\t\t\t\t<td>Nama</td>";
            foreach ( $kp as $k => $v )
            {
                if ( $datacek[import] == $v[IDKOMPONEN] )
                {
                    $stcss = " bgcolor='#FFFF00' style='color:#000000' ";
                }
                echo "\r\n\t\t\t\t\t\t\t<td {$stcss}>{$v['NAMA']} ({$v['BOBOT']}%)</td>";
                $stcss = "";
            }
            echo "\r\n\t\t\t\t\t\t<td>Nilai Akhir</td>\r\n\t\t\t\t\t\t<td>Bobot</td>\r\n\t\t\t\t\t\t<td>Simbol</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            $i = 1;
            $totalbobot = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                echo "\r\n\t\t\t\t\t\t<tr {$kelas}{$cetak}  align=center>\r\n\t\t\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['ID']}</td>\r\n\t\t\t\t\t\t\t<td  align=left nowrap>{$d['NAMA']}</td>";
                $q = "\r\n\t\t\t\t\t\t\t\tSELECT IDKOMPONEN,NILAI FROM nilai\r\n\t\t\t\t\t\t\t\tWHERE \r\n\t\t\t\t\t\t\t\tIDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\t\t\tAND TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\t\t\tAND SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\t\t\tAND KELAS='{$kelasupdate}'\r\n\t\t\t\t\t\t\t\tAND IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\t\t";
                $h2 = mysqli_query($koneksi,$q);
                unset( $datanilai );
                while ( !( 0 < sqlnumrows( $h2 ) ) || !( $d2 = sqlfetcharray( $h2 ) ) )
                {
                    $datanilai[$d2[IDKOMPONEN]] = $d2[NILAI];
                }
                $nilaiakhir = 0;
                foreach ( $kp as $k => $v )
                {
                    $stcss = " bgcolor='#FFEEEE' style='color:#000000' ";
                    echo "\r\n\t\t\t\t\t\t\t\t\t<td {$stcss}>".$datanilai[$v[IDKOMPONEN]]."</td>\r\n\t\t\t\t\t\t\t\t";
                    $stcss = "";
                    $total += $v[IDKOMPONEN];
                    $nilaiakhir += $datanilai[$v[IDKOMPONEN]] * $v[BOBOT] / 100;
                }
                $totalnilaiakhir += $nilaiakhir;
                $simbolakhir = "?";
                $nilaiekakhir = "?";
                if ( is_array( $kon ) )
                {
                    foreach ( $kon as $k => $v )
                    {
                        if ( $v[SYARAT] <= $nilaiakhir )
                        {
                            $simbolakhir = $v[SIMBOL];
                            $nilaiekakhir = $v[NILAI];
                            break;
                            break;
                        }
                    }
                }
                echo "\r\n\t\t\t\t\t\t\t<td>".number_format_sikad( $nilaiakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t<td>".number_format_sikad( $nilaiekakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t<td>{$simbolakhir}</td>\r\n\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t";
                $q = "UPDATE pengambilanmk SET\r\n\t\t\t\t\t\tSIMBOL='{$simbolakhir}',\r\n\t\t\t\t\t\tNILAI='{$nilaiakhir}',\r\n\t\t\t\t\t\tBOBOT='{$nilaiekakhir}'\r\n\t\t\t\t\t\tWHERE IDMAHASISWA='{$d['ID']}'\r\n\t\t\t\t\t\tAND pengambilanmk.IDMAKUL='{$idmakulupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.TAHUN='{$tahunupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.SEMESTER='{$semesterupdate}'\r\n\t\t\t\t\t\tAND pengambilanmk.KELAS='{$kelasupdate}'\r\n\t\t\t\t\t";
                mysqli_query($koneksi,$q);
                $totalbobotsemua += $nilaiekakhir;
                $totalbobot += $d[BOBOT];
                ++$i;
            }
            echo " \r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Total</td>";
            foreach ( $kp as $k => $v )
            {
                if ( $datacek[import] == $v[IDKOMPONEN] )
                {
                    $stcss = " bgcolor='#FFFF00' style='color:#000000'";
                }
                echo "\r\n\t\t\t\t\t\t\t\t<td {$stcss}>".number_format_sikad( $total[$v[IDKOMPONEN]], 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t";
                $stcss = "";
            }
            echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua, 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=juduldata{$cetak} align=center>\r\n\t\t\t\t\t\t<td colspan=3 align=right>Rata-rata</td>";
            foreach ( $kp as $k => $v )
            {
                if ( $datacek[import] == $v[IDKOMPONEN] )
                {
                    $stcss = " bgcolor='#FFFF00' style='color:#000000'";
                }
                echo "\r\n\t\t\t\t\t\t\t\t<td {$stcss}>".number_format_sikad( $total[$v[IDKOMPONEN]] / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t";
                $stcss = "";
            }
            echo "\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalnilaiakhir / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td>".number_format_sikad( $totalbobotsemua / ( $i - 1 ), 2, ".", "," )."</td>\r\n\t\t\t\t\t\t\t\t<td colspan=2></td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t";
            echo "</table>\r\n\t\t\t\t</form>";
        }
        else
        {
            $errmesg = "Data mahasiswa yang mengambil mata kuliah ini belum ada";
            printmesg( $errmesg );
        }
    }
}
else
{
    $errmesg = "Komponen Nilai belum ada. Silakan membuat komponen nilai untuk M-K ini\r\n\t\t\tterlebih dahulu.";
    printmesg( $errmesg );
}
?>
