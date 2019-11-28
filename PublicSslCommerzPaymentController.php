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
