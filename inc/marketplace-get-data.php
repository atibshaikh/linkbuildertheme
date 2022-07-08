<?php
//get url parameter to search based on save filter
if(isset($_GET['from_domain_rating_dr'])){
    $from_domain_rating_dr = $_GET['from_domain_rating_dr'];
}

if(isset($_GET['to_domain_rating_dr'])){
    $to_domain_rating_dr = $_GET['to_domain_rating_dr'];
    if($to_domain_rating_dr == 0){
        $to_domain_rating_dr = "∞";
    } 
}
if(isset($_GET['from_organic_traffic'])){
    $from_organic_traffic = $_GET['from_organic_traffic'];
}
if(isset($_GET['to_organic_traffic'])){
    $to_organic_traffic = $_GET['to_organic_traffic'];
    if($to_organic_traffic == 0){
        $to_organic_traffic = "∞";
    }
}
if(isset($_GET['from_domain_age'])){
    $from_domain_age = $_GET['from_domain_age'];
}
if(isset($_GET['to_domain_age'])){
    $to_domain_age = $_GET['to_domain_age'];
    if($to_domain_age == 0){
        $to_domain_age = "∞";
    }
}
if(isset($_GET['from_domain_authority_da'])){
    $from_domain_authority_da = $_GET['from_domain_authority_da'];
}
if(isset($_GET['to_domain_authority_da'])){
    $to_domain_authority_da = $_GET['to_domain_authority_da'];
    if($to_domain_authority_da == 0){
        $to_domain_authority_da = "∞";
    }
}
if(isset($_GET['link_language'])){
    $link_language = $_GET['link_language'];
    ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            console.log("Test");
            jQuery('select#link_language option:selected').attr("selected", null);
            jQuery("select#link_language option[value='<?php echo $link_language; ?>']").attr("selected", "selected");
        });
        

        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}

if(isset($_GET['term'])){
    $product_cat = $_GET['term'];
    ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            console.log("Test");
            jQuery('select#product_cat option:selected').attr("selected", null);
            jQuery("select#product_cat option[value='<?php echo $product_cat; ?>']").attr("selected", "selected");
        });
        

        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}
if(isset($_GET['domain_casino'])){
    $domain_casino = $_GET['domain_casino'];

     ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            // console.log("Test");
            $domain_casino_value = "<?php echo $domain_casino; ?>";
            if($domain_casino_value == "Yes"){
                jQuery('#domain_casino').prop('checked', true);

            }else{
                jQuery('#domain_casino').prop('checked', false);    
            }
            
        });
        

        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
    
}
if(isset($_GET['domain_loan'])){
    $domain_loan = $_GET['domain_loan'];
    ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            // console.log("Test");
            $domain_loan_value = "<?php echo $domain_loan; ?>";
            if($domain_loan_value == "Yes"){
                jQuery('#domain_loan').prop('checked', true);

            }else{
                jQuery('#domain_loan').prop('checked', false);    
            }
            
        });
        
        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}
if(isset($_GET['domain_erotic'])){
    $domain_erotic = $_GET['domain_erotic'];
    ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            // console.log("Test");
            $domain_erotic_value = "<?php echo $domain_erotic; ?>";
            if($domain_erotic_value == "Yes"){
                jQuery('#domain_erotic').prop('checked', true);

            }else{
                jQuery('#domain_erotic').prop('checked', false);    
            }
            
        });
        
        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}
if(isset($_GET['domain_dating'])){
    $domain_dating = $_GET['domain_dating'];
     ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            // console.log("Test");
            $domain_dating_value = "<?php echo $domain_dating; ?>";
            if($domain_dating_value == "Yes"){
                jQuery('#domain_dating').prop('checked', true);

            }else{
                jQuery('#domain_dating').prop('checked', false);    
            }
            
        });
        
        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}
if(isset($_GET['domain_cbd'])){
    $domain_cbd = $_GET['domain_cbd'];
      ?>
    <script type="text/javascript">

        jQuery(document).ready(function($) {
            // console.log("Test");
            $domain_cbd_value = "<?php echo $domain_cbd; ?>";
            if($domain_cbd_value == "Yes"){
                jQuery('#domain_cbd').prop('checked', true);

            }else{
                jQuery('#domain_cbd').prop('checked', false);    
            }
            
        });
        

        // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
    </script>
    <?php
}
if(isset($_GET['domain_crypto'])){
    $domain_crypto = $_GET['domain_crypto'];

      ?>
        <script type="text/javascript">

            jQuery(document).ready(function($) {

                
                setTimeout(function () {
                     jQuery('#search-now').trigger('click');
                 }, 1500);
                // console.log("Test");
                $domain_crypto_value = "<?php echo $domain_crypto; ?>";
                if($domain_crypto_value == "Yes"){
                    jQuery('#domain_crypto').prop('checked', true);

                }else{
                    jQuery('#domain_crypto').prop('checked', false);    
                }
                
            });
            

            // jQuery('#link_language option[value="<?php echo $link_language; ?>"]').attr('selected','selected')
        </script>
        <?php
}

