# 🎨 Dot-Poster E-commerce Platform

A modern, full-featured e-commerce platform built with Laravel 12 for selling posters and artwork online.

## ✨ Features

### 🛍️ **Customer Features**
- **Product Catalog** - Browse posters with high-quality images
- **Advanced Search** - Search by name, category, price range with sorting options
- **Shopping Cart** - Add/remove items, quantity management
- **Secure Checkout** - Stripe payment integration + cash on delivery
- **Order Tracking** - View order history and status updates
- **Product Reviews** - Rate and review purchased items
- **User Profiles** - Manage personal information and addresses

### 🔧 **Admin Features**
- **Product Management** - Full CRUD with image uploads
- **Category Management** - Hierarchical category organization
- **Order Management** - Update status, track payments, manage fulfillment
- **User Management** - Ban/unban users, view customer data
- **Inventory Tracking** - Stock management with low-stock alerts
- **Email Notifications** - Automated order confirmations and status updates

### 🛡️ **Security & Performance**
- Role-based access control (Customer/Admin)
- Rate limiting on authentication
- Secure file uploads with validation
- CSRF protection on all forms
- Input sanitization and validation

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MariaDB/MySQL
- Stripe account (for payments)

### Installation

1. **Clone & Install Dependencies**
```bash
git clone <repository-url>
cd dot-poster
composer install
npm install
```

2. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure Database**
Update `.env` with your database credentials:
```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dot_poster
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Configure Stripe** (Optional)
Add your Stripe keys to `.env`:
```env
STRIPE_KEY=pk_test_your_stripe_publishable_key
STRIPE_SECRET=sk_test_your_stripe_secret_key
```

5. **Setup Database**
```bash
php artisan migrate
php artisan db:seed
```

6. **Start Development Server**
```bash
composer run dev
```
This runs the Laravel server, queue worker, logs, and Vite concurrently.

## 📁 Project Structure

### Models
- **User** - Customer and admin accounts with roles
- **Product** - Poster products with images, pricing, stock
- **Category** - Hierarchical product categorization
- **Order/OrderItem** - Order management and line items
- **CartItem** - Shopping cart functionality
- **Review** - Product reviews and ratings
- **Payment** - Payment transaction records

### Key Controllers
- **ProductController** - Public product browsing with search/filter
- **CartController** - Shopping cart management
- **CheckoutController** - Order processing and payment
- **Admin/AdminProductController** - Product CRUD with image uploads
- **Admin/AdminCategoryController** - Category management
- **Admin/AdminOrderController** - Order status management

## 🎯 Usage

### For Customers
1. Browse products at `/products`
2. Add items to cart
3. Checkout with Stripe or cash payment
4. Track orders in profile
5. Leave reviews on purchased items

### For Admins
1. Access admin panel at `/admin/dashboard`
2. Manage products, categories, orders, and users
3. Upload product images
4. Update order statuses (triggers email notifications)
5. Monitor inventory levels

## 🔧 Configuration

### Email Setup
Configure mail settings in `.env` for production:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

### File Storage
Product images are stored in `storage/app/public/products/` and accessible via `/storage/products/` URL.

## 🛠️ Development

### Running Tests
```bash
composer run test
```

### Code Style
```bash
./vendor/bin/pint
```

### Queue Workers
For production, run queue workers:
```bash
php artisan queue:work
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
