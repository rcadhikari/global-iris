# global-iris
Integration of Global IRIS (HSBC) payment in PHP



Friday, March 6, 2015
Integration of Global IRIS (HSBC) payment

Integration the Global IRIS (HSBC) payment system into your website can be kinda daunting, however following below steps may make your life easier.

In fact, I have recently went through the process and thought would be helpful if you looking to work on it as well.

1. First of ally, please ask to Global IRIS (GI) technical team to configure the Sandbox account and live account into their system with below detail. You can contact them via direct number +44 845 702 3344 (Option 6)* or email;

Developer documention can be found here, pdf here.., I have found the documentation is bit outdated, but please contact & confirm with them if necessary.

In fact, you have to ask them to provide below details (including login info) for both environment (sandbox and live) :

| Modes  | Live/Production | Test(sandbox) |
| :------------ |:---------------| :-----|
| Action URL	| https://hpp.globaliris.com/pay | https://hpp.sandbox.globaliris.com/pay |
| Merchant ID:  | -			|	-	|
| Secret hash string: | -	|	-	|
| Account:    | internet	|	internet	|
| Below is the login detail to for HSBC reporting system |
| Reportin URL: | https://reporting.globaliris.com/login | 	https://reporting.sandbox.globaliris.com/login	|
| Username: 	| -			|	-	|
| Password: 	| -			|	-	|


Then, use create the request form page, response page and confirmation page.

<br />
NOTE: It is require to <b>pass </b>the RESPONSE PAGE URL to GI team by contacting them when you are deploying the payment function. The response url is the page which will display after clicking "Pay Now".<br />
<br />
So, please setup a reponse page or url on your server for reponse page,<br />
for eg. create a page 'http://www.your_domain.com/hsbc_reponse.php' ( https://github.com/rcadhikari/global-iris/blob/master/reponse.php) <br />
or ''http://www.your_domain.com/payment/reponse'.<br />
<br />
On then that reponse page or url, add the below content;<br />
<br />

Once you create the above response page or response url and ask to update at their end for above repose page or url.<br />
<br />
After completing the above steps succfully, then, when someone go through the payment, then payment response from GI will return to your above reponse page or url which will automatically redirected back to your provided return url through the auto form submission script.<br />
<br />
Finally, above redirection will go to your provided return_url with payment responses on $_POST variables, which can be used to verify the payment and update your database/system accordingly.<br />
<br />
In fact, I have added the above response page to auto redirect to any provided URL which indeed can be control by passing url on MERCHANT_RESPONSE_URL parameter (do not include http://www.your_domain.com) while submitting the payment request form. If you don't need that, you can skip that step.<br />
<br />
The below function will verify the confirm the payment by processing the payment response data.<br />
