<?php
class word
{ 
/*
@GNU:GPL
@author axgle <axgle@yahoo.com.cn>
@date 2005.4.20
*/

function start()
{
ob_start();
print'<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">';

}

function save($path)
{

print "</html>";
$data = ob_get_contents();

ob_end_clean();

$this->wirtefile ($path,$data);
}

function wirtefile ($fn,$data)
{

$fp=fopen($fn,"wb");
fwrite($fp,$data);
fclose($fp);
}

}

?>