<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Affiliate;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\AffliateNetwork;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Country;
use App\Models\Plan;
use App\Models\PlanFeature;
use App\Models\AffiliateSubcription;
use Stripe\Stripe;

class AffiliateManagmentController extends Controller
{
    //

    public function index(){
        $categories = Category::with('products')->get();
        $plan = Plan::with('planFeature')->get();
        return view('site.affiliate.index', compact('categories','plan'));
        return view('site.affiliate.index');
    }

    public function Affilates()
    {
        $categry =  Category::with('products')->withCount('products')->get();
        $categories = Category::with('products')->get();
        return view('front-end.Affilates',compact('categry','categories'));
    }
    public function affilatespackage()
    {
        $categories = Category::with('products')->get();
        $plan = Plan::with('planFeature')->get();
        return view('front-end.affilatespackage', compact('categories','plan'));
    }

    public function affiliateRegisterForm($link = '',$id = ''){

        $email = '';
        $subscrID = $id;
        // if($id){
        //      $affiliate_sub = AffiliateSubcription::where('id',$id)->first();
        //      $email = $affiliate_sub->payer_email;
        //      $subscrID = $id;
        // }
        
        $plans = Plan::get();
        $affliate = '';
        if(!empty($link)){

            $affliate =  Affiliate::where('referral_link',$link)->with('user')->first();
            if(!empty( $affliate)){
                Session::put('referral_link', $link);
                Session::put('user_id', $affliate->user_id);
            }
           
        }else{

            Session::put('referral_link', '');
            Session::put('user_id', '');
        }

        $countries = Country::all();

        if (Auth::check()) {

            return redirect()->route('dashboard');
        }
        return view('site.affiliate.register',compact('affliate','countries','plans','subscrID'));
    }

    public function affiliateRegister(Request $request){

    //    return $request->all();
    //     // Validate the request
    //     $request->validate([
    //         //'name' => [ 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         //'password' => ['required', Rules\Password::defaults()],
    //     ]);
        
        
        
        // if(isset($request->affiliate_code)){

        //     $affiliate_code = Affiliate::where('code',$request->affiliate_code)->first();
        //     if(!$affiliate_code){
        //         return redirect()->back()->with('errors', 'Affiliate code is invalid.');
        //     }

        //     $request->affiliate_user_id = $affiliate_code->user_id;
        // }
        // $product_id = Session::get('product_id');
        // $code = Session::get('code');
    
        // if ($product_id && $code) {
        //     $affiliate = Affiliate::where('code', $code)->first();
            
        //     // Check if affiliate exists
        //     if ($affiliate) {
        //         $request->affiliate_user_id = $affiliate->user_id;
        //     } else {
        //         // Handle the case where the affiliate is not found
        //         return redirect()->back()->with('errors', 'Affiliate code is invalid.');
        //     }
        // }
        // return $request->all();
        // Prepare user data
        $dataUser = [
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'number' => $request->phonenumber,
            'status' => 1,
            'email' => $request->email,
            'role' => 4,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'city' => $request->ms_select_city,
            'postalcode' => $request->postalcode,
            'ms_select_state' => $request->ms_select_state,
            'ms_select_country' => $request->ms_select_country,
            'user_type' => 'affiliate',
        ];
    
        // Create the user
         $user = User::create($dataUser);
    
        if(isset($request->subscrID)){

            $affiliate_sub = AffiliateSubcription::find($request->subscrID);
            $affiliate_sub->user_id = $user->id;
            $affiliate_sub->save();
        }
        // Generate random codes and links
        $random = Str::random(4);
        $code = time().$random;
    
        $random = Str::random(4);
        $refferral_link = time().$random;
    
        $random = Str::random(4);
        $shoppink_link = time().$random;
    
        // Prepare affiliate data
        $dataAffiliate = [
            'referral_link' => $refferral_link,
            'shoppink_link' => $shoppink_link,
            'user_id' => $user->id,
            'code' => $code,
            'minimum_category' => 2,
            'status' => 1,
        ];
    
        // Create the affiliate
        $affiliate = Affiliate::create($dataAffiliate);
    
        // Check if product_id and code exist in the session
       
    
        // Create the affiliate network if affiliate_user_id is set
        if (isset($request->affiliate_user_id)) {
            $affliate_network = [
                'parent_id' => $request->affiliate_user_id,
                'child_id' => $user->id,
                'product_id' => $product_id,
            ];
            AffliateNetwork::create($affliate_network);
        }
    
        // Update the cart items with the new user ID
        // $ip_address = \Request::ip();
      //  CartItem::where('ip_addrees', $ip_address)->update(['user_id' => $user->id]);

        // $plan = Plan::find($request->plan_id);
    //     if($plan->price > 0  && $plan->stripe_price_id){
    //         $domain = request()->getSchemeAndHttpHost();

    //         $plan_id = $plan->stripe_price_id;
    //         $stripeSecretKey = 'sk_test_FdzbMH2J38NJsr76X86wqHPI';
    //         Stripe::setApiKey($stripeSecretKey);
      
    //         $checkout_session = \Stripe\Checkout\Session::create([
    //             'line_items' => [[
    //               'price' => $plan_id,
    //               'quantity' => 1,
    //             ]],
    //             'billing_address_collection' => 'auto',
    //             'phone_number_collection' => ['enabled' => false],
    //             'customer_email' => $user->email,
    //             'payment_method_types' => ['card'],
    //             'mode' => 'subscription',
    //             'success_url' =>$domain .'/sub/successfull/{CHECKOUT_SESSION_ID}/'.$user->id,
    //             'cancel_url' =>$domain . '/sub/cancel/{CHECKOUT_SESSION_ID}',
    //           ]);
            
    //           header("HTTP/1.1 303 See Other");
    //           header("Location: " . $checkout_session->url);
    //           exit;
       
    //    }
    
        // Redirect to login with success message
        return redirect()->route('affiliate.login')->with('success', 'Successfully registered...!');
    }
    

    public function affiliateTraining(){

        return view('front-end.training');
    }


    public function affiliateCommission(){

        return view('front-end.commission');
    }

    public function affiliateTicket(){

        return view('front-end.ticket');
    }

    public function affiliateShop($categoryName = '')
    {
        $categories = Category::with('products')->withCount('products')->get();
        $path = route('affiliate.shop');
        
        if ($categoryName) {
            // Convert the slug back to the original category name
            $originalName = str_replace('-', ' ', $categoryName);
            $category = Category::where('name', 'like', $originalName)->first();
            if ($category) {
                $products = Product::where('category_id', $category->id)->with('category')->paginate(10);
            } else {
                $products = new LengthAwarePaginator([], 0, 10, 1, [
                    'path' => $path,
                    'pageName' => 'page',
                ]);
            }
        } else {
            $products = new LengthAwarePaginator([], 0, 10, 1, [
                'path' => $path,
                'pageName' => 'page',
            ]);
        }
    
        return view('front-end.affilateshop', compact('categories', 'products'));
    }
    
    



    public function affiliateNetwork(){

        if (!Auth::check()) {

            return redirect('/');
        }

        $networks = AffliateNetwork::where('parent_id',auth()->user()->id)->with('child')->get();

        $level_one_sale = 0;
        $level_two_sale = 0;

        foreach($networks as $row){

            $order_sale = Order::where('affiliate_id',$row->child_id)->sum('total_amount');
            if($order_sale > 0){

                $level_one_sale += $order_sale;
            }

           $level_2 =  AffliateNetwork::where('parent_id',$row->child_id)->with('child')->get();

           foreach($level_2 as $level){
            $order_sale_2 = Order::where('affiliate_id',$level->child_id)->sum('total_amount');
            if($order_sale_2 > 0){

                $level_two_sale += $order_sale_2;
            }

           }

        }
        // print_r($level_one_sale);
        // echo "<br>";
        // print_r($level_two_sale);
        // die;

        $parent_network = AffliateNetwork::where('child_id',auth()->user()->id)->with('parent')->first();

        $tab = 'network';
        return view('front-end.affiliate.network',compact('networks','tab','parent_network'));
    }

    public function childNetwork(Request $request){

        // return $request->all();
        $networks = AffliateNetwork::where('parent_id',$request->id)->with('child')->get();

     
         $affiliate = User::where('id',$request->id)->with('Affiliate')->first();
        
        $child = '';
        foreach ($networks as $row){

           $child = $child.'
           <td id="child_network"><span
                   class="parent_level_arrow">→<!--&uarr;--></span>
               '.$row->child->first_name . ' ' . $row->child->last_name.'
           </td>
         </tr>' ;
        }
        
        $data = [
            'child' => $child,
            'affiliate' => $affiliate
        ];

        return response()->json($data);
    }


    public function childOrder(){

        $orders = Order::where('affiliate_id',auth()->user()->Affiliate->id)->with('user')->with('affliateCommission')->get();

        $tab = 'order';

        return view('front-end.affiliate.order',compact('orders','tab'));    
    }


    public function affliateProfile(){


        // return auth()->user();
        $tab = 'profile';

        return view('front-end.affiliate.profile',compact('tab'));    
    }

    public function affilateregister(){
        $categories = Category::with('products')->get();
        $countries = Country::all();
        return view('front-end.affilateregister', compact('categories','countries'));
    }

    public function affiliateMailCheck(Request $request){

        
        $request->validate([
            //'name' => [ 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            //'password' => ['required', Rules\Password::defaults()],
        ]);
        $domain = request()->getSchemeAndHttpHost();
        $plan = Plan::where('id',$request->plan_id)->first();
        $plan_id = $plan->stripe_price_id;
        $stripeSecretKey = 'sk_test_FdzbMH2J38NJsr76X86wqHPI';
        Stripe::setApiKey($stripeSecretKey);
        try {
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              'price' => $plan_id,
              'quantity' => 1,
            ]],
            'billing_address_collection' => 'auto',
            'phone_number_collection' => ['enabled' => false],
            'customer_email' => $request->email,
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'success_url' =>$domain .'/sub/successfull/{CHECKOUT_SESSION_ID}',
            'cancel_url' =>$domain . '/sub/cancel/{CHECKOUT_SESSION_ID}',
          ]);
        
          header("HTTP/1.1 303 See Other");
          header("Location: " . $checkout_session->url);
          exit;
        } catch (Error $e) {
          http_response_code(500);
          echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function subscriptionSuccessfull($session_id,$id){

        // return $id;
        $stripeSecretKey = 'sk_test_FdzbMH2J38NJsr76X86wqHPI';
        Stripe::setApiKey($stripeSecretKey);
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/checkout/sessions/' . $session_id);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $stripeSecretKey);

		$response = curl_exec($ch);
		$data = json_decode($response);
        
        $subscription_id = $data->subscription;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/subscriptions/'.$subscription_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $stripeSecretKey);

		$response = curl_exec($ch);
	 	$subscription = json_decode($response);
	

		 $plan = Plan::where('stripe_price_id',$subscription->plan->id)->first();
       
        if($subscription->status == 'active'){ 
                // Subscription info 
                $subscrID = $subscription->id; 
                $custID = $subscription->customer; 
                $planID = $subscription->plan->id; 
                $planAmount = ($subscription->plan->amount/100); 
                $planCurrency = $subscription->plan->currency; 
                $planInterval = $subscription->plan->interval; 
                $planIntervalCount = $subscription->plan->interval_count; 
                $current_period_start = date("Y-m-d H:i:s", $subscription->current_period_start); 
                $current_period_end = date("Y-m-d H:i:s", $subscription->current_period_end); 
                $email = $data->customer_email;
                $payment_status = $data->payment_status;
                $subscription_status = $data->status;
                $status = $subscription->status;
                $mode = 0;
                if(isset($subscription->livemode)){
                    
                    $mode = $subscription->livemode; 
                }
            $sub_date = [
                'plan_id' => $plan->id,
                'user_id' => $id,
                'stripe_subscription_id' => $subscrID,
                'stripe_customer_id' => $custID,
                'stripe_price_id' => $planID,
                'plan_amount' => $planAmount,
                'curency' => $planCurrency,
                'plan_intervel' => $planInterval,
                'plan_intervel_count' => $planIntervalCount,
                'plan_start_date' => $current_period_start,
                'plan_end_date' => $current_period_end,
                'payer_email' => $email,
                'payment_status' => $payment_status,
                'subscription_status' => $subscription_status,
                'status' => $status,
                'billing_cycle_anchor' => date("Y-m-d H:i:s"),
                'mode' => $mode,
            ];

            $affiliate_sub = AffiliateSubcription::create($sub_date);

            $link = "sdfr4567";
            return redirect('affiliate/register/form/'.$link.'/'.$affiliate_sub->id);
        }
        if($subscription->status == 'incomplete'){ 

            return redirect()->route('affilatespackage')->with('error','Something went wrong and your transaction is not completed yet it might be due to change in payment polices by stripe');
        }

        
        return redirect()->route('login')->with('success', 'Successfully registered...!');
        

    }

    public function subscriptionCancel($id){

        return redirect()->route('affilatespackage')->with('error','Transaction cancled...!');
    }

    public function affliateSubscription(){

        $affiliate_sub = AffiliateSubcription::where('user_id',auth()->user()->id)->with('plan')->get();
        // return $affiliate_sub;
        $tab = 'subscription';
        return view('front-end.affiliate.subscription', compact('affiliate_sub','tab'));
    }


    public function affiliateLogin(){


        if(Auth::check()){

            $category = Category::with('products')->get();
            $total_category = Category::with('products')->count();

            $user_affliate_id = auth()->user()->Affiliate->id;

            $total_orders = Order::where('affiliate_id',$user_affliate_id)->count(); 
            $total_sale = Order::where('affiliate_id',$user_affliate_id)->sum('total_amount'); 

            $total_affliate = AffliateNetwork::where('parent_id',auth()->user()->id)->count();

            
            $tab ='dashboard';
            $domain = request()->getSchemeAndHttpHost();
            
            return view('site.affiliate.user-dashboard',compact('tab','category','total_orders','total_sale','total_category','total_affliate'));
        }
        return view('site.affiliate.login');

    }


    public function affiliateLoginStore(Request $request ){

        $data = $request->only('email', 'password');
      //  $data['status'] = 'Active';
         $userData = User::where('email', $data['email'])->first();

        if (\Hash::check($data['password'], $userData->password)) {
           
              Auth::guard('user')->attempt($data);

              $category = Category::with('products')->get();
              $total_category = Category::with('products')->count();
  
              $user_affliate_id = auth()->user()->Affiliate->id;
  
              $total_orders = Order::where('affiliate_id',$user_affliate_id)->count(); 
              $total_sale = Order::where('affiliate_id',$user_affliate_id)->sum('total_amount'); 
  
              $total_affliate = AffliateNetwork::where('parent_id',auth()->user()->id)->count();
  
              
              $tab ='dashboard';
              $domain = request()->getSchemeAndHttpHost();
              
              return view('site.affiliate.user-dashboard',compact('tab','category','total_orders','total_sale','total_category','total_affliate'));
  
        }
    }
}
