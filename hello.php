<font face="美咲ゴシック"><?php

function test(){
if($_REQUEST["attack"]){
  return $rand = rand(5,50000);
 }
}

echo test();

?>
