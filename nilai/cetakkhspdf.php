<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$t                  = (!$_POST["idmhs"])?"":$_POST["idmhs"];
$idprodi            = (!$_POST["idprodi"])?"":$_POST["idprodi"];
$iddosen            = (!$_POST["iddosen"])?"":$_POST["iddosen"];
$angkatan           = (!$_POST["angkatan"])?"":$_POST["angkatan"];
$id                 = (!$_POST["id"])?"":$_POST["id"];
$nama               = (!$_POST["nama"])?"":$_POST["nama"];
$status             = (!$_POST["status"])?"":$_POST["status"];
$tahun              = (!$_POST["tahun"])?"":$_POST["tahun"];
$semester           = (!$_POST["semester"])?"":$_POST["semester"];
$nilaidiambil       = (!$_POST["nilaidiambil"])?"":$_POST["nilaidiambil"];
$nilaikosong        = (!$_POST["nilaikosong"])?"":$_POST["nilaikosong"];
$sp                 = (!$_POST["sp"])?"":$_POST["sp"];
$diagram            = (!$_POST["diagram"])?"":$_POST["diagram"];
$jenistampilan      = (!$_POST["jenistampilan"])?"":$_POST["jenistampilan"];
$tgllap['tgl']      = (!$_POST["tgllap[tgl]"])?"":$_POST["tgllap[tgl]"];
$tgllap['bln']      = (!$_POST["tgllap[bln]"])?"":$_POST["tgllap[bln]"];
$tgllap['thn']      = (!$_POST["tgllap[thn]"])?"":$_POST["tgllap[thn]"];
$dataperhalaman     = (!$_POST["dataperhalaman"])?"":$_POST["dataperhalaman"];

$nim = $tmp ="";
for($a=0;$a<count($t);$a++) {
    if(!$tmp)
        $tmp = "'".$t[$a]."'";
    else
        $tmp.=", '".$t[$a]."'";
}
$nim = "(".$tmp.")";

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
include( "fungsinilai.php" );
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

$stylekhs = "\r\n<style type=\"text/css\">\r\n.tengah  {\r\n    text-align:center;\r\n}\r\n.kiri  {\r\n    text-align:left;\r\n}\r\n.kanan  {\r\n    text-align:right;\r\n}\r\n</style>\r\n";
$stylekhs .= "\r\n<style type=\"text/css\">\r\n\r\nbody {\r\n\tfont-family:\"Trebuchet MS\", Arial, Helvetica, sans-serif;\r\n\t}\r\n\r\n.borderblack {\r\n\tborder-left:1px solid black;\r\n\tborder-bottom:1px solid black;\r\n\twidth:650px;\r\n\t}\r\n\t\r\n.borderblack td{\r\n\tborder-right:1px solid black;\r\n\tborder-top:1px solid black;\r\n\tpadding:5px;\r\n\t}\r\n.tengah  {\r\n    text-align:center;\r\n}\r\n.kiri  {\r\n    text-align:left;\r\n}\r\n.kanan  {\r\n    text-align:right;\r\n}\r\n\t\r\n</style>";
$cetak = $aksi = "cetak";
$border = " border=0 width=95% style=' border-collapse:collapse;'";

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
if ( ismahasiswa( ) || iswali( ) )
{
    $idmhs = $users;
}
if ( $idmhs != "" )
{
    $qfield .= " AND mahasiswa.ID IN {$nim}";
    //$qjudul .= " NIM = '{$idmhs}' <br>";
    //$qinput .= " <input type=hidden name=idmhs value='{$nim}'>";
    //$href .= "idmhs={$idmhs}&";
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
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
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

$q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS,dosen.NAMA AS NAMADOSEN \r\n\tFROM mahasiswa LEFT JOIN dosen ON mahasiswa.IDDOSEN=dosen.ID ,prodi,departemen  ,trakm,mspst\r\n\tWHERE 1=1 {$qprodidep5} \r\n  AND  trakm.THSMSTRAKM=CONCAT('".( $tahun - 1 )."','{$semester}')\r\n  AND  trakm.NIMHSTRAKM=mahasiswa.ID\r\n  AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID AND\r\n\tprodi.ID=mspst.IDX AND\r\n\tmspst.KDPTIMSPST = trakm.KDPTITRAKM AND\r\n\tmspst.KDJENMSPST = trakm.KDJENTRAKM AND\r\n\tmspst.KDPSTMSPST\t = trakm.KDPSTTRAKM  \r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort}";

$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $totalsemua = 0;
    $bobotsemua = 0;
    $totals = "";
    $bobots = "";
    $headerkhs = $bodykhs = $footerkhs = "";
    $count = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "SELECT SMAWLMSMHS FROM msmhs WHERE NIMHSMSMHS='{$d['ID']}'";
        $hxx = mysqli_query($koneksi,$q);
        $semesterawal = 1;
        if ( 0 < sqlnumrows( $hxx ) )
        {
            $dxx = sqlfetcharray( $hxx );
            $semesterawal = substr( $dxx[SMAWLMSMHS], 4, 1 );
        }
        if ( $semesterawal == 1 )
        {
            $tambahansemester = 0;
        }
        else
        {
            $tambahansemester = 0 - 1;
        }
        $idfakultas = $d[IDFAKULTAS];
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        $semesterhitung = $kurawal = $kurakhir = "";
        if ( $semester != 3 )
        {
            $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester - get_jumlah_cuti_mahasiswa( $d[ID], $tahun - 1, $semester ) + $tambahansemester;
            $kurawal = "(";
            $kurakhir = ")";
        }
        $batasstudimhs = $batasstudi + get_jumlah_cuti_mahasiswa( $d[ID], $tahun - 1, $semester );
        $headerkhs .= $tmpcetakawal .= "<div style='page-break-after:always;margin:0px;padding:0px;'>\r\n         ".$tmpkop;
        $idmahasiswa = $d[ID];
        $sem = $semester;
        $tahunlama = $tahun;
        include( $HEADERKHS );
        $angkatanmhs = $d[ANGKATAN];
        $idmahasiswa = $d[ID];
        //echo $FILEKHS;
        if ( 0 < $semesterhitung )
        { ?>
<style type="text/css">
	td{
		border:1px solid black;
		}
		
	.clearborder td{
		border:none;
		}	
</style>
<?



			unset($arraydatanilai);
			unset($arrayipkmhs);

			  $q="
				SELECT 
        pengambilanmk.BOBOT,
        pengambilanmk.SIMBOL,
        pengambilanmk.IDMAKUL,
				pengambilanmk.TAHUN,
        pengambilanmk.NAMA,
        pengambilanmk.SKSMAKUL AS SKS,
				pengambilanmk.SEMESTER AS SEMESTERS,
				pengambilanmk.SEMESTERMAKUL AS SEMESTER, 
 				tbkmk.NAKMKTBKMK AS NAMAMAKUL
				FROM pengambilanmk,tbkmk,msmhs
				WHERE 

				 pengambilanmk.IDMAKUL=tbkmk.KDKMKTBKMK  
				AND pengambilanmk.THNSM=tbkmk.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmk.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmk.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmk.IDMAHASISWA

				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmk.SEMESTERMAKUL,
				IDMAKUL
			";

// 				AND CONCAT(pengambilanmk.TAHUN-1,pengambilanmk.SEMESTER)=tbkmk.THSMSTBKMK  


			$hn=doquery($q,$koneksi);
			$bodykhs .=  mysqli_error($koneksi);
			if (sqlnumrows($hn)>0) {
			   while ($d2=sqlfetcharray($hn)) {
			     $arraydatanilai["$d2[TAHUN]-$d2[SEMESTERS]-$d2[IDMAKUL]"]=$d2;
			     //$bodykhs .=  "$d2[IDMAKUL]-$d2[TAHUN]-$d2[SEMESTER]<br>";
			   }
			}
// SP
  if ($sp==1) {
	
 			  $q="
				SELECT 
        pengambilanmksp.BOBOT,
        pengambilanmksp.SIMBOL,
        pengambilanmksp.IDMAKUL,
				pengambilanmksp.TAHUN,
        pengambilanmksp.NAMA,
        pengambilanmksp.SKSMAKUL AS SKS,
				pengambilanmksp.SEMESTER AS SEMESTERS,
				pengambilanmksp.SEMESTERMAKUL AS SEMESTER, 
 				tbkmksp.NAKMKTBKMK AS NAMAMAKUL
				FROM pengambilanmksp,tbkmksp,msmhs
				WHERE 

				 pengambilanmksp.IDMAKUL=tbkmksp.KDKMKTBKMK  
				AND CONCAT(pengambilanmksp.TAHUN-1,pengambilanmksp.SEMESTER)=tbkmksp.THSMSTBKMK  
				AND msmhs.KDPSTMSMHS=tbkmksp.KDPSTTBKMK
				AND msmhs.KDJENMSMHS=tbkmksp.KDJENTBKMK
				AND msmhs.NIMHSMSMHS=pengambilanmksp.IDMAHASISWA

				AND IDMAHASISWA='$d[ID]'  
				ORDER BY pengambilanmksp.SEMESTERMAKUL,
				IDMAKUL
			";


			$hn2=doquery($q,$koneksi);
			//$bodykhs .=  mysqli_error($koneksi);
			//unset($arraydatanilai);
			if (sqlnumrows($hn2)>0) {
			   while ($d3=sqlfetcharray($hn2)) {
  			   if ($nilaidiambil!=1) { // Yang terbaik
  			     //if ($arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
  			     if ($arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"][BOBOT]<=$d3[BOBOT]) {
      			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
    			     $arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"]=$d3;
             }
           } else {
    			   //$arraydatatranskrip["$d3[SEMESTER]-$d3[IDMAKUL]"]=$d3;
  			     $arraydatanilai["$d3[TAHUN]-$d3[SEMESTERS]-$d3[IDMAKUL]"]=$d3;
           }
			   }
			}
		}
// SP


        @ksort($arraydatanilai);

			if (is_array($arraydatanilai)) {

					if ($semester!=3) {
						 $semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+$semester;
					} else {
						$semesterhitung=(($tahun-1-$d[ANGKATAN])*2)+0.5;
					}
				$bodykhs .=  "
					<br>
					<div style='padding:2px; border:1px solid black; width:650px;'>
					<table celpadding=0 cellspacing=0 $border class=borderblack>
						<tr class=juduldata$cetak align=center style='background:#d7d7d7;'>
	 
							<td  class=tengah width=5%><b>No</td>
							<td  class=tengah  width=10%><b>Kode  </td>
							<td  class=tengah  width=56%><b>Mata Kuliah</td>
							<td  class=tengah  width=5%><b>SKS</td>
							<!-- <td class=tengah  width=9%><b>Bobot</td> -->
							<td class=tengah  width=7%><b>Nilai</td>
							<td  class=tengah><b>Mutu</td>
							<td  class=tengah><b>Keterangan</td>
						</tr>
				";
				$i=1;
				$semlama=$semlast=0;
				foreach ($arraydatanilai as $kk=>$d2) {
				  //$bodykhs .=  "$kk <br>";
				//while ($d2=sqlfetcharray($hn)) {
					unset($kp);
 					if ($d2[SEMESTERS]!=3) {
						 $semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+$d2[SEMESTERS];
					} else {
						$semesterhitungx=(($d2[TAHUN]-1-$d[ANGKATAN])*2)+0.5;
					}
  						$kelas=kelas($i);
 						
 						$semlama=$semesterhitungx;
						
				  
					$kelas=kelas($i);
 
				
////////////////////////////////////////////////////////////////////////////////////////////
			$nilai="";
			$total="";
			$bobot="";
			$nilaiakhir=$nilaiakhirdicari=
			$totalmax=$totalmaxdicari=
			$bobotmax=$bobotmaxdicari=
			$simbolmax=$simbolmaxdicari=
			"-";
 
		 	$nilaiakhir=$nilaiakhirdicari;
			$totalmax=$totalmaxdicari;
			$bobotmax=$bobotmaxdicari;
			$simbolmax=$simbolmaxdicari;
////////////////////////////////////////////////////////////////////////////////////////							
 
	 		       if  (
                ($nilaikosong==1) || 
                ($d2[SIMBOL]!="MD" && $d2[SIMBOL]!="" && $d2[SIMBOL]!="T" && $nilaikosong==0)
              ) {
 
								$totalnilaiakhir+=$nilaiakhir;
								 
								$nilai=$d2[SIMBOL];
								$bobot=$d2[BOBOT];
								$total=number_format_sikad($d2[SKS]*$d2[BOBOT],2,'.',',');
							 	$totals[$semesterhitungx]+=$total;
							 	$totalsemua+=$totalmax;
      					$bobots[$semesterhitungx]+=$d2[SKS];
      					$bobotsemua+=$d2[SKS];
               } 

//					$bodykhs .=  "$d2[TAHUN] $semesterhitungx === $semesterhitung <br>";
					if ($semesterhitung==$semesterhitungx) {

            if ($d2[NAMA]=="")  {
              $d2[NAMA]=$d2[NAMAMAKUL];
            } 
						$bodykhs .=  "
								<tr $kelas$cetak align=left>
									<td align=center width=5%>$i&nbsp;</td>
									<td align=center width=10%>$d2[IDMAKUL]&nbsp;</td>
									<td width=56%> $d2[NAMA]&nbsp;</td>
									<td align=center width=5%>$d2[SKS] &nbsp;</td>
									<!-- <td align=center width=9%>$bobot &nbsp; </td> -->
									<td align=center width=5%>$nilai  &nbsp;</td>
									<td align=center>$total&nbsp;</td>
									<td align=center>&nbsp;</td>
								</tr>
								
								
						";
				
              $idmakul=$d2[IDMAKUL];
              
						$i++;
					}
				}
						if ($semlama!="") {
		
							if ($semesterhitungx==$semlama) {

                   $arrayipkmhs=getipk($d[ID],$tahun,$semester,$nilaidiambil,$nilaikosong);
                  $ipkmhs=$arrayipkmhs[0];
                  $sksmhs=$arrayipkmhs[1];

							
			
								$bodykhs .=  "
	               </table>	
                 
                <table>
 
 

								";
							}
						}
 						if (0/*$semlama!=""  Ditutup dulu*/) {
                  /*$q="SELECT NLIPKTRAKM FROM trakm
                  WHERE
                  THSMSTRAKM='".($tahun-1)."$semester' AND 
                  NIMHSTRAKM='$d[ID]'";
                  $hipk=doquery($q,$koneksi);
                  $dipk=sqlfetcharray($hipk);
                  */
                   $arrayipkmhs=getipk($d[ID],$tahun,$semester,$nilaidiambil,$nilaikosong);
                  $ipkmhs=$arrayipkmhs[0];
                  $sksmhs=$arrayipkmhs[1];
						$bodykhs .=  "
							<tr >
								<td colspan=6 align=left>Indeks Prestasi Kumulatif</td>
								<td class=tengah>
								".number_format_sikad($ipkmhs ,2)."
								</td>
							</tr>
						";
						//".number_format_sikad(@($d[BOBOT]/$d[SKS]),2,'.',',')."
 
						}
 
            if ($semesterhitung > 0 && $semesterhitung <=$batasstudimhs) {
              if (isoperator() && $tingkataksesusers[$kodemenu]=="T") {
    						include "../makul/edittrakm.php";
    					}
					      $q="UPDATE trakm SET
							  NLIPSTRAKM='".number_format_sikad(@($totals[$semesterhitung]/$bobots[$semesterhitung]),2)."', 
							  NLIPKTRAKM='".number_format_sikad($ipkmhs,2)."', 
                SKSTTTRAKM='$sksmhs',
                SKSEMTRAKM='$bobots[$semesterhitung]'
                WHERE
                NIMHSTRAKM='$idmahasiswa'
                AND THSMSTRAKM='".($tahunlama-1)."$sem'
                ";
                 doquery($q,$koneksi);          
                 }   

 
	 	
				$bodykhs .=  "</table>
				</div>
				<div style='padding:2px border:none; width:650px;'>
				<table width=100% celpadding=0 cellspacing=0 $border class=clearborder >
                 <tr valign=top>
					 <td align=left >	
					 <b style='font-size:8pt;'>	
					 Jumlah SKS : $bobots[$semesterhitung]. Jumlah Angka Mutu : $totals[$semesterhitung]		<br>
					 Indeks Prestasi Sementara : ".number_format_sikad(@($totals[$semesterhitung]/$bobots[$semesterhitung]),2,'.',',')."
					 Indeks Prestasi Kumulatif : ".number_format_sikad($ipkmhs ,2)."
					 <br><br>
					 
					 A=4 B=3 C=2 D=1 E=0
					 </td>
					 <td>
					 <!--FOOTERKHS-->
					 </td>
                 </tr>
                 </table>
				</div><br> <br> <br>
				";	 	

  	 	include "footerlaporankhsuniversitasbatam.php";
         $bodykhs=str_replace("<!--FOOTERKHS-->",$footerkhsx,$bodykhs);
         echo $bodykhs;
        }
        $hasilkhs .= $headerkhs.$bodykhs.$footerkhs;
        $headerkhs = $bodykhs = $footerkhs = "";
    }    
}    
?>
