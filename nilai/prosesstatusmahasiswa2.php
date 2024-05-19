<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "lll";exit();
periksaroot( );
#$batasstudi = 14;
//kondisi batas studi berdasarkan tingkat
$sql_batas_studi="SELECT TINGKAT FROM prodi WHERE ID='{$idprodi}'";
$h_batas_studi = doquery( $sql_batas_studi, $koneksi );
$d_batas_studi = sqlfetcharray( $h_batas_studi );
if($d_batas_studi['TINGKAT']=='C'){

	$batasstudi=14;	

}elseif($d_batas_studi['TINGKAT']=='J'){

	$batasstudi=6;
}
if ( 0 )
{
    $errmesg = token_err_mesg( "Nilai IPS/IPK", CARI_DATA );
    $aksi = "";
}
else
{
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditaskodeprodi2( "Jurusan/Program Studi", $idprodi );
    $vld[] = cekvaliditastahun2( "Angkatan", $angkatan );
    #$vld[] = cekvaliditaskode( "NIM", $id );
    #$vld[] = cekvaliditasnama( "Nama", $nama );
    $vld[] = cekvaliditaskode( "Status", $status );
    $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
    $vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
        $aksi = "";
    }
    else
    {
        $href .= "index.php?dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&simpanstatus={$simpanstatus}&";
        if ( $idprodi != "" )
        {
            $qfield .= " AND IDPRODI='{$idprodi}'";
            $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
            $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
            $href .= "idprodi={$idprodi}&";
        }
        if ( $iddosen != "" )
        {
            $qfield .= " AND IDDOSEN='{$iddosen}'";
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
        if ( $status != "" )
        {
            $qfield .= " AND mahasiswa.STATUS='{$status}'";
            $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
            $qinput .= " <input type=hidden name=status value='{$status}'>";
            $href .= "status={$status}&";
        }
        $qjudul .= "Tahun ajaran: ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."<br>";
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
        $qinput .= " <input type=hidden name=sort value='{$sort}'>";
        $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
        #echo $q;
		$h = doquery($koneksi,$q );
        $d = sqlfetcharray( $h );
        $total = $d[JML];
        $first = 0;
        if ( 0 + $dataperhalaman <= 0 )
        {
            $dataperhalaman = 10;
        }
        $maxdata = $dataperhalaman;
        #include( "../paginating.php" );
        #$q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
        #$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,prodi.IDDEPARTEMEN,prodi.TINGKAT,departemen.IDFAKULTAS,KDPTIMSPST ,KDJENMSPST,KDPSTMSPST,STPIDMSMHS FROM mahasiswa,prodi,departemen,mspst,msmhs WHERE 1=1 {$qprodidep5} AND mahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND IDX=prodi.ID {$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
        #$q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,prodi.IDDEPARTEMEN,prodi.TINGKAT,departemen.IDFAKULTAS,KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mahasiswa,prodi,departemen,mspst WHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND IDX=prodi.ID {$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort}";
        $q = "SELECT mahasiswa.ID,mahasiswa.NAMA,mahasiswa.ANGKATAN,prodi.IDDEPARTEMEN,prodi.TINGKAT,departemen.IDFAKULTAS,KDPTIMSPST ,KDJENMSPST,KDPSTMSPST,STPIDMSMHS FROM mahasiswa,prodi,departemen,mspst,msmhs WHERE 1=1 {$qprodidep5} AND mahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND IDX=prodi.ID {$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort}";
        
		echo $q;
		$h = doquery($koneksi,$q );
        if ( 0 < sqlnumrows( $h ) )
        {
			//hitung looping tahun
			/*for($i=($angkatan+1);$i<$tahun;$i++){
				$tahunajar.=$i.",";
			}
			$tahunajar=substr($tahunajar, 0, -1);
			echo "TAHUNAJAR=".$tahunajar.'<br>';*/
            #printjudulmenu( "Proses Nilai IPS/IPK untuk disimpan di TRAKM" );
            #printmesg( $qjudul );
            #echo "{$tpage} {$tpage2}";
            $totalsemua = 0;
            $bobotsemua = 0;
            $totals = "";
            $bobots = "";
            
		echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";
										printmesg( $errmesg );
										 printmesg( $qjudul );
		echo "						<div class='portlet-title'>";
										printmesg("Proses Status Mahasiswa");
		echo "						</div>
								<div class=\"m-portlet\">
				
									<div class=\"m-section__content\">
                                        <div class=\"table-responsive\">";
            
            echo "{$tpage}";
            echo "            
											<table class=\"table table-bordered table-hover\">
												<thead>";
            echo "									<tr class=juduldata align=center>\r\n        <td rowspan=2>No</td>\r\n        <td>ID/NIM</td>\r\n        <td>Nama</td>\r\n        <td>Angkatan</td>\r\n        <td>Status Mahasiswa</td><td>Keterangan</td></tr> ";
            echo "								</thead>
												<tbody>";
			$i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $totalsemua = 0;
                $bobotsemua = 0;
                $totals = "";
                $bobots = "";
                $batasstudimhs = $batasstudi;
                $semesterhitung = $kurawal = $kurakhir = "";
                if ( $semester != 3 )
                {
                    $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
                    $kurawal = "(";
                    $kurakhir = ")";
                }
                $idmahasiswa = $d[ID];
                $sem = $semester;
                $tahunlama = $tahun;
                $angkatanmhs = $d[ANGKATAN];
                $idmahasiswa = $d[ID];
				$statusawalmhs = $d[STPIDMSMHS];
                $batasstudimhs += get_jumlah_cuti_mahasiswa( $idmahasiswa, $tahun - 1, $semester );
				$kodept=$d['KDPTIMSPST'];
				$kodeps=$d['KDPSTMSPST'];
				$kodejenjang=$d['KDJENMSPST'];
				/*echo "<br>";
				echo "TAHUN".$tahun.'<br>';
				echo "STATUS AWAL MAHASISWA".$statusawalmhs.'<br>';
				echo "ANGKATAN MAHASISWA".$d[ANGKATAN].'<br>';
				echo "SEMESTER".$semester.'<br>';
				echo "SEMESTER HITUNG MAHASISWA".$semesterhitung.'<br>';
				echo "BATAS STUDI MAHASISWA".$batasstudimhs.'<br>';
				echo "CUTI MAHASISWA".get_jumlah_cuti_mahasiswa( $idmahasiswa, $tahun - 1, $semester ).'<br>';*/
                $ipkmhs = "";
                $sksmhs = "";
                $ipsemmhs = "";
                $skssemmhs = "";
                $ket="Cek Data";
                $status = "Tidak tersimpan";
                $stylewarna = "";
                /*$q = "SELECT \r\n\t\t\t\t\t\t\t  NLIPSTRAKM, \r\n\t\t\t\t\t\t\t  NLIPKTRAKM, \r\n                SKSTTTRAKM,\r\n                SKSEMTRAKM\r\n                FROm trakm\r\n                WHERE\r\n                NIMHSTRAKM='{$idmahasiswa}'\r\n                AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'\r\n                ";
                unset( $d2 );
                $h2 = doquery($koneksi,$q );
                if ( 0 < sqlnumrows( $h2 ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                }*/
				
                /*if ( $semesterhitung > 4 && $semesterhitung <= $batasstudimhs )
				{
                    #$arrayipsmhs = getips( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
                    #$ipsemmhs = $arrayipsmhs[0];
                    #$skssemmhs = $arrayipsmhs[1];
                    #$arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
                    #$ipkmhs = $arrayipkmhs[0];
                    #$sksmhs = $arrayipkmhs[1];
					
					//get bayar komponen per mahasiswa
					#$sql_get_bayar_komp="SELECT SUM(a.JUMLAH+a.DISKON) AS JUMLAH , (d.BIAYA*
					#(CASE
					#	WHEN b.APPROVEBEASISWA=1 && e.DISKON IS NOT NULL THEN (100-e.DISKON)/100
					#	ELSE 1
					#	END)) AS BIAYALAGI,(d.BIAYA*(100-a.BEASISWA)/100) AS BIAYA,(d.BIAYA*(100-e.DISKON)/100) AS DISKONBIAYA, a.IDMAHASISWA, 
					#a.SEMESTER,a.TAHUNAJARAN, a.BEASISWA, DATE_FORMAT(a.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,b.ANGKATAN,c.NAMA NAMAKOMPONEN , 
					#c.JENIS, c.ID AS IDKOMPONEN,e.IDKOMPONEN AS IDKOMPONENBEASISWA,e.DISKON AS DISKONBEASISWA,e.TAHUN AS TAHUNBEASISWA,
					#e.SEMESTER AS SEMSTERBEASISWA,CONCAT(a.TAHUNAJARAN,a.SEMESTER) AS TAHUNAKADEMIK FROM bayarkomponen a 
					#JOIN mahasiswa b ON a.IDMAHASISWA=b.ID JOIN komponenpembayaran c ON a.IDKOMPONEN=c.ID 
					#JOIN biayakomponen d ON c.ID=d.IDKOMPONEN LEFT JOIN diskonbeasiswa e ON a.IDMAHASISWA=e.IDMAHASISWA 
					#AND a.TAHUNAJARAN=e.TAHUN AND a.SEMESTER=e.SEMESTER WHERE b.IDPRODI=d.IDPRODI AND b.ANGKATAN=d.ANGKATAN AND b.GELOMBANG=d.GELOMBANG 
					#AND d.JENISKELAS=''	AND a.TANGGALBAYAR>=b.TANGGALMASUK AND a.TANGGALBAYAR<=NOW() AND a.IDMAHASISWA='".$d['ID']."' GROUP BY a.IDMAHASISWA,a.IDKOMPONEN, a.TAHUNAJARAN,a.SEMESTER 
					#HAVING ( BIAYALAGI > JUMLAH AND IDKOMPONEN!='99' AND IDKOMPONEN!='98' AND TAHUNAKADEMIK<'$tahun$semester') OR ( IDKOMPONEN='99' OR IDKOMPONEN='98' ) 
					#ORDER BY a.IDMAHASISWA";
					$tahunangkatan=$d['ANGKATAN']+1;
					#for($i=$tahunupdate;$i<$tahun;$i++){
							#echo "LOOPING".$i.'<br>';
							
							#$lunas = getpembayaranmahasiswa( $idmahasiswa, $tahun,$semester,$statusawalmhs);
							#$hutangspp = getpembayaransppmahasiswa( $idmahasiswa, $tahun,$tahunangkatan);
							#$hutangsw = getpembayaranswmahasiswa( $idmahasiswa, $tahun,$tahunangkatan);
							$hutangspp = gethutangmahasiswa( $idmahasiswa, $tahun,$tahunangkatan,$semester);
							#echo "HUTANG SPPNYA BERAPA=".$hutangspp['HUTANGSPP'].'<br>';
							#echo "HUTANG SWNYA BERAPA=".$hutangsw.'<br>';
							if ( $simpanstatus == 1 )
							{
								if($hutangspp['HUTANGSPP']>3 || $hutangsw['HUTANGSW']>1){
									
									$statusmahasiswa='Cuti';
									$statusmhs='C';
									$tahuncuti=$tahun-1;
									$stylewarna="style='background-color:#FFFF00;'";
									#$q = "INSERT INTO trlsm (THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM,SIMBOL,NOBLANKO,NOTRANSKRIP,\r\n      NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN) VALUES ('{$tahuncuti}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}','{$d['ID']}','{$statusmhs}',NOW(),'{$skslulus}','{$data['ipk']}','{$data['sk']}','{$tanggalsk}','{$data['ijazah']}','{$jalur}','{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}','{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}' ,'{$data['simbol']}' ,'{$data['noblanko']}','{$data['notranskrip']}','{$d['nilaiuaptulis']}','{$d['nilaiuappraktek']}','{$d['simboluaptulis']}','{$d['simboluappraktek']}','{$d['peminatan']}' )\r\n      ";
									$q = "REPLACE INTO trlsm (THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM,SIMBOL,NOBLANKO,NOTRANSKRIP,\r\n      NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN) VALUES ('{$tahuncuti}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}','{$d['ID']}','{$statusmhs}',NOW(),'{$skslulus}','{$data['ipk']}','{$data['sk']}','{$tanggalsk}','{$data['ijazah']}','{$jalur}','{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}','{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}' ,'{$data['simbol']}' ,'{$data['noblanko']}','{$data['notranskrip']}','{$d['nilaiuaptulis']}','{$d['nilaiuappraktek']}','{$d['simboluaptulis']}','{$d['simboluappraktek']}','{$d['peminatan']}' )\r\n      ";
									
									#echo $q.'<br>';
									mysqli_query($koneksi,$q);
									if ( 0 < sqlaffectedrows( $koneksi ) )
									{
										$q = "UPDATE mahasiswa\r\n             SET STATUS ='{$statusmhs}',\r\n            TANGGALKELUAR=NOW(),\r\n            TAHUNLULUS='{$dtk['thn']}',CATATAN='Cuti By System' WHERE ID='{$d['ID']}' \r\n            ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$q = "UPDATE msmhs SET STMHSMSMHS ='{$statusmhs}',TGLLSMSMHS=NOW()        WHERE NIMHSMSMHS='{$d['ID']}' \r\n            ";
										#echo $q.'<br>';
										mysqli_query($koneksi,$q);
										$errmesg = "Data Status Mahasiswa berhasil disimpan";
									}
									$ket="Status Mahasiswa Berhasil Diubah";	
								}else{
									
									$statusmahasiswa="Aktif";
									$ket="Status Mahasiswa Tetap";	
									$stylewarna='';	
								}
								
							}else{
								
								if($hutangspp['HUTANGSPP']>3 || $hutangsw['HUTANGSW']>1){
									$statusmahasiswa="Cuti";
									$stylewarna="style='background-color:#FFFF00;'";
								}else{
									$statusmahasiswa="Aktif";
								}
								$ket="Cek Data";	
							}
							
							
                }*/
				#elseif($semesterhitung > $batasstudimhs){
				if($semesterhitung > $batasstudimhs){
					
					if ( $simpanstatus == 1 )
					{
						$statusmahasiswa='Non Aktif';
						$statusmhs='N';
						$tahuncuti=$tahun-1;
						//cek tahun semester di trlsm
						#$sql_cek_trlsm="SELECT COUNT(THSMSTRLSM) FROM trlsm WHERE NIMHSTRLSM='{$idprodi}' AND THSMSTRLSM=''";
						#$h_batas_studi = doquery( $sql_batas_studi, $koneksi );
						#$d_batas_studi = sqlfetcharray( $h_batas_studi );
						
						#$q = "INSERT INTO trlsm (THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM,SIMBOL,NOBLANKO,NOTRANSKRIP,\r\n      NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN) VALUES ('{$tahuncuti}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}','{$d['ID']}','{$statusmhs}',NOW(),'{$skslulus}','{$data['ipk']}','{$data['sk']}','{$tanggalsk}','{$data['ijazah']}','{$jalur}','{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}','{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}' ,'{$data['simbol']}' ,'{$data['noblanko']}','{$data['notranskrip']}','{$d['nilaiuaptulis']}','{$d['nilaiuappraktek']}','{$d['simboluaptulis']}','{$d['simboluappraktek']}','{$d['peminatan']}' )\r\n      ";
						$q = "REPLACE INTO trlsm (THSMSTRLSM, KDPTITRLSM,KDPSTTRLSM,KDJENTRLSM,NIMHSTRLSM,STMHSTRLSM,TGLLSTRLSM,SKSTTTRLSM,NLIPKTRLSM,NOSKRTRLSM,TGLRETRLSM,NOIJATRLSM,STLLSTRLSM,JNLLSTRLSM,BLAWLTRLSM,BLAKHTRLSM,\r\n      NODS1TRLSM,NODS2TRLSM,NODS3TRLSM,NODS4TRLSM, NODS5TRLSM,SIMBOL,NOBLANKO,NOTRANSKRIP,\r\n      NILAIUAPTULIS,NILAIUAPPRAKTEK,SIMBOLUAPTULIS,SIMBOLUAPPRAKTEK,PEMINATAN) VALUES ('{$tahuncuti}{$semester}','{$kodept}','{$kodeps}','{$kodejenjang}','{$d['ID']}','{$statusmhs}',NOW(),'{$skslulus}','{$data['ipk']}','{$data['sk']}','{$tanggalsk}','{$data['ijazah']}','{$jalur}','{$individu}','{$bulanawal}{$tahunawal}','{$bulanakhir}{$tahunakhir}','{$dosen1}','{$dosen2}','{$dosen3}','{$dosen4}','{$dosen5}' ,'{$data['simbol']}' ,'{$data['noblanko']}','{$data['notranskrip']}','{$d['nilaiuaptulis']}','{$d['nilaiuappraktek']}','{$d['simboluaptulis']}','{$d['simboluappraktek']}','{$d['peminatan']}' )\r\n      ";
									
						#echo $q.'<br>';
						#mysqli_query($koneksi,$q);
						doquery($koneksi,$q );
						#if ( 0 < sqlaffectedrows( $koneksi ) )
						#{
							$q = "UPDATE mahasiswa\r\n             SET STATUS ='{$statusmhs}',TANGGALKELUAR=NOW(),TAHUNLULUS='{$dtk['thn']}',CATATAN='Non Aktif By System'     WHERE ID='{$d['ID']}' \r\n            ";
							#echo $q.'<br>';
							#mysqli_query($koneksi,$q);
							doquery($koneksi,$q );
							$q = "UPDATE msmhs SET STMHSMSMHS ='{$statusmhs}',TGLLSMSMHS=NOW()        WHERE NIMHSMSMHS='{$d['ID']}' \r\n            ";
							#echo $q.'<br>';
							#mysqli_query($koneksi,$q);
							doquery($koneksi,$q );
							$errmesg = "Data Status Mahasiswa berhasil disimpan";
						#}
					}else{
						$statusmahasiswa="Non Aktif";
					}
				}
                else
                {
					$statusmahasiswa="Aktif";
                    #$ket = "Semester < 0 atau Semester > {$batasstudimhs}";
                }
                ++$i;
                echo "<tr {$stylewarna}>\r\n        <td align=center>{$i}</td>\r\n        <td >{$d['ID']}</td>\r\n        <td >{$d['NAMA']}</td>\r\n        <td align=center>{$d['ANGKATAN']}</td>\r\n        <td align=center>{$statusmahasiswa}</td><td align=center>{$ket}</td></tr>";
            }
            #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
			 echo "								</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";
        }
        else
        {
            $errmesg = "Data mahasiswa tidak ada";
            $aksi = "";
        }
    }
}
?>
