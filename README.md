# hot_news
PHP app for handy news rendering

Apache2 Config:

```bash
<VirtualHost *:80>
        ServerAdmin admin@hot_news
        ServerName hot_news
        ServerAlias www.hot_news
        DocumentRoot /var/www/hot_news/Public

        <Directory /var/www/hot_news/Public>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
