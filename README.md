# global-iris
Integration of Global IRIS (HSBC) payment in PHP



Friday, March 6, 2015
Integration of Global IRIS (HSBC) payment

Integration the Global IRIS (HSBC) payment system into your website can be kinda daunting, however following below steps may make your life easier.

In fact, I have recently went through the process and thought would be helpful if you looking to work on it as well.

* First of all, please ask to Global IRIS (GI) technical team to configure the Sandbox account and live account into their system with below detail. You can contact them via direct number *+44 845 702 3344 (Option 6)** or [email](mailto:globaliris@realexpayments.com);

Developer documention can be found here, pdf here.., I have found the documentation is bit outdated, but please contact & confirm with them if necessary.

In fact, you have to ask them to provide below details (including login info) for both environment (sandbox and live):

| Modes  | Live/Production | Test(sandbox) |
| :------------ |:---------------| :-----|
| Action URL	| https://hpp.globaliris.com/pay | https://hpp.sandbox.globaliris.com/pay |
| Merchant ID:  | -			|	-	|
| Secret hash string: | -	|	-	|
| Account:    | internet	|	internet	|
| | *Below is the login detail to for HSBC reporting system* | |
| Reporting URL: | https://reporting.globaliris.com/login | 	https://reporting.sandbox.globaliris.com/login	|
| Username: 	| -			|	-	|
| Password: 	| -			|	-	|

Please ask all the **-** bits to GI Team.

Next steps would be to create the request form page, response page and confirmation page.

* So, create request form to connect to Global IRIS payment system, sample code can be found [here](https://github.com/rcadhikari/global-iris/blob/master/request.php)

* Next, please create a response page somewhere on your project folder, I would suggest to create on root folder, e.g. create a page 'http://www.your_domain.com/hsbc_reponse.php' OR ''http://www.your_domain.com/payment/reponse'.
Response page sample code can be found [here](https://github.com/rcadhikari/global-iris/blob/master/reponse.php)

NOTE: It is require to <b>pass </b>the RESPONSE PAGE URL to GI team by contacting them when you are deploying the payment function. The response url is the page which will display after clicking "Pay Now".<br />

* After clicking "Pay Now", the GI will access the RESPONSE PAGE URL and display on the page ( in fact, the visible URL would be their URL), which means GI indirectly access our response page and display it from their end. 

In my case, I have written the resonse function which retain their payment reponses and auto post to your provided return url through the auto form submission script.

* At last, you can access GI payment responses on `$_POST` variables from the provided `return_url`, where you can verify the payment and update your database/system accordingly.

In fact, the return_url can be passed via request from with `MERCHANT_RESPONSE_URL` parameter ( but do not include http://www.your_domain.com) while submitting the payment request form. 

Please refer [here](https://github.com/rcadhikari/global-iris/blob/master/confirmation.php) to find a sample code to verify and confirm the payment.
