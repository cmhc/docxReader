<?php
	header("Content-type:text/html;charset=utf-8");
  require('docxReader.php');
  $DR = new docxReader();
  print_r($DR->read("files/test.docx"))
?>