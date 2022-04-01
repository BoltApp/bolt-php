## Bolt PHP library

Official PHP library to interact with Bolt [APIs](https://docs.bolt.com/reference).

### Requirements

PHP 5.6+

#### API credentials
* The following three required values, (i.e. API Key, Signing Secret, Publishable Key) can be found in your Bolt Merchant Dashboard under Developers > API. The Publishable Key is for the multi-step checkout by default. You can find other publishable keys (Payment Only) in the division dropdown at the top-right corner.
* For production, these will be found at: https://merchant.bolt.com
* For sandbox mode, use the following URL: https://merchant-sandbox.bolt.com".

#### Bolt Configuration:

Let's say https://your-store-url.com is the base URL of your store. You need go to Developers > API > Merchant API and configure hook URLs in your Bolt Merchant Dashboard

* Universal API: https://your-store-url.com/example/universalapi.php (If universal API feature is enabled) 
* Shipping: https://your-store-url.com/example/shipping.php (if the split shipping and tax feature is enabled)
* Tax: https://your-store-url.com/example/tax.php (if the split shipping and tax feature is enabled) 
* Shipping And Tax: https://your-store-url.com/example/shipping_and_tax.php (if the split shipping and tax feature is disabled) 
* Create Order: https://your-store-url.com/example/preauth_create_order.php (if the pre-auth order creation feature is enabled)
* WebHook: https://your-store-url.com/example/apihook.php 


#### Plugin configuration: 
Go to file example/config.php and configure value for essential settings below
* API_KEY: This is used for calling Bolt API from your back-end server
* IS_SANDBOX: This is used for setting up testing vs. production execution environment
* SIGNING_SECRET: This is used for signature verification in checking the authenticity of webhook requests
* PUBLISHABLE_KEY: This is used to open the Bolt Payment Popup typically on cart (multi step) page (example/cart.php)
* PUBLISHABLE_KEY_PAYMENT_ONLY: This is used to open the Bolt Payment Popup typically on cart payment only page (example/cart_paymentonly.php)

##### Demo: 
Let's say https://your-store-url.com is the base URL of your store
* Go to https://your-store-url.com/example/cart.php to see Bolt Multi-Step Checkout works in the cart page
* Go to https://your-store-url.com/example/cart_paymentonly.php to see Bolt Payment Only Checkout works the cart payment only page
* Go to https://your-store-url.com/example/product_page_checkout.php.php to see Bolt works in product page

