<?php

namespace App\Http\Controllers;

use App\Models\IyzicoPayment;
use App\Models\Order;
use App\Models\OrderedProduct;
use Illuminate\Http\Request;

class IyzicoPaymentController extends Controller
{
    public function redirect(Request $request)
    {


        $order = Order::with('ordered_products.product')
            ->with('address')
            ->find($request->order_id);


        if(!$order){
            return null;
        }


        $requestIyzico = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $requestIyzico->setLocale(app()->getLocale());
        $requestIyzico->setConversationId(rand());
        $requestIyzico->setPrice($order->total_amount);
        $requestIyzico->setPaidPrice($order->total_amount);
        $requestIyzico->setCurrency('USD');
        $requestIyzico->setBasketId("B67832");
        $requestIyzico->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $requestIyzico->setCallbackUrl(route('iyzico.callback'));
        $requestIyzico->setEnabledInstallments(array(2, 3, 6, 9));


        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId(1);
        $buyer->setName("R");
        $buyer->setSurname("R");
        $buyer->setGsmNumber("R");
        $buyer->setEmail("R@m.com");
        $buyer->setIdentityNumber(rand());
        $buyer->setRegistrationAddress("R");
        $buyer->setIp($request->ip());
        $buyer->setCity("R");
        $buyer->setCountry("TR");
        $buyer->setZipCode("R");

        $requestIyzico->setBuyer($buyer);


        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("R");
        $shippingAddress->setCity("R");
        $shippingAddress->setCountry("R");
        $shippingAddress->setAddress("R");
        $shippingAddress->setZipCode("R");
        $requestIyzico->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("R");
        $billingAddress->setCity("R");
        $billingAddress->setCountry("R");
        $billingAddress->setAddress("R");
        $billingAddress->setZipCode("R");
        $requestIyzico->setBillingAddress($billingAddress);

        $totalAmount = $order->total_amount;

       $basketItems = array();
        $products = 0;
        foreach ($order->ordered_products as $op) {
            $BasketItem = new \Iyzipay\Model\BasketItem();
            $BasketItem->setId($op->product_id);
            $BasketItem->setName($op->product->title);
            $BasketItem->setCategory1("Test");

            $BasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
            $BasketItem->setPrice(($op->selling * $op->quantity) + $op->tax_price + $op->shipping_price);
            $basketItems[$products] = $BasketItem;
            $products++;
        }
        $requestIyzico->setBasketItems($basketItems);

        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($requestIyzico, IyzicoPayment::options());
       // $paymentForm = $checkoutFormInitialize->getCheckoutFormContent();

        return $checkoutFormInitialize;


        print_r($checkoutFormInitialize);
        dd();

        $paymentResponse = (array)$checkoutFormInitialize;




        echo "<pre>";
        print_r($paymentResponse);
        die();

        $responseDecode = null;

        foreach ($paymentResponse as $key => $value){
            $responseDecode = json_decode($value);
            echo "<pre>";
            print_r();
        }



        return $responseDecode;

       // print_r(compact('paymentForm'));



        //return view('iyzico::iyzico-form', compact('paymentForm'));
    }

    public function callback(Request $request)
    {

        $orderId  = $request->order_id;

        $requestIyzico = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $requestIyzico->setLocale(app()->getLocale());
        $requestIyzico->setToken($request->token);
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($requestIyzico, IyzicoPayment::options());


        if ($checkoutForm->getPaymentStatus() == 'SUCCESS') {


            Order::where('id', $orderId)->update([
                'payment_done' => true
            ]);

        }

        return redirect(env('CLIENT_BASE_URL', '/user/order/' . $orderId) . '/user/order/' . $orderId);
    }

    public function success()
    {
        return redirect()->route('shop.checkout.success');
    }
}
