<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( $aksi == "HAPUS" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tagihan", HAPUS_DATA );
    }
    else
    {
        $q = "DELETE FROM buattagihan_calonmahasiswa WHERE TANGGALTAGIHAN='{$tanggal}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data tagihan tanggal {$tanggal} telah dihapus.";
        }
    }
    $aksi = "";
}
$strunduh = "<form method=post action=downloadtagihan_calonmahasiswa.php target=_blank>\r\n<input type=hidden name=tanggal value=\"_TANGGAL_\">\r\n<table width=100% >\r\n<tr>\r\n  <td width=150 >\r\n    Tipe \r\n   </td>\r\n  <td   >\r\n    <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n    <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">  </td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2>\r\n    <input type=submit name=aksi value=UNDUH>\r\n    <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n  </td>\r\n</tr>\r\n</table>\r\n</form>";
printjudulmenu( "BUAT TAGIHAN CALON MAHASISWA" );
if ( $aksi == "Lanjut" )
{
    $qfield = $qjudul = "";
    if ( is_array( $jenispilihan ) )
    {
        $qfield = " AND (";
        foreach ( $jenispilihan as $k => $v )
        {
            $qfield .= " komponenpembayaran.JENIS='{$k}' OR";
        }
        $qfield .= ")";
        $qfield = str_replace( "OR)", ")", $qfield );
    }
    if ( $angkatancari != "" )
    {
        $qfield .= " AND a.ANGKATAN='{$angkatancari}' ";
        $qjudul .= " Angkatan {$angkatancari} <br>";
    }
    if ( $idprodicari != "" )
    {
        $qfield .= " AND a.IDPRODI='{$idprodicari}' ";
        $qjudul .= " Program Studi ".$arrayprodidep[$idprodicari]." <br>";
    }
    /*if ( $jeniskolom == "SPC" )
    {
        $qfield .= " AND komponenpembayaran.LABELSPC!='' ";
        $qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	if ( $jeniskolom == "" )
    {
        $qfield .= " AND komponenpembayaran.LABELSPC='' ";
        $qjudul .= " Komponen Non SPC saja <br>";
    }*/
    $tanggal = "{$tgl['thn']}-{$tgl['bln']}-{$tgl['tgl']}";
    $qfieldbiaya = $qcolumn = "";
    $jeniskelaskeuangan = 0;
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $jeniskelaskeuangan = 1;
        $qcolumn = " ,biayakomponen_tagihan.JENISKELAS  ";
        $qcolumn2 = " ,a.JENISKELAS  ";
        $qfieldbiaya = " AND biayakomponen_tagihan.JENISKELAS!='' AND biayakomponen_tagihan.JENISKELAS='{$jeniskelas}'";
        $qfieldmahasiswa = " AND JENISKELAS!='' AND JENISKELAS='{$jeniskelas}'";
        $qtagihan = "\r\n            \r\n              b.JENISKELAS=a.JENISKELAS AND  \r\n            ";
    }
    if ( $tanggal != "" )
    {
        $qjudul .= " Tanggal Tagihan {$tgl['tgl']}-{$tgl['bln']}-{$tgl['thn']} <br>";
        printmesg( $qjudul );
        $q = "\r\n    \r\n    SELECT   komponenpembayaran.JENIS,komponenpembayaran.LABELSPC, \r\n    a.*,a.TANGGAL AS TANGGALTAGIH,DATE_FORMAT(a.TANGGAL,'%d-%m-%Y') AS TGLTAGIH,\r\n    DATE_FORMAT(a.TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1,\r\n    DATE_FORMAT(a.TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n    \r\n    FROM\r\n     komponenpembayaran,\r\n    biayakomponen_tagihan a, \r\n    (\r\n      SELECT biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI, \r\n      biayakomponen_tagihan.GELOMBANG {$qcolumn2} , \r\n      MAX(IF(biayakomponen_tagihan.TANGGAL <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d') ,  \r\n      biayakomponen_tagihan.TANGGAL,'1901-01-01') )  AS TANGGALTAGIH \r\n      \r\n      FROM\r\n      biayakomponen_tagihan \r\n      GROUP BY biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI, \r\n      biayakomponen_tagihan.GELOMBANG {$qcolumn2} \r\n       \r\n    ) b \r\n    WHERE\r\n     komponenpembayaran.ID =a.IDKOMPONEN AND   \r\n              b.IDKOMPONEN=a.IDKOMPONEN AND  \r\n              b.IDPRODI=a.IDPRODI AND  \r\n              b.ANGKATAN=a.ANGKATAN AND  \r\n              b.GELOMBANG=a.GELOMBANG AND  \r\n              {$qtagihan}\r\n              \r\n              \r\n              b.TANGGALTAGIH=a.TANGGAL AND\r\n              b.TANGGALTAGIH  <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d')   \r\n                 {$qfield}\r\n                 \r\n                 ORDER BY   a.IDPRODI, a.ANGKATAN,\r\n      a.GELOMBANG {$qcolumn2} , a.IDKOMPONEN\r\n    ";
        #echo $q;
		$h = mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
        if ( 0 < sqlnumrows( $h ) )
        {
            $strunduh = str_replace( "_TANGGAL_", "{$tanggal}", $strunduh );
            $strunduhproses = preg_replace( "/\\s+/", " ", "<div align=left><br><b>PERHATIAN!! JANGAN mengulangi proses sebelum mengunduh hasil akhir. Jika proses diulangi, data hasil akhir pembuatan tagihan untuk tanggal yang sama akan tertimpa. {$strunduh} </b></div>" );
            echo "\r\n           <script type=\"text/javascript\" language=\"javascript\">\r\n              var counter=0;\r\n              var selesai=0;\r\n              var gagal=0;\r\n              \r\n           </script> \r\n           <div align=center id='linkdownload' ><br><input type=button id=proses value='Klik di sini untuk memulai proses pembuatan tagihan '><br><br></div>\r\n        <table>\r\n          <tr class=juduldata align=center>\r\n            <td>Program Studi</td>\r\n            <td>Angkatan</td>\r\n            <td>Gelombang</td>\r\n            ";
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                echo "\r\n                  <td>Jenis Kelas</td>\r\n                  ";
            }
            echo "\r\n            <td>Komponen</td>\r\n            <td>Periode</td>\r\n            <td>Label SPC</td>\r\n            <td>Tanggal Tagihan</td>\r\n            <td>Periode Pembayaran</td>\r\n            <td>Status</td>\r\n          </tr>\r\n      ";
            $i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $arraytagihan[] = $d;
                $idkomponen = $d[IDKOMPONEN];
                ++$i;
                $periode = "";
                if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 )
                {
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
                {
                    $periode = ( "".( $d[TAHUN] - 1 ) )."/{$d['TAHUN']}";
                }
                else
                {
                    $periode = ( "".( $d[TAHUN] - 1 ) )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]];
                    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
                    {
                        $periode = "".$arraybulan2[$d[SEMESTER]]." ".$d[TAHUN];
                    }
                }
                $idstatus = "status".$d[IDPRODI].$d[ANGKATAN].$d[GELOMBANG].$d[JENISKELAS].$d[IDKOMPONEN]."";
                $url = "idprodi=".$d[IDPRODI]."&angkatan=".$d[ANGKATAN]."&gelombang=".$d[GELOMBANG]."&jeniskelas=".$d[JENISKELAS]."&idkomponen=".$d[IDKOMPONEN]."&tgl={$d['TANGGALTAGIH']}&tanggal={$tanggal}&jeniskolom={$jeniskolom}";
                echo "\r\n               <tr>\r\n                <td>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n                <td align=center>{$d['ANGKATAN']}</td>\r\n                <td align=center>{$d['GELOMBANG']}</td>\r\n                ";
                if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                {
                    echo "\r\n                      <td>".$arraykelasstei[$d[JENISKELAS]]."</td>\r\n                      ";
                }
                echo "\r\n                <td  >{$d['IDKOMPONEN']}/".$arraykomponenpembayaran[$d[IDKOMPONEN]]."  </td>\r\n                <td nowrap  >{$periode}</td>\r\n                <td  align=center>{$d['LABELSPC']}</td>\r\n                <td nowrap align=center>{$d['TGLTAGIH']}</td>\r\n                <td nowrap align=center>{$d['TGLBAYAR1']} <br> s.d.<br> {$d['TGLBAYAR2']}</td>\r\n                <td nowrap align=center>\r\n                      <div id='{$idstatus}' >...</div>\r\n                </td>\r\n              </tr>\r\n          ";
                if ( $i == 1 )
                {
                    echo ( ( "<script type=\"text/javascript\" language=\"javascript\">$(document).ready(function() {                 \$(\"#proses\").click(function(event){\r\n                            \$('#linkdownload').html('<br>Mohon tunggu. Pembuatan tagihan sedang diproses.... klik <a href=\\'downloadsementara.php&tanggal={$tanggal}\\' target=_blank>di sini </a>jika Anda ingin melihat hasil sementara<br><br>');\r\n                            \$.ajax( {\r\n                                type: \"POST\",\r\n                                url:'prosesbuattagihancalonmahasiswa.php',cache: false,\r\n                                data: \"sessid={$token}&pilihan={$pilihan}&aksi={$aksi}&{$url}\",\r\n                                beforeSend:function(jqXHR) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFAAAA');\r\n                                   \$('#{$idstatus}').html('<img src=\"progress.gif\">');\r\n                                \r\n                                },\r\n                               success:function(data) {\r\n                                    \$('#{$idstatus}').css('background-color','#AAFFAA');\r\n                                   \$('#{$idstatus}').html(data);\r\n                                   if (data.search( 'Tidak ada tagihan' )!=-1) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFF00');\r\n                                   }\r\n                                    selesai= selesai+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                      fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                                  \r\n                               },\r\n                               error:function(jqXHR, textStatus, errorThrown) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFFAA');\r\n                                   \$('#{$idstatus}').html('Error. '+jqXHR.responseText+' Silakan coba lagi.');\r\n\r\n                                    gagal= gagal+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                     fungsi".( $i + 1 ) )."();\r\n                                  }\r\n\r\n\r\n                               }\r\n                            });\r\n                  \r\n                         });\r\n                        \r\n                     });\r\n                      counter= counter+1;\r\n                     </script>           \r\n          ";
                }
                else
                {
                    echo ( ( "\r\n                    <script type=\"text/javascript\" language=\"javascript\"> function fungsi{$i}() {\r\n           \r\n                             \$.ajax( {\r\n                                type: \"POST\",\r\n                                url:'prosesbuattagihan.php',cache: false,\r\n                                data: \"sessid={$token}&pilihan={$pilihan}&aksi={$aksi}&{$url}\",\r\n                                beforeSend:function(jqXHR) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFAAAA');\r\n                                   \$('#{$idstatus}').html('<img src=\"progress.gif\">');\r\n                                \r\n                                },\r\n                               success:function(data) {\r\n                                    \$('#{$idstatus}').css('background-color','#AAFFAA');\r\n                                   \$('#{$idstatus}').html(data);\r\n                                   if (data.search( 'Tidak ada tagihan' )!=-1) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFF00');\r\n                                   }\r\n                                    selesai= selesai+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                    fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                               },\r\n                               error:function(jqXHR, textStatus, errorThrown) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFFAA');\r\n                                   \$('#{$idstatus}').html('Error. '+jqXHR.responseText+' Silakan coba lagi.');\r\n\r\n                                    gagal= gagal+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                    } else {\r\n                                    fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                                    \r\n\r\n                               }\r\n                        \r\n                  \r\n                             });\r\n                          }\r\n                      counter= counter+1;\r\n                     </script>           \r\n          ";
                }
            }
            $idstatus = "hasil";
            echo ( "</table> \r\n                    <script type=\"text/javascript\" language=\"javascript\">\r\n                        function fungsi".( $i + 1 ) )."() {\r\n                        }\r\n                       </script>           \r\n      \r\n       ";
        }
    }
    else
    {
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    printmesg( $errmesg );
    if ( $gelombang == "" )
    {
        $gelombang = 1;
    }
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n \t\t<table class=form>\r\n\t\t<!--\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=masukan> \r\n\t\t\t\t\t\t ";
    $cek = "";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $waktu[year] )
        {
            $cek = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t <tr class=judulform>\r\n\t\t\t<td>Gelombang Masuk</td>\r\n\t\t\t<td>".createinputtext( "gelombang", $gelombang, " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi / Program Pendidikan</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "\r\n     \t\t <tr class=judulform>\r\n    \t\t\t<td>Jenis Kelas Default </td>\r\n    \t\t\t<td>\r\n            <select name='jeniskelas' >\r\n             \r\n          ";
        foreach ( $arraykelasstei as $k => $v )
        {
            $selected = "";
            if ( $k == $d[JENISKELAS] )
            {
                $selected = "selected";
            }
            echo "<option value='{$k}' {$selected}>{$v}</option>";
        }
        echo "\r\n          </select>\r\n          \r\n          </td>\r\n    \t\t</tr>\r\n         ";
    }
    echo "\r\n -->\r\n      \r\n      \r\n      <tr>\r\n        <td width=150>Tanggal Tagihan</td>\r\n        <td>".createinputtanggal( "tgl", $tgl, "", "" )." </td>\r\n      </tr>\t\r\n      <tr>\r\n        <td  >Jenis Komponen</td>\r\n        <td>";
    #foreach ( $arrayjenispembayaran as $k => $v )
    #{
        echo "<input type=checkbox name='jenispilihan[0]' value='0' checked>1 Kali Awal Kuliah<br>";
    #}
    #echo "\r\n        \r\n        </td>\r\n      </tr>\t      \r\n      <tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Semua Komponen\r\n        \r\n        </td>\r\n      </tr>\t  \r\n";
    #echo "\r\n        \r\n        </td>\r\n      </tr>\t      \r\n      <tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\t  \r\n";
    
	$arrayangkatan = getarrayangkatan( );
    echo "\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td>Angkatan</td>\r\n\t\t\t\t<td>";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatancari class=masukan> \r\n\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    $cek = "";
    foreach ( $arrayangkatan as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$k}</option>\r\n\t\t\t\t\t\t\t";
        $cek = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>Program Studi </td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=idprodicari>\r\n\t\t\t\t\t\t<option value=''>Semua</option>\r\n\t\t\t\t\t\t ";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\r\n\t\t\t<tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit name=aksi value='Lanjut' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\t\r\n\t\t</table>\r\n\t\t</form>\r\n\t";
    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL \r\n    FROM buattagihan_calonmahasiswa WHERE 1=1 \r\n    GROUP BY TANGGALTAGIHAN \r\n    ORDER BY TANGGALTAGIHAN DESC  ";
    #echo $q;
	$h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( $jml>0 )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d[TANGGALTAGIHAN]] = $d;
        }
        $jeniskolom = $d[JENISKOLOM];
        $strunduh = str_replace( "name=jeniskolom value=\"\"", "name=jeniskolom value=\"{$jeniskolom}\"", $strunduh );
        printjudulmenukecil( "<b>UNDUH HASIL PEMBUATAN TAGIHAN SEBELUMNYA   " );
        echo "\r\n\r\n        <form method=post action=downloadtagihan_calonmahasiswa.php target=_blank>\r\n        <table width=100% >\r\n        <tr>\r\n            <td>Tanggal Tagihan</td>\r\n            <td>\r\n              <select name=tanggal>\r\n                \r\n            ";
        foreach ( $arraytagihan as $k => $v )
        {
            echo "<option value='{$k}'>{$v['TGL']}</option>";
        }
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\"> <br>\r\n            <input type=radio name=jenisfile value=\"HTML\"> HTML   <br>\r\n            <input type=radio name=jenisfile value=\"EXCEL\"> Excel \r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        printjudulmenukecil( "<b>HAPUS HASIL PEMBUATAN TAGIHAN SEBELUMNYA   " );
        echo "\r\n\r\n        <form method=post action=index.php target=_blank \r\n        onSubmit=\"return confirm('Hapus data tagihan yang dipilih?');\">".createinputhidden( "sessid", $_SESSION['token'], "" )."\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>        \r\n      <table width=100% >\r\n        <tr>\r\n            <td width=150>Tanggal Tagihan</td>\r\n            <td>\r\n              <select name=tanggal>\r\n                \r\n            ";
        foreach ( $arraytagihan as $k => $v )
        {
            echo "<option value='{$k}'>{$v['TGL']} # ({$v['SUDAHDIPROSES']} dari {$v['JUMLAHDATA']} data telah dibayar)</option>";
        }
        echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n \r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=HAPUS>\r\n           </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
    }#else{
	#}
}
?>
