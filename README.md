# crypto
## In this Crypto website you can:

* Find your favorite crypto.
* Buy and Sell crypto.
* Open and Close Short positions on your crypto.
* Check your transaction history

## Technologies used:
<ol>
<li>PHP 7.4</li>
<li>MySQL 8.0.31</li>
</ol>

## Instructions to run the website:

* Clone this repository using the command:<br>
  <code> git clone https://github.com/ojcis/crypto.git </code>
* Install the required packages using the command:<br>
  <code>composer install</code>
* Make a copy of the <code>.env.example</code> and rename it to <code>.env</code>
* Register at https://coinmarketcap.com/api/ and get your API key.
* Enter your API key in the <code>.env</code> file.
* Create data base 'cryptocurrency'.
* Import the table structure (<code>script.sql</code>) into the project.
  Here are instructions on how to import <code>script.sql</code> into your database https://www.jetbrains.com/help/phpstorm/import-data.html
* Enter your database credentials in the <code>.env</code> file.
* You need to run the website from <code>crypto/public</code> folder by typing in terminal:<br>
  <code>cd public/</code><br><code>php -S localhost:8000</code>

### Home page, login, register::
![home-login-register](https://user-images.githubusercontent.com/112757458/209707392-eea49db1-fd8a-41e3-b2db-9226b314e991.gif)
### Select, Search:
![select-search](https://user-images.githubusercontent.com/112757458/209707445-9b16cae5-4796-4e48-b268-a8e3e2eccfca.gif)
### Buy, sell:
![buy-sell](https://user-images.githubusercontent.com/112757458/209707583-f4a3e67c-49c8-45ea-bb4f-06e2a53557c5.gif)
### Open, close short position:
![open-close-short](https://user-images.githubusercontent.com/112757458/209707794-22027e39-7ddf-4565-8755-f750997555a2.gif)
### profile:
![profile](https://user-images.githubusercontent.com/112757458/209707845-31f0a2a8-7512-49b4-bcc7-51405e077a50.gif)


