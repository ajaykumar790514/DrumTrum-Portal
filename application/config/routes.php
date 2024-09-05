<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'login/logout';

$route['header-products/(:any)'] 	= 'home/header_products';

//for second level categories
$route['categories/(:any)'] 	= 'home/categories/$1';

// $route['products'] 	= 'home/products';
$route['productsProps/(:any)'] 	= 'home/productsPropsValue/$1';
$route['products/(:any)'] 	= 'home/products';
$route['products/(:any)/(:any)'] 	= 'home/products';
$route['product-detail/(:any)/(:any)/(:any)'] = 'home/products/product_detail';
$route['product/(:any)'] = 'home/products/product_detail';
$route['category/(:any)'] 	= 'home/products';
//cart
$route['cart']='home/cart';

$route['checkout'] = 'checkout/checkout_items';
$route['worldpayresponse'] = 'checkout/worldpay_response';

$route['about-us'] = 'home/about_us';
$route['privacy-policy'] = 'home/privacy_policy';
$route['shipping-delivery'] = 'home/shipping_delivery';
$route['terms'] = 'home/terms';
$route['returns-refunds'] = 'home/returns_refunds';
$route['faq'] = 'home/faq';
$route['contact-us'] = 'home/contact_us';
$route['thanks'] = 'home/thanks';
$route['error'] = 'home/error';

//My Account routes
$route['profile'] = 'user/users';
$route['profile/address'] = 'user/address';
$route['order-details/(:any)'] = 'user/users/order_details';
$route['bill-invoice/(:any)'] = 'user/users/bill_invoice/$1';
$route['register'] = 'login/register';
$route['forget-password'] = 'login/forget_password';
$route['wishlist'] = 'home/wishlist';
$route['bill-invoice-open/(:any)'] = 'home/printInvoice/$1';
$route['home/wishlish_cousnt'] = 'home/wishlist';

$route['submit-feedback-form'] = 'home/submit_feedback_form';

$route['reset-password/(:any)'] = 'login/reset_password/$1';

// $route['thanksworldpay']='checkout/thanksworldpay';
