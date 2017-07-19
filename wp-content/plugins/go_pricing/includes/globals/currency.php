<?php
/**
 * Register Globals - Currency
 */


// Prevent direct call
if ( !defined( 'WPINC' ) ) die;
if ( !class_exists( 'GW_GoPricing' ) ) die;	


/**
 * Currency globals
 */	
 
$go_pricing['currency'] = array ( 
	array(
		'name' => 'United Arab Emirates Dirham',
		'id' => 'AED',
		'symbol' => 'د.إ'
	),
	array(
		'name' => 'Australian Dollars',
		'id' => 'AUD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Bangladeshi Taka',
		'id' => 'BDT',
		'symbol' => '&#2547;&nbsp;'
	),
	array(
		'name' => 'Brazilian Real',
		'id' => 'BRL',
		'symbol' => '&#82;&#36;'
	),
	array(
		'name' => 'Bulgarian Lev',
		'id' => 'BGN',
		'symbol' => '&#1083;&#1074;.'
	),
	array(
		'name' => 'Canadian Dollars',
		'id' => 'CAD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Chilean Peso',
		'id' => 'CLP',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Chinese Yuan',
		'id' => 'CNY',
		'symbol' => '&yen;'
	),
	array(
		'name' => 'Colombian Peso',
		'id' => 'COP',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Czech Koruna',
		'id' => 'CZK',
		'symbol' => '&#75;&#269;'
	),
	array(
		'name' => 'Danish Krone',
		'id' => 'DKK',
		'symbol' => 'kr.'
	),
	array(
		'name' => 'Dominican Peso',
		'id' => 'DOP',
		'symbol' => 'RD&#36;'
	),
	array(
		'name' => 'Euros',
		'id' => 'EUR',
		'symbol' => '&euro;'
	),
	array(
		'name' => 'Hong Kong Dollar',
		'id' => 'HKD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Croatia kuna',
		'id' => 'HRK',
		'symbol' => 'Kn'
	),
	array(
		'name' => 'Hungarian Forint',
		'id' => 'HUF',
		'symbol' => '&#70;&#116;'
	),
	array(
		'name' => 'Icelandic krona',
		'id' => 'ISK',
		'symbol' => 'Kr.'
	),
	array(
		'name' => 'Indonesia Rupiah',
		'id' => 'IDR',
		'symbol' => 'Rp'
	),
	array(
		'name' => 'Indian Rupee',
		'id' => 'INR',
		'symbol' => 'Rs.'
	),
	array(
		'name' => 'Nepali Rupee',
		'id' => 'NPR',
		'symbol' => 'Rs.'
	),
	array(
		'name' => 'Israeli Shekel',
		'id' => 'ILS',
		'symbol' => '&#8362;'
	),
	array(
		'name' => 'Japanese Yen',
		'id' => 'JPY',
		'symbol' => '&yen;'
	),
	array(
		'name' => 'Lao Kip',
		'id' => 'KIP',
		'symbol' => '&#8365;'
	),
	array(
		'name' => 'South Korean Won',
		'id' => 'KRW',
		'symbol' => '&#8361;'
	),
	array(
		'name' => 'Malaysian Ringgits',
		'id' => 'MYR',
		'symbol' => '&#82;&#77;'
	),
	array(
		'name' => 'Mexican Peso',
		'id' => 'MXN',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Nigerian Naira',
		'id' => 'NGN',
		'symbol' => '&#8358;'
	),
	array(
		'name' => 'Norwegian Krone',
		'id' => 'NOK',
		'symbol' => '&#107;&#114;'
	),
	array(
		'name' => 'New Zealand Dollar',
		'id' => 'NZD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Paraguayan Guaraní',
		'id' => 'PYG',
		'symbol' => '(&#8370;)'
	),
	array(
		'name' => 'Philippine Pesos',
		'id' => 'PHP',
		'symbol' => '&#8369;'
	),
	array(
		'name' => 'Polish Zloty',
		'id' => 'PLN',
		'symbol' => '&#122;&#322;'
	),
	array(
		'name' => 'Pounds Sterling',
		'id' => 'GBP',
		'symbol' => '&pound;'
	),
	array(
		'name' => 'Romanian Leu',
		'id' => 'RON',
		'symbol' => 'lei'
	),
	array(
		'name' => 'Russian Ruble',
		'id' => 'RUB',
		'symbol' => '&#x20bd;'
	),
	array(
		'name' => 'Signapore Dollar',
		'id' => 'SGD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'South African rand',
		'id' => 'ZAR',
		'symbol' => '&#82;'
	),
	array(
		'name' => 'Swedish Krona',
		'id' => 'SEK',
		'symbol' => '&#107;&#114;'
	),
	array(
		'name' => 'Swiss Franc',
		'id' => 'CHF',
		'symbol' => '&#67;&#72;&#70;'
	),
	array(
		'name' => 'Taiwan New Dollars',
		'id' => 'TWD',
		'symbol' => '&#78;&#84;&#36;'
	),
	array(
		'name' => 'Thai Baht',
		'id' => 'THB',
		'symbol' => '&#3647;'
	),
	array(
		'name' => 'Turkish Lira',
		'id' => 'TRY',
		'symbol' => '&#8378;'
	),
	array(
		'name' => 'Ukrainian Hryvnia',
		'id' => 'UAH',
		'symbol' => '&#8372;'
	),
	array(
		'name' => 'US Dollars',
		'id' => 'USD',
		'symbol' => '&#36;'
	),
	array(
		'name' => 'Vietnamese Dong',
		'id' => 'VND',
		'symbol' => '&#8363;'
	),
	array(
		'name' => 'Egyptian Pound',
		'id' => 'EGP',
		'symbol' => 'EGP'
	),
	array(
		'name' => 'Saudi Riyal',
		'id' => 'SAR',
		'symbol' => 'ريال'
	)	
);

// Global currency filter
$go_pricing['currency'] =  apply_filters( 'go_pricing_currency', $go_pricing['currency'] );


?>