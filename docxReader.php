<?php
/*---------------------------------------------
 * docx文档读取器
 * Author huchao
 * Email hu_chao@139.com
 * Site http://www.ttwrite.com 
---------------------------------------------*/
class docxReader
{
  public $resource;//文件路径
  
  private $content;//文档内容
  
  public function __construct(){
    $this->content = '';
  }
  
  /*
    返回document文档
  */
  public function getDocument(){
  
    if( !file_exists($this->resource) )
			return false;
			
    $zip = new ZipArchive;
    $res = $zip->open($this->resource);
    if($res == true){
      $fp = $zip->getStream('word/document.xml');
      if($fp){
				while(!feof($fp))
					$this->content .= fread($fp,2);
			  fclose($fp);
			}
      $zip->close();
      //删除zip临时文件
      //unlink($this->tmp_file);
      return true;
    }
    
    return false;
    
  }
  
  /**
   * 格式化xml文档
  */
	private function formatXML($xml){
		//正则替换
		//return $xml;
		$pattern = array(
			'/<w:p[^\w][^>]*?>/',
			'/<w:tbl[^\w][^>]*>/',
			'/<w:tr[^\w][^>]*>/',
			'/<w:tc>/'
		);
		$replace = array(
			'<p>',
			'<table>',
			'<tr>',
			'<td>'
		);
		$xml = preg_replace($pattern,$replace,$xml);
		
		//固定替换
		$from = array('</w:p>','</w:tbl>','</w:tr>','</w:tc>','<w:br/>');
		$to = array('</p>','</table>','</tr>','</td>','<br/>');
		$xml = str_replace($from,$to,$xml);
		return strip_tags($xml,'<p><table><tr><td><br>');
	}
	
  /*
    输出文档
  */
  public function read($file_path){
		$this->resource = $file_path;
		$this->getDocument();//获取文档内容
    return $this->formatXML($this->content);
  }
}
?>