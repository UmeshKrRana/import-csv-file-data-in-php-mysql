<?php

	class ImportController {

		// getting connection in constructor
		function __construct($conn) {

			$this->conn 		 =		 $conn;

		}


		// function for reading csv file
		public function index() {

        	$fileName         =        "";

        	// if there is any file
	        if(isset($_FILES['file'])){

	        	// reading tmp_file name
	    		$fileName     =        $_FILES["file"]["tmp_name"];
	        }

			$counter          =        0;	 


			// if file size is not empty
	        if (isset($_FILES["file"]) && $_FILES["file"]["size"] > 0) {   

		        $file       =  fopen($fileName, "r");			        
		        
		        // eliminating the first row of CSV file
			    fgetcsv($file);  ?>

			    <table class="table">
			    	<thead>
			    		<th> Sl </th>
			    		<th> Product Name </th>
			    		<th> SKU </th>
			    		<th> Brand </th>
			    		<th> Quantity </th>
			    		<th> Price Per Unit </th>
			    		<th> Response </th>
			    	</thead>
			        
		        <?php 
		        	while (($column = fgetcsv($file, 10000, ",")) !== FALSE) { 

			            $counter++;	   

			            // assigning csv column to a variable
	        	 		$product_name      =       $column[0];

	        	 		$sku         	   =       $column[1];
	        	 		
	        	 		$brand             =       $column[2];
	        	 		
	        	 		$quantity		   =	   $column[3];
	        	 		
	        	 		$price_per_unit    =	   $column[4];
	                

	                	// inserting values into the table
	                	$sql 				=		"INSERT INTO products (product_name, sku, brand, quantity, price_per_unit) VALUES ('$product_name', '$sku', '$brand', '$quantity', '$price_per_unit') ";
	                	$result 			=		$this->conn->query($sql);

	                	if($result == 1): ?>                		
	                    		<tr>
									<td> <?php echo $counter; ?> </td>
									<td> <?php echo $product_name; ?> </td>
									<td> <?php echo $sku; ?> </td>
									<td> <?php echo $brand; ?> </td>
									<td> <?php echo $quantity; ?> </td>
									<td> <?php echo $price_per_unit; ?> </td>
	     							<td> <?php echo "<label class='text-success'>Success </label> " .date('d-m-Y H:i:s');?> </td>
								</tr>
	                	<?php endif;
				}
				 ?>
				</table>

				<?php
			}

		else{
		}
	}	

}

?>