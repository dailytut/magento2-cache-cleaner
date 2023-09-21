# Magento 2 Cache Cleaner

This Magento 2 module provides an easy way to clear both Magento and Varnish caches directly from the admin panel.

## Features

- Clears Magento frontend and backend cache.
- Purges Varnish cache.
- Integrated directly into the Cache Management section for easy access.

## Installation

### Using Composer (Recommended)

1. Navigate to your Magento root folder:

```bash
cd path_to_the_magento_root_directory
```
2. Install the module via Composer:

```bash
composer require w3cert/magento2-cachecleaner
```
3. Enable the module:

```bash
php bin/magento module:enable W3cert_CacheCleaner
php bin/magento setup:upgrade
php bin/magento cache:flush

```

# Manual Installation

Download from github and place the folder inside app/code/W3cert/CacheCleaner.

Navigate to your Magento root folder:

 ```bash
cd path_to_the_magento_root_directory
 ```

### Enable the module:

```bash
php bin/magento module:enable W3cert_CacheCleaner
php bin/magento setup:upgrade
php bin/magento cache:flush
```

### Usage

- Go to the Magento 2 Admin Panel.
- Navigate to System > Cache Management.
- Find the "Clear Varnish & Magento Cache" option and click it.
- Your Magento and Varnish caches will be cleared.

Support

If you encounter any problems or bugs, please create an issue on GitHub.
Contribution

Feel free to fork and submit a pull request if you wish to contribute to the module's development.