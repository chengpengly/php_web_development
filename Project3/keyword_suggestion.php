<?php
       require "/fs1/home/chengp/dbtest/dbconnect.php";
       require "my_escape.php";
	   //clean user input
	   
	   $query=$_POST['myinput'];
	 
	   $select_q="select col1 from suggestion where col1 like '".$query."%'";
	    $count=0;
	    if($result=mysqli_query($db,$select_q))
	   {     while($row=mysqli_fetch_assoc($result) and $count<=10){
		    $count+=1;
		   $a=$row['col1'];  
		   
		   echo $a."<br/>";
		
	}
	  
	  }
	   
	   else{
		  // cannot find results;
	   }
	   
	  ?> 