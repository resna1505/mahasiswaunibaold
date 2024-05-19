<?php
if ( $aksi == "HAPUS" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tagihan", HAPUS_DATA );
    }
    else
    {
        $q = "DELETE FROM buattagihanvamandiri WHERE TANGGALTAGIHAN='{$tanggal}'";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data tagihan tanggal {$tanggal} telah dihapus.";
        }
    }
    $aksi = "";
}
$strunduh = "<form method=post action=downloadtagihanvamandiri.php target=_blank>\r\n<input type=hidden name=tanggal value=\"_TANGGAL_\"><input type=hidden name=koderekening value=\"{$koderekening}\" ><input type=hidden name=angkatancari value=\"{$angkatancari}\" ><input type=hidden name=idkomponencari value=\"{$idkomponencari}\" ><input type=hidden name=idprodicari value=\"{$idprodicari}\" ><table width=100% >\r\n<tr>\r\n  <td width=150 >\r\n    Tipe \r\n   </td>\r\n  <td   >\r\n    <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" ><input type=radio name=jenisfile value=\"HTML\" checked> HTML </td>\r\n</tr><tr>\r\n  <td  colspan=2><input type=submit name=aksi value=\"PERIKSA HASIL\" class=\"btn btn-brand\">\r\n  </td>\r\n</tr>\r\n</table>\r\n</form>";#printjudulmenu( "BUAT TAGIHAN" );
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
		$qfield2 .= " AND d.ANGKATAN='{$angkatancari}' ";
        $qjudul .= " Angkatan {$angkatancari} <br>";
    }
    if ( $idprodicari != "" )
    {
        $qfield .= " AND a.IDPRODI='{$idprodicari}' ";
		$qfield2 .= " AND d.IDPRODI='{$idprodicari}' ";
        $qjudul .= " Program Studi ".$arrayprodidep[$idprodicari]." <br>";
    }
	
	if ( $gelombang != "" )
    {
        $qfield .= " AND a.GELOMBANG='{$gelombang}' ";
        $qjudul .= " Gelombang {$gelombang} <br>";
    }
	if ( $koderekening2 != "" )
    {
        $qfield .= " AND komponenpembayaran.KODEREKENING2='{$koderekening2}' ";
        $qjudul .= " Kode Rekening {$koderekening2} <br>";
    }
    if ( $jeniskolom == "SPC" )
    {
        $qfield .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
		$qfield2 .= " AND komponenpembayaran.LABELSPC!='' AND komponenpembayaran.ID NOT IN (261,262,263,264) ";
        #$qjudul .= " Komponen dengan Label SPC saja <br>";
    }
	if ( $jeniskolom == "" )
    {
        $qfield .= " AND komponenpembayaran.LABELSPC='' ";
        #$qjudul .= " Komponen Non SPC saja <br>";
    }
	$qjudul .= " Komponen Pembayaran <br>";
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
    #if ( $tanggal != "" &&)
	{
        $qjudul .= " Tanggal Tagihan {$tgl['tgl']}-{$tgl['bln']}-{$tgl['thn']} <br>";
        
        $q = "SELECT   komponenpembayaran.JENIS,c.TINGKAT,komponenpembayaran.LABELSPC,komponenpembayaran.KODEBANK2,komponenpembayaran.KODEREKENING2,
		a.*,a.TANGGAL AS TANGGALTAGIH,DATE_FORMAT(a.TANGGAL,'%d-%m-%Y') AS TGLTAGIH,DATE_FORMAT(a.TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1,
		DATE_FORMAT(a.TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2 FROM komponenpembayaran,biayakomponen_tagihan a,
		(SELECT biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI, 
		biayakomponen_tagihan.GELOMBANG {$qcolumn2} ,MAX(IF(biayakomponen_tagihan.TANGGAL <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d'),
		biayakomponen_tagihan.TANGGAL,'1901-01-01') )  AS TANGGALTAGIH 
		FROM biayakomponen_tagihan GROUP BY biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI,
		biayakomponen_tagihan.GELOMBANG {$qcolumn2}) b, prodi c WHERE c.ID=b.IDPRODI AND komponenpembayaran.ID =a.IDKOMPONEN AND 
		b.IDKOMPONEN=a.IDKOMPONEN AND b.IDPRODI=a.IDPRODI AND b.ANGKATAN=a.ANGKATAN AND b.GELOMBANG=a.GELOMBANG AND 
		{$qtagihan} b.TANGGALTAGIH=a.TANGGAL AND b.TANGGALTAGIH  = DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d')  
		{$qfield} 
		UNION ALL
		SELECT   komponenpembayaran.JENIS,c.TINGKAT,komponenpembayaran.LABELSPC,komponenpembayaran.KODEBANK2,komponenpembayaran.KODEREKENING2,
		a.IDKOMPONEN,d.IDPRODI,a.ANGKATAN,a.BIAYA,a.TANGGAL,a.GELOMBANG,
		a.JENISKELAS,a.TAHUN,a.SEMESTER,a.TANGGALBAYAR1,a.TANGGALBAYAR2,a.TANGGAL AS TANGGALTAGIH,
		DATE_FORMAT(a.TANGGAL,'%d-%m-%Y') AS TGLTAGIH,DATE_FORMAT(a.TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1,
		DATE_FORMAT(a.TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2 FROM komponenpembayaran,trakk_tagihan a,
		(SELECT trakk_tagihan.IDKOMPONEN, trakk_tagihan.ANGKATAN, trakk_tagihan.GELOMBANG {$qcolumn2},
		MAX(IF(trakk_tagihan.TANGGAL <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d'),trakk_tagihan.TANGGAL,'1901-01-01') )  AS TANGGALTAGIH 
		FROM trakk_tagihan GROUP BY trakk_tagihan.IDKOMPONEN, trakk_tagihan.ANGKATAN, 
		trakk_tagihan.GELOMBANG {$qcolumn2}) b, prodi c,mahasiswa d WHERE c.ID=d.IDPRODI AND komponenpembayaran.ID =a.IDKOMPONEN AND 
		b.IDKOMPONEN=a.IDKOMPONEN AND a.ANGKATAN=d.ANGKATAN 
		AND a.GELOMBANG=d.GELOMBANG AND d.ID=a.IDMAHASISWA AND
		{$qtagihan} b.TANGGALTAGIH=a.TANGGAL AND b.TANGGALTAGIH  = DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d') {$qfield2}   ORDER BY 5,6,9,4";
		echo "TAGIHAN BNI=".$q.'<br>';

		$h = mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Buat Tagihan VA BNI");
		echo "			</div>";
		printmesg( $qjudul );
        if ( 0 < sqlnumrows( $h ) )
        {
            #$strunduh = str_replace( "_TANGGAL_", "{$tanggal}", $strunduh );
            #$strunduhproses = preg_replace( "/\\s+/", " ", "<div align=left><br><b>PERHATIAN!! JANGAN mengulangi proses sebelum mengunduh hasil akhir. Jika proses diulangi, data hasil akhir pembuatan tagihan untuk tanggal yang sama akan tertimpa. {$strunduh} </b></div>" );
            $strunduhproses = preg_replace( "/\\s+/", " ", "<div align=left><br><b>PERHATIAN!! JANGAN mengulangi proses sebelum mengunduh hasil akhir. Jika proses diulangi, data hasil akhir pembuatan tagihan untuk tanggal yang sama akan tertimpa.</b></div>" );	    
	
		echo "<script type=\"text/javascript\" language=\"javascript\">\r\n              var counter=0;\r\n              var selesai=0;\r\n              var gagal=0;\r\n              \r\n           </script>";								
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";	
         echo "					
									<!--<div align=center id='linkdownload' >
										<input class=\"btn btn-brand\" type=button id=proses value='Klik Proses Buat Tagihan '>
									</div>-->
										<div align='center' class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\" id='linkdownload'>
											<div class=\"col-lg-6\">
												<input class=\"btn btn-brand\" type=button id=proses value='Proses Buat Tagihan '>
											</div>
										</div>
									<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n            <td>Program Studi</td>\r\n            <td>Angkatan</td>\r\n            <td>Gelombang</td>\r\n            ";
           
			if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                echo "\r\n                  <td>Jenis Kelas</td>\r\n                  ";
            }
            echo "\r\n            <td>Komponen</td>\r\n            <td>Periode</td>\r\n            <td>Label SPC</td>\r\n            <td>Tanggal Tagihan</td>\r\n            <td>Periode Pembayaran</td>\r\n            <td>Status</td>\r\n          </tr>\r\n      ";
			echo "									</thead>
													<tbody>";     
			$i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $arraytagihan[] = $d;
                $idkomponen = $d['IDKOMPONEN'];
				/*if($idkomponen=='032'){
				
					#$sqljumlahkomponen="SELECT COUNT(*) FROM  komponenpembayaran, biayakomponen_tagihan a";
					$qjumlahkomponen = "\r\n    \r\n    SELECT   COUNT(*) AS jumlahrecord,komponenpembayaran.JENIS,c.TINGKAT,komponenpembayaran.LABELSPC, \r\n    a.*,a.TANGGAL AS TANGGALTAGIH,DATE_FORMAT(a.TANGGAL,'%d-%m-%Y') AS TGLTAGIH,\r\n    DATE_FORMAT(a.TANGGALBAYAR1,'%d-%m-%Y') AS TGLBAYAR1,\r\n    DATE_FORMAT(a.TANGGALBAYAR2,'%d-%m-%Y') AS TGLBAYAR2\r\n    \r\n    FROM\r\n     komponenpembayaran,\r\n    biayakomponen_tagihan a, \r\n    (\r\n      SELECT biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI, \r\n      biayakomponen_tagihan.GELOMBANG {$qcolumn2} , \r\n      MAX(IF(biayakomponen_tagihan.TANGGAL <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d') ,  \r\n      biayakomponen_tagihan.TANGGAL,'1901-01-01') )  AS TANGGALTAGIH \r\n      \r\n      FROM\r\n      biayakomponen_tagihan \r\n      GROUP BY biayakomponen_tagihan.IDKOMPONEN, biayakomponen_tagihan.ANGKATAN, biayakomponen_tagihan.IDPRODI, \r\n      biayakomponen_tagihan.GELOMBANG {$qcolumn2} \r\n       \r\n    ) b, prodi c \r\n    WHERE\r\n     c.ID=b.IDPRODI AND komponenpembayaran.ID =a.IDKOMPONEN AND   \r\n              b.IDKOMPONEN=a.IDKOMPONEN AND  \r\n              b.IDPRODI=a.IDPRODI AND  \r\n              b.ANGKATAN=a.ANGKATAN AND  \r\n              b.GELOMBANG=a.GELOMBANG AND  \r\n              {$qtagihan}\r\n              \r\n              \r\n              b.TANGGALTAGIH=a.TANGGAL AND\r\n              b.TANGGALTAGIH  <= DATE_FORMAT('{$tanggal}' ,'%Y-%m-%d')  AND YEAR(b.TANGGALTAGIH)=DATE_FORMAT('{$tanggal}' ,'%Y') \r\n                 {$qfield} AND a.IDKOMPONEN='032'\r\n                 \r\n                 ORDER BY   a.IDPRODI, a.ANGKATAN,\r\n      a.GELOMBANG {$qcolumn2} , a.IDKOMPONEN\r\n    ";
					#echo $qjumlahkomponen;
					$hjumlahkomponen = mysql_query( $qjumlahkomponen, $koneksi );
					$djumlahkomponen = sqlfetcharray( $hjumlahkomponen );
					$totalkomponen=$djumlahkomponen['jumlahrecord'];
					
				}*/
                ++$i;
                $periode = "";
                if ( $arrayjeniskomponenpembayaran[$idkomponen] == 0 || $arrayjeniskomponenpembayaran[$idkomponen] == 1 )
                {
                }
                else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
                {
                    $periode = ( "".( $d['TAHUN'] - 1 ) )."/{$d['TAHUN']}";
                }
                else
                {
                    $periode = ( "".( $d['TAHUN'] - 1 ) )."/{$d['TAHUN']} ".$arraysemester[$d['SEMESTER']];
                    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
                    {
                        $periode = "".$arraybulan2[$d['SEMESTER']]." ".$d['TAHUN'];
                    }
                }
                $idstatus = "status".$d['IDPRODI'].$d['ANGKATAN'].$d['GELOMBANG'].$d['JENISKELAS'].$d['IDKOMPONEN']."";
		list($thn_expired_tagihan,$bln_expired_tagihan,$tgl_expired_tagihan)=explode("-",$d['TANGGALBAYAR2']);
				$tgl_expired_date_tagihan=$thn_expired_tagihan."-".$bln_expired_tagihan."-20";
                #$url = "idprodi=".$d[IDPRODI]."&angkatan=".$d[ANGKATAN]."&gelombang=".$d[GELOMBANG]."&jeniskelas=".$d[JENISKELAS]."&idkomponen=".$d[IDKOMPONEN]."&tgl={$d['TANGGALTAGIH']}&tanggal={$tanggal}&jeniskolom={$jeniskolom}";
                $url = "idprodi=".$d['IDPRODI']."&angkatan=".$d['ANGKATAN']."&gelombang=".$d['GELOMBANG']."&jeniskelas=".$d['JENISKELAS']."&idkomponen=".$d['IDKOMPONEN']."&tgl={$d['TANGGALTAGIH']}&tanggal={$tanggal}&jeniskolom={$jeniskolom}&tingkat={$d['TINGKAT']}&totalkomponenakhir={$totalkomponen}&exp_date={$tgl_expired_date_tagihan}&kodebank2={$d['KODEBANK2']}&koderekening2={$d['KODEREKENING2']}";
                
				echo "\r\n               <tr>\r\n                <td>".$arrayprodidep[$d['IDPRODI']]."</td>\r\n                <td align=center>{$d['ANGKATAN']}</td>\r\n                <td align=center>{$d['GELOMBANG']}</td>\r\n                ";
                if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
                {
                    echo "\r\n                      <td>".$arraykelasstei[$d['JENISKELAS']]."</td>\r\n                      ";
                }
                echo "\r\n                <td  >{$d['IDKOMPONEN']}/".$arraykomponenpembayaran[$d['IDKOMPONEN']]."  </td>\r\n                <td nowrap  >{$periode}</td>\r\n                <td  align=center>{$d['LABELSPC']}</td>\r\n                <td nowrap align=center>{$d['TGLTAGIH']}</td>\r\n                <td nowrap align=center>{$d['TGLBAYAR1']} <br> s.d.<br> {$d['TGLBAYAR2']}</td>\r\n                <td nowrap align=center>\r\n                      <div id='{$idstatus}' >...</div>\r\n                </td>\r\n              </tr>\r\n          ";
                if ( $i == 1 )
                {
                    echo ( ( "<script type=\"text/javascript\" language=\"javascript\">$(document).ready(function() {                 \$(\"#proses\").click(function(event){\r\n                            \$('#linkdownload').html('<br>Mohon tunggu. Pembuatan tagihan sedang diproses.... <!--klik <a href=\\'downloadsementara.php&tanggal={$tanggal}\\' target=_blank>di sini </a>jika Anda ingin melihat hasil sementara--><br><br>');\r\n                            \$.ajax( {\r\n                                type: \"POST\",\r\n                                url:'prosesbuattagihanvabni.php',cache: false,\r\n                                data: \"sessid={$token}&pilihan={$pilihan}&aksi={$aksi}&{$url}\",\r\n                                beforeSend:function(jqXHR) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFAAAA');\r\n                                   \$('#{$idstatus}').html('<img src=\"progress.gif\">');\r\n                                \r\n                                },\r\n                               success:function(data) {\r\n                                    \$('#{$idstatus}').css('background-color','#AAFFAA');\r\n                                   \$('#{$idstatus}').html(data);\r\n                                   if (data.search( 'Tidak ada tagihan' )!=-1) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFF00');\r\n                                   }\r\n                                    selesai= selesai+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                      fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                                  \r\n                               },\r\n                               error:function(jqXHR, textStatus, errorThrown) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFFAA');\r\n                                   \$('#{$idstatus}').html('Error. '+jqXHR.responseText+' Silakan coba lagi.');\r\n\r\n                                    gagal= gagal+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                     fungsi".( $i + 1 ) )."();\r\n                                  }\r\n\r\n\r\n                               }\r\n                            });\r\n                  \r\n                         });\r\n                        \r\n                     });\r\n                      counter= counter+1;\r\n                     </script>           \r\n          ";
                }
                else
                {
                    echo ( ( "\r\n                    <script type=\"text/javascript\" language=\"javascript\"> function fungsi{$i}() {\r\n           \r\n                             \$.ajax( {\r\n                                type: \"POST\",\r\n                                url:'prosesbuattagihanvabni.php',cache: false,\r\n                                data: \"sessid={$token}&pilihan={$pilihan}&aksi={$aksi}&{$url}\",\r\n                                beforeSend:function(jqXHR) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFAAAA');\r\n                                   \$('#{$idstatus}').html('<img src=\"progress.gif\">');\r\n                                \r\n                                },\r\n                               success:function(data) {\r\n                                    \$('#{$idstatus}').css('background-color','#AAFFAA');\r\n                                   \$('#{$idstatus}').html(data);\r\n                                   if (data.search( 'Tidak ada tagihan' )!=-1) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFF00');\r\n                                   }\r\n                                    selesai= selesai+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                   } else {\r\n                                    fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                               },\r\n                               error:function(jqXHR, textStatus, errorThrown) {\r\n                                    \$('#{$idstatus}').css('background-color','#FFFFAA');\r\n                                   \$('#{$idstatus}').html('Error. '+jqXHR.responseText+' Silakan coba lagi.');\r\n\r\n                                    gagal= gagal+1;\r\n                                   if ( selesai+gagal>= counter) {\r\n                                       \$('#linkdownload').html('{$strunduhproses}');\r\n                                    } else {\r\n                                    fungsi".( $i + 1 ) )."();\r\n                                  }\r\n                                    \r\n\r\n                               }\r\n                        \r\n                  \r\n                             });\r\n                          }\r\n                      counter= counter+1;\r\n                     </script>           \r\n          ";
                }
            }
            $idstatus = "hasil";
            #echo ( "</table> \r\n                    <script type=\"text/javascript\" language=\"javascript\">\r\n                        function fungsi".( $i + 1 ) )."() {\r\n                        }\r\n                       </script>           \r\n      \r\n      </div></div></div></div></div> ";
			echo "										</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<script type=\"text/javascript\" language=\"javascript\">\r\n                        function fungsi".( $i + 1 )."() {\r\n                        }\r\n                       </script>  ";			
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
    #if ( $gelombang == "" )
    #{
    #    $gelombang = 1;
    #}
    
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Buat Tagihan VA BNI");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "tgl", $tgl, "class=form-control m-input style=\"width:auto;display:inline-block;\"", "" )." 
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Nama Komponen</label>
												<label class=\"col-form-label\">
													<select name=idkomponencari class=form-control m-input>";
														foreach ( $arraykomponenpembayaran as $k => $v )
														{
															echo "<option value={$k}>{$v}</option>";
														}
	 echo "												</select>
												</label>											
										</div>";    
	$arrayangkatan = getarrayangkatan();
    	echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
											<label class=\"col-form-label\">";
												$waktu = getdate( );
	echo "										<select name=angkatancari class=form-control m-input>
													<!--<option value=''>Semua</option>-->";
													$cek = "";
													foreach ( $arrayangkatan as $k => $v )
													{
														echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$k}</option>\r\n\t\t\t\t\t\t\t";
														$cek = "";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Gelombang Masuk</label>\r\n    
											<label class=\"col-form-label\">
												".createinputtext( "gelombang", $gelombang, " class=form-control m-input  size=2" )."
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=idprodicari>
													<!--<option value=''>Semua</option>-->";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Kode Rekening</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=koderekening2>
													<!--<option value=''>Semua</option>-->";
													foreach ( $arrayrekening2 as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=hidden name=jeniskolom value='SPC' class=\"btn btn-brand\">
												<input type=submit name=aksi value='Lanjut' class=\"btn btn-brand\">
											</div>
										</div>
									</div>
								</form>";


    $q = "SELECT COUNT(*) AS JUMLAHDATA,SUM(STATUS) AS SUDAHDIPROSES, TANGGALTAGIHAN,JENISKOLOM,DATE_FORMAT(TANGGALTAGIHAN,'%d-%m-%Y') AS TGL \r\n    FROM buattagihanvabni WHERE 1=1 \r\n    GROUP BY TANGGALTAGIHAN \r\n    ORDER BY TANGGALTAGIHAN DESC  ";
	echo "TAGIHAN BNI=".$q.'<br>';
   
$h = mysqli_query($koneksi,$q);
    $jml = sqlnumrows( $h );
    if ( 0 < $jml )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraytagihan[$d['TANGGALTAGIHAN']] = $d;
        }
        $jeniskolom = $d[JENISKOLOM];
        $strunduh = str_replace( "name=jeniskolom value=\"\"", "name=jeniskolom value=\"{$jeniskolom}\"", $strunduh );
        #printjudulmenukecil( "<b>UNDUH HASIL PEMBUATAN VA SEBELUMNYA   " );
        /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\">UNDUH HASIL PEMBUATAN TAGIHAN SEBELUMNYA</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
		echo "			<div class='portlet-title'>";
								printtitle("Unduh Hasil Pembuatan Tagihan VA Sebelumnya");
		echo "			</div>";
        echo "			<form method=post action=downloadtagihanvabni.php target=_blank class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
									<label class=\"col-form-label\">
										<select name=tanggal class=form-control m-input>";
											foreach ( $arraytagihan as $k => $v )
											{
												echo "<option value='{$k}'>{$v['TGL']}</option>";
											}
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr>\r\n        \r\n        <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n            <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\"> <br>\r\n            <input type=radio name=jenisfile value=\"HTML\"> HTML   <br>\r\n            <input type=radio name=jenisfile value=\"EXCEL\"> Excel \r\n           </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        #echo "\r\n              </select>\r\n            </td>\r\n        </tr><tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\      <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n            <input type=submit name=aksi value=UNDUH>\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
        echo "\r\n              		</select>
									</label>
								</div>";
									$arrayangkatan = getarrayangkatan( );
    echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
									<label class=\"col-form-label\">";
										$waktu = getdate( );
    echo "								<select name=angkatancari class=form-control m-input>
											<!--<option value=''>Semua</option>-->";
											$cek = "";
											foreach ( $arrayangkatan as $k => $v )
											{
												echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$k}</option>\r\n\t\t\t\t\t\t\t";
												$cek = "";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodicari>
											<!--<option value=''>Semua</option>-->";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
	<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Kode Rekening</label>\r\n    
											<label class=\"col-form-label\">
												<select class=form-control m-input name=koderekening>
													<!--<option value=''>Semua</option>-->";
													foreach ( $arrayrekening2 as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
    echo "										</select>
											</label>
										</div>";
		#echo "<!--<tr>\r\n        <td  >Jenis Kolom</td>\r\n        <td> \r\n          <input type=radio name=jeniskolom value='SPC' checked> Komponen dengan Label SPC saja <br>\r\n          <input type=radio name=jeniskolom value=''> Komponen Non SPC Saja\r\n        \r\n        </td>\r\n      </tr>\   -->   <tr>\r\n          <td width=150 >\r\n            Tipe \r\n           </td>\r\n          <td   >\r\n            <!--<input type=hidden name=jeniskolom value=\"{$jeniskolom}\" >\r\n -->           <input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter <input type=text size=1 name=delimiter value=\";\">   </td>\r\n        </tr>\r\n        <tr>\r\n          <td  colspan=2>\r\n  <input type='hidden' name='jeniskolom' value='SPC' class=\"btn blue\">          <input type=submit name=aksi value=UNDUH class=\"btn blue\">\r\n            <input type=submit name=aksi value=\"PERIKSA HASIL\" class=\"btn blue\">\r\n          </td>\r\n        </tr>\r\n        </table>\r\n        </form>      \r\n      \r\n      \r\n      ";
    echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tipe</label>\r\n    
									<label class=\"col-form-label\">
										<input type=radio name=jenisfile value=\"CSV\" checked> CSV, delimiter 
										<input type=text size=1 name=delimiter value=\";\">   
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type='hidden' name='jeniskolom' value='SPC' class=\"btn btn-brand\">
											<input type=submit name=aksi value=UNDUH class=\"btn btn-brand\">
											<input type=submit name=aksi value=\"PERIKSA HASIL\" class=\"btn btn-brand\">
										</div>
									</label>
								</div>
							</div>
						</form>";
            
		$token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        #printjudulmenukecil( "<b>HAPUS HASIL PEMBUATAN TAGIHAN SEBELUMNYA   " );
		echo "			<div class='portlet-title'>";
								printtitle("Hapus Hasil Pembuatan Tagihan VA Sebelumnya");
		echo "			</div>";
        echo "			<form method=post action=index.php target=_blank onSubmit=\"return confirm('Hapus data tagihan yang dipilih?');\" class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							".createinputhidden( "sessid", $_SESSION['token'], "" )."
							<input type=hidden name=pilihan value='{$pilihan}'>
							<div class=\"m-portlet__body\">
								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
									<label class=\"col-lg-2 col-form-label\">Tanggal Tagihan</label>\r\n    
									<label class=\"col-form-label\">
										<select name=tanggal class=form-control m-input>\r\n                \r\n            ";
											foreach ( $arraytagihan as $k => $v )
											{
												echo "<option value='{$k}'>{$v['TGL']} # ({$v['SUDAHDIPROSES']} dari {$v['JUMLAHDATA']} data telah dibayar)</option>";
											}
        echo "							</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value=HAPUS class=\"btn btn-brand\">
										</div>
									</label>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>";
    }
}
?>
