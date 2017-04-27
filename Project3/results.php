


<html>
<head>
<link href="results.css" rel="stylesheet" type="text/css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#p1").keyup(function(){
		$input=$("#p1").val();
		
		$.ajax({
			method:"POST",
			url:"keyword_suggestion.php",
			data:{
				myinput:$input
			
			},
			dataType:"html",
		success:function(data){
			$("#suggestion").html(data);
		}
		});
		

	});
	
$(".result").mouseenter(function(){
	
		$.ajax({
			method:"POST",
			url:"result-detail.php",
			data:{
				videoid:$(this).attr("videoid")
			
			},
			dataType:"html",
		success:function(data){
			$("#D").html(data);
		}
		});
	
});
$(".result").mouseout(function(){
	$("#D").text("");
});

});
</script>

</head>

<body>

		<form action='https://opal.ils.unc.edu/~chengp/Project3/results.php' id='login' method='get' class='show'>
         User:<input type='text' name='user'><br><br>
         Password:<input type='password' name='password'><br><br>
         <input type='submit' value='submit' onclick()='Myfunction()'>
         </form>


<?php
     //When first visit or logout, display the login form
   
     session_start();
  
	   require "/fs1/home/chengp/dbtest/dbconnect.php";
       require "my_escape.php";
	   //Check Valid user
	    
	   if(isset($_GET['action']))	{
		   if($_GET['action']=="logout")
		   {
			   $user=$_SESSION["username"];
               $_SESSION=array();
              if(isset($_COOKIE[session_name()])){
	           setcookie(session_name(),'',time()-4200,'/');

               session_destroy();}


			   
		   }
	   }
		
		
	   if(isset($_GET['user'])&&isset($_GET['password'])){
		   //Check user and password parameter exist
	
		   $user=my_escape($db,$_GET['user']);
		   $password=sha1($_GET['password']); 
		   $_SESSION['action']="validuser";
           $query="select password from logi where pname='".$user."'";	
         
		   if($result=mysqli_query($db,$query))
	   {   
           
		   while($row=mysqli_fetch_assoc($result)){
		   
		    $expected_p=$row['password'];
			if($expected_p==$password)
			 //valid user login 
			$_SESSION['username']=$user;
		    $_SESSION['action']="validuser";
	   }}
	   else{echo "error";}}
	   
	   
	   if(isset($_SESSION['username'])){
		//valid user login 
	   //check GET Parameter pass to the script or not 
	   echo "<Script type='text/Javascript'>";
	   echo "document.getElementById('login').className='hidden'";
	   echo "</Script>";
	   $_SESSION['action']="valid uer";
	   echo "<p id='info'>Hello  ".$_SESSION['username']."  <a href='results.php?action=logout'>Log out</a></p>";
	   echo "<p id='p'>Open video</p>";
	   echo  "<div id='flex_container'>";
	   echo  "<div id='B_C'>";
       echo "<form action='https://opal.ils.unc.edu/~chengp/Project3/results.php' method='get'>";
	   echo "<input type='text' id='p1' style='width:200px' name='query'><br/>";
	   echo "<input type='submit' value='Search' id='b'/><br/>";
       echo "</form>";
       echo "<p id='p2'>Suggestions:</p>";
      echo "<div id='suggestion'></div>";
      echo "</div>";
      echo "<div id='A'>";
	   
	   if(isset($_GET['query']))
	   {  
	   $query=my_escape($db,$_GET['query']);   
	  
	    if($query=="")
		 echo "No valid input";
		else
		{$select_q="select videoid ,title,creationyear,description from p3records where match( title, description, keywords) against ('".$query."')";
	 
	   if($result=mysqli_query($db,$select_q))
	   {    echo "Showing results for:".$query."<br/>";
		   while($row=mysqli_fetch_assoc($result)){
		 
		   $videoid=$row['videoid'];  
		   $title=htmlentities($row['title']);
	       $year=htmlentities($row['creationyear']);
		   $description=htmlentities($row['description']);
		   echo "<div class='result' videoid=".$videoid.">";
		   echo "<strong>".$title."</strong>(".$year.")<br/>";
		   echo $description;
		   echo "</div>";
		   echo "<br/>";
	       echo "<br/>";
		
	   }}
	   
	   else{
		  // cannot find results;
	   }
		}// valid input query
	
	 
	   }//query parameter exist
	   
	   echo "</div>";
       echo "<div id='D'></div>";
       echo "</div>"; 
       echo "</body>";
       echo "</html>";

}
?> 

