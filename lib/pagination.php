<?php
	$total_pages = sqlfetcharray(mysql_query($query));
	$total_pages = $total_pages[num];
	$adjacents = 3;	
	if($_REQUEST['limit_table']){
		$limit=$_REQUEST['limit_table'];
	}else{
		$limit=5;
	}
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			
	else
		$start = 0;								
	
	if ($page == 0) $page = 1;					
	$prev = $page - 1;							
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);	
	$lpm1 = $lastpage - 1;
	$pagination = "";
	
	
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?$uri&limit=$limit&page=$prev\">previous</a>";
		else
			$pagination.= "<span class=\"disabled\">previous</span>";	
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?limit_table=$limit&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?limit_table=$limit&page=$lastpage\">$lastpage</a>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&page=$lastpage\">$lastpage</a>";		
				//$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			else
			{
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=2\">2</a>";

				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$counter\">$counter</a>";
				
				}
			}
		}
		if ($page < $counter - 1) 
		$pagination.= "<a href=\"$targetpage?$uri&limit_table=$limit&page=$next\">next</a>";
		
			//$pagination.= "<a href=\"$targetpage?page=$next\">next</a>";
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		//$pagination.= "</div>";		
	}
// end paging
?>