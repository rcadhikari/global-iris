# global-iris
Integration of Global IRIS (HSBC) payment in PHP



Friday, March 6, 2015
Integration of Global IRIS (HSBC) payment

Integration the Global IRIS (HSBC) payment system into your website can be kinda daunting, however following below steps may make your life easier.

In fact, I have recently went through the process and thought would be helpful if you looking to work on it as well.

1. First of ally, please ask to Global IRIS (GI) technical team to configure the Sandbox account and live account into their system with below detail. You can contact them via direct number +44 845 702 3344 (Option 6)* or email;

Developer documention can be found here, pdf here.., I have found the documentation is bit outdated, but please contact & confirm with them if necessary.

In fact, you have to ask them to provide below details (including login info) for both environment (sandbox and live) :

For Live Mode
--------------
Action URL:     https://hpp.globaliris.com/pay
Merchant ID:    -
Secret hash string: -
Account:    internet
Below is the login detail to for HSBC reporting system
Reportin URL: 	https://reporting.globaliris.com/login
Username: 	-
Password: 	-

For Test Mode
--------------
Action URL:     https://hpp.sandbox.globaliris.com/pay
Merchant ID:    -
Secret hash string: -
Account:    internet
Below is the login detail to for HSBC reporting system
Reportin URL: 	https://reporting.sandbox.globaliris.com/login
Username: 	-
Password: 	-

Then, use create the request form page, response page and confirmation page.