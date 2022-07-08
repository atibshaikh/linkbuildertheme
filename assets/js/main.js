

(function($) {

	$doc = $(document);
	$doc.ready( function() {

		/**
		 * Retrieve marketplace posts
		 */
		function get_posts($params) {

			$container = $('#ajax-posts-filter');
			$content   = $container.find('.content');
	        $status    = $container.find('.status');

			$status.text('Loading links ...');

				$.ajax({

            		url: linkbuild.ajax_url,
            		data: {
            			action: 'do_filter_postajax',
							nonce: linkbuild.nonce,
							params: $params
		            		},
            		type: 'post',
            		dataType: 'json',
            		success: function(data, textStatus, XMLHttpRequest) {
            	
		            	if (data.status === 200) {
		            		$content.html(data.content);
		            	}
		            	else if (data.status === 201) {
		            		$content.html(data.message);	
		            	}
		            	else {
		            		$status.html(data.message);
		            	}
		            },
			        error: function(MLHttpRequest, textStatus, errorThrown) {

						$status.html(textStatus);
					
						/*console.log(MLHttpRequest);
						console.log(textStatus);
						console.log(errorThrown);*/
			        },
					complete: function(data, textStatus) {
						
						msg = textStatus;

		            	if (textStatus === 'success') {
		            		msg = data.responseJSON.found;
		            	}

		            	$status.text(msg + ' matches Found');
		            	
		            	/*console.log(data);
		            	console.log(textStatus);*/
		            }

		        });
		}


		/**
		 * javascript to get all post filter data and call ajax to retrive products
		 */
		$('#ajax-posts-filter').on('click', 'a[data-filterp], .pagination a, #search-now', function(event) {
			
			event.preventDefault();
			if(event.preventDefault) { event.preventDefault(); }

			$this = $(this);

			$from_domain_rating_dr = $('#from_domain_rating_dr').val();
			$to_domain_rating_dr = $('#to_domain_rating_dr').val();


			$from_organic_traffic = $('#from_organic_traffic').val();
			$to_organic_traffic = $('#to_organic_traffic').val();

			$from_domain_age = $('#from_domain_age').val();
			$to_domain_age = $('#to_domain_age').val();


			$from_domain_authority_da = $('#from_domain_authority_da').val();
			$to_domain_authority_da = $('#to_domain_authority_da').val();

			
			$link_language = $('#link_language').val();
			$productCat = $('#product_cat').val();

			$sort_field_data = $('#sort_field').val();
			$sort_order_data = $('#sort_order').val();

			// Yes
			// No

			if ($('#domain_casino').is(":checked")){
			  $domain_casino="Yes";
			}else{
			  $domain_casino="";
			}

			if ($('#domain_loan').is(":checked"))
			{
			  $domain_loan ="Yes";
			}else{
			  $domain_loan ="";

			}
			
			if ($('#domain_erotic').is(":checked"))
			{
			  $domain_erotic= "Yes";
			}else{
			  $domain_erotic= "";
			}
			
			if ($('#domain_dating').is(":checked"))
			{
			  $domain_dating = "Yes";
			}else{
				$domain_dating = "";
			}
			
			if ($('#domain_cbd').is(":checked"))
			{
			  $domain_cbd = "Yes";
			}else{
				$domain_cbd = "";
			}

			if ($('#domain_crypto').is(":checked"))
			{
			  $domain_crypto= "Yes";
			}else{
				$domain_crypto= "";
			}
			
			// console.log("domain_casino " + $domain_casino);
			// console.log("domain_loan " + $domain_loan);
			// console.log("domain_erotic " + $domain_erotic);
			// console.log("domain_dating " + $domain_dating);
			// console.log("domain_cbd " + $domain_cbd);
			// console.log("domain_crypto " + $domain_crypto);

			// console.log($productCat);
			
			// console.log($from_domain_rating_dr);
			// console.log($to_domain_rating_dr);

			// console.log($from_organic_traffic);
			// console.log($to_organic_traffic);

			// console.log($from_domain_age);
			// console.log($to_domain_age);

			// console.log($from_domain_authority_da);
			// console.log($to_domain_authority_da);

			// console.log($link_language);

			// set filter  value text on ajax call

			$seatch_product = $('#seatch_product').val();
			console.log($seatch_product);

			$('.dr-from').text($from_domain_rating_dr);

			if($to_domain_rating_dr == ''){
				$('.dr-to').text("∞");
			}else{
				$('.dr-to').text($to_domain_rating_dr);
			}

			
			$('.dt-from').text($from_organic_traffic);

			if($to_organic_traffic == ''){
				$('.dt-to').text("∞");
			}else{
				$('.dt-to').text($to_organic_traffic);
			}


			$('.age-from').text($from_domain_age);

			if($to_domain_age == ''){
				$('.age-to').text("∞");
			}else{
				$('.age-to').text($to_domain_age);
			}

			$('.authority-from').text($from_domain_authority_da);

			if($to_domain_authority_da == ''){
				$('.authority-to').text("∞");
			}else{
				$('.authority-to').text($to_domain_authority_da);
			}

			/**
			 * Set filter active
			 */

			if ($this.data('filterp')) {
				$this.closest('ul').find('.active').removeClass('active');
				$this.parent('li').addClass('active');
				$page = $this.data('page');
			}
			else if($this.data('send')){
				$page = $this.data('page');
			}
			else {
				/**
				 * Pagination
				 */
				$page = parseInt($this.attr('href').replace(/\D/g,''));
				$this = $('.nav-filter .active a');
			}
			

	        $params    = {
	        	'page' : $page,
	        	'tax'  : 'product_cat',
	        	// 'term' : $this.data('term'),
	        	'term' : $productCat,
	        	'qty'  : 8,
	        	'from_domain_rating_dr'  : $from_domain_rating_dr,
	        	'to_domain_rating_dr'  : $to_domain_rating_dr,
	        	'from_organic_traffic' : $from_organic_traffic,
	        	'to_organic_traffic' : $to_organic_traffic,
	        	'from_domain_age'   : $from_domain_age,
	        	'to_domain_age'   : $to_domain_age,
	        	'from_domain_authority_da' : $from_domain_authority_da,
	        	'to_domain_authority_da' : $to_domain_authority_da,
	        	'link_language' : $link_language,
	        	'domain_casino' : $domain_casino,
	        	'domain_loan' 	 : $domain_loan,
	        	'domain_erotic' : $domain_erotic,
	        	'domain_dating' : $domain_dating,
	        	'domain_cbd' : $domain_cbd,
	        	'domain_crypto' : $domain_crypto,
				'sort_field_data' : $sort_field_data,
	        	'sort_order_data' : $sort_order_data,
	        	'seatch_product' : $seatch_product


	        };

	        // Run query
	        get_posts($params);
		});
		var timer = null;

		$('#seatch_product').on('input', function(e) {
			  if('' == this.value) {
			   	triggerSearch();
			  }

		});
		$('#seatch_product').keydown(function(){
		       clearTimeout(timer); 
		       timer = setTimeout(triggerSearch, 1000)
		});

		function triggerSearch(){
			$('#search-now').trigger('click');	
		}
		
		// $('a[data-term="all-terms"]').trigger('click');
		$('#search-now').trigger('click');

		
	});

})(jQuery);





(function($){


	//show hide doc upload on cart page popup form
	function show_doc_upload_btn(){

		$('.doc_upload').on('change keyup paste',function(e){
				
				var dockey = $(this).data('dockey');
				console.log('.key_' + dockey+ ' #doc_upload');
				$doc_upload = $('.key_' + dockey + ' #doc_upload').val();
				console.log($doc_upload);

				if($doc_upload === "article"){
					console.log('article selected');
					jQuery('.doc_'+ dockey + ' a.upload-file').hide();
					jQuery('.doc_'+ dockey + ' a.upload-file').text("upload article");
					
				}else{
					jQuery('.doc_'+ dockey + ' a.upload-file').show();
					jQuery('.doc_'+ dockey + ' a.upload-file').text("upload banner");
				}

		});

		$('.who_provide_article').on('change keyup paste',function(e){
			
			var dockey = $(this).data('dockey');
			//console.log("DOC KEY" + dockey);
			console.log('.key_' + dockey+ ' #who_provide_article');


			
			$who_provide_article = $('.key_' + dockey + ' #who_provide_article').val();
			console.log($who_provide_article);

			if($who_provide_article === "write_content"){
				console.log('write_content selected');
				jQuery('.doc_'+ dockey + ' a.upload-file').hide();
				jQuery('.doc_'+ dockey + ' a.upload-file').text("upload Article");
			}else {
				jQuery('.doc_'+ dockey + ' a.upload-file').show();
				jQuery('.doc_'+ dockey + ' a.upload-file').text("upload Article");
			}

		});
	}


	//cart product option popup form function
	function update_cart_option(){

		//update product option on cart 
		$('.submit-cart-data').on('click',function(e){
		 	e.preventDefault();
			 $('.cart_totals').block({
					message: null,
					overlayCSS: {
					background: '#fff',
					opacity: 0.6
				 }
			 });


		 	var cart_id = $(this).data('cartkey');
		 	//console.log('.key_' + cart_id + ' #doc_upload');
			$doc_upload = $('.key_' + cart_id + ' #doc_upload').val();
			$who_provide_article = $('.key_' + cart_id + ' #who_provide_article').val();
			$article_anchor_text = $('.key_' + cart_id + ' #article_anchor_text').val();
			$article_req = $('.key_' + cart_id + ' #article_req').val();
			$publish_period = $('.key_' + cart_id + ' #publish_period').val();
			$cart_product_id = $('.key_' + cart_id + ' #cart_product_id').val();
			$internal_ref = $('.key_' + cart_id + ' #internal_ref').val();
			$custom_modal_id = $('.key_' + cart_id + ' #custom_modal_id').val();


			console.log(cart_id);
			console.log($doc_upload);
			console.log($who_provide_article);
			console.log($article_anchor_text);
			console.log($article_req);
			console.log($publish_period);
			console.log($internal_ref);
			console.log($custom_modal_id);
			console.log($cart_product_id);


			 $.ajax({
				 type: 'POST',
				 url: prefix_vars.ajaxurl,
				 data: {
					 action: 'update_niche_on_cart',
					 security: $('#woocommerce-cart-nonce').val(),
					 custom_product_id : $cart_product_id,
					 doc_upload: $doc_upload,
					 who_provide_article: $who_provide_article,
					 article_anchor_text: $article_anchor_text,
					 article_req: $article_req,
					 publish_period: $publish_period,
					 internal_ref : $internal_ref,
					 cart_id: cart_id
				 },
				 success: function( response ) {
				 	$('.cart_totals').unblock();
				 	console.log(response);
				 }
		 	})

			var myModalEl = document.getElementById($custom_modal_id);
			var modal = bootstrap.Modal.getInstance(myModalEl)
			modal.hide();

			setTimeout(function () {
	             $('button.trigger-total').trigger("click");
	         }, 1500);
			
		});

	}

	//jquery for conditional show hide fields
	function form_condition_script(){

		$('.product-cart-options' ).formalist({

		  // default selector
		  selector: ':radio,:checkbox,select',

		  // trigger event
		  event: 'change',

		  // default box
		  box: '.c-show-hide',

		  // cascading elements
		  cascade: 'select:visible option:selected',

		  // default CSS classes
		  classwhenhidden: 'hidden',
		  classwhenvisible: 'visible',

		  // callback functions
		  // hide: function(box) {hide(box);},
		  // show: function(box) {show(box);},
		  // correlate: function(box, field, type, value, name, id) {return correlate(box, field, type, value, name, id);}
		  
		});
	}



	$(document).ready(function(){

			// $ = jQuery;
			
			//cart conditional field script call function
			form_condition_script();

			$( ".menu-trigger" ).on( "click", function(e) {
			      e.preventDefault();
			      $('.mob-menu').toggleClass('show-menu');
			});

			// $( ".showTrigger" ).on( "click", function(e) {

			//       e.preventDefault();
			      

			//       var triggerTarget = $(this).data('showtarget');
			//       console.log("Target :" + triggerTarget);
			//       $('.'+ triggerTarget).toggleClass('show-box');
			// });


			//filter DR,OT,RD Data js
			var removeClass1 = true
			$(".showTrigger").on( "click", function(e) {

				e.preventDefault();	
				
				removeClass1 = false;

				e.stopPropagation()

				var triggerTarget = $(this).data('showtarget');
			      console.log("Target :" + triggerTarget);

				//console.log(targetValue);
				// $('.' + targetValue).toggleClass('active');

				 if ($('.' + triggerTarget).hasClass("show-box")) {

			      $(".show-box").removeClass("show-box");
			    

			    } else {

			      $(".show-box").removeClass("show-box");
			      $('.' + triggerTarget).addClass("show-box")

			    }

				//$(this).closest('div').find('.popover-content').toggleClass('active');

			});
			$('.close-box').on('click', function (event) {
			  $(".commonTrigger").removeClass("show-box");
			});


			$('.triggerColCheck input[type=checkbox]').change(function() {

			  var checkValue = $(this).val(); // this gives me null
			  const checked = $(this).is(':checked'); 
			  console.log(checked);
			  if (checked === true) {
			   	$('.' + checkValue).show();
			  }else{
			  	
			  	$('.' + checkValue).hide();
			  }

			});
			



			 
		//update product option on cart 
		update_cart_option();

		//js function to show hide upload button on form select field
		show_doc_upload_btn();



		  //add note from order thank you page
		  $( "#note-submit" ).on( "click", function(e) {

		   	e.preventDefault();	

				$.ajax({
					url: prefix_vars.ajaxurl,
					type: 'POST',
					data: $('#thankyou_form').serialize(),
					beforeSend : function( xhr ){
						$('#thankyou_form').html('Thank you! You feedback has been send!');
					},
					success : function( data ){
						console.log( data );
					}
				});

			});
		

		 //change tooltip value on change
		 $(".popover-content input").on( "change", function(e) {
			
			$from_domain_rating_dr = $('#from_domain_rating_dr').val();
			$to_domain_rating_dr = $('#to_domain_rating_dr').val();


			$from_organic_traffic = $('#from_organic_traffic').val();
			$to_organic_traffic = $('#to_organic_traffic').val();

			$from_domain_age = $('#from_domain_age').val();
			$to_domain_age = $('#to_domain_age').val();


			$from_domain_authority_da = $('#from_domain_authority_da').val();
			$to_domain_authority_da = $('#to_domain_authority_da').val();

			//Domain Rating
			if($from_domain_rating_dr === ''){
				$('.dr-from').text("0");
			}else{
				$('.dr-from').text($from_domain_rating_dr);
			}
			if($to_domain_rating_dr === ''){
				$('.dr-to').text("∞");
			}else{
				$('.dr-to').text($to_domain_rating_dr);
			}

			// Organic Traffic
			if($from_organic_traffic === ''){
				$('.dt-from').text("0");
			}else{
				$('.dt-from').text($from_organic_traffic);
			}

			if($to_organic_traffic === ''){
				$('.dt-to').text("∞");
			}else{
				$('.dt-to').text($to_organic_traffic);
			}

			// Referring Domain
			if($from_domain_age === ''){
				$('.age-from').text("0");
			}else{
				$('.age-from').text($from_domain_age);
			}
			if($to_domain_age === ''){
				$('.age-to').text("∞");
			}else{
				$('.age-to').text($to_domain_age);
			}

			//Domain Authority
			if($from_domain_authority_da === ''){
				$('.authority-from').text("0");
			}else{
				$('.authority-from').text($from_domain_authority_da);
			}
			if($to_domain_authority_da === ''){
				$('.authority-to').text("∞");
			}else{
				$('.authority-to').text($to_domain_authority_da);
			}

	});


	//load script after cart calculate event
	$( document ).on( 'updated_cart_totals', function(){
		console.log("HIT JS");
		
		//cart product option form function
		update_cart_option();

		//js function to show hide upload button on form select field
		show_doc_upload_btn();

		
		//cart conditional field script call function
		form_condition_script();
		 
	});


	//filter DR,OT,RD Data js
	var removeClass = true
	$(".show-popover").on( "click", function(e) {

		e.preventDefault();	
		
		removeClass = false;

		e.stopPropagation()

		var targetValue = $(this).attr("data-target");

		//console.log(targetValue);
		// $('.' + targetValue).toggleClass('active');

		 if ($('.' + targetValue).hasClass("active")) {

	      $(".popover-content").removeClass("active");
	    

	    } else {

	      $(".popover-content").removeClass("active");
	      $('.' + targetValue).addClass("active")

	    }

		//$(this).closest('div').find('.popover-content').toggleClass('active');

	});

	$(document).on('click', function (event) {
	  $(".popover-content").removeClass("active");
	});

	$('.popover-content').on( "click", function(e) {
			e.stopPropagation();
	});

	$('.mob-showhide-filter').on( "click", function(e) {
			e.preventDefault();
			$('.form-filters').toggle();
	});
		
		
 });


})(jQuery);



//run js after ajax complete on document
jQuery( document ).ajaxComplete(function() {

	
 	jQuery('input[name="quantity"]').change(function(){
		console.log('quantity change');
	    var q = jQuery(this).val();
	    jQuery('input[name="quantity"]').parent().next().attr('data-quantity', q);
	});

	//init tooltip
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})


	//sorting js and trigger ajax call
	jQuery('.csort').on('click', function(e) {
		e.preventDefault();
		
		var sort_field = jQuery(this).attr("data-sort");
		var sort_order = jQuery(this).attr('data-order');
		if(sort_order == "DESC"){
			jQuery(this).attr('data-order', 'ASC');
			// jQuery(this).append('<i class="fal fa-sort-numeric-down"></i>');
		}else{
			jQuery(this).attr('data-order', 'DESC');
			// jQuery(this).append('<i class="fal fa-sort-numeric-up"></i>');

		}

		jQuery('#sort_field').val(sort_field);
		jQuery('#sort_order').val(sort_order);

		console.log(sort_field);	
		console.log(sort_order);

		jQuery('#search-now').trigger('click');
	});

	//check sorting value after ajax call
	
	$check_sort_field = jQuery('#sort_field').val();
	$check_orderby_field = jQuery('#sort_order').val();
	
	if($check_orderby_field != ''){
		jQuery('span.add-arrow').remove();
		if($check_orderby_field == "DESC"){
			jQuery('.orderby-data').attr('data-order', 'ASC');
			jQuery('[data-sort=' + $check_sort_field + ']').append('<span class="add-arrow"><i class="fad fa-sort-down"></i><span>');
			
		}else{
			jQuery('.orderby-data').attr('data-order', 'DESC');
			
			jQuery('[data-sort=' + $check_sort_field + ']').append('<span class="add-arrow"><i class="fad fa-sort-up"></i></span>');
			
		}	
	
	}

});




//script to save filter data 
(function($) {

	$doc = $(document);
	$doc.ready( function() {

		function reload() {
            window.location = window.location.href.split("?")[0];
        }

		/**
		 * Retrieve posts
		 */
		function save_filter($params) {

			$.ajax({

            	url: linkbuild.ajax_url,
            	data: {
            		action: 'save_filter_ajax',
					nonce: linkbuild.nonce,
					params: $params
		        },
            	type: 'post',
            	dataType: 'json',
            	success: function(data, textStatus, XMLHttpRequest) {
            		
            		console.log(data);
                    console.log(textStatus);

                    $('#show-ajax-msg').show();
                    $('#show-ajax-msg').text(data.message);

                    setTimeout(function(){
                        $('#show-ajax-msg').hide();
                    }, 3000);

                    
                   setTimeout(function(){
                         reload();
                    }, 2000);

			    },
			    error: function(MLHttpRequest, textStatus, errorThrown) {

					console.log(textStatus);

			    }
			

	        });
		}


		/**
		 * Bind get_posts to tag cloud and navigation
		 */
		$('#ajax-posts-filter').on('click', '#save-filter', function(event) {
			
			event.preventDefault();

			if(event.preventDefault) { event.preventDefault(); }

			$this = $(this);

			$filterName = $('#add_filter_name').val();

			$from_domain_rating_dr = $('#from_domain_rating_dr').val();
			$to_domain_rating_dr = $('#to_domain_rating_dr').val();


			$from_organic_traffic = $('#from_organic_traffic').val();
			$to_organic_traffic = $('#to_organic_traffic').val();

			$from_domain_age = $('#from_domain_age').val();
			$to_domain_age = $('#to_domain_age').val();

			$from_domain_authority_da = $('#from_domain_authority_da').val();
			$to_domain_authority_da = $('#to_domain_authority_da').val();

			
			$link_language = $('#link_language').val();
			$productCat = $('#product_cat').val();

			$sort_field_data = $('#sort_field').val();
			$sort_order_data = $('#sort_order').val();

			// Yes
			// No

			if ($('#domain_casino').is(":checked")){
			  $domain_casino="Yes";
			}else{
			  $domain_casino="";
			}

			if ($('#domain_loan').is(":checked"))
			{
			  $domain_loan ="Yes";
			}else{
			  $domain_loan ="";
			}
			
			if ($('#domain_erotic').is(":checked"))
			{
			  $domain_erotic= "Yes";
			}else{
			  $domain_erotic= "";
			}
			
			if ($('#domain_dating').is(":checked"))
			{
			  $domain_dating = "Yes";
			}else{
				$domain_dating = "";
			}
			
			if ($('#domain_cbd').is(":checked"))
			{
			  $domain_cbd = "Yes";
			}else{
			  $domain_cbd = "";
			}

			if ($('#domain_crypto').is(":checked"))
			{
			  $domain_crypto= "Yes";
			}else{
			  $domain_crypto= "";
			}
	
			// set filter  value text on ajax call
			$('.dr-from').text($from_domain_rating_dr);

			if($to_domain_rating_dr == ''){
				$('.dr-to').text("∞");
			}else{
				$('.dr-to').text($to_domain_rating_dr);
			}

			
			$('.dt-from').text($from_organic_traffic);

			if($to_organic_traffic == ''){
				$('.dt-to').text("∞");
			}else{
				$('.dt-to').text($to_organic_traffic);
			}


			$('.age-from').text($from_domain_age);

			if($to_domain_age == ''){
				$('.age-to').text("∞");
			}else{
				$('.age-to').text($to_domain_age);
			}

			$('.authority-from').text($from_domain_authority_da);

			if($to_domain_authority_da == ''){
				$('.authority-to').text("∞");
			}else{
				$('.authority-to').text($to_domain_authority_da);
			}		

	        $params    = {
	        	'tax'  : $productCat,
	        	// 'term' : $this.data('term'),
	        	'term' : $productCat,
	        	'from_domain_rating_dr'  : $from_domain_rating_dr,
	        	'to_domain_rating_dr'  : $to_domain_rating_dr,
	        	'from_organic_traffic' : $from_organic_traffic,
	        	'to_organic_traffic' : $to_organic_traffic,
	        	'from_domain_age'   : $from_domain_age,
	        	'to_domain_age'   : $to_domain_age,
	        	'from_domain_authority_da' : $from_domain_authority_da,
	        	'to_domain_authority_da' : $to_domain_authority_da,
	        	'link_language' : $link_language,
	        	'domain_casino' : $domain_casino,
	        	'domain_loan' 	 : $domain_loan,
	        	'domain_erotic' : $domain_erotic,
	        	'domain_dating' : $domain_dating,
	        	'domain_cbd' : $domain_cbd,
	        	'domain_crypto' : $domain_crypto,
				'sort_field_data' : $sort_field_data,
	        	'sort_order_data' : $sort_order_data,
	        	 'filterName' : $filterName
	        };

	        // Run query
	        save_filter($params);
		});
		
		
	});

})(jQuery);