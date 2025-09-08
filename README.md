
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
   - `php artisan key:generate`
   - `php artisan migrate`
   - `php artisan serve`
   - `cp .env.example .env`

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
```
curl -X GET "http://127.0.0.1:8000/api/payment/rest/register.do?orderNumber=123&amount=100&currency=012&returnUrl=http://localhost/success&failUrl=http://localhost/fail&language=EN&userName=satim_68be9e9c5ec3f&password=B2fgKUNR1C&description=TestPayment&jsonParams=%7B%7D" \
-H "Accept: application/json"

```
### Confirm a Payment

```
GET /api/payment/rest/confirmOrder.do?language=EN&orderId=1&password=xxxxx&userName=testtest
```

```
curl -X GET "http://127.0.0.1:8000/api/payment/rest/confirmOrder.do?language=EN&orderId=5&userName=satim_68be9e9c5ec3f&password=B2fgKUNR1C" \
-H "Accept: application/json"

```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request


This project is licensed under the Apache License - see the LICENSE file for details.
## Getting a Keycloak Token

To retrieve an **access token** with an existing Keycloak user (`ranim`), use the following `curl` command:

```bash
curl -X POST "http://172.17.0.1:8080/realms/satim/protocol/openid-connect/token" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "grant_type=password" \
  -d "client_id=laravel-api" \
  -d "client_secret=PK2lHGeL4QaAW0eMXiaPqFnbzIi50OcK" \
  -d "username=ranim" \
  -d "password=ranim"
```