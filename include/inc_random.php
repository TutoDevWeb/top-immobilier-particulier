<?PHP
//-----------------------------------------------------------------------
function key_generator($size) { 
  $key_g = ""; 
  $letter = "abcdefghijklmnopqrstuvwxyz"; 
  $letter .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  $letter .= "0123456789"; 
  
  srand((double)microtime()*date("YmdGis")); 
  
  for($cnt = 0; $cnt < $size; $cnt++) $key_g .= $letter[rand(0, 61)]; 
  
  return $key_g; 
}
//-----------------------------------------------------------------------
function pass_generator() { 
  $key_g = ""; 
  $letter = "ABCDEFGHJKLMNPQRSTUVWXYZ"; 
  $number = "23456789"; 
  
  srand((double)microtime()*date("YmdGis")); 
  
  for($cnt = 0; $cnt < 2; $cnt++) $pass_letter .= $letter[rand(0,23)]; 
  for($cnt = 0; $cnt < 3; $cnt++) $pass_number .= $number[rand(0,7)];
	
  return ($pass_letter.$pass_number); 
}
//-----------------------------------------------------------------------
function code_generator($size) { 
  $code_g = ""; 
  $number = "123456789"; 
  
  srand((double)microtime()*date("YmdGis")); 
  
  for($cnt = 0; $cnt < $size; $cnt++) $code_g .= $number[rand(0,8)]; 
  
  return $code_g; 
}
//-----------------------------------------------------------------------
function random_sleep() {
  srand((double)microtime()*date("YmdGis")); 
  
  $val = rand(1,10);
    
  sleep($val); 

}
//-----------------------------------------------------------------------
function random_ban() {
  srand((double)microtime()*date("YmdGis")); 
  
  $val = rand(1,4);

  return $val;

}
?>