<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

date_default_timezone_set( "Asia/Jakarta" );
periksaroot( );
$n = getdate( time( ) );
echo "<s";
echo "cript Language=\"JavaScript\">\r\nvar timerID = null;\r\nvar timerRunning = false;\r\nvar menit = ";
echo $n['minutes'];
echo ";\r\nvar detik = ";
echo $n['seconds'];
echo ";\r\nvar jamku = ";
echo $n['hours'];
echo ";\r\n\r\nvar n = new Date();\r\n//var lmenit = n.getMinutes();\r\nvar ldetik = n.getSeconds();\r\n//var ljam = n.getHours();\r\n\r\n\r\nfunction stopclock (){\r\n        if(timerRunning)\r\n                clearTimeout(timerID);\r\n        timerRunning = false;\r\n}\r\n\r\n\r\nfunction showtime () {\r\n        var now = new Date();\r\n//        var hours = now.getHours();\r\n //       var minutes = now.getMinutes();\r\n        var sec";
echo "onds = now.getSeconds();\r\n\r\n\t\t\tif (((seconds > ldetik) && (seconds!=0))||(seconds==0 && ldetik==59)) {\r\n\t\t\t\tif (detik < 59) {\r\n\t\t\t\t\tdetik++;\r\n\t\t\t\t} else {\r\n\t\t\t\t\tdetik=0;\r\n\t\t\t\t\tif (menit < 59) {\r\n\t\t\t\t\t\tmenit ++;\r\n\t\t\t\t\t} else {\r\n\t\t\t\t\t\tmenit=0;\r\n\t\t\t\t\t\tif (jamku < 23)  {\r\n\t\t\t\t\t\t\tjamku++;\r\n\t\t\t\t\t\t} else {\r\n\t\t\t\t\t\t\tjamku=0;\r\n\t\t\t\t\t\t}\r\n\t\t\t\t\t}\r\n\t\t\t\t}\r\n\t\t\t\t\r\n\t\t\t}\r\n\t\t\tldetik=seconds;\r\n\r\n        var timeValue ;\r\n ";
echo "       timeValue = ((jamku < 10) ? \"0\" : \"\") + jamku;\r\n        timeValue += ((menit < 10) ? \":0\" : \":\") + menit;\r\n        timeValue += ((detik < 10) ? \":0\" : \":\") + detik;\r\n        window.status = timeValue;\r\n       jam.value= timeValue;\r\n        timerID = setTimeout(\"showtime()\",500);\r\n        timerRunning = true;\r\n\r\n}\r\nfunction startclock () {\r\n        stopclock();\r\n        showtime();\r\n}\r\n</script>";
echo "\r\n";
?>
