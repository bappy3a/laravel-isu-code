public function fail(Request $request)
    {
        $lastid = Order::all()->last()->id;;
        $order = Order::findOrFail($lastid);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->delete();
            }
            $order->delete();
        }
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(__('Payment Failed'))->success();
        return redirect()->url()->previous();

    }

public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $object['quantity'] = $request->quantity;
                if($object['quantity'] == 5){
                    $object['price'] = 100;
                }
            }

            return $object;
        });
        $request->session()->put('cart', $cart);

        return view('frontend.partials.cart_details');
    }
