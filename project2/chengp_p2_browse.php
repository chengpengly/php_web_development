<html>
<head>
<title>Data display</title>
<link rel="stylesheet" type="text/css" href="chengp_p2_styles.css">
</head>
<body>
<h1>Data display</h1>
<table border="1">
    
<?php
   // connect database;
    $h='pearl.ils.unc.edu';
	$u='webdb5';
	$p='Jw7WrQq8Y';
	$dbname='webdb5';
	$db=mysqli_connect($h,$u,$p,$dbname);
	if(mysqli_connect_errno()){
		echo "Problem connecting".mysqli_connect_error();
		exit();
	}
   //Get data from browse 
   $sort=$_GET['sort']==''?'itemnum':$_GET['sort'];
   
   $page=$_GET['page']==''?'1':$_GET['page'];
   $page=intval($page);
   $start=($page-1)*25;
   $end=$start+24;
 
   //The first time display the page, add column to database 
   if($sort==null)
   {$add_query="alter table  p2records add column last_name varchar(1000)";
   if(!mysqli_query($db,$add_query)) echo "add column error";}
   $last_name=array();
   
   //extract the last name of the first author's name
    $get_lastname_query="select authors from p2records";  
    if($result=mysqli_query($db,$get_lastname_query)){
	   while($row=mysqli_fetch_assoc($result)){
		   $name=addslashes($row['authors']);
		   $position_first_and=strpos($name,'and');
		  
		   //To get the name of first author;
		   $position_first_and?$first_author=substr($name,0,$position_first_and ):$first_author=$name;
		   $first_author_last_dot=strrpos($first_author,'.');
		   $lastname=$first_author_last_dot?substr($first_author,$first_author_last_dot+1):$first_author;
		   $last_name[$lastname]=$name;
	   }
   }
    else{ echo "Extract data error";}
  
   //update data in p2records
    foreach($last_name as $last=>$name){
	 
	    $update_query="update p2records set last_name='".$last."' where authors='".$name."'";		
		mysqli_query($db,$update_query);
	   
   }
  //To count the max number of pages
   $max_page=0;
   $count_query="select count(*) from p2records";
   if($result=mysqli_query($db,$count_query))  
   {   if($get=mysqli_fetch_assoc($result))
         $max_page=$get['count(*)']%25==0?$get['count(*)']/25:$get['count(*)']/25+1;
     }
   else echo "Count the max number of pages error";

   //To display data 
   $query="select authors,title,publication,year,type,url from p2records  order by " .$sort." limit ".$start.",".$end;
  
   echo "<tr>";
   
		echo "<td><a href='chengp_p2_browse.php?sort=last_name&page=".$page."'>authors</a></td>";
		echo "<td><a href='chengp_p2_browse.php?sort=title&page=".$page."'>title</a></td>";
		echo "<td><a href='chengp_p2_browse.php?sort=publication&page=".$page."'>publication</a></td>";
		echo "<td><a href='chengp_p2_browse.php?sort=year&page=".$page."'>year</a></td>";
		echo "<td><a href='chengp_p2_browse.php?sort=type&page=".$page."'>type</a></td>";
	echo "</tr>";
    if($result=mysqli_query($db,$query)){
	   while($row=mysqli_fetch_assoc($result)){
		   echo "<tr>";
		   echo "<td>".$row['authors']."</td>"; 
		   echo "<td><a href='".$row['url']."'>".$row['title']."</a></td>"; 
		   echo "<td>".$row['publication']."</td>"; 
		   echo "<td>".$row['year']."</td>"; 
		   echo "<td>".$row['type']."</td></tr>"; 
	   }
	   echo "</table>";
	   echo "<p>";
	   for($i=1;$i<=$max_page;$i++)
	   {  if ($i==$page) echo "[".$i."]";
	      else	 echo "<a href='chengp_p2_browse?page=".$i."&sort=".$sort."'>".$i."</a>";
	   
        }
   echo "</p>";}
   else{
	   echo "connection failed";
   }

   mysqli_close($db);
?>

</body>
</html>