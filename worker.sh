#!/bin/bash

# Navigate to your Laravel project directory
cd /home/jnmxriqr/public_html/portfolio/

# Run the Laravel scheduler
/usr/local/bin/ea-php81 artisan schedule:work
