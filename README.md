<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Payment Processing

A payment processing system built with Laravel.

## Features

- Payment registration
- Payment confirmation
- Payment failure handling
- Secure session handling
- Modern UI with responsive design

## API Endpoints

### Payment Registration

- **Endpoint**: `/payment/rest/register.do`
- **Method**: GET
- **Parameters**:
  - `userName`: Required - User's username
  - `password`: Required - User's password
  - `orderNumber`: Required - Unique order identifier
  - `amount`: Required - Payment amount
  - `currency`: Required - Currency code
  - `returnUrl`: Required - URL to redirect on success
  - `failUrl`: Required - URL to redirect on failure
  - `description`: Required - Payment description
  - `language`: Required - Language preference
  - `jsonParams`: Required - Additional parameters in JSON format

### Payment Confirmation

- **Endpoint**: `/payment/rest/confirm.do`
- **Method**: GET
- **Parameters**:
  - `userName`: Required - User's username
  - `password`: Required - User's password
  - `orderNumber`: Required - Order identifier
  - `language`: Required - Language preference

### Payment Refund

- **Endpoint**: `/payment/rest/refund.do`
- **Method**: GET

## Payment Webpage

The payment webpage is accessible at `/paymentWebpage` with the order ID as a query parameter:

- **Endpoint**: `/paymentWebpage?orderId=ORDER_ID`
- **Features**:
  - Two action buttons: Confirm Payment and Fail Payment
  - Secure form submission
  - Responsive design
  - Session-based URL handling

## Session Management

The application uses PHP sessions to store:
- Return URL for successful payments
- Fail URL for failed payments
- Order information

## Security Features

- CSRF protection for form submissions
- Input validation for all parameters
- Secure session handling

## Usage Example

### Register a Payment

```
GET /payment/rest/register.do?userName=johnsmith&password=secure123&orderNumber=ORD12345&amount=100.00&currency=USD&returnUrl=http://example.com/success&failUrl=http://example.com/failure&description=Test%20Order&language=en&jsonParams={"key":"value"}
```

### Confirm a Payment

```
GET /payment/rest/confirm.do?userName=johnsmith&password=secure123&orderNumber=ORD12345&language=en
```

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       └── PaymentController.php
resources/
└── views/
    └── paymentWebpage.blade.php
routes/
└── web.php
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request


This project is licensed under the Apache License - see the LICENSE file for details.
