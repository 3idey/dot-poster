# Dot-Poster E-commerce Platform

A modern, full-featured e-commerce platform built with Laravel 12 for selling posters and artwork online. Features a beautiful, responsive design with professional UI/UX and comprehensive e-commerce functionality.

## ✨ Features

### **Customer Features**
- **Product Catalog** - Browse posters with high-quality image galleries and interactive thumbnails
- **Advanced Search & Filtering** - Search by name, category, price range with dynamic sorting options
- **Smart Shopping Cart** - Modern cart interface with quantity management and real-time updates
- **Wishlist System** - Save favorite products with visual indicators and easy management
- **Secure Checkout** - Professional Stripe payment integration + cash on delivery options
- **Saved Payment Methods** - Secure payment method storage for faster checkout
- **Order Tracking** - Comprehensive order history with real-time status updates
- **Product Reviews** - Interactive 5-star rating system with detailed review functionality
- **User Profiles** - Complete profile management with avatar uploads and personal information
- **Email Notifications** - Automated order confirmations and status update emails
- **Google Sign-In** - OAuth authentication with Google accounts for seamless login
- **Newsletter Subscription** - Stay updated with new arrivals and exclusive offers

### **Admin Features**
- **Product Management** - Full CRUD with multiple image uploads and gallery management
- **Category Management** - Hierarchical category organization with nested structures
- **Order Management** - Update status, track payments, manage fulfillment with email notifications
- **User Management** - Ban/unban users, view customer data and activity
- **Inventory Tracking** - Stock management with low-stock alerts and warnings
- **Email System** - Automated order confirmations and status update notifications

### **Vendor Features**
- **Vendor Dashboard** - Dedicated vendor panel with role-based access
- **Product Management** - Vendors can manage their own product listings
- **Order Fulfillment** - Track and update orders for vendor products
- **Inventory Control** - Manage stock levels and product availability
- **Sales Analytics** - View vendor-specific order and product performance

### **UI/UX & Design**
- **Modern Interface** - Clean, professional design with consistent color scheme
- **Responsive Layout** - Mobile-first design that works perfectly on all devices
- **Interactive Elements** - Smooth animations, hover effects, and visual feedback
- **Accessibility** - Proper contrast ratios and keyboard navigation support
- **Professional Navigation** - Intuitive sidebar with active state indicators and badge counters
- **Visual Consistency** - Unified design system across all pages and components

### **Security & Performance**
- Role-based access control (Customer/Admin/Vendor)
- Rate limiting on authentication
- Secure file uploads with validation
- CSRF protection on all forms
- Input sanitization and validation
- OAuth integration with Google Sign-In
- Secure payment method storage with Stripe

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MariaDB/MySQL
- Stripe account (for payments)
- Google OAuth credentials (for Google Sign-In)

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


4. **Setup Database**
```bash
php artisan migrate
php artisan db:seed
```

5. **Start Development Server**
```bash
composer run dev
```
This runs the Laravel server, queue worker, logs, and Vite concurrently.

## Project Structure

### Models
- **User** - Customer, admin, and vendor accounts with role-based access and Google OAuth support
- **Product** - Poster products with multiple images, pricing, stock, vendor assignment
- **ProductImage** - Multiple image support with gallery functionality and lazy loading
- **Category** - Hierarchical product categorization with nested structures
- **Order/OrderItem** - Complete order management and line items with status tracking
- **CartItem** - Shopping cart functionality with quantity management and real-time updates
- **Wishlist** - User wishlist system for saving favorite products
- **Review** - Product reviews and interactive star ratings system
- **Payment** - Stripe and cash payment transaction records with secure storage
- **SavedPaymentMethod** - Secure storage of customer payment methods for faster checkout
- **Newsletter** - Email subscription management for marketing campaigns

### Key Controllers
- **ProductController** - Public product browsing with advanced search/filter and image galleries
- **CartController** - Modern shopping cart management with AJAX updates and quantity controls
- **WishlistController** - Wishlist functionality with add/remove and visual indicators
- **CheckoutController** - Professional checkout flow with Stripe and cash payment options
- **SavedPaymentMethodController** - Secure payment method management for faster checkout
- **GoogleSigninController** - Google OAuth authentication and user management
- **ProfileController** - Comprehensive user profile management with OAuth support
- **Admin/AdminProductController** - Product CRUD with multiple image uploads and gallery management
- **Admin/AdminCategoryController** - Category management with hierarchical organization
- **Admin/AdminOrderController** - Order status management with automated email notifications
- **Vendor/VendorProductController** - Vendor-specific product management with image handling
- **Vendor/VendorOrderController** - Vendor order fulfillment and tracking system

### Email System
- **OrderConfirmation** - Automated email sent on order placement
- **OrderStatusUpdate** - Email notifications for status changes (shipped, delivered, etc.)
- **Markdown Templates** - Professional email templates with order details and tracking links

## Usage

### For Customers
1. Browse products at `/products` with advanced filtering and search
2. Register/login with email or Google Sign-In for seamless access
3. Add items to cart and wishlist for later purchase
4. Save payment methods for faster future checkouts
5. Complete secure checkout with Stripe or cash on delivery
6. Track order status and history in your profile
7. Leave detailed reviews and star ratings on purchased items
8. Subscribe to newsletter for exclusive offers and updates

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

## Configuration

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

### Google OAuth Setup
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `http://your-domain.com/auth/google/callback`
6. Configure in `.env`:
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
```

### File Storage & Assets
- Product images stored in `storage/app/public/products/` with proper permissions
- Multiple images per product supported via ProductImage model with gallery functionality
- Automatic fallback to placeholder.svg for missing images
- Images accessible via `/storage/products/` URL with lazy loading
- Frontend assets compiled with Vite for optimal performance
- Responsive image handling with proper optimization

## Development

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

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
