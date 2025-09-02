# 🎨 Dot-Poster E-commerce Platform

A modern, full-featured e-commerce platform built with Laravel 12 for selling posters and artwork online.

## ✨ Features

### 🛍️ **Customer Features**
- **Product Catalog** - Browse posters with high-quality image galleries and thumbnails
- **Advanced Search** - Search by name, category, price range with sorting options
- **Shopping Cart** - Add/remove items, quantity management with real-time updates
- **Secure Checkout** - Stripe payment integration + cash on delivery options
- **Order Tracking** - View order history and real-time status updates
- **Product Reviews** - Interactive star ratings and detailed review system
- **User Profiles** - Manage personal information, addresses, and avatar uploads
- **Email Notifications** - Automated order confirmations and status update emails

### 🔧 **Admin Features**
- **Product Management** - Full CRUD with multiple image uploads and gallery management
- **Category Management** - Hierarchical category organization with nested structures
- **Order Management** - Update status, track payments, manage fulfillment with email notifications
- **User Management** - Ban/unban users, view customer data and activity
- **Inventory Tracking** - Stock management with low-stock alerts and warnings
- **Email System** - Automated order confirmations and status update notifications

### 🏪 **Vendor Features**
- **Vendor Dashboard** - Dedicated vendor panel with role-based access
- **Product Management** - Vendors can manage their own product listings
- **Order Fulfillment** - Track and update orders for vendor products
- **Inventory Control** - Manage stock levels and product availability
- **Sales Analytics** - View vendor-specific order and product performance

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
git clone https://github.com/3idey/dot-poster.git
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
- **User** - Customer, admin, and vendor accounts with role-based access
- **Product** - Poster products with multiple images, pricing, stock, vendor assignment
- **ProductImage** - Multiple image support with gallery functionality
- **Category** - Hierarchical product categorization
- **Order/OrderItem** - Complete order management and line items
- **CartItem** - Shopping cart functionality with quantity management
- **Review** - Product reviews and star ratings system
- **Payment** - Stripe and cash payment transaction records

### Key Controllers
- **ProductController** - Public product browsing with advanced search/filter
- **CartController** - Shopping cart management with AJAX updates
- **CheckoutController** - Order processing with Stripe and cash payment options
- **Admin/AdminProductController** - Product CRUD with multiple image uploads
- **Admin/AdminCategoryController** - Category management with hierarchy
- **Admin/AdminOrderController** - Order status management with email notifications
- **Vendor/VendorProductController** - Vendor-specific product management
- **Vendor/VendorOrderController** - Vendor order fulfillment and tracking

### Email System
- **OrderConfirmation** - Automated email sent on order placement
- **OrderStatusUpdate** - Email notifications for status changes (shipped, delivered, etc.)
- **Markdown Templates** - Professional email templates with order details and tracking links

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
3. Upload multiple product images with gallery management
4. Update order statuses (automatically triggers email notifications)
5. Monitor inventory levels with low-stock alerts
6. View comprehensive order and payment analytics

### For Vendors
1. Access vendor dashboard at `/vendor/dashboard`
2. Manage vendor-specific product listings
3. Upload and edit product images
4. Track orders for vendor products
5. Update order fulfillment status
6. Monitor vendor inventory and sales

## 🔧 Configuration

### Email Setup
Configure mail settings in `.env` for production:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_FROM_ADDRESS=orders@yourstore.com
MAIL_FROM_NAME="Your Store Name"
```

### Payment Configuration
Configure Stripe for payment processing:
```env
STRIPE_KEY=pk_live_your_stripe_publishable_key
STRIPE_SECRET=sk_live_your_stripe_secret_key
```

### File Storage
- Product images stored in `storage/app/public/products/`
- Multiple images per product supported via ProductImage model
- Automatic fallback to placeholder.svg for missing images
- Images accessible via `/storage/products/` URL

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
