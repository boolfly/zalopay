# Boolfly ZaloPay Wallet for Magento 2

Read more about Zalopay: https://fintechnews.sg/10595/vietnam/vietnams-zalo-pay-brings-payments-social-media/

First of all, we need to make sure our website supporting Vietnamese Dong.

Log in to Admin, **STORES > Configurations > GENERAL > Currency Setup > Currency Options > Allowed Currencies**. Make sure the Vietnamese Dong is selected.

![Zalopay Wallet currency](https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/zalopay-wallet-currency-01.png)

Go to Currency Rates, **STORES > Currency > Currency Rates**

![Zalopay Wallet currency](https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/zalopay-currency-rates-01.png)

## Zalopay Configuration

Log in to Admin, **STORES > Configurations > SALES > Payment Methods > Zalopay**

![Zalopay Wallet Configuration](https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/configuration_zalopay.png)

Read more here:

- https://docs.zalopay.vn/en/faq/#f-a-q-frequently-asked-questions_3-is-zalopay-support-sandbox-for-developer
- https://developers.zalopay.vn/docs/gateway/index.html#dang-ky-ng-d-ng

After registering Zalo Pay system will see the application the following information:
<ul>
  <li>appid : positive integer, identifier for the application during the payment process with Zalo Pay system.</li>
  <li>key1 : secret key used to create authentication data for orders </li>
  <li>key2 : the secret key used to authenticate data sent by ZaloPayServer via MerchantServer at callback.</li>
</ul>

Configuration info to integrate with MoMo API.
<ul>
   <li>Enabled: enable or disable this method.</li>
   <li>App Id: Use the info above.</li>
   <li>Key 1: Use the info above.</li>
   <li>Key 2: Use the info above.</li>
   <li>App User: Identification information of the user of the payment order application: id / username / name / phone number / email of the user. If it is not identifiable, the default information can be used, such as the application name.</li>
  <li>Sandbox Mode: when testing, we should enable this mode</li>
 </ul>
 
  ## Checkout
 After enabling this method, go to the checkout, we can see this method.
 
 ![Zalopay Wallet Checkout]( https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/m2_checkout_zalopay.png)

 Zalopay Payment page:
 
 ![Zalopay Payment page](https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/zalo_pay_scan_qr.png)
 
 ## Purchased Successfully
 
  ![Zalopay Payment page](https://github.com/boolfly/wiki/blob/master/magento/magento2/images/zalopay/zalopay_sucess_payment.png)
 
