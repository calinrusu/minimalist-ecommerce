# Small Ecommerce NoSQL PHP Site

Simple ecommerce website built with core PHP and procedural code with non-SQL database support.

## Requirements

- PHP 8.0+
- Apache or Nginx
- Document root pointed to /public

## Pages
- home - displays the products (catalog)
- product.php - displays product details and add to cart
- cart.php - displays the items in the shopping cart
- account.php - client account - login and register

## Notes

- Shared setup is loaded through app/bootstrap.php
- Only the public folder should be exposed by the web server
- Data is stored in json files in a data directory
