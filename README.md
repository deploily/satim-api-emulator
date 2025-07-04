
## SATIM CLONE Payment Processing

A payment processing system built with Laravel.

## Features

- Payment registration
- Payment confirmation
- Payment failure handling
- Secure session handling

### Usage
 - **instalation**: `cd src`
   - `composer install`
 - **run**:
   - `cd src`
   - `php artisan migrate`
   - `php artisan serve`

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
GET /api/payment/rest/register.do?currency=012&amount=139139&language=fr&orderNumber=1538298192&userName=xxxxxxxx&password=xxxxxxx&returnUrl=httpssatimdzdirectpay
```

### Confirm a Payment

```
GET /api/payment/rest/confirmOrder.do?language=EN&orderId=1&password=xxxxx&userName=testtest
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request


This project is licensed under the Apache License - see the LICENSE file for details.
