# Deployment

Target stack:

- PHP 8.3 with common Laravel extensions
- Composer
- Node.js and npm
- Nginx
- PHP-FPM
- MySQL database at `230edadc0da0aea808aa603a.twc1.net:3306`

Do not store SSH or MySQL passwords in the repository. Put the MySQL password only into the server-side `.env` file.

## Server commands

```bash
apt update
apt install -y nginx unzip curl git software-properties-common ca-certificates lsb-release
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.3-fpm php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-bcmath php8.3-intl
```

Install Composer:

```bash
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

Install Node.js/npm using the current LTS package source for your server distribution, then place the project:

```bash
mkdir -p /var/www/powerbank-rental
cd /var/www/powerbank-rental
composer install --no-dev --optimize-autoloader
npm install
npm run build
cp .env.example .env
php artisan key:generate
```

Edit `.env` on the server:

```env
APP_NAME=PowerbankRental
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain-or-ip

DB_CONNECTION=mysql
DB_HOST=230edadc0da0aea808aa603a.twc1.net
DB_PORT=3306
DB_DATABASE=default_db
DB_USERNAME=gen_user
DB_PASSWORD=
DB_SSL=true
DB_SSL_VERIFY=false
MYSQL_ATTR_SSL_CA=/var/www/powerbank-rental/deploy/certs/timeweb-ca.crt
```

Then run:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

Configure Nginx:

```bash
cp deploy/nginx/powerbank-rental.conf /etc/nginx/sites-available/powerbank-rental
ln -sfn /etc/nginx/sites-available/powerbank-rental /etc/nginx/sites-enabled/powerbank-rental
nginx -t
systemctl reload nginx
systemctl restart php8.3-fpm
```

Initial administrator:

- email: `admin@example.com`
- password: `password`

Change this password immediately after deployment.
