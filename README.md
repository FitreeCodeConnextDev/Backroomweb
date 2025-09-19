# Backroom12

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Backroom12

Backroom12 is a comprehensive web application built with Laravel that provides a robust backend management system. This application is designed to streamline business operations through efficient management of vendors, products, promotions, and user authentication systems.

## Key Features

### 🏪 **Vendor Management**
- Complete vendor profile management
- Vendor registration and verification
- Performance tracking and analytics
- Vendor communication tools

### 📦 **Product Management**
- Product catalog management
- Inventory tracking
- Product categorization
- Bulk product operations
- CSV import/export functionality

### 🎯 **Promotion & Coupon Management**
- Create and manage discount coupons
- Promotional campaign management
- Usage tracking and analytics
- Flexible discount rules

### 🔐 **User Authentication & Authorization**
- Secure login/logout system
- Role-based access control
- Permission management
- User profile management

### 📊 **Additional Features**
- Dashboard with analytics
- Data export capabilities (CSV)
- Responsive design
- RESTful API endpoints

## Technology Stack

- **Framework**: Laravel (PHP)
- **Frontend**: Blade Templates, JavaScript, CSS
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Auth
- **Package Manager**: Composer, NPM

## Prerequisites

Before you begin, ensure you have the following installed:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL or PostgreSQL
- Git

## Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/FitreeCodeConnextDev/Backroomweb.git
cd Backroomweb
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Or Install bun.js dependencies
bun install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=pgsql 
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```



### 5. Build Assets
```bash
# Compile assets
npm run dev

# Compile assets with bun.js
bun run dev

# For production
npm run build

# or bun run build
bun run build
```

### 6. Start the Application
```bash
# Start the development server 
php artisan serve
```

The application will be available at `http://localhost:8000`

## Usage

### Accessing the Application
1. Navigate to `http://localhost:8000`
2. Register a new account or login with existing credentials
3. Access the dashboard to manage vendors, products, and promotions

### Key Endpoints
- `/dashboard` - Main dashboard
- `/vendors` - Vendor management
- `/products` - Product management
- `/coupons` - Coupon management
- `/users` - User management

## Development

### Running Tests
```bash
# Run PHPUnit tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

### Code Style
```bash
# Format code using Laravel Pint
./vendor/bin/pint
```

### Database Operations
```bash
# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName

# Create controller
php artisan make:controller ControllerName
```

## API Documentation

The application provides RESTful API endpoints for integration:

- `GET /api/vendors` - List all vendors
- `POST /api/vendors` - Create new vendor
- `GET /api/products` - List all products
- `POST /api/products` - Create new product
- `GET /api/coupons` - List all coupons

## Contributing

We welcome contributions to Backroom12! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Contribution Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation as needed
- Ensure all tests pass before submitting

## Security

If you discover any security vulnerabilities, please send an email to the development team. All security vulnerabilities will be promptly addressed.

### Security Features
- CSRF protection
- SQL injection prevention
- XSS protection
- Secure authentication
- Input validation and sanitization

## Troubleshooting

### Common Issues

**Issue**: Database connection error
**Solution**: Check your `.env` database credentials and ensure your database server is running

**Issue**: Permission denied errors
**Solution**: Set proper file permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

**Issue**: Assets not loading
**Solution**: Run asset compilation:
```bash
npm run dev
```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:
- Create an issue on GitHub
- Check the [Laravel Documentation](https://laravel.com/docs)
- Visit [Laravel Community](https://laravel.com/community)

## Acknowledgments

- Built with [Laravel Framework](https://laravel.com)
- Thanks to all contributors
- Special thanks to the Laravel community

---

**Backroom12** - Streamlining business operations with powerful backend management tools.
