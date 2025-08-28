<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Course;
use App\Models\Checkout;
use App\Mail\BundleCourseEnroll;
use Illuminate\Support\Facades\Mail;
use App\Models\BundleCourse;
class CheckoutBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        //
        $bundle = BundleCourse::where('id', $slug)->first();
        // return $bundle->course->pluck('id');
        // configure stripe key
        Stripe::setApiKey( $bundle->user->stripe_secret_key);

        // check if stripe key is not null
        if($bundle->user->stripe_secret_key == null){
            return redirect()->route('students.show.courses', $bundle->course->pluck('slug'))->with('error', 'Instructor has not connected with stripe yet');
        }

        // check if checkout table has the logged in user id and course id
        $checkout = $bundle->course;
        
        foreach($checkout as $course){
            $checkout = Checkout::where('user_id', auth()->user()->id)->where('course_id', $course->id)->first();
            if($checkout){
                return back()->with('error', 'You have already purchased this course');
            }
        }

        // Create a checkout session
        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $bundle->price * 100,
                    'product_data' => [
                        'name' => $bundle->title,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('bundle.checkout.success', $bundle->id) .'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('bundle.checkout.cancel', $bundle->id),
        ]);

        // save checkout session id in checkout table
        return redirect($checkout_session->url);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function success($slug)
    {
        //
        $bundle = BundleCourse::where('id', $slug)->first();
        $selectedcourse = Course::whereIn('id', explode(',', $bundle->selected_course))->get();

        Stripe::setApiKey( $bundle->user->stripe_secret_key);
        // Get the session ID
        $session_id = Session::all()['data'][0]['id'];
        $start_date = null;
        $end_date = null;

        // start_date end_date add based on course subscription_status
        if($bundle->subscription_status == 'one_time'){
            $start_date = null;
            $end_date = null;
        }else if($bundle->subscription_status == 'monthly'){
            $start_date = now()->toDateTimeString();
            $end_date = now()->addMonth();
        }else if($bundle->subscription_status == 'anully'){
            $start_date = now()->toDateTimeString();
            $end_date = now()->addYear();
        }else if($bundle->subscription_status == 'Free'){
            $start_date = null;
            $end_date = null;
        }

        try {
            // Retrieve the payment data and amount using the session ID
            $session = Session::retrieve($session_id);
            $payment_id = $session->payment_intent;
            $paymentMethod = 'Stripe';
            $amount = $session->amount_total / 100;

            // Attach the user to the course with the payment details
            foreach($selectedcourse as $course){
                $course->students()->attach(auth()->user()->id, [
                    'payment_method' => $paymentMethod,
                    'amount' => $amount,
                    'paid' => true,
                    'start_at' => $start_date,
                    'end_at' => $end_date,
                ]);
            }

            // save checkout session id in checkout table
            foreach($selectedcourse as $course){
            $checkout=  $course->checkouts()->create([
                    'course_id' => $course->id,
                    'instructor_id' => $course->user_id,
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'paid',
                    'payment_id' => $payment_id,
                    'status' => 'completed',
                    'amount' => $amount,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                ]);
            }

            if ($checkout) {

                // Send email
                Mail::to(auth()->user()->email)->send(new BundleCourseEnroll($bundle));

                return redirect()->route('students.show.courses', $selectedcourse[0]->slug)->with('success', 'You have successfully enrolled in this course');
            } else {
                return redirect()->route('students.show.courses', $selectedcourse[0]->slug)->with('error', 'Something went wrong');
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the process
            return redirect()->route('students.show.courses', $selectedcourse->pluck('slug'))->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($slug)
    {
        //
        return redirect()->route('students.show.courses', $slug)->with('error', 'You have cancelled the payment');
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
