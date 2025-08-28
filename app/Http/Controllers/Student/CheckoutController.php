<?php

namespace App\Http\Controllers\Student;

use Mail;
use Stripe\Stripe;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Cart;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Http\Controllers\Controller;
use App\Mail\CourseEnroll;

class CheckoutController extends Controller
{
    /**
     * Configure Stripe
     */
    public function __construct()
    {
        // Stripe::setApiKey(auth()->user()->stripe_secret_key ?? env('STRIPE_SECRET'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($domain ,$slug)
    {
        //
        // $cart = Cart::select('course_id')->where('user_id', auth()->id())->get();
        // dd($cart);
        $course = Course::where('slug', $slug)->first();

        // configure stripe key
        Stripe::setApiKey($course->user->stripe_secret_key);

        // check if stripe key is not null
        if($course->user->stripe_secret_key == null){
            return redirect()->route('students.show.courses', $course->slug)->with('error', 'Instructor has not connected with stripe yet');
        }

        if($course->offer_price == 0){
            $course_price = $course->price;
        }else{
            $course_price = $course->offer_price;
        }

        // check if checkout table has the logged in user id and course id
        $checkout = $course->checkouts()->where('user_id', auth()->user()->id)->first();

        if($checkout){
            return redirect()->route('students.show.courses', ['slug' => $course->slug, 'subdomain' => config('app.subdomain') ])->with('error', 'You have already enrolled in this course');
        }

        // Create a checkout session

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $course_price * 100,
                    'product_data' => [
                        'name' => $course->title,
                        'images' => [asset('uploads/courses/' . $course->thumbnail)],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['slug' => $course->slug, 'subdomain' => config('app.subdomain') ]) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['slug' => $course->slug, 'subdomain' => config('app.subdomain') ]),
        ]);

        return redirect($checkout_session->url);
    }

    public function indexOfCart()
    {
        $courseIds = Cart::where('user_id', auth()->id())->pluck('course_id')->toArray();
        $courses = Course::whereIn('id', $courseIds)->get();
        $course_price = 0;
        $courseTitles = [];
        foreach ($courses as $course) {
            Stripe::setApiKey( $course->user->stripe_secret_key);
            if($course->user->stripe_secret_key == null){
                return redirect()->route('students.show.courses', ['slug' => $course->slug, 'subdomain' => config('app.subdomain') ])->with('error', 'Instructor has not connected with stripe yet. Remove that course from cart first please');
            }
            $courseTitles[] = $course->title;

            if($course->offer_price == 0){
                $course_price = $course_price + $course->price;
            }else{
                $course_price = $course_price + $course->offer_price;
            }

            $checkout = $course->checkouts()->where('user_id', auth()->user()->id)->first();

            if($checkout){
                return redirect()->route('students.show.courses', $course->slug)->with('error', 'You have already enrolled in this course. Remove that course from cart');
            }
        }
        $courseNames = implode(', ', $courseTitles);

        $idsString = implode(',', $courseIds);

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $course_price * 100,
                    'product_data' => [
                        'name' => $courseNames,
                        'images' => [asset('uploads/courses/new-budle-course-64cb5712834ef.jpg')],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['slug' => $idsString, 'subdomain' => config('app.subdomain') ] ) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', ['slug' => $idsString, 'subdomain' => config('app.subdomain') ] ),
        ]);

        return redirect($checkout_session->url);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function success($slug)
    {
        return 'This method has been removed';
        $courseIds = explode(',', $slug);

        foreach ($courseIds as $courseId) {
            $course = Course::where('id', $courseId)->first();
            Stripe::setApiKey( $course->user->stripe_secret_key);
            $session_id = Session::all()['data'][0]['id'];
            $start_date = null;
            $end_date = null;
            if($course->subscription_status == 'one_time'){
                $start_date = null;
                $end_date = null;
            }else if($course->subscription_status == 'monthly'){
                $start_date = now()->toDateTimeString();
                $end_date = now()->addMonth();
            }else if($course->subscription_status == 'anully'){
                $start_date = now()->toDateTimeString();
                $end_date = now()->addYear();
            }else if($course->subscription_status == 'Free'){
                $start_date = null;
                $end_date = null;
            }


            try {
                // Retrieve the payment data and amount using the session ID
                $session = Session::retrieve($session_id);
                $payment_id = $session->payment_intent;
                $paymentMethod = 'Stripe';
                // $amount = $session->amount_total / 100;
                $amount = $course->price;

                if($course->offer_price){
                    $amount = $course->offer_price;
                }

                // Attach the user to the course with the payment details
                $course->students()->attach(auth()->user()->id, [
                    'payment_method' => $paymentMethod,
                    'amount' => $amount,
                    'paid' => true,
                    'start_at' => $start_date,
                    'end_at' => $end_date,
                ]);

                // Store the transaction in the checkout table
                $checkout = $course->checkouts()->create([
                    'course_id' => $course->id,
                    'instructor_id' => $course->user_id,
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'completed',
                    'payment_id' => $payment_id,
                    'status' => 'completed',
                    'amount' => $amount,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);

                if ($checkout) {

                     // Send email
                    Mail::to(auth()->user()->email)->send(new CourseEnroll($course));
                    $cart = Cart::select('course_id')->where('user_id', auth()->id())->get();

                } else {
                    // return redirect()->route('students.show.courses', $course->slug)->with('error', 'Something went wrong');
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur during the process
                // return redirect()->route('students.show.courses', $slug)->with('error', $e->getMessage());
                return redirect()->route('students.catalog.courses', config('app.subdomain') )->with('error', $e->getMessage());

            }

        }
        $cartItems = Cart::where('user_id', auth()->id())->get();

        foreach ($cartItems as $cartItem) {
            $cartItem->delete();
        }

        // set notification for instructor
        // $notify = new Notification([
        //     'user_id'   => Auth::user()->id,
        //     'instructor_id' => $course->user_id,
        //     'course_id' => $course->id,
        //     'type'      => 'instructor',
        //     'message'   => "enrolled",
        //     'status'   => 'unseen',
        // ]);
        // $notify->save();

        // $pdf = PDF::loadView('emails.invoice', ['data' => $package, 'subscription' => $subscription]);
        // $pdfContent = $pdf->output();

        // // Send the email with the PDF attachment
        // $mailInfo = Mail::send('emails.invoice', ['data' => $package, 'subscription' => $subscription], function($message) use ($package, $pdfContent, $subscription) {
        //     $message->to(auth()->user()->email)
        //             ->subject('Invoice')
        //             ->attachData($pdfContent,  $subscription->name.'.pdf', ['mime' => 'application/pdf']);
        // });


        return redirect()->route('students.catalog.courses', config('app.subdomain') )->with('success', 'You have successfully enrolled in this course');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel($slug)
    {
        //
        return redirect()->route('students.show.courses', ['slug' => $slug, 'subdomain' => config('app.subdomain') ])->with('error', 'You have cancelled the payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
