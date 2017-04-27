

<?php
	   require "/fs1/home/chengp/dbtest/dbconnect.php";
       require "my_escape.php";
	   //clean user input
	   $query=my_escape($db,$_POST['videoid']);
	 
	   $select_q="select duration,genre ,title,keywords,color,sound,sponsorname from p3records where videoid=".$query;
	 
	   if($result=mysqli_query($db,$select_q))
	   {   $row=mysqli_fetch_assoc($result);
		   $genre=htmlentities($row['genre']);
		   $duration=htmlentities($row['duration']);  
		   $title=htmlentities($row['title']);
	       $color=htmlentities($row['color']);
		   $sound=htmlentities($row['sound']);
		   $sponsorname=htmlentities($row['sponsorname']);
		   echo "<strong>".$title."</strong><br>";
		   echo "<strong>Genre:</strong>".$genre."<br>";
		   echo "<strong>Duration:</strong>".$duration."<br>";
		   echo "<strong>Color:</strong>".$color."<br>";
		   echo "<strong>Sound:</strong>".$sound."<br>";
		   echo "<strong>Sponsor:</strong>".$sponsorname."<br>";
	     
	   }
	   else{
		  // cannot find results;
	   }
?> 


