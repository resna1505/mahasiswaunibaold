<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
printjudulmenu( "Pembayaran Keuangan Mahasiswa" );
if ( $aksi2 == "Simpan Data" && $REQUEST_METHOD == POST )
{
    if ( is_array( $arraypilih ) )
    {
        $i = 0;
        foreach ( $arraypilih as $k => $v )
        {
            $q = "\r\n\t\t\t\t\tUPDATE bayarkomponen SET \r\n\t\t\t\t\tJUMLAH='".$arraybayar[$k]."',\r\n\t\t\t\t\tDISKON='".$arraydiskon[$k]."',\r\n\t\t\t\t\tDENDA='".$arraydenda[$k]."',\r\n\t\t\t\t\tKET='".$arrayket[$k]."' ,\r\n\t\t\t\t\tBULANSPP='".$tahunspp[$k]."-".$bulanspp[$k]."-01' ,\r\n\t\t\t\t\tUSER='{$users}',\r\n\t\t\t\t\tTGLUPDATE=NOW()\r\n\t\t\t\t\tWHERE ID='{$k}' \r\n\t\t\t\t";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Data pembayaran sudah disimpan";
        }
        else
        {
            $errmesg = "Data pembayaran tidak disimpan";
        }
    }
    $aksi = "Lanjut";
}
if ( $aksi2 == "Hapus Data" && $REQUEST_METHOD == POST )
{
    if ( is_array( $arraypilih ) )
    {
        $i = 0;
        foreach ( $arraypilih as $k => $v )
        {
            $q = "DELETE FROM bayarkomponen WHERE ID='{$k}'";
            mysqli_query($koneksi,$q);
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                ++$i;
            }
        }
        if ( 0 < $i )
        {
            $errmesg = "Data pembayaran sudah dihapus";
        }
        else
        {
            $errmesg = "Data pembayaran tidak dihapus";
        }
    }
    $aksi = "Lanjut";
}
if ( $aksi2 == "Tambah Data" && $REQUEST_METHOD == POST )
{
    $q = "SELECT JENIS FROM komponenpembayaran WHERE ID='{$jenis}'";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $jenisk = $d[JENIS];
    if ( $jenisk == 2 )
    {
        $tahunbayar = $tahunajaran;
    }
    else if ( $jenisk == 3 )
    {
        $tahunbayar = $tahunajaran;
        $semesterbayar = $semesterbayar;
    }
    else if ( $jenisk == 5 )
    {
        $tahunbayar = $tahunajaran2;
        $semesterbayar = $bulanbayar;
    }
    else
    {
        $tahunbayar = $semesterbayar = 0;
    }
    $loop = 1;
    if ( $jenis == "002" && 1 < $jumlahbulan )
    {
        $loop = $jumlahbulan;
        $jumlahbayar = $jumlahbayar / $jumlahbulan;
        $jumlahdiskon = $jumlahdiskon / $jumlahbulan;
    }
    $i = 1;
    while ( $i <= $loop )
    {
        $q = "INSERT INTO bayarkomponen \r\n\t\t  \t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n          TANGGAL,USER,TGLUPDATE,DENDA)\r\n\t\t\t   VALUES \r\n\t\t\t   ('{$idmahasiswa}','{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','{$jenis}','{$jenisk}',\r\n\t\t\t   '{$jumlahbayar}','{$ket}',\r\n\t\t\t   '".$tahunbayar."','".$semesterbayar."','{$carabayar}','{$jumlahdiskon}',\r\n          NOW(),'{$users}',NOW(),'{$jumlahdenda}')";
        mysqli_query($koneksi,$q);
        ++$i;
    }
    if ( 0 < sqlaffectedrows( $koneksi ) )
    {
        $errmesg = "Data pembayaran sudah disimpan";
        $jumlahbayar = $jumlahdiskon = $ket = "";
        $idupdate = mysqli_insert_id($koneksi);
        $arrayid[$idupdate] = $idupdate;
    }
    else
    {
        $errmesg = "Data pembayaran tidak berhasil disimpan";
    }
    $aksi = "Lanjut";
}
if ( $aksi == "Lanjut" )
{
	#echo "kesini";exit();
    if ( trim( $idmahasiswa ) == "" )
    {
        $errmesg = "NIM harus diisi";
        $aksi = "";
    }
    else
    {
		#echo "kesini";
        printmesg( $errmesg );
        $q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
        $h = mysqli_query($koneksi,$q);
        if ( sqlnumrows( $h ) <= 0 )
        {
            $errmesg = "Tidak ada mahasiswa dengan NIM '{$idmahasiswa}'";
            $aksi = "";
        }
        else
        {
            $data = sqlfetcharray( $h );
            echo "\r\n\t\t\t\t<form name=form action=index.php method=post>\r\n\t\t\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t \t\t<table class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=200>NIM</td>\r\n\t\t\t\t\t\t<td><b>{$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td >Nama</td>\r\n\t\t\t\t\t\t<td><b>{$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t\t\t<td><b>{$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t\t\t<td><b>".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<b>{$tglbayar['tgl']} ".$arraybulan[$tglbayar[bln] - 1]." {$tglbayar['thn']}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\t\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td>Cara Bayar </td>\r\n\t\t\t\t\t\t<td><b>".$arraycarabayar[$carabayar]."\r\n\t\t\t\t\t\t<input type=hidden name=carabayar value='{$carabayar}'>\r\n            \r\n            </td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t</table>";
            echo "\r\n      <br>\r\n      <b>Tambah Komponen Pembayaran</b>\r\n      <table>\r\n        <tr>\r\n          <td>Jenis</td>\r\n          <td>\r\n          <select name=jenis>\r\n            ";
            foreach ( $arraykomponenpembayaran as $k => $v )
            {
                echo "<option value='{$k}'>{$v}</option>";
            }
            echo "\r\n          </select>\r\n          </td>\r\n        </tr>\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Bulan/Semester/Tahun</td>\r\n\t\t\t\t\t\t<td> \r\n<select name=bulanbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t  ";
            foreach ( $arraybulan as $k => $v )
            {
                $cek = "";
                if ( $k + 1 == $w[mon] )
                {
                    $cek = "selected";
                }
                echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\r\n\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t\t<select name=tahunajaran2 class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
            $ii = 1900;
            while ( $ii <= $waktu[year] + 5 )
            {
                $cek = "";
                if ( $ii == $d2[TAHUNAJARAN] )
                {
                    $cek = "selected";
                }
                else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
                {
                    $cek = "selected";
                }
                echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}> {$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                ++$ii;
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t</select> (Bulanan) <br>\r\n<select name=semesterbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t  ";
            foreach ( $arraysemester as $k => $v )
            {
                $cek = "";
                if ( $k == $d2[SEMESTER] )
                {
                    $cek = "selected";
                }
                echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t\t</select>\t\t\t\t\t\t\t\t\t\t\r\n\t\t\t\t\t\t\t\t\t<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t\t\t ";
            $ii = 1900;
            while ( $ii <= $waktu[year] + 5 )
            {
                $cek = "";
                if ( $ii == $d2[TAHUNAJARAN] )
                {
                    $cek = "selected";
                }
                else if ( $ii == $waktu[year] + 1 && $d2[TAHUNAJARAN] == "" )
                {
                    $cek = "selected";
                }
                echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>".( $ii - 1 )."/{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
                ++$ii;
            }
            echo "\r\n\t\t\t\t\t\t\t\t\t</select> (Semester/Tahunan)            \r\n                </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n        <tr>\r\n          <td>Jumlah Dibayar Rp.</td>\r\n          <td>\r\n          <input type=text size=20 name=jumlahbayar value='{$jumlahbayar}'> Kosongkan untuk jumlah pembayaran otomatis\r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Diskon Rp.</td>\r\n          <td>\r\n          <input type=text size=20 name=jumlahdiskon value='{$jumlahdiskon}'>            \r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Keterangan</td>\r\n          <td>\r\n          <textarea name=ket cols=40 rows=4 >{$ket}</textarea>            \r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td>Khusus Pembayaran Uang Kuliah/SPP <br>\r\n          Pembayaran untuk: </td>\r\n          <td>\r\n            <input type=text name=jumlahbulan size=2 value=1> bulan\r\n          </td>\r\n        </tr>\r\n        <tr>\r\n          <td></td>\r\n          <td>\r\n          <input type=submit  name=aksi2 value='Tambah Data'>            \r\n          </td>\r\n        </tr>\r\n      </table>\r\n      <br><br>\r\n      ";
            $q = "SELECT bayarkomponen.* ,komponenpembayaran.NAMA ,\r\n            biayakomponen.BIAYA AS BIAYAK,biayakomponen.TANGGAL,biayakomponen.DENDA AS DENDAD,\r\n            biayakomponen.JENISDENDA\r\n          FROM bayarkomponen,komponenpembayaran,biayakomponen\r\n          WHERE   \r\n          biayakomponen.IDKOMPONEN=bayarkomponen.IDKOMPONEN\r\n          AND biayakomponen.IDPRODI='{$data['IDPRODI']}'\r\n          AND biayakomponen.ANGKATAN='{$data['ANGKATAN']}'\r\n          AND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID \r\n          AND  bayarkomponen.TANGGALBAYAR='{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}'\r\n          AND bayarkomponen.IDMAHASISWA='{$idmahasiswa}' \r\n          ORDER BY IDKOMPONEN";
            #echo $q;
			$h = mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "<table>\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>Pilih</td>\r\n            <td>No</td>\r\n \t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>Jenis</td>\r\n\t\t\t\t\t\t<td>Waktu</td>\r\n\t\t\t\t\t\t<td>Biaya<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Sudah<br>Dibayar<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Dibayar<br>Saat Ini<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Diskon<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Denda<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Sisa<br>Rp.</td>\r\n\t\t\t\t\t\t<td>Bulan SPP</td>\r\n\t\t\t\t\t\t<td>Ket</td>\r\n\t\t\t\t\t\t\r\n\t\t \t\t\t</tr>\r\n\r\n        ";
                $i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    $jumlahlama = $d[JUMLAH];
                    $dendalama = $d[DENDA];
                    ++$i;
                    $waktu = "-";
                    $biaya = $totaldenda = 0;
                    $qdibayar = "";
                    if ( $d[JENIS] == 2 )
                    {
                        $waktu = "{$d['TAHUNAJARAN']}";
                        $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}'";
                    }
                    else if ( $d[JENIS] == 3 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}' AND\r\n                  SEMESTER='{$d['SEMESTER']}' ";
                        if ( $d[IDKOMPONEN] == "002" && $d[JENIS] == 3 )
                        {
                        }
                    }
                    else if ( $d[JENIS] == 5 )
                    {
                        $waktu = "".$arraybulan[$d[SEMESTER] - 1]."  {$d['TAHUNAJARAN']}";
                        $qdibayar = " AND TAHUNAJARAN='{$d['TAHUNAJARAN']}' AND\r\n                  SEMESTER='{$d['SEMESTER']}' ";
                        $totaldenda = 0;
                        $kettambahan = "";
                        $q = "SELECT TO_DAYS('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}')-TO_DAYS('{$d['TAHUNAJARAN']}-{$d['SEMESTER']}-{$d['TANGGAL']}') AS HARI ";
                        $hx = mysqli_query($koneksi,$q);
                        $dx = sqlfetcharray( $hx );
                        $jumlahhari = $dx[HARI] + 0;
                        if ( 0 < $jumlahhari )
                        {
                            if ( $d[JENISDENDA] == 0 )
                            {
                                $totaldenda = $d[DENDAD];
                            }
                            else
                            {
                                $totaldenda = $d[DENDAD] * $jumlahhari;
                            }
                            $kettambahan = "Denda terlambat Rp. ".cetakuang( $totaldenda );
                        }
                    }
                    $kelas = kelas( $i );
                    $q = "SELECT SUM(JUMLAH) AS TOTAL,SUM(DENDA) AS TOTALDENDA\r\n                 FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'\r\n\t\t\t\t\tAND TANGGALBAYAR != DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d') AND\r\n\t\t\t\t\tIDKOMPONEN='{$d['IDKOMPONEN']}'\r\n          {$qdibayar}\r\n          ";
                    $h3 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h3 ) )
                    {
                        $d3 = sqlfetcharray( $h3 );
                        $dibayar = $d3[TOTAL];
                    }
                    if ( $d[IDKOMPONEN] != "99" )
                    {
                        $biaya = $d[BIAYAK];
                        if ( $d[IDKOMPONEN] == "002" && $d[JENIS] == 3 )
                        {
                        }
                    }
                    else
                    {
                        $jumlahsks = getjumlahsks( $idmahasiswa, $d[TAHUNAJARAN], $d[SEMESTER] );
                        $jumlahskswajib = getjumlahskswajib( $idmahasiswa, $d[TAHUNAJARAN], $d[SEMESTER] );
                        $skslebih = 0;
                        if ( $jumlahskswajib < $jumlahsks )
                        {
                            $skslebih = $jumlahsks - $jumlahskswajib;
                        }
                        $q = "SELECT BIAYA AS TOTAL\r\n            \t\tFROM biayakomponen,mahasiswa\r\n            \t\tWHERE\r\n            \t\t  mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n            \t\t  mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n              \t\t  mahasiswa.ID='{$idmahasiswa}' AND\r\n            \t\t  biayakomponen.IDKOMPONEN='99'\r\n            \t\t\t \r\n            \t\t";
                        $ht = mysqli_query($koneksi,$q);
                        $dt = sqlfetcharray( $ht );
                        echo mysqli_error($koneksi);
                        $biayakomponen = $dt[TOTAL] + 0;
                        $biaya = $skslebih * $biayakomponen;
                    }
                    if ( $d[JUMLAH] == 0 )
                    {
                        $d[JUMLAH] = $biaya;
                    }
                    if ( $d[DENDA] == 0 )
                    {
                        $d[DENDA] = $totaldenda;
                    }
                    $sisa = 0;
                    $sisa = $biaya - $dibayar - $d[JUMLAH] - $dibayarsebelumnya[$d[IDKOMPONEN]]["{$d['TAHUNAJARAN']}{$d['SEMESTER']}"] - $d[DISKON];
                    $styletd = " ";
                    $cektd = "";
                    if ( $jumlahlama != $d[JUMLAH] )
                    {
                        $styletd = "style='background-color:#ffff00'";
                        $cektd = "checked";
                        $strerror = "Pemrosesan Jumlah Pembayaran. Ada data Jumlah pembayaran yang belum disimpan. Klik tombol Simpan untuk menyimpan data jumlah pembayaran.";
                    }
                    $strbulanspp = "";
                    if ( $d[IDKOMPONEN] == "002" )
                    {
                        $tmp = explode( "-", $d[BULANSPP] );
                        $bulanspp = $tmp[1] + 0;
                        $tahunspp = $tmp[0] + 0;
                        if ( $d[BULANSPP] == "" )
                        {
                            $styletd = "style='background-color:#ffff00'";
                            $cektd = "checked";
                            $strerror = "Pemrosesan Bulan Pembayaran SPP/Uang Kuliah. Ada data bulan pembayaran yang belum disimpan. Klik tombol Simpan untuk menyimpan data bulan pembayaran.";
                        }
                        $strbulanspp .= "\r\n                <select name='bulanspp[{$d['ID']}]'>";
                        foreach ( $arraybulan as $k => $v )
                        {
                            $selected = "";
                            if ( $k + 1 == $bulanspp )
                            {
                                $selected = "selected";
                            }
                            if ( $k + 1 == $w[mon] && $bulanspp == "" )
                            {
                                $selected = "selected";
                            }
                            $strbulanspp .= "\r\n                  <option {$selected} value='".( $k + 1 )."'>{$v}</option>";
                        }
                        $strbulanspp .= "\r\n                </select>\r\n                <select name='tahunspp[{$d['ID']}]'>";
                        $k = 1990;
                        while ( $k <= $w[year] + 10 )
                        {
                            $selected = "";
                            if ( $k == $tahunspp )
                            {
                                $selected = "selected";
                            }
                            if ( $k == $w[year] && $tahunspp == "" )
                            {
                                $selected = "selected";
                            }
                            $strbulanspp .= "<option {$selected} value='".$k."'>{$k}</option>";
                            ++$k;
                        }
                        $strbulanspp .= "\r\n                </select> \r\n              ";
                        $tglbatas = $d[TANGGAL];
                        $dendaperhari = $d[DENDAD];
                        if ( $tglbatas < $tglbayar[tgl] && $bulanspp <= $tglbayar[bln] && $tahunspp <= $tglbayar[thn] )
                        {
                            if ( $tglbayar[bln] == $bulanspp )
                            {
                                $jumlahhari = $tglbayar[tgl] - $tglbatas;
                            }
                            else
                            {
                                $jumlahhari = $arrayharibulan[$bulanspp] - $tglbatas;
                            }
                            if ( $d[JENISDENDA] == 0 )
                            {
                                $totaldenda = $d[DENDAD];
                            }
                            else
                            {
                                $totaldenda = $jumlahhari * $dendaperhari;
                            }
                            $d[DENDA] = $totaldenda;
                        }
                    }
                    else
                    {
                        $strbulanspp .= "-";
                    }
                    if ( $d[DENDA] < 0 )
                    {
                        $d[DENDA] = 0;
                    }
                    if ( $dendalama != $d[DENDA] )
                    {
                        $styletd = "style='background-color:#ffff00'";
                        $cektd = "checked";
                        $strerror = "Pemrosesan Denda. Ada data denda yang belum disimpan. Klik tombol Simpan untuk menyimpan data denda.";
                    }
                    $sisa += $d[DENDA];
                    echo "\r\n\t\t\t\t\t<tr  {$kelas} {$styletd}>\r\n\t\t\t\t\t\t<td  nowrap><input {$cektd}  type=checkbox name='arraypilih[{$d['ID']}]' value=1></td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$i}</td>\r\n \t\t\t\t\t\t<td  nowrap>{$d['NAMA']}</td>\r\n\t\t\t\t\t\t<td  nowrap>".$arrayjenispembayaran[$d[JENIS]]."</td>\r\n\t\t\t\t\t\t<td  nowrap align=center>{$waktu}</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $biaya )."</td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $dibayar )."</td>\r\n\t\t\t\t\t\t<td  nowrap align=right><input type=tex size=8 name='arraybayar[{$d['ID']}]' value='{$d['JUMLAH']}'> </td>\r\n\t\t\t\t\t\t<td  nowrap align=right><input type=tex size=4 name='arraydiskon[{$d['ID']}]' value='{$d['DISKON']}'> </td>\r\n\t\t\t\t\t\t<td  nowrap align=right><input type=tex size=4 name='arraydenda[{$d['ID']}]' value='{$d['DENDA']}'> </td>\r\n\t\t\t\t\t\t<td  nowrap align=right>".cetakuang( $sisa )."</td>\r\n\t\t\t\t\t\t<td  nowrap align=center>{$strbulanspp}\r\n            </td>\r\n\t\t\t\t\t\t<td  nowrap><textarea cols=10 rows=2 name='arrayket[{$d['ID']}]'>{$d['KET']}</textarea></td>\r\n\t\t \t\t\t</tr>          \r\n          ";
                    $dibayarsebelumnya[$d[IDKOMPONEN]] += "{$d['TAHUNAJARAN']}{$d['SEMESTER']}";
                }
                echo "\r\n          <tr>\r\n            <td colspan=12 align=left>\r\n              <input type=submit name=aksi2 value='Simpan Data'>\r\n              <input type=submit name=aksi2 value='Hapus Data'>\r\n            </td>\r\n          </tr>\r\n        ";
                echo "</table>";
                echo "\t</form>";
                printmesg( $strerror );
                echo "\r\n\t\t\t\t<form name=form action=cetakkuitansibatam.php method=post target=_blank>\r\n\t\t\t\t\t<input type=hidden name=idmahasiswa value='{$idmahasiswa}'>\r\n\t\t\t\t\t<input type=hidden name=carabayar value='{$carabayar}'>\r\n\t\t\t\t\t{$qinput}\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n<input class=masukan type=submit name=aksi value='Cetak Kuitansi'>        \r\n";
            }
            else
            {
                printmesg( "Data pembayaran belum ada" );
            }
            echo "\r\n\t\t\t\t</form>\r\n\t\t\t";
        }
    }
}
if ( $aksi == "" )
{
	#echo "ll";
    printmesg( $errmesg );
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n  \t\t<tr >\r\n\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t<td>".createinputtext( "idmahasiswa", $idmahasiswa, " class=masukan  size=20" )."\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarmhs('form,wewenang,idmahasiswa',\r\n\t\t\tdocument.form.idmahasiswa.value)\" >\r\n\t\t\tdaftar mahasiswa\r\n\t\t\t</a>\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tanggal Pembayaran</td>\r\n\t\t\t\t\t\t<td>".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."</td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Cara Pembayaran</td>\r\n\t\t\t\t\t\t<td>\r\n            <select name=carabayar>";
    foreach ( $arraycarabayar as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n              </select>\r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t\t\t\r\n \r\n\r\n\t\t\t\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
}
?>