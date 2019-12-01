public function subscription($id){
        $plan=Plan::findorFail($id);
        $name=$plan->name;
        $price=$plan->price;
        $credit=$plan->credit;
        $plan=$plan->id;
        $success = route('success');
        $fail = route('pricing');
        $cancel = route('pricing');
        $post_data = array();
        //$post_data['store_id'] = "easyticketbdlive";
        $post_data['store_id'] = "easyt5d47c1bdea896";
        //$post_data['store_passwd'] = "5D6BAD90053ED33455";
        $post_data['store_passwd'] = "easyt5d47c1bdea896@ssl";
        $post_data['total_amount'] = $price;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = now();
        $post_data['success_url'] = $success;
        $post_data['fail_url'] = $fail;
        $post_data['cancel_url'] = $cancel;
# OPTIONAL PARAMETERS
        $post_data['value_a'] = $plan;
        $post_data['value_b '] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";
        //$direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v4/api.php";
        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url );
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1 );
        curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
        $content = curl_exec($handle );
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($code == 200 && !( curl_errno($handle))) {
            curl_close( $handle);
            $sslcommerzResponse = $content;
        } else {
            curl_close( $handle);
            echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
            exit;
        }
# PARSE THE JSON RESPONSE
        $sslcz = json_decode($sslcommerzResponse, true );
        if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
            # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
            # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
            echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
            # header("Location: ". $sslcz['GatewayPageURL']);
            exit;
        } else {
            echo "JSON Data parsing error!";
        }
    }
