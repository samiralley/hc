# Deployment Guide

## Prerequisites
1. PHP >= 7.4
2. MySQL
3. Composer

## Steps
1. Clone the repository:
   ```
   git clone https://github.com/your-repo/saas-product.git
   cd saas-product
   ```
2. Set up the database:
   ```
   php backend/migrate.php
   ```
3. Configure `.env` file with your credentials.

4. Install dependencies:
   ```
   composer install
   ```

5. Serve the application:
   ```
   php -S localhost:8000
   ```

6. Access the application at:
   ```
   http://localhost:8000
   ```
