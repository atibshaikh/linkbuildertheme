<?php 

	$thecurpage = $_GET['page'];
	$theaction = '';



	$ahref_token = 'eaefb9584ab1541994d9d6cace17efa7d2e67b5a';


	// https://apiv2.ahrefs.com?token=eaefb9584ab1541994d9d6cace17efa7d2e67b5a&target=interia.pl&mode=subdomains&from=domain_rating&limit=1&output=json&select=domain_rating

	// https://apiv2.ahrefs.com?token=eaefb9584ab1541994d9d6cace17efa7d2e67b5a&target=interia.pl&mode=subdomains&from=positions_metrics&limit=1&output=json&select=traffic

	// https://apiv2.ahrefs.com?token=eaefb9584ab1541994d9d6cace17efa7d2e67b5a&target=interia.pl&mode=subdomains&from=refdomains&limit=1&output=json&select=refdomain


	//$videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$thechannelid.'&maxResults='.'4'.'&key='.$theyoutubekey.''));



	if (isset($_GET['action'])){
	  //set the action
	  $theaction = $_GET['action'];
	  $import_domain_rating = false;
	  $import_organic_traffic = false;
	  $import_referring_domains = false;

	  if($theaction == "import_domain_rating"){

	  	$dr_date = $_GET['dr_dp'];

		  $orderdate = explode('-', $dr_date);
			$day = $orderdate[0];
			$month   = $orderdate[1];
			$year  = $orderdate[2];

			//get all product query in helper-function file
			$allProduct = get_all_products($day,$month,$year);

	  }else if($theaction == "import_organic_traffic"){

	  	$ot_dp = $_GET['ot_dp'];

		  $orderdate = explode('-', $ot_dp);
			$day = $orderdate[0];
			$month   = $orderdate[1];
			$year  = $orderdate[2];

			//get all product query in helper-function file
			$allProduct = get_all_products($day,$month,$year);

	  }else if($theaction == "import_referring_domains"){

	  	$rd_dp = $_GET['rd_dp'];

		  $orderdate = explode('-', $rd_dp);
			$day = $orderdate[0];
			$month   = $orderdate[1];
			$year  = $orderdate[2];

			//get all product query in helper-function file
			$allProduct = get_all_products($day,$month,$year);
	  }

	  
	}

	if($theaction == "import_domain_rating"){


		if( $allProduct->have_posts() ){

			while ($allProduct->have_posts()) {
				
				$allProduct->the_post();

				$product = wc_get_product(get_the_ID());
				$product_title = get_the_title();

				$request_url_dr = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=domain_rating&limit=1&output=json&select=domain_rating';

				$ahref_response = json_decode(file_get_contents($request_url_dr));
		
				$domain_rating = $ahref_response->domain->domain_rating;

				update_field( 'domain_rating_dr', $domain_rating, get_the_ID());
			}

			$import_domain_rating = true;

			wp_reset_postdata();

		}
		
	}else if($theaction == "import_organic_traffic"){


		if( $allProduct->have_posts() ){

			while ($allProduct->have_posts()) {
				
				$allProduct->the_post();

				$product_title = get_the_title();

				$request_url_ot = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=positions_metrics&limit=1&output=json&select=traffic';

				$ahref_response = json_decode(file_get_contents($request_url_ot));
		
				$organic_traffic = (int)$ahref_response->metrics->traffic;

				update_field( 'organic_traffic', $organic_traffic, get_the_ID());
			}

			$import_organic_traffic = true;

			wp_reset_postdata();

		}

	}else if($theaction == "import_referring_domains"){

		if( $allProduct->have_posts() ){

			while ($allProduct->have_posts()) {
				
				$allProduct->the_post();

				$product_title = get_the_title();

				$request_url_rd = 'https://apiv2.ahrefs.com?token='.$ahref_token.'&target='.$product_title.'&mode=subdomains&from=refdomains&limit=1&output=json&select=refdomain';

				$ahref_response = json_decode(file_get_contents($request_url_rd));
		
				$ref_domain = $ahref_response->stats->refdomains;

				update_field( 'domain_age', $ref_domain, get_the_ID());
			}

			$import_referring_domains = true;

			wp_reset_postdata();

		}

	}


	if($import_domain_rating == true){
		?>
		<div class="alert alert-success">
	      <h2>You have successfully updated Domain Rating data from ahref</h2>
	    </div>
		<?php

	}else if($import_organic_traffic == true){
		?>
		<div class="alert alert-success">
	      <h2>You have successfully updated Organic Trafiic data from ahref</h2>
	    </div>
		<?php
	}else if($import_referring_domains == true){
		?>
		<div class="alert alert-success">
	      <h2>You have successfully updated Referring Domains data from ahref</h2>
	    </div>
		<?php
	}


?>


<div class="wrap" id="wrap">
	<div class="container" style="max-width:100%;">

	     <div class="row text-center">

	     	<div class="col-sm col-md-12 p-3">
	         	<div class="form-wrap">
	         		<h4>Enable API call during Update Product</h4>
		             <form method="post" action="options.php">
                        <?php
                        settings_fields( 'enableApiOnSavePost' );
                        do_settings_sections( 'enableApiOnSavePost' );

                        $options = get_option( 'enableapi' );
                        ?>
                        <div class="form-group">
                          
                          <input type="radio" id="enableapi" name="enableapi" value="Yes" <?php if($options == "Yes") echo "checked";  ?> /> Yes
                          <input type="radio" id="enableapi" name="enableapi" value="No" <?php if($options == "No") echo "checked";  ?>/> No
                          
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
	         	</div>
	         </div>

	         <div class="col-sm col-md-4 p-3">
	         	<div class="form-wrap">
	         		<h5>Click here to Update Domain Rating Data From ahref</h5>
		            <form method="get" action="">
		               <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
		               <input type="hidden" value="import_domain_rating" name="action" />
		               <div class="import-date-field">
		               		<label for="datepicker1">Select products from specific date or leave empty</label>
		               		<input type="text" id="datepicker1" class="importDatepicker" placeholder="Select Date" name="dr_dp" value="<?php echo $dr_date; ?>" />
		               </div>
		               
		               <button type="submit" class="btn btn-success btn-lg">Import</button>
		            </form>
	         	</div>
	         </div>

	          <div class="col-sm col-md-4 p-3">
	         	<div class="form-wrap">
	         		<h5>Click here to Update Organic Traffic Data From ahref</h5>
		            <form method="get" action="">
		               <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
		               <input type="hidden" value="import_organic_traffic" name="action" />
		               <div class="import-date-field">
		               		<label for="datepicker2">Select products from specific date or leave empty</label>
		              	 <input type="text" id="datepicker2" class="importDatepicker" placeholder="Select Date" name="ot_dp" value="<?php echo $ot_dp; ?>" />
		             </div>
		               <button type="submit" class="btn btn-success btn-lg">Import</button>
		            </form>
	         	</div>
	         </div>

	          <div class="col-sm col-md-4 p-3">
	         	<div class="form-wrap">
	         		<h5>Click here to Update Referring Domains Data From ahref</h5>
		            <form method="get" action="">
		               <input type="hidden" value="<?php echo($thecurpage); ?>" name="page" />
		               <input type="hidden" value="import_referring_domains" name="action" />
		               <div class="import-date-field">
		               		<label for="datepicker3">Select products from specific date or leave empty</label>
		              	 <input type="text" id="datepicker3" class="importDatepicker" placeholder="Select Date" name="rd_dp" value="<?php echo $rd_dp; ?>" />
		            	 </div>
		               <button type="submit" class="btn btn-success btn-lg">Import</button>
		            </form>
	         	</div>
	         </div>
	     </div>  

	</div>
</div>
