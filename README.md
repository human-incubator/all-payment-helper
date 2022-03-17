# all-payment-helper
A Laravel package that can be used in client sites for an ease access of all all-payment actions that can be done form clients.

## Installation
You can install this package in your laravel app by running this command
`composer require human-incubator/all-payment-helper`

After a successful installation of the package, run `php artisan vendor:publish` to setup the package's Service Provider and will extract all the configuration files needed.
Select only the `HumanIncubator\AllPaymentHelper\AllpaymentServiceProvider` when there are several options listed.

The package expects your app to have the `ALLPAYMENT_API_URL` and `ALLPAYMENT_TOKEN` given in your .env file. If this wasnt setup yet, please do.

- ALLPAYMENT_API_URL = The allpayment url dedicated for your current environment(Test or production url of allpayment).
- ALLPAYMENT_TOKEN = The client api key that was given for your app to access allpayment.

## Basic Usage

#### Invoice creation to Allpayment
In your controller, include the library class as `use HumanIncubator\AllPaymentHelper\AllPayment;`

You can then process invoice creation method by doing this simple command

```
return AllPayment::create_invoice(130, 'https://google.com');
```

where 130 is the total amount of the invoice and https://google.com is the callback url.

The `create_invoice` method accepts Three arguments.
1. **Amount** - the total amount of the invoice
2. **Callback URL** - The url in your app where the result of allpayment process can be sent.
3. **Client Invoice ID** - The id of the invoice recorded in the client app. (Can be left as empty).

#### Payment Cancellation
In your controller, include the library class as `use HumanIncubator\AllPaymentHelper\AllPayment;`

There are two ways by which we can cancel a payment in allpayment and refund the amount paid. It is either using the Allpayment invoice id or using GMO order id as reference.
That is why it is necessary to save either of this two data right after a successful invoice creation.

```
return AllPayment::cancel(1);
```
where 1 is the invoice id reference to allpayment.

This method accepts Two argument.
1. **ID** - This can be either an Allpament invoiceID or GMO OrderID depending what you set on the second argument
2. **Cancel By Invoice ID** - The default value for this argument is true which means cancellation by invoice id. If set as false, It is expected that the first parameter is the value of GMO Order ID for the cancellation will process via GMO Order id as reference.
