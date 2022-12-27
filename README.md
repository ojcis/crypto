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
![ezgif com-gif-maker](https://user-images.githubusercontent.com/112757458/209704052-ed69c5b0-c33b-4d94-a051-ac53d3fd35e8.gif)
### Sell, buy:

