<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
#printjudulmenu( "IMPOR DATA PEMBAYARAN" );
if ( $aksi == "PROSES IMPOR" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        unset( $_SESSION['token'] );
        if ( is_array( $pilih ) )
        {
            $hasiltabel = "\r\n          <table width=100% border=1>\r\n            <tr class=juduldata align=center>\r\n       \r\n              <td>ID Mahasiswa</td>\r\n              <td>ID Komponen</td>\r\n              <td>Tanggal Bayar</td>\r\n              <td>Jenis</td>\r\n              <td>Jumlah</td>\r\n              <td>Ket</td>\r\n              <td>Tahun Ajaran</td>\r\n              <td>Semester</td>\r\n              <td>Cara Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Tanggal Entri</td>\r\n              <td>Denda</td>\r\n              <td>Bulan SPP</td>\r\n              <td>Biaya</td>\r\n              <td>Status Impor</td>\r\n            </tr>\r\n       ";
            foreach ( $pilih as $k => $v )
            {
                $statusimpor = 1;
                $errorimpor = $hasilimpor = $styletr = "";
                $biayakomponen = 0;
                $q = "SELECT ANGKATAN,GELOMBANG,IDPRODI,JENISKELAS FROM mahasiswa WHERE ID='".$idmhs[$k]."'";
                #echo $q;
				$h = mysqli_query($koneksi,$q);
                echo mysqli_error($koneksi);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                    {
                        $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$d['JENISKELAS']}' ";
                        $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
                    }
                    else
                    {
                        $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
                        $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
                    }
                    $q = "SELECT BIAYA FROM biayakomponen \r\n              WHERE \r\n              IDKOMPONEN='".$idkomponen[$k]."' AND \r\n              IDPRODI='{$d['IDPRODI']}'  AND \r\n              ANGKATAN='{$d['ANGKATAN']}' AND\r\n              GELOMBANG='{$d['GELOMBANG']}' {$qfieldjeniskelas}\r\n              ";
                    #echo $q;
					$h2 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h2 ) )
                    {
                        $d2 = sqlfetcharray( $h2 );
                        $biayakomponen = $d2[BIAYA];
                        $biaya[$k] = $biayakomponen;
                        if ( $biayakomponen <= 0 )
                        {
                            $statusimpor = 0;
                            $errorimpor = "Biaya Komponen Keuangan Nol.";
                            $styltr = "style='background:#FFFF00;'";
                        }
                    }
                    else
                    {
                        $statusimpor = 0;
                        $errorimpor = "Biaya Komponen Keuangan tidak ada.";
                        $styltr = "style='background:#FFFF00;'";
                    }
                }
				#echo $statusimpor;exit();
                $namamhs = getfieldfromtabel( $idmhs[$k], "NAMA", "mahasiswa" );
                $namakomponen = getfieldfromtabel( $idkomponen[$k], "NAMA", "komponenpembayaran" );
                if ( $statusimpor == 1 )
                {
                    $q = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA='".$idmhs[$k]."' AND IDKOMPONEN='".$idkomponen[$k]."'  TANGGALBAYAR='".$tglbayar[$k]."' LIMIT 0,1";
                    $h3 = mysqli_query($koneksi,$q);
                    if ( 0 < sqlnumrows( $h3 ) )
                    {
                        $hasilimpor = "GAGAL";
                        $errorimpor = "Data pembayaran sudah ada.";
                        $styltr = "style='background:#FFFF00;'";
                    }
                    else
                    {
                        $q = "INSERT INTO bayarkomponen(IDMAHASISWA,IDKOMPONEN,TANGGALBAYAR,JENIS, JUMLAH,KET,TAHUNAJARAN,SEMESTER, CARABAYAR,DISKON,TANGGAL,USER,TGLUPDATE,DENDA,BULANSPP,BIAYA) VALUES ('".$idmhs[$k]."','".$idkomponen[$k]."','".$tglbayar[$k]."','".$jenisbayar[$k]."','".$jumlahbayar[$k]."','".$ket[$k]."','".( $tahun[$k] + 1 )."','".$semester[$k]."','".$carabayar[$k]."','".$diskon[$k]."','".$tglentri[$k]."','{$users}',NOW(),'".$denda[$k]."','".$bulanspp[$k]."','".$biaya[$k]."')\r\n            ";
                        #echo $q;
						#mysqli_query($koneksi,$q);
                        if ( sqlaffectedrows( $koneksi ) )
                        {
                            ++$berhasil;
                            $hasilimpor = "OK";
                            $ketlog = "(IMPOR) Tambah Pembayaran dengan \r\n        \t\t\t\tID Komponen=".$idkomponen[$k]." (".$jumlahbayar[$k]."),ID Mahasiswa=".$idmhs[$k].",\r\n        \t\t\t\tTanggal bayar={$tglbayar[$k]}\r\n        \t\t\t\t";
                            buatlog( 54 );
                        }
                        else
                        {
                            $styltr = "style='background:#FFFF00;'";
                        }
                    }
                }
                $hasiltabel .= "       \r\n            <tr {$styltr}>       \r\n              <td nowrap>".$idmhs[$k]." /  {$namamhs} </td>\r\n              <td nowrap>".$idkomponen[$k]." / {$namakomponen}</td>\r\n              <td nowrap  >".$tglbayar[$k]."</td>\r\n              <td align=center nowrap>".$arrayjenispembayaran[$jenisbayar[$k]]." (".$jenisbayar[$k].")</td>\r\n              <td align=right>".cetakuang( $jumlahbayar[$k] )."</td>\r\n              <td>".$ket[$k]."</td>\r\n              <td align=center>".$tahun[$k]."/".( $tahun[$k] + 1 )."</td>\r\n              <td align=center>".$semester[$k]."</td>\r\n              <td align=center nowrap>".$arraycarabayar[$carabayar[$k]]." (".$carabayar[$k].")   </td>\r\n              <td align=right>".cetakuang( $diskon[$k] )."</td>\r\n              <td nowrap>".$tglentri[$k]."</td>\r\n              <td align=right>".cetakuang( $denda[$k] )."</td>\r\n              <td nowrap>".$bulanspp[$k]."</td>\r\n              <td align=right>".cetakuang( $biaya[$k] )."</td>\r\n              <td align=left nowrap>{$hasilimpor} {$errorimpor}</td>\r\n              </tr>\r\n          ";
            }
            $hasiltabel .= "</table>";
            if ( 0 < $berhasil )
            {
                $errmesg = "{$berhasil} Data pembayaran berhasil diimpor";
            }
            else
            {
                $errmesg = "Data pembayaran tidak diimpor ".$errorimpor;
            }
            printmesg( $errmesg );
            echo "<br><br>";
            echo "{$hasiltabel}";
        }
        else
        {
            $aksi = "";
            $errmesg = "Data yang diimpor tidak ada.";
        }
    }
    else
    {
        $errmesg = token_err_mesg( "DATA PEMBAYARAN", SIMPAN_DATA );
        $aksi = "";
    }
}
if ( $aksi == "PROSES" )
{
    if ( $_SESSION['token'] == $_POST['sessid'] )
    {
        if ( $jenisfile == "DBF" )
        {
            require_once( "../dbfparser/Column.class.php" );
            require_once( "../dbfparser/Record.class.php" );
            require_once( "../dbfparser/Table.class.php" );
        }
        $tmp = explode( ".", $fileimpor_name );
        $ext = $tmp[count( $tmp ) - 1];
		#echo $tmp.'XXX'.$ext.'<br>';
        if ( $fileimpor_name == "" || !( strtoupper( $ext ) == "DBF" || strtoupper( $ext ) == "txt" ) )
        {
            $errmesg = "File kosong atau tidak valid.";
            $aksi = "";
        }
        else
        {
            $token = md5( uniqid( rand( ), TRUE ) );
            $_SESSION['token'] = $token;
            $berhasil = 0;
            if ( $jenisfile == "DBF" )
            {
                $table = new dbfTable( $fileimpor );
                $table->open( );
            }
            else
            {
				#echo $delimiter.'<br>';
                $data = file( $fileimpor );
                if ( trim( $delimiter == "" ) )
                {
                    $delimiter = ";";
                }
            }
            $qjudul = "";
            if ( $id != "" )
            {
                $qjudul .= "ID Mahasiswa = {$id} <br>";
            }
            if ( $istanggal == 1 && ( mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) < mktime( 0, 0, 0, $tgl1[bln], $bln1[tgl], $tgl1[thn] ) || mktime( 0, 0, 0, $tgl2[bln], $bln2[tgl], $tgl2[thn] ) < mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) ) )
            {
                $qjudul .= "Antara tanggal {$tgl1['tgl']}-{$tgl1['bln']}-{$tgl1['thn']} s.d  {$tgl2['tgl']}-{$tgl2['bln']}-{$tgl2['thn']} <br>";
            }
            echo "\r\n    <form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'\r\nonSubmit=\"return confirm('Lakukan impor data pembayaran?')\"\r\n     >\r\n<input type=submit name=aksi value='PROSES IMPOR' class=masukan>    <br><br>      \r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=tab value='{$tab}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."";
            printmesg( $qjudul );
            echo "\r\n    <br>\r\n          <table width=100% border=1>\r\n            <tr class=juduldata align=center>\r\n              <td>Pilih</td>\r\n              <td>ID Mahasiswa</td>\r\n              <td>ID Komponen</td>\r\n              <td>Tanggal Bayar</td>\r\n              <td>Jenis</td>\r\n              <td>Jumlah</td>\r\n              <td>Ket</td>\r\n              <td>Tahun Ajaran</td>\r\n              <td>Semester</td>\r\n              <td>Cara Bayar</td>\r\n              <td>Diskon</td>\r\n              <td>Tanggal Entri</td>\r\n              <td>Denda</td>\r\n              <td>Bulan SPP</td>\r\n              <td>Biaya</td>\r\n            </tr>\r\n          ";
            $i = 0;
            if ( $jenisfile == "DBF" )
            {
                while ( $record = $table->nextRecord( ) )
                {
                    ++$i;
                    $styletr = "";
                    $idmhs = $record->getStringByName( "IDMHS" );
                    if ( $id != "" && $id != $idmhs )
                    {
                        continue;
                    }
                    $tglbayar = $record->getStringByName( "TGLBAYAR" );
                    $tmptgl = explode( "-", $tglbayar );
                    if ( $istanggal == 1 && ( mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) < mktime( 0, 0, 0, $tgl1[bln], $bln1[tgl], $tgl1[thn] ) || mktime( 0, 0, 0, $tgl2[bln], $bln2[tgl], $tgl2[thn] ) < mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) ) )
                    {
                        continue;
                    }
                    $namamhs = getfieldfromtabel( $idmhs, "NAMA", "mahasiswa" );
                    $carabayar = $record->getStringByName( "CARABAYAR" );
                    $idkomponen = $record->getStringByName( "IDKOMPONEN" );
                    $namakomponen = getfieldfromtabel( $idkomponen, "NAMA", "komponenpembayaran" );
                    $jenisbayar = getfieldfromtabel( $idkomponen, "JENIS", "komponenpembayaran" );
                    $jumlahbayar = $record->getFloat( $record->getColumnByName( "JUMLAH" ) );
                    $ket = $record->getStringByName( "KET" );
                    $tahun = $record->getStringByName( "TAHUN" );
                    $semester = $record->getStringByName( "SEMESTER" );
                    $diskon = $record->getStringByName( "DISKON" );
                    $tglentri = $record->getStringByName( "TGLENTRI" );
                    $denda = $record->getStringByName( "DENDA" );
                    $bulanspp = $record->getStringByName( "BULANSPP" );
                    $biaya = $record->getFloat( $record->getColumnByName( "BIAYA" ) );
                    $statusvalid = 1;
                    if ( $idmhs == "" || $namamhs == "" || $idkomponen == "" || $namakomponen == "" || $jumlahbayar <= 0 || $tglbayar == "" || $tglentri == "" || $jenisbayar == "" || $jenisbayar == 2 && $tahun == "" || $jenisbayar == 3 && ( $tahun == "" || $semester == "" ) || $jenisbayar == 5 && ( $tahun == "" || $semester == "" || $bulanspp == "" ) )
                    {
                        $statusvalid = 0;
                        $styltr = "style='background:#FFFF00;'";
                    }
                    echo "\r\n                <tr {$styltr}>\r\n                  <td align=center>";
                    if ( $statusvalid == 1 )
                    {
                        echo "\r\n                    <input type=checkbox name='pilih[{$i}]' value=1 checked > ";
                    }
                    echo "\r\n                  <input type=hidden name='idmhs[{$i}]' value='{$idmhs}'  >\r\n                  <input type=hidden name='idkomponen[{$i}]' value='{$idkomponen}'  >\r\n                  <input type=hidden name='tglbayar[{$i}]' value='{$tglbayar}'  >\r\n                  <input type=hidden name='jenisbayar[{$i}]' value='{$jenisbayar}'  >\r\n                  <input type=hidden name='jumlahbayar[{$i}]' value='{$jumlahbayar}'  >\r\n                  <input type=hidden name='ket[{$i}]' value='{$ket}'  >\r\n                  <input type=hidden name='tahun[{$i}]' value='{$tahun}'  >\r\n                  <input type=hidden name='semester[{$i}]' value='{$semester}'  >\r\n                  <input type=hidden name='carabayar[{$i}]' value='{$carabayar}'  >\r\n                  <input type=hidden name='diskon[{$i}]' value='{$diskon}'  >\r\n                  <input type=hidden name='tglentri[{$i}]' value='{$tglentri}'  >\r\n                  <input type=hidden name='denda[{$i}]' value='{$denda}'  >\r\n                  <input type=hidden name='bulanspp[{$i}]' value='{$bulanspp}'  >\r\n                  <input type=hidden name='biaya[{$i}]' value='{$biaya}'  >\r\n                  </td>\r\n                  <td nowrap>{$idmhs} /  {$namamhs} </td>\r\n                  <td nowrap>{$idkomponen} / {$namakomponen}</td>\r\n                  <td nowrap  >{$tglbayar}</td>\r\n                  <td align=center nowrap>".$arrayjenispembayaran[$jenisbayar]." ({$jenisbayar})</td>\r\n                  <td align=right>".cetakuang( $jumlahbayar )."</td>\r\n                  <td>".$ket."</td>\r\n                  <td align=center>{$tahun}/".( $tahun + 1 )."</td>\r\n                  <td align=center>".$semester."</td>\r\n                  <td align=center nowrap>".$arraycarabayar[$carabayar]." ({$carabayar})   </td>\r\n                  <td align=right>".cetakuang( $diskon )."</td>\r\n                  <td nowrap>".$tglentri."</td>\r\n                  <td align=right>".cetakuang( $denda )."</td>\r\n                  <td>".$bulanspp."</td>\r\n                  <td align=right>".cetakuang( $biaya )."</td>\r\n                </tr>            ";
                }
            }
            else
            {
				#print_r($data);
				#echo '<br>';
                foreach ( $data as $k => $v )
                {
                    $i++;
                    if ( $i == 1 )
                    {
                        continue;
                    }
					#echo $delimiter.'<br>';
					#echo $v.'<br>';
                    $d = explode( $delimiter, $v );
				#	print_r($d).'<br>';
                    $styletr = "";
                    $idmhs = $d[0];
                    if ( $id != "" && $id != $idmhs )
                    {
                        continue;
                    }
                    $tglbayar = $d[2];
                    $tmptgl = explode( "/", $tglbayar );
                    if ( $tmptgl[2] == "" )
                    {
                        $tmptgl = explode( "-", $tglbayar );
                        if ( $tmptgl[2] == "" )
                        {
                            $tmptgl = explode( "-", $tglbayar );
                            $tmptgl[0] = substr( $tglbayar, 0, 4 );
                            $tmptgl[1] = substr( $tglbayar, 4, 2 );
                            $tmptgl[2] = substr( $tglbayar, 6, 2 );
                        }
                    }
                    if ( $istanggal == 1 && ( mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) < mktime( 0, 0, 0, $tgl1[bln], $bln1[tgl], $tgl1[thn] ) || mktime( 0, 0, 0, $tgl2[bln], $bln2[tgl], $tgl2[thn] ) < mktime( 0, 0, 0, $tmptgl[1], $tmptgl[2], $tmptgl[0] ) ) )
                    {
                        continue;
                    }
                    $namamhs = getfieldfromtabel( $idmhs, "NAMA", "mahasiswa" );
                    $carabayar = $d[8];
                    $idkomponen = $d[1];
                    $namakomponen = getfieldfromtabel( $idkomponen, "NAMA", "komponenpembayaran" );
                    $jenisbayar = getfieldfromtabel( $idkomponen, "JENIS", "komponenpembayaran" );
                    $jumlahbayar = $d[4];
                    $ket = $d[5];
                    $tahun = $d[6];
                    $semester = $d[7];
                    $diskon = $d[9];
                    $tglentri = $d[10];
                    $denda = $d[11];
                    $bulanspp = $d[12];
                    $biaya = $d[13];
                    $statusvalid = 1;
                    if ( $idmhs == "" || $namamhs == "" || $idkomponen == "" || $namakomponen == "" || $jumlahbayar <= 0 || $tglbayar == "" || $tglentri == "" || $jenisbayar == "" || $jenisbayar == 2 && $tahun == "" || $jenisbayar == 3 && ( $tahun == "" || $semester == "" ) || $jenisbayar == 5 && ( $tahun == "" || $semester == "" || $bulanspp == "" ) )
                    {
                        $statusvalid = 0;
                        $styltr = "style='background:#FFFF00;'";
                    }
                    echo "\r\n                <tr {$styltr}>\r\n                  <td align=center>";
                    if ( $statusvalid == 1 )
                    {
                        echo "\r\n                    <input type=checkbox name='pilih[{$i}]' value=1 checked > ";
                    }
                    echo "\r\n                  <input type=hidden name='idmhs[{$i}]' value='{$idmhs}'  >\r\n                  <input type=hidden name='idkomponen[{$i}]' value='{$idkomponen}'  >\r\n                  <input type=hidden name='tglbayar[{$i}]' value='{$tglbayar}'  >\r\n                  <input type=hidden name='jenisbayar[{$i}]' value='{$jenisbayar}'  >\r\n                  <input type=hidden name='jumlahbayar[{$i}]' value='{$jumlahbayar}'  >\r\n                  <input type=hidden name='ket[{$i}]' value='{$ket}'  >\r\n                  <input type=hidden name='tahun[{$i}]' value='{$tahun}'  >\r\n                  <input type=hidden name='semester[{$i}]' value='{$semester}'  >\r\n                  <input type=hidden name='carabayar[{$i}]' value='{$carabayar}'  >\r\n                  <input type=hidden name='diskon[{$i}]' value='{$diskon}'  >\r\n                  <input type=hidden name='tglentri[{$i}]' value='{$tglentri}'  >\r\n                  <input type=hidden name='denda[{$i}]' value='{$denda}'  >\r\n                  <input type=hidden name='bulanspp[{$i}]' value='{$bulanspp}'  >\r\n                  <input type=hidden name='biaya[{$i}]' value='{$biaya}'  >\r\n                  </td>\r\n                  <td nowrap>{$idmhs} /  {$namamhs} </td>\r\n                  <td nowrap>{$idkomponen} / {$namakomponen}</td>\r\n                  <td nowrap  >  {$tmptgl['0']}-{$tmptgl['1']}-{$tmptgl['2']}</td>\r\n                  <td align=center nowrap>".$arrayjenispembayaran[$jenisbayar]." ({$jenisbayar})</td>\r\n                  <td align=right>".cetakuang( $jumlahbayar )."</td>\r\n                  <td>".$ket."</td>\r\n                  <td align=center>{$tahun}/".( $tahun + 1 )."</td>\r\n                  <td align=center>".$semester."</td>\r\n                  <td align=center nowrap>".$arraycarabayar[$carabayar]." ({$carabayar})   </td>\r\n                  <td align=right>".cetakuang( $diskon )."</td>\r\n                  <td nowrap>".$tglentri."</td>\r\n                  <td align=right>".cetakuang( $denda )."</td>\r\n                  <td>".$bulanspp."</td>\r\n                  <td align=right>".cetakuang( $biaya )."</td>\r\n                </tr>            ";
                }
				exit();
            }
            echo "</table>\r\n <br><br>  \r\n<input type=submit name=aksi value='PROSES IMPOR' class=masukan>          \r\n\r\n          </form>";
            if ( $jenisfile == "DBF" )
            {
                $table->close( );
            }
        }
    }
    else
    {
        $errmesg = token_err_mesg( "DATA PEMBAYARAN", SIMPAN_DATA );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    #printmesg( $errmesg );
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    #echo "\r\n<p>\r\n<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA'\r\nonSubmit=\"return confirm('Yakin hendak memasukkan data? Pastikan data yang Anda masukkan valid dan harap sabar menunggu sebab lama proses impor bergantung pada besar-kecil-nya file yang diimpor.')\"\r\n>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=tab value='{$tab}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\r\n  <table>\r\n    <tr>\r\n      <td>FILE</td>\r\n      <td>\r\n      <input type=radio name=jenisfile value='DBF' checked> DBF\r\n      <input type=radio name=jenisfile value='CSV'> CSV, Delimiter <input type=text size=1 value=';' readonly>\r\n      <br>\r\n      <br>File <input type=file name=fileimpor> \r\n      </td>\r\n     </tr>\r\n     <tr>\r\n      <td>ID Mahasiswa</td>\r\n      <td><input type=text name=id></td>\r\n     </tr>\r\n    <tr>\r\n      <td>Tanggal</td>\r\n      <td><input type=checkbox name=istanggal value=1>\r\n      ".createinputtanggal( "tgl1", "", "", "", "" )." s.d\r\n      ".createinputtanggal( "tgl2", "", "", "", "" )."\r\n      </td>\r\n     </tr>\r\n \r\n    <tr>\r\n        <td></td>\r\n\t\t\t\t<td  >\r\n\t\t\t\t\t<input type=submit name=aksi value='PROSES' class=masukan>\r\n \t\t\t\t</td>\r\n\t\t\t</tr>\r\n  </table>\r\n\r\n</form>\r\n</p><br><br>\r\n";
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Impor Data Pembayaran");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post ENCTYPE='MULTIPART/FORM-DATA' onSubmit=\"return confirm('Yakin hendak memasukkan data? Pastikan data yang Anda masukkan valid dan harap sabar menunggu sebab lama proses impor bergantung pada besar-kecil-nya file yang diimpor.')\" class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<input type=hidden name=tab value='{$tab}'>".createinputhidden( "sessid", $_SESSION['token'], "" )."
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jenis File</label>
										<div class=\"col-lg-6\">
											<div class=\"m-radio-list\">
												<label class=\"m-radio\">
													<input type=radio name=jenisfile value='DBF' checked> DBF
												<span></span>
												</label>
												<label class=\"m-radio\">					
													<input type=radio name=jenisfile value='CSV'> CSV
												<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Delimiter</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text size=1 value=';' readonly>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">File</label>\r\n    
										<label class=\"col-form-label\">
											<input type=file name=fileimpor>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='PROSES' class=\"btn btn-brand\">
											</div>
				</div>
			</div>
		</form>
	</div>
	</div>
	</div>
	</div>
	</div>";
}
?>
