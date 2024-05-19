tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
    theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
    theme_advanced_buttons3 : "",
    theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    plugins : 'asciimath,asciisvg,table,inlinepopups,media',
    remove_script_host : true,
    AScgiloc : '../tiny_mce/php/svgimg.php',  		      //change me  
    ASdloc : '../tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : '../tiny_mce/css/content.css'
}); 
