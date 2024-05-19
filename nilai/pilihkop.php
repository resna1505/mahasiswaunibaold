<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#printjudulmenu( "SETTING KOP SURAT" );
#echo "\r\n<UL>\r\n  <LI><A href='index.php?pilihan=kopumum'>SETTING KOP UMUM</a></LI>\r\n  <LI><A href='index.php?pilihan=kopfakultas'>SETTING KOP PER ".strtoupper( $JUDULFAKULTAS )."</a></LI>\r\n</UL>\r\n";
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Setting Kop Surat");
echo "									</div>
									</div>
									<div class='portlet-body form'>";
echo "									<UL>\r\n  <LI><A href='index.php?pilihan=kopumum'>SETTING KOP UMUM</a></LI>\r\n  <LI><A href='index.php?pilihan=kopfakultas'>SETTING KOP PER ".strtoupper( $JUDULFAKULTAS )."</a></LI>\r\n</UL>\r\n";
echo "						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>";
?>
