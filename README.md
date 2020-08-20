# Online-Shop
Implements an online shop using PHP and maintaining a framework layout.

In order to configure settings for the application, you must create a ".env"
file after the sample below:

```
# Application Name
APP_NAME="Online Shop"

# Turn on for development, off for production
APP_DEBUG=true

# Cache Twig views. Leave false for development, true for production
CACHE_VIEWS=false

# Database configuration values
DB_TYPE=mysql
DB_DRIVER=pdo_mysql
DB_HOST=127.0.0.1
DB_DATABASE=auth
DB_USERNAME=user
DB_PASSWORD=passwd
DB_PORT=port
```

Make sure to delete empty .gitkeep file in cache folder before using!
