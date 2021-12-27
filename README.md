# MikkoTask
The small command-line utility to help a fictional
company determine the dates they need to pay salaries to their sales
department.

## Requirements
- PHP 7.3 or higher
- Composer installed

## Installation
1. Clone this repo
2. Run `$ composer update`

## How to use
1. Open project root
2. Run `$ php app/console.php app:payment-report <filename>`

   replace `<filename>` with a filename of your report.

## Frameworks & Libraries
- [Symfony/Console] https://symfony.com/doc/current/components/console.html
- [Symfony/Filesystem] https://symfony.com/doc/current/components/filesystem.html