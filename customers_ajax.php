<?php

header("Content-Type:text/plain");

include "config.php";
include "includes/check_login.php";

if (isset($_GET['q'])) {
	if (isset($_GET['p'])) {
		$p = intval($_GET['p']);
		if ($p < 1) {
			$p = 1;
		}
		$record_from = (($p) - 1) * 10;
		$record_to = 10;
	} else {
		$record_from = 0;
		$record_to = 10;
		$p = 1;
	}
	$q = $_GET['q'];
	if ($q == '') {
		$sql = mysqli_query($link,"SELECT SQL_CALC_FOUND_ROWS * FROM customers
				ORDER BY customer_id DESC LIMIT $record_from, $record_to");
	} else {
		$sql = mysqli_query($link,"SELECT SQL_CALC_FOUND_ROWS * FROM customers
				WHERE company LIKE '%$q%'
				OR last_name LIKE '%$q%' 
				OR first_name LIKE '%$q%'
				OR CONCAT(first_name,' ',last_name) LIKE '%$q%'
				OR email LIKE '%$q%'
				OR address LIKE '%$q%'
				OR city LIKE '%$q%'
				OR street LIKE '%$q%'
				OR ward LIKE '%$q%'
				OR phone LIKE '%$q%'
				OR email LIKE '%$q%'
				ORDER BY customer_id DESC LIMIT $record_from, $record_to");
	}
	$num = mysqli_num_rows($sql);
	$num_rows = mysqli_fetch_row(mysqli_query($link,"SELECT FOUND_ROWS()"));
	$total_found_rows = $num_rows[0];
	$total_pages = ceil($total_found_rows / 10);

	

	if ($num > 0) {

		?>

<table class="table table-condensed" style="background-color: #e6ffff">	
    <thead>	
        <tr>	
            <th>NAME</th>
			<th>ADDRESS</th>
			<th>CONTACT</th>
			<th>CREATED</th>
			<th>STATS</th>
		</tr>
	</thead>
    <tbody>
		
        <?php

							while ($row = mysqli_fetch_array($sql)) {
								$id = $row['customer_id'];
								$company = $row['company'];
								$last_name = ucwords($row['last_name']);
								$first_name = ucwords($row['first_name']);
								$address = ucwords($row['address']);
								$city = $row['city'];
								$street = $row['street'];
								$ward = $row['ward'];
								$phone = $row['phone'];
								if (strlen($phone) > 2) {
									$phone = substr($row['phone'], 0, 3) . "-" . substr($row['phone'], 3, 3) . "-" . substr($row['phone'], 6, 4);
								}
								$email = $row['email'];
								$human_time = human_time($row['date_added']);
								$date_added = date($date_format, $row['date_added']);

								$total_work_orders = mysqli_num_rows(mysqli_query($link,"SELECT * FROM work_orders WHERE customer_id = $id"));
								if ($total_work_orders > 0) {
									$display_work_orders = "$total_work_orders <i class='glyphicon glyphicon-wrench'></i>";
								} else {
									$display_work_orders = '';
								}
								$total_customer_notes = mysqli_num_rows(mysqli_query($link,"SELECT * FROM customer_notes WHERE customer = $id"));
								if ($total_customer_notes > 0) {
									$display_customer_notes = "$total_customer_notes <i class='glyphicon glyphicon-pencil'></i>";
								} else {
									$display_customer_notes = '';
								}
								$total_quotes = mysqli_num_rows(mysqli_query($link, "SELECT * FROM boq WHERE customer_id = '$id'"));
								if ($total_quotes > 0) {
									$display_quotes = "$total_quotes <i class='fa fa-bell'></i>";
								} else {
									$display_quotes = '';
								}
								echo "
					<tr id='tr_$id'>
						<td><a href='customer_details.php?id=$id'>$first_name $last_name, $company</a></td>
						<td>$address<br><small>$city $street $ward</small></td>
						<td>$phone<br><small>$email</small></td>
						<td>$human_time</td>
						<td>$display_work_orders $display_customer_notes $display_quotes</td>
					</tr>
				";
							}
							?>
	
    </tbody>
</table>
			
<small class="text-muted pull-right">Records: <?php echo $total_found_rows; ?></small>

<?php 
	
	if ($total_found_rows > 10) { 

?>

<ul class="pagination">		
	

	<?php
		$i = $p;

		if ($total_pages <= 100 ){$pages_split = 10;}
		if (($total_pages <= 1000) AND ($total_pages > 100)){$pages_split = 100;}
		if (($total_pages <= 10000) AND ($total_pages > 1000)){$pages_split = 1000;}

		$url_query_strings = http_build_query(array_merge($_GET,array('p' => $i)));
		$p = $i;
		$prev_page = $p - 1;
		$next_page  = $p + 1;
		if ($p > 1 ){echo "<li id='p_$prev_page' class='prev'><a href='#$url_query_strings&p=$prev_page'>Prev</a></li>";}
		
		while ($i < $total_pages){
			$i++;
			if (($i == 1) OR (($p <= 3 ) AND ($i <= 6)) OR (( $i >  $total_pages - 6) AND ($p > $total_pages - 3 )) OR (is_int($i / $pages_split)) OR (($p > 3 ) AND ($i >= $p - 2) AND ($i <= $p + 3)) OR ($i == $total_pages)){
				if ($p == $i ) {
					$page_class = "active"; 
				}else{ 
					$page_class = "";
				}
				echo "<li id='p_$i' class='$page_class'><a href='#$url_query_strings&p=$i'>$i</a></li>";
			}
		}
		if ($p <> $total_pages ) {echo "<li id='p_$next_page' class='next'><a href='#$url_query_strings&p=$next_page'>Next</a></li>";}

	?>

</ul>

<?php 

} //  if (total_found_rows >= 10)   
} else { //if no records found
	echo "<div class='alert alert-danger'>No Records.</div>";
}
}//if(isset($_GET['q'])){

?>