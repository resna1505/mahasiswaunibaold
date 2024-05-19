<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$arrayjeniscsvspc[''] = "SIKAD";
$arrayjeniscsvspc['BNIBATAM'] = "BNI-BATAM";
printjudulmenu( "IMPOR PEMBAYARAN BANK - {$tanggal}" );
$q = "SELECT ID,NAMA, LABELSPC FROM komponenpembayaran WHERE LABELSPC!=''";
$h = mysqli_query($koneksi,$q);
#while ( !( 0 < sqlnumrows( $h ) ) || !( $d = sqlfetcharray( $h ) ) )
#{
if(0 < sqlnumrows( $h )){
	while ($d = sqlfetcharray( $h )){
	
		$arraylabelspc[$d[LABELSPC]] = $d[ID];
		
	}
}
if ( $aksi == "PROSES IMPOR" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Impor tagihan", TAMBAH_DATA );
        $aksi = "";
    }
    else
    {
        echo "\r\n  <form method=post action=index.php\r\n \r\n  >\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=tanggal value='{$tanggal}'>\r\n \r\n  <table>\r\n    <tr class=juduldata align=center>\r\n      <td>NO</td> \r\n      <td>ID MAHASISWA</td> \r\n      <td>NAMA MAHASISWA</td> \r\n      <td>PROGRAM STUDI</td> \r\n      <td>ANGKATAN</td> \r\n      <td>GELOMBANG</td> \r\n      <td>JENIS KELAS</td> \r\n      <td>KOMPONEN</td> \r\n      <td>PERIODE</td> \r\n      <td>JUMLAH TAGIHAN</td> \r\n      <td>DIBAYAR</td> \r\n      <td>STATUS</td> \r\n    </tr>\r\n  ";
        $i = 0;
        foreach ( $datamahasiswa as $k => $idmahasiswa )
        {
            $q = "SELECT NAMA,ANGKATAN,IDPRODI,GELOMBANG,JENISKELAS FROM mahasiswa\r\n    WHERE ID='{$idmahasiswa}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                #$dm = sqlfetcharray( $h );
                $idspc = 1;
                #do
				while($dm = sqlfetcharray( $h ))
                {
                    if ( $idspc <= 10 )
                    {
                        $str = "dataamount_{$idspc}";
                        $idspc2 = "AMOUNT_{$idspc}";
                        $idkomponen = $arraylabelspc[$idspc2];
                        $jumlah = $$str[$idmahasiswa];
                        $sisa = $jumlah;
                        if ( 0 < $jumlah )
                        {
                            $q = "SELECT * FROM buattagihan WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TANGGALTAGIHAN='{$tanggal}' AND STATUS=0 ORDER BY TAHUN,SEMESTER ";
                            $ht = mysqli_query($koneksi,$q);
                            #do
							while($dt = sqlfetcharray($ht))
                            {
                                if (0 < sqlnumrows( $ht ) )
                                {
                                    break;
                                }
                                else
                                {
                                    ++$i;
                                    $periode = "";
                                }
                                if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
                                {
                                    $periode = "".( $dt[TAHUN] - 1 )."/{$dt['TAHUN']}";
                                }
                                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 || $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
                                {
                                    $periode = "".( $dt[TAHUN] - 1 )."/{$dt['TAHUN']} ".$arraysemester[$dt[SEMESTER]]."";
                                }
                                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
                                {
                                    $periode = "".$arraybulan2[$dt[SEMESTER]]." {$dt['TAHUN']}";
                                }
                                $jumlahtagihan = $dt[JUMLAH];
                                $dibayar = 0;
                                if ( $jumlahtagihan <= $sisa )
                                {
                                    $dibayar = $jumlahtagihan;
                                    $sisa = $sisa - $dibayar;
                                    $carabayar = 1;
                                    $status = "Gagal";
                                    $q = "INSERT INTO bayarkomponen \r\n            \t\t\t(IDMAHASISWA,TANGGALBAYAR,IDKOMPONEN,JENIS,JUMLAH,KET,TAHUNAJARAN,SEMESTER,CARABAYAR,DISKON,\r\n                  TANGGAL,USER,TGLUPDATE,DENDA,BIAYA,BEASISWA)\r\n            \t\t\tVALUES \r\n            \t\t\t('{$idmahasiswa}',CURDATE(),'{$idkomponen}','".$arrayjeniskomponenpembayaran[$idkomponen]."',\r\n            \t\t\t'{$dibayar}','Impor via Bank',\r\n            \t\t\t'{$dt['TAHUN']}','{$dt['SEMESTER']}','{$carabayar}','0',\r\n                  CURDATE(),'{$users}',CURDATE(),'0','".( $jumlahtagihan * 100 / ( 100 - $dt[BEASISWA] ) )."','{$dt['BEASISWA']}')";
                                    mysqli_query($koneksi,$q);
                                    if ( 0 < sqlaffectedrows( $koneksi ) )
                                    {
                                        $ketlog = "Impor Pembayaran dengan \r\n              \t\t\t\tID Komponen={$idkomponen} (".$dibayar."),ID Mahasiswa={$idmahasiswa} \r\n              \t\t\t\t";
                                        buatlog( 54 );
                                        $jenisjurnal = $arrayakunjenisjurnal[$carabayar];
                                        $idbayar = mysqli_insert_id($koneksi);
                                        $q = "SELECT MAX(ID) AS MAX FROM transkeuangan WHERE JENIS='{$jenisjurnal}'";
                                        $h = mysqli_query($koneksi,$q);
                                        $d = sqlfetcharray( $h );
                                        if ( $d[MAX] == "" )
                                        {
                                            $idbaru = 1;
                                        }
                                        else
                                        {
                                            $idbaru = $d[MAX] + 1;
                                        }
                                        $q = "INSERT INTO transkeuangan \r\n                          (ID,JENIS,TANGGAL,CATATAN,UPDATER,TANGGALUPDATE,KODE,STATUS)\r\n                          VALUES\r\n                          ('{$idbaru}','{$jenisjurnal}',CURDATE(),\r\n                        \t'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                              ','{$users}',NOW(),'BK-{$idbayar}',1)";
                                        mysqli_query($koneksi,$q);
                                        if ( 0 < sqlaffectedrows( $koneksi ) )
                                        {
                                            $q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
                                            $h = mysqli_query($koneksi,$q);
                                            $d = sqlfetcharray( $h );
                                            if ( $d[MAX] == "" )
                                            {
                                                $iddetilbaru = 0;
                                            }
                                            else
                                            {
                                                $iddetilbaru = $d[MAX] + 1;
                                            }
                                            if ( $carabayar == 0 )
                                            {
                                                $idakun = $arrayakun[kas];
                                            }
                                            else
                                            {
                                                $idakun = $arrayakun[bank];
                                            }
                                            $q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$idakun."','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]." mahasiswa dengan NIM {$idmahasiswa} {$periode}\r\n                             ','D')\r\n                              ";
                                            mysqli_query($koneksi,$q);
                                            $q = "SELECT MAX(ID) AS MAX FROM detilkeuangansgm WHERE JENIS='{$jenisjurnal}' AND IDTRANS='{$idbaru}'";
                                            $h = mysqli_query($koneksi,$q);
                                            $d = sqlfetcharray( $h );
                                            if ( $d[MAX] == "" )
                                            {
                                                $iddetilbaru = 0;
                                            }
                                            else
                                            {
                                                $iddetilbaru = $d[MAX] + 1;
                                            }
                                            $q = "INSERT INTO detilkeuangansgm (ID,IDTRANS,JENIS,JUMLAH,BUKTI,IDAKUN,UPDATER,TANGGALUPDATE,CATATAN,JENISAKUN)\r\n                                  VALUES ('{$iddetilbaru}','{$idbaru}','{$jenisjurnal}','".$dibayar."','{$tanda}','".$arrayakun[pendapatan]."-{$idkomponen}','{$users}',NOW(),'Pembayaran ".$arraykomponenpembayaran[$idkomponen]."  mahasiswa dengan NIM {$idmahasiswa} {$periode} \r\n                             ','K')\r\n                              ";
                                            mysqli_query($koneksi,$q);
                                            $status = "Berhasil";
                                            $q = "UPDATE buattagihan SET STATUS=1 \r\n                                WHERE IDMAHASISWA='{$idmahasiswa}' AND IDKOMPONEN='{$idkomponen}' AND TANGGALTAGIHAN='{$tanggal}' AND\r\n                                TAHUN='{$dt['TAHUN']}' AND SEMESTER='{$dt['SEMESTER']}'";
                                            mysqli_query($koneksi,$q);
                                        }
                                    }
                                    echo "\r\n                <tr>\r\n                  <td align=center>{$i}</td>\r\n                  <td>{$idmahasiswa} </td>\r\n                  <td nowrap>{$dm['NAMA']}</td>\r\n                  <td nowrap>".$arrayprodidep[$dm[IDPRODI]]." </td>\r\n                  <td align=center>{$dm['ANGKATAN']}</td>\r\n                  <td align=center>{$dm['GELOMBANG']}</td>\r\n                  <td  nowrap align=center>".$arraykelasstei[$dm[JENISKELAS]]." </td>\r\n                  <td  nowrap>".$arraykomponenpembayaran[$idkomponen]." </td>\r\n                  <td  nowrap>{$periode}</td>\r\n                  <td align=right >".cetakuang( $jumlahtagihan )."  </td>\r\n                  <td align=right >".cetakuang( $dibayar )."</td>\r\n                  <td align=right >{$status}</td>\r\n              \r\n                </tr>    \r\n                \r\n                ";
                                }
                            } #while ( 1 );
                        }
                        ++$idspc;
                    }
                } #while ( 1 );
            }
        }
        echo "\r\n  </table>\r\n \r\n  </form>";
    }
}
if ( $aksi == "LANJUT" )
{
    if ( $fileimpor == "" )
    {
        $errmesg = "File impor harus diisi.";
        $aksi = "";
    }
    else
    {
        if ( trim( $delimiter ) == "" )
        {
            $delimiter = ";";
        }
        $data = file( $fileimpor );
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        $hasil = "\r\n  <form method=post action=index.php\r\n  onSubmit=\"return confirm('Lakukan proses impor?');\"\r\n  >\r\n  <input type=hidden name=pilihan value='{$pilihan}'>\r\n  <input type=hidden name=tanggal value='{$tanggal}'>\r\n  <input type=submit name=aksi value='PROSES IMPOR'>".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n  <table>\r\n    <tr class=juduldata align=center>\r\n      <td>NO.BILLING</td>\r\n      <td>NO. MAHASISWA</td>\r\n       <td>NAMA MAHASISWA</td> \r\n      <!-- <td>ADDRESS_1</td>\r\n      <td>BILL_REF_1</td>\r\n      <td>BILL_REF_2</td>\r\n      <td>BILL_REF_3</td>\r\n      <td>BILL_REF_4</td>\r\n      <td>BILL_REF_5</td> -->\r\n      <td>NOMINAL</td>\r\n      <td>AMOUNT_1 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_1]]."</td>\r\n      <td>AMOUNT_2 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_2]]."</td>\r\n      <td>AMOUNT_3 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_3]]."</td>\r\n      <td>AMOUNT_4 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_4]]."</td>\r\n      <td>AMOUNT_5 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_5]]."</td>\r\n      <td>AMOUNT_6 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_6]]."</td>\r\n      <td>AMOUNT_7 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_7]]."</td>\r\n      <td>AMOUNT_8 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_8]]."</td>\r\n      <td>AMOUNT_9 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_9]]."</td>\r\n      <td>AMOUNT_10 <br> ".$arraykomponenpembayaran[$arraylabelspc[AMOUNT_10]]."</td>\r\n     <!--\r\n      <td>AUTODEBET_ACC_D</td>\r\n      <td>REGISTER_NO</td>\r\n      <td>DUE_DATE</td>\r\n      \r\n      -->\r\n    </tr>\r\n  ";
        $i = 0;
        foreach ( $data as $k => $v )
        {
            if ( $i == 0 )
            {
                ++$i;
                continue;
            }
            $d = explode( $delimiter, $v );
            if ( $jeniscsv == "" )
            {
                $BILLING_NO = $d[0];
                $PAYEE_ID = $d[1];
                $BILL_FIRST_NAME = $d[2];
                $ADDRESS_1 = $d[3];
                $BILL_REF_1 = $d[4];
                $BILL_REF_2 = $d[5];
                $BILL_REF_3 = $d[6];
                $BILL_REF_4 = $d[7];
                $BILL_REF_5 = $d[8];
                $AMOUNT_TOTAL = $d[9];
                $AMOUNT_1 = $d[10];
                $AMOUNT_2 = $d[11];
                $AMOUNT_3 = $d[12];
                $AMOUNT_4 = $d[13];
                $AMOUNT_5 = $d[14];
                $AMOUNT_6 = $d[15];
                $AMOUNT_7 = $d[16];
                $AMOUNT_8 = $d[17];
                $AMOUNT_9 = $d[18];
                $AMOUNT_10 = $d[19];
                $AUTODEBET_ACC_D = $d[20];
                $REGISTER_NO = $d[21];
                $DUE_DATE = $d[22];
            }
            else if ( $jeniscsv == "BNIBATAM" )
            {
                $BILLING_NO = $d[1];
                $PAYEE_ID = $d[2];
                $BILL_FIRST_NAME = $d[3];
                $BILL_REF_1 = $d[9];
                $BILL_REF_2 = $d[10];
                $BILL_REF_3 = $d[11];
                $BILL_REF_4 = $d[12];
                $BILL_REF_5 = $d[13];
                $AMOUNT_TOTAL = $d[6];
                $AMOUNT_1 = $d[14];
                $AMOUNT_2 = $d[15];
                $AMOUNT_3 = $d[16];
                $AMOUNT_4 = $d[17];
                $AMOUNT_5 = $d[18];
                $AMOUNT_6 = $d[19];
                $AMOUNT_7 = $d[20];
                $AMOUNT_8 = $d[21];
                $AMOUNT_9 = $d[22];
                $AMOUNT_10 = $d[23];
            }
            if ( $id != "" && $id != $PAYEE_ID )
            {
                continue;
            }
            if ( $angkatan != "" && $angkatan != getfield( "ANGKATAN", "mahasiswa", "WHERE ID='{$PAYEE_ID}'" ) )
            {
                continue;
            }
            if ( $idprodi != "" && $idprodi != getfield( "IDPRODI", "mahasiswa", "WHERE ID='{$PAYEE_ID}'" ) )
            {
                continue;
            }
            $hasil .= "\r\n    <tr>\r\n      <td nowrap>{$BILLING_NO} <input type=checkbox name='datamahasiswa[{$PAYEE_ID}]'   value='{$PAYEE_ID}' checked></td>\r\n      <td>{$PAYEE_ID}</td>\r\n      <td nowrap>{$BILL_FIRST_NAME} </td>\r\n      <!-- <td>{$ADDRESS_1}</td>\r\n      <td>{$BILL_REF_1}</td>\r\n      <td>{$BILL_REF_2}</td>\r\n      <td>{$BILL_REF_3}</td>\r\n      <td>{$BILL_REF_4}</td>\r\n      <td>{$BILL_REF_5}</td> -->\r\n      <td align=right>".cetakuang( $AMOUNT_TOTAL )."</td>\r\n      <td><input type=text size=8 name='dataamount_1[{$PAYEE_ID}]' value='{$AMOUNT_1}'></td>\r\n      <td><input type=text size=8 name='dataamount_2[{$PAYEE_ID}]' value='{$AMOUNT_2}'></td>\r\n      <td><input type=text size=8 name='dataamount_3[{$PAYEE_ID}]' value='{$AMOUNT_3}'></td>\r\n      <td><input type=text size=8 name='dataamount_4[{$PAYEE_ID}]' value='{$AMOUNT_4}'></td>\r\n      <td><input type=text size=8 name='dataamount_5[{$PAYEE_ID}]' value='{$AMOUNT_5}'></td>\r\n      <td><input type=text size=8 name='dataamount_6[{$PAYEE_ID}]' value='{$AMOUNT_6}'></td>\r\n      <td><input type=text size=8 name='dataamount_7[{$PAYEE_ID}]' value='{$AMOUNT_7}'></td>\r\n      <td><input type=text size=8 name='dataamount_8[{$PAYEE_ID}]' value='{$AMOUNT_8}'></td>\r\n      <td><input type=text size=8 name='dataamount_8[{$PAYEE_ID}]' value='{$AMOUNT_9}'></td>\r\n      <td><input type=text size=8 name='dataamount_10[{$PAYEE_ID}]' value='{$AMOUNT_10}'></td>\r\n     <!--\r\n      <td>{$AUTODEBET_ACC_D}</td>\r\n      <td>{$REGISTER_NO}</td>\r\n      <td>{$DUE_DATE}</td>\r\n    -->\r\n    </tr>    \r\n    \r\n    ";
            ++$i;
        }
        $hasil .= "\r\n  </table>\r\n    <input type=submit name=aksi value='PROSES IMPOR'>  \r\n  </form>";
        if ( 1 < $i )
        {
            echo $hasil;
        }
        else
        {
            printmesg( "Tidak ada data yang dapat diimpor.  " );
        }
    }
}
if ( $aksi == "" )
{
    printmesg( $errmesg );
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL \r\n    FROM buattagihan WHERE 1=1 \r\n    GROUP BY TANGGALTAGIHAN \r\n    ORDER BY TANGGALTAGIHAN DESC ";
    $h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d[TANGGALTAGIHAN]] = $d;
        }
        echo "\r\n\r\n        <form method=post action=index.php  ENCTYPE='MULTIPART/FORM-DATA'>\r\n        <input type=hidden name=pilihan value='{$pilihan}'>\r\n        <table width=100% >\r\n        <tr>\r\n            <td>Tanggal Tagihan</td>\r\n            <td>\r\n              <select name=tanggal>\r\n                \r\n            ";
        foreach ( $arraytagihan as $k => $v )
        {
            echo "<option value='{$k}'>{$v['TGL']} # ({$v['SUDAHDIPROSES']} dari {$v['JUMLAHDATA']} data telah dibayar)</option>";
        }
        echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n \r\n    <tr>\r\n      <td>File CSV</td>\r\n      <td><input type=file name=fileimpor> Delimiter  <input type=text size=1 name=delimiter value=\";\"> \r\n      JENIS : <select name=jeniscsv>\r\n                \r\n            ";
        foreach ( $arrayjeniscsvspc as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n              </select>\r\n      </td>\r\n     </tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        foreach ( $arrayprodidep as $k => $v )
        {
            echo "<option value='{$k}'>{$v}</option>";
        }
        echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
        $waktu = getdate( );
        echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
        $arrayangkatan = getarrayangkatan( );
        foreach ( $arrayangkatan as $k => $v )
        {
            echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        }
        echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>NIM</td>\r\n\t\t\t<td>".createinputtext( "id", $id, " class=masukan  size=20 id='inputString' onkeyup=\"lookup(this.value,form.angkatan.value,form.idprodi.value);\" " )."\r\n \r\n             <div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">\r\n               <div class=\"suggestionList\" id=\"autoSuggestionsList\">\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\r\n     \r\n     \r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=LANJUT> \r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
    }
    else
    {
        printmesg( "Data tagihan tidak ada." );
    }
}
?>
