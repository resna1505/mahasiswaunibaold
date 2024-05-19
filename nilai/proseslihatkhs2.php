<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester Ajaran", $tahun, $semester, false );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
$vld[] = cekvaliditaskode( "Nilai SP", $sp );
$vld[] = cekvaliditaskode( "Cetak Diagram", $diagram );
$vld[] = cekvaliditaskode( "Jenis", $jenistampilan );
$vld[] = cekvaliditastanggal( "Tanggal", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    include( "fungsinilai.php" );
    include( "../libchart/libchart.php" );
    $href = "dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&jenistampilan={$jenistampilan}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&sp={$sp}&kopsurat={$kopsurat}&diagram={$diagram}&";
    if ( $idprodi != "" )
    {
        $qfield .= " AND IDPRODI='{$idprodi}'";
        $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
        $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
        $href .= "idprodi={$idprodi}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>Jurusan/Program Studi</td>\r\n      <td>".$arrayprodidep[$idprodi]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND IDDOSEN='{$iddosen}'";
        $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
        $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
        $href .= "iddosen={$iddosen}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>Dosen Wali</td>\r\n      <td>".$arraydosen[$iddosen]."</td>\r\n    </tr>\r\n    ";
    }
    if ( ismahasiswa( ) || iswali( ) )
    {
        $idmhs = $users;
    }
    if ( $angkatan != "" )
    {
        $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
        $qjudul .= " Angkatan '{$angkatan}' <br>";
        $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
        $href .= "angkatan={$angkatan}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>Angkatan</td>\r\n      <td>".$angkatan."</td>\r\n    </tr>\r\n    ";
    }
    if ( $id != "" )
    {
        $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
        $qjudul .= " NIM mengandung kata '{$id}' <br>";
        $qinput .= " <input type=hidden name=id value='{$id}'>";
        $href .= "id={$id}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>NIM</td>\r\n      <td>".$id."</td>\r\n    </tr>\r\n    ";
    }
    if ( $idmhs != "" )
    {
        $qfield .= " AND mahasiswa.ID = '{$idmhs}'";
        $qjudul .= " NIM = '{$idmhs}' <br>";
        $qinput .= " <input type=hidden name=idmhs value='{$idmhs}'>";
        $href .= "idmhs={$idmhs}&";
    }
    if ( $nama != "" )
    {
        $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
        $qjudul .= " Nama mengandung kata '{$nama}' <br>";
        $qinput .= " <input type=hidden name=nama value='{$nama}'>";
        $href .= "nama={$nama}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>Nama Mhs</td>\r\n      <td>".$nama."</td>\r\n    </tr>\r\n    ";
    }
    if ( $status != "" )
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
        $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
        $qinput .= " <input type=hidden name=status value='{$status}'>";
        $href .= "status={$status}&";
        $qtabel .= "\r\n    <tr>\r\n      <td>Status Mahasiswa</td>\r\n      <td>".$arraystatusmahasiswa["{$status}"]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $jeniskelas != "" )
    {
        $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
        $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
        $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
        $href .= "jeniskelas={$jeniskelas}&";
        $qtabel .= "\r\n    <tr>\qr\n      <td>Jenis Kelas</td>\r\n      <td>".$arraykelasstei["{$jeniskelas}"]."</td>\r\n    </tr>\r\n    ";
    }
    if ( $sort == "" )
    {
        $sort = " mahasiswa.ID";
    }
    if ( $tahun != "" )
    {
        $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    if ( $semester == "" )
    {
        $semester = 1;
    }
    $href .= "semester={$semester}&";
    $href2 = "{$href}";
    $href = "index.php?{$href}";
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  ,trakm\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
    
    //print_r($q);
    //exit();
    
    $h = doquery($koneksi,$q );
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    $first = 0;
    if ( 0 + $dataperhalaman <= 0 )
    {
        $dataperhalaman = 1;
    }
    $maxdata = $dataperhalaman;
    include( "../paginating.php" );
    $q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  ,trakm,mspst\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND\r\n\tprodi.ID=mspst.IDX AND\r\n\tmspst.KDPTIMSPST = trakm.KDPTITRAKM AND\r\n\tmspst.KDJENMSPST = trakm.KDJENTRAKM AND\r\n\tmspst.KDPSTMSPST\t = trakm.KDPSTTRAKM  \r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
    $h = doquery($koneksi,$q );
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Kartu Hasil Studi (KHS)" );
            echo "\r\n\t\t<b>Filter/Setting</b>\r\n    <table>\r\n      {$qtabel}\r\n      <tr>\r\n        <td  width=200>Tahun Akademik</td>\r\n        <td>".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."</td>\r\n      </tr>\r\n      <tr>\r\n        <td  >Nilai MK yg diambil</td>\r\n        <td>";
            if ( $nilaidiambil == 0 )
            {
                echo "Nilai Terbaik";
            }
            else
            {
                echo "Nilai Terakhir";
            }
            echo "</td>\r\n      </tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td  >\r\n\t\t\t\t\tPerlakuan terhadap Nilai Kosong/Tunda\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
            if ( $nilaikosong == 0 )
            {
                echo "Tidak dihitung";
            }
            else
            {
                echo "Dihitung";
            }
            echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tNilai SP\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
            if ( $sp == 1 )
            {
                echo "Ambil langsung dari nilai SP  (proses akan sedikit lebih lambat)";
            }
            else
            {
                echo "Tidak diambil langsung.";
            }
            echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Cetak Diagram\r\n\t\t</td>\r\n\t\t<td>";
            if ( $diagram == 0 )
            {
                echo "Tidak ";
            }
            else
            {
                echo "Ya";
            }
            echo "\r\n\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jenis\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
            if ( $jenistampilan == 99 )
            {
                echo "\r\n       \t\tKHS {$UNIVERSITAS}  \r\n        ";
            }
            else if ( $jenistampilan == "untag" )
            {
                echo "\r\n       \t\tKHS {$UNIVERSITAS}  - BLANKO \r\n        ";
            }
            else
            {
                echo "\r\n       \t\tStandar\r\n        ";
            }
            echo "\r\n \r\n\t\t</td>\r\n\t</tr>\r\n \t\t <tr class=judulform>\r\n\t\t\t<td>Tanggal Laporan</td>\r\n\t\t\t<td>{$tgllap['tgl']}-{$tgllap['bln']}-{$tgllap['thn']} </td>\r\n\t\t</tr> \t\t\t";
            if ( $jenisusers != 2 )
            {
                echo "\r\n\t<tr>\r\n\t\t<td  >Data Per Halaman\r\n\t\t</td>\r\n\t\t<td>{$maxdata}\r\n \t\t</td>\r\n\t</tr>";
                if ( $jenisusers == 0 )
                {
                    echo "\r\n\t<tr>\r\n\t\t<td  >Kop Surat\r\n\t\t</td>\r\n\t\t<td>";
                    if ( $kopsurat == 1 )
                    {
                        echo "Cetak Kop Surat Umum";
                    }
                    else if ( $kopsurat == 2 )
                    {
                        echo "Cetak Kop Surat Fakultas";
                    }
                    else if ( $kopsurat == "" )
                    {
                        echo "Tidak dicetak.";
                    }
                    echo "\r\n\t\t</td>\r\n\t</tr>";
                }
                echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td  >\r\n\t\t\t\t\tCatatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t ".nl2br( $catatan )."\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \r\n   \r\n\r\n    </table>\r\n    <hr>\r\n    ";
            }
            echo "{$tpage} {$tpage2}";
        }
        if ( $aksi != "cetak" )
        {
           # echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkhs.php' method=post>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t<input type=checkbox name=pdf value=1> PDF \r\n             <a class='settingpdf' href='../lib/settingpdf.php' >Setting</a> \r\n  \t\t\t\t\t\t\r\n  \t\t\t<script>\r\n            jQuery(document).ready(function () {\r\n                jQuery('a.settingpdf').colorbox();\r\n            });\r\n        </script>\r\n  \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n \t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "catatan", "{$catatan}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n\t\t\t".createinputhidden( "nilaikosong", "{$nilaikosong}", "" )."\r\n\t\t\t".createinputhidden( "sp", "{$sp}", "" )."\r\n\t\t\t".createinputhidden( "kopsurat", "{$kopsurat}", "" )."\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        
        echo "\r\n \t\t\t<table {$border} class=data>\r\n\t\t\t<tr class=juduldata align=center>\r\n      <td><input type='checkbox' name='checkall]' value='all'></td><td>ID Mahasiswa</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Program Studi</td>\r\n        <td>Cetak KHS</td>\r\n      </tr>\r\n    ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            
            $kelas = kelas( $i );
           # echo "\r\n        <tr {$kelas}>\r\n          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td align=center><a target=_blank href='cetakkhs.php?idmhs={$d['ID']}&".$href2."'>cetak </a>\r\n          | <a target=_blank href='cetakkhs.php?idmhs={$d['ID']}&pdf=1".$href2."'>PDF</a></td>\r\n        </tr>\r\n        ";
			 echo "\r\n        <tr {$kelas}>\r\n<td align='center'><input type='checkbox' name='idmhs[]' value='".$d['ID']."'> </td>          <td>{$d['ID']}</td>\r\n          <td>{$d['NAMA']}</td>\r\n          <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n          <td align=center><a target=_blank href='cetakkhs.php?idmhs={$d['ID']}&".$href2."'>cetak </a></td>\r\n        </tr>\r\n        ";
        
		}
        echo "</table><input type='submit' name='printbtn' value='Cetak'>";
    }
    else
    {
        $errmesg = "Data KHS mahasiswa tidak ada";
        $aksi = "";
    }
}
?>
