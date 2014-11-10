#docx文档读取器
###描述
>office软件自带有导出html的功能，但是批量操作太麻烦，在网上搜索我决然没搜到转化的软件，于是就用php写了一个
###功能
>仅仅做最基础的转化，目前转化后的标签只有p,br,table系列，对我目前来说够用啦。
###用法
	header("Content-type:text/html;charset=utf-8");
  require('docxReader.php');
  $DR = new docxReader();
  print_r($DR->read("files/test.docx"))