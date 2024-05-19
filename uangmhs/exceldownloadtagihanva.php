<?php
error_reporting(E_ALL    & ~E_NOTICE);
#echo "aaa";exit();
unset( $arraysort );
if ( $_GET['root'] != "" )
{
    $root = "";
}
if ( $_POST['root'] != "" )
{
    $root = "";
}
unset( $_GET['root'] );
unset( $_POST['root'] );
unset( $_GET['root'] );
unset( $_POST['root'] );

//Require Excel Library for php 
include "../lib/PHPExcel.php";
include "../db.php";
//include "../fungsitampilan.php";
//include "../fungsi.php";
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit();
}
#mysqli_select_db( $basisdatasql, $koneksi );
mysqli_query( $koneksi,"SET time_zone='{$offset}';" );
include "../arrayakademik.php";
//Loading Excel Library 
$excel = new PHPExcel();
ob_start();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()->setTitle("Tagihan-VA");

//Setting display
//for title
$styleArray = array(
    "alignment" => array(
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            
        )
                    
);

$styleArray2 = array(
	    "borders" => array(
		"allborders" => array(
		    "style" => PHPExcel_Style_Border::BORDER_THIN
		)
	    ),
	    "alignment" => array(
		"vertical" 	 => PHPExcel_Style_Alignment::VERTICAL_TOP
	    )	
	);

//Get Data
//Title
foreach(range("A","BE") as $columnID) {
    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

//Attribut
$excel->getActiveSheet()->getStyle("A1:BE1")->applyFromArray($styleArray2);
$excel->getActiveSheet()->setCellValue("A1", "No MVA");
$excel->getActiveSheet()->setCellValue("B1", "Key2");
$excel->getActiveSheet()->setCellValue("C1", "Key3");
$excel->getActiveSheet()->setCellValue("D1", "currency");
$excel->getActiveSheet()->setCellValue("E1", "NAMA");
$excel->getActiveSheet()->setCellValue("F1", "NPM");
$excel->getActiveSheet()->setCellValue("G1", "KETERANGAN");
$excel->getActiveSheet()->setCellValue("H1", "TAGIHAN");
$excel->getActiveSheet()->setCellValue("I1", "Bill Info 05");
$excel->getActiveSheet()->setCellValue("J1", "Bill Info 06");
$excel->getActiveSheet()->setCellValue("K1", "Bill Info 07");
$excel->getActiveSheet()->setCellValue("L1", "Bill Info 08");
$excel->getActiveSheet()->setCellValue("M1", "Bill Info 09");
$excel->getActiveSheet()->setCellValue("N1", "Bill Info 10");
$excel->getActiveSheet()->setCellValue("O1", "Bill Info 11");
$excel->getActiveSheet()->setCellValue("P1", "Bill Info 12");
$excel->getActiveSheet()->setCellValue("Q1", "Bill Info 13");
$excel->getActiveSheet()->setCellValue("R1", "Bill Info 14");
$excel->getActiveSheet()->setCellValue("S1", "Bill Info 15");
$excel->getActiveSheet()->setCellValue("T1", "Bill Info 16");
$excel->getActiveSheet()->setCellValue("U1", "Bill Info 17");
$excel->getActiveSheet()->setCellValue("V1", "Bill Info 18");
$excel->getActiveSheet()->setCellValue("W1", "Bill Info 19");
$excel->getActiveSheet()->setCellValue("X1", "Bill Info 20");
$excel->getActiveSheet()->setCellValue("Y1", "Bill Info 21");
$excel->getActiveSheet()->setCellValue("Z1", "Bill Info 22");
$excel->getActiveSheet()->setCellValue("AA1", "Bill Info 23");
$excel->getActiveSheet()->setCellValue("AB1", "Bill Info 24");
$excel->getActiveSheet()->setCellValue("AC1", "Bill Info 25");
$excel->getActiveSheet()->setCellValue("AD1", "Periode Open");
$excel->getActiveSheet()->setCellValue("AE1", "Periode Close");
$excel->getActiveSheet()->setCellValue("AF1", "SubBill 01");
$excel->getActiveSheet()->setCellValue("AG1", "SubBill 02");
$excel->getActiveSheet()->setCellValue("AH1", "SubBill 03");
$excel->getActiveSheet()->setCellValue("AI1", "SubBill 04");
$excel->getActiveSheet()->setCellValue("AJ1", "SubBill 05");
$excel->getActiveSheet()->setCellValue("AK1", "SubBill 06");
$excel->getActiveSheet()->setCellValue("AL1", "SubBill 07");
$excel->getActiveSheet()->setCellValue("AM1", "SubBill 08");
$excel->getActiveSheet()->setCellValue("AN1", "SubBill 09");
$excel->getActiveSheet()->setCellValue("AO1", "SubBill 10");
$excel->getActiveSheet()->setCellValue("AP1", "SubBill 11");
$excel->getActiveSheet()->setCellValue("AQ1", "SubBill 12");
$excel->getActiveSheet()->setCellValue("AR1", "SubBill 13");
$excel->getActiveSheet()->setCellValue("AS1", "SubBill 14");
$excel->getActiveSheet()->setCellValue("AT1", "SubBill 15");
$excel->getActiveSheet()->setCellValue("AU1", "SubBill 16");
$excel->getActiveSheet()->setCellValue("AV1", "SubBill 17");
$excel->getActiveSheet()->setCellValue("AW1", "SubBill 18");
$excel->getActiveSheet()->setCellValue("AX1", "SubBill 19");
$excel->getActiveSheet()->setCellValue("AY1", "SubBill 20");
$excel->getActiveSheet()->setCellValue("AZ1", "SubBill 21");
$excel->getActiveSheet()->setCellValue("BA1", "SubBill 22");
$excel->getActiveSheet()->setCellValue("BB1", "SubBill 23");
$excel->getActiveSheet()->setCellValue("BC1", "SubBill 24");
$excel->getActiveSheet()->setCellValue("BD1", "SubBill 25");
$excel->getActiveSheet()->setCellValue("BE1", "end record");
$i = 0;
$no=2;
#print_r($arraydatatagihan);exit();
foreach ($arraydatatagihan as $tagihan => $d ){
	#echo "<br>";
	#echo "ARRAYNYA=".$arraydatatagihan.",VALUE=".$d.'<br>';
	#print_r($tagihan);
	#echo "<br>";
	#echo "ARRAYNYA LAGI=";
	#print_r($d['IDKOMPONEN']);
	/*foreach ($d as $datatagihan => $d2 ){
		echo "<br>";
		
		echo "TAGIHAN=".$datatagihan;
		echo "<br>";
		echo "ARRAYNYA APA LAGI=";
		print_r($datatagihan);
	}*/
	#$strtmp.= "AAA".$tagihan;
	#echo '<br>';
	#$strtmp .= "\r\n               <tr >\r\n                  <td nowrap>{$d['TRXID']}</td>\r\n                  <td nowrap>{$d['VANUMB']}</td>\r\n                  <td nowrap>{$d['NAMA']}</td>\r\n                  <td nowrap>{$d['EMAIL']}</td>\r\n                  <td nowrap>{$d['HP']}</td><td nowrap align=right>".intval( $arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']] )."</td>\r\n                ";
   	list($tglmulaiva,$blnmulaiva,$thnmulaiva)=explode("-",$d['TANGGALTAGIHAN']);
		$periodemulaiva=$tglmulaiva.$blnmulaiva.$thnmulaiva;
		list($tglakhirva,$blnakhirva,$thnakhirva)=explode("-",$d['EXPDATE']);
		$periodeakhirva=$tglakhirva.$blnakhirva.$thnakhirva;

	$ket_total_excel_tagihan=utf8_encode("01\TOTAL\TOTAL\\1");
	$excel->getActiveSheet()->getStyle("A".$no.":BE".$no)->applyFromArray($styleArray2);
	$excel->getActiveSheet()->getStyle("A".$no)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        $excel->getActiveSheet()->setCellValue("A".$no, $d['VANUMB']);
        $excel->getActiveSheet()->setCellValue("B".$no, "");
        $excel->getActiveSheet()->setCellValue("C".$no, "");
        $excel->getActiveSheet()->setCellValue("D".$no, "IDR");
        $excel->getActiveSheet()->setCellValue("E".$no, $d['NAMA']);
        $excel->getActiveSheet()->setCellValue("F".$no, $d['IDMAHASISWA']);
        $excel->getActiveSheet()->setCellValue("G".$no, $d['IDKOMPONEN']."-".$arraykomponenpembayaran2[$d['IDKOMPONEN']]);
	$excel->getActiveSheet()->setCellValue("H".$no, intval( $arrayjumlahtagihan[$d['IDMAHASISWA']][$d['IDKOMPONEN']]));
	$excel->getActiveSheet()->setCellValue("I".$no, "");
	$excel->getActiveSheet()->setCellValue("J".$no, "");
	$excel->getActiveSheet()->setCellValue("K".$no, "");
	$excel->getActiveSheet()->setCellValue("L".$no, "");
	$excel->getActiveSheet()->setCellValue("M".$no, "");
	$excel->getActiveSheet()->setCellValue("N".$no, "");
	$excel->getActiveSheet()->setCellValue("O".$no, "");
	$excel->getActiveSheet()->setCellValue("P".$no, "");
	$excel->getActiveSheet()->setCellValue("Q".$no, "");
	$excel->getActiveSheet()->setCellValue("R".$no, "");
	$excel->getActiveSheet()->setCellValue("S".$no, "");
	$excel->getActiveSheet()->setCellValue("T".$no, "");
	$excel->getActiveSheet()->setCellValue("U".$no, "");
	$excel->getActiveSheet()->setCellValue("V".$no, "");
	$excel->getActiveSheet()->setCellValue("W".$no, "");
	$excel->getActiveSheet()->setCellValue("X".$no, "");
	$excel->getActiveSheet()->setCellValue("Y".$no, "");
	$excel->getActiveSheet()->setCellValue("Z".$no, "");
	$excel->getActiveSheet()->setCellValue("AA".$no, "");
	$excel->getActiveSheet()->setCellValue("AB".$no, "");
	$excel->getActiveSheet()->setCellValue("AC".$no, "");
	$excel->getActiveSheet()->setCellValue("AD".$no, $periodemulaiva);
	$excel->getActiveSheet()->setCellValue("AE".$no, $periodeakhirva);
	$excel->getActiveSheet()->setCellValue("AF".$no, $ket_total_excel_tagihan);
	$excel->getActiveSheet()->setCellValue("AG".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AH".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AI".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AJ".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AK".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AL".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AM".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AN".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AO".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AP".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AQ".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AR".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AS".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AT".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AU".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AV".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AW".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AX".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AY".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("AZ".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("BA".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("BB".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("BC".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("BD".$no, "\\\\\\");
	$excel->getActiveSheet()->setCellValue("BE".$no, "~");

   $no++;
}
#exit();
ob_end_clean(); 
#$filename="tagihan-".$arrayjenjang[$d['TINGKAT']]."-".$d['NAMAJURUSAN']."-".$d['ANGKATAN']."-".$d['GELOMBANG']."-".$d['KODEREKENING']."-".$tanggal.".xls"; //save our workbook as this file name
header("Content-Type: application/vnd.ms-excel"); //mime type
#header("Content-Disposition: attachment;filename=\"tagihan-".$arrayjenjang[$d['TINGKAT']]."-".$d['NAMAJURUSAN']."-".$d['ANGKATAN']."-".$d['GELOMBANG']."-".$d['KODEREKENING']."-".$tanggal.".xls\""); //tell browser what"s the file name
header("Content-Disposition: attachment;filename=\"tagihan-".$arrayjenjang[$d['TINGKAT']]."-".$d['NAMAJURUSAN']."-".$d['ANGKATAN']."-".$d['KODEREKENING']."-".$tanggal.".xls\""); //tell browser what"s the file name
header("Cache-Control: max-age=0"); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format q
$objWriter = PHPExcel_IOFactory::createWriter($excel, "Excel5");  
//force user to download the Excel file without writing it to server's HD
$objWriter->save("php://output");
$excel->disconnectWorksheets();
exit();        
?>
