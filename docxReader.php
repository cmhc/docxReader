<?php
/*---------------------------------------------
 * docx�ĵ���ȡ��
 * Author huchao
 * Email hu_chao@139.com
 * Site http://www.ttwrite.com 
---------------------------------------------*/
class docxReader
{
  public $resource;//�ļ�·��
  
  private $content;//�ĵ�����
  
  public function __construct(){
    $this->content = '';
  }
  
  /*
    ����document�ĵ�
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
      //ɾ��zip��ʱ�ļ�
      //unlink($this->tmp_file);
      return true;
    }
    
    return false;
    
  }
  
  /**
   * ��ʽ��xml�ĵ�
  */
	private function formatXML($xml){
		//�����滻
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
		
		//�̶��滻
		$from = array('</w:p>','</w:tbl>','</w:tr>','</w:tc>','<w:br/>');
		$to = array('</p>','</table>','</tr>','</td>','<br/>');
		$xml = str_replace($from,$to,$xml);
		return strip_tags($xml,'<p><table><tr><td><br>');
	}
	
  /*
    ����ĵ�
  */
  public function read($file_path){
		$this->resource = $file_path;
		$this->getDocument();//��ȡ�ĵ�����
    return $this->formatXML($this->content);
  }
}
?>