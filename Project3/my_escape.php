<?php

 function my_escape($db,$s){
	 $retrval=$s;
	 if(get_magic_quotes_gpc)
		 $retrval=stripslashes($s);
	 $retrval=mysqli_real_escape_string($db,$retrval);
	 return $retrval;
 }
?>