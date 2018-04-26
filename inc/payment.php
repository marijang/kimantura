<?php
/**
 * B4B Payment fix paypal
 *
 * @package kimnaturaV1
 */


/* WooCommerce, please, prihvati HRK kao valutu podržanu od strane PayPala.*/
add_filter( 'woocommerce_paypal_supported_currencies', 'mx_add_hrk_paypal_valid_currency' );    
function mx_add_hrk_paypal_valid_currency( $currencies ) { 
    array_push ( $currencies , 'HRK' );
    return $currencies; 
}

/* WooCommerce, pretty please, konvertiraj iznos iz HRK u EUR */
//add_filter('woocommerce_paypal_args', 'mx_convert_hrk_to_eur_old');
function mx_convert_hrk_to_eur_old($paypal_args){
    if ( $paypal_args['currency_code'] == 'HRK'){
        $convert_rate = 7.5; //set the converting rate
        $paypal_args['currency_code'] = 'EUR'; //change HRK to EUR
        $i = 1;
 
        while (isset($paypal_args['amount_' . $i])) {
            $paypal_args['amount_' . $i] = round( $paypal_args['amount_' . $i] / $convert_rate, 2);
            ++$i;
        }
    if ( $paypal_args['discount_amount_cart'] > 0 ) {
         $paypal_args['discount_amount_cart'] = round( $paypal_args['discount_amount_cart'] / $convert_rate, 2);
        }
         
    if ( $paypal_args['tax_cart'] > 0 ) {
         $paypal_args['tax_cart'] = round( $paypal_args['tax_cart'] / $convert_rate, 2);
        }
         
        if ( $paypal_args['shipping_1'] > 0 ) {
         $paypal_args['shipping_1'] = round( $paypal_args['shipping_1'] / $convert_rate, 2);
        }
 
    }
return $paypal_args; 
}

function get_currency() {
    $eur_rate = get_transient( 'eur_rate' );
    if ( empty( $eur_rate ) ){
            $response = wp_remote_get( 'http://hnbex.eu/api/v1/rates/daily');
            if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
                    $eur_rate = '7.5';
            try {
                    $result = wp_remote_retrieve_body( $response );
                    $currency_list = json_decode( $result, true);
                    foreach ($currency_list as $item) {
                            if ($item['currency_code'] === 'EUR') {
                                    $eur_rate = $item['median_rate'];
                            }
                    }
                    set_transient( 'eur_rate', $eur_rate, 6 * HOUR_IN_SECONDS );
            } catch ( Exception $ex ) {
                    error_log( 'HNBEX API REQUEST ERROR : ' . $ex->getMessage() );
                    $eur_rate = '7.5';
            }
    }
    return $eur_rate;
}

/* WooCommerce, pretty please, konvertiraj iznos iz HRK u EUR baziran na tecaju */
add_filter('woocommerce_paypal_args', 'mx_convert_hrk_to_eur'); 
function mx_convert_hrk_to_eur($paypal_args){
    if ( $paypal_args['currency_code'] == 'HRK'){ 
    $convert_rate = get_currency();
    $paypal_args['currency_code'] = 'EUR';
            $i = 1;

    while (isset($paypal_args['amount_' . $i])) { 
        $paypal_args['amount_' . $i] = round( $paypal_args['amount_' . $i] / $convert_rate, 2);
        ++$i; 
    } 

            if ( $paypal_args['discount_amount_cart'] > 0 ) {
                    $paypal_args['discount_amount_cart'] = round( $paypal_args['discount_amount_cart'] / $convert_rate, 2);
              } 
             
            if ( $paypal_args['tax_cart'] > 0 ) {
                  $paypal_args['tax_cart'] = round( $paypal_args['tax_cart'] / $convert_rate, 2);
              }
            if ( $paypal_args['shipping_1'] > 0 ) {
                  $paypal_args['shipping_1'] = round( $paypal_args['shipping_1'] / $convert_rate, 2);
      }
            }

return $paypal_args; 
}

