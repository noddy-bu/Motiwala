<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faq;
use App\Models\Contact;

use Illuminate\Support\Facades\Validator;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Http;


class IndexController extends Controller
{
    public function index(){
        $plan_duration = DB::table('plans')->where('status', 1)->select(['id', 'installment_period'])->get();
        // Filter the collection to get the installment_period for the plan with id = 1
        $plan1_duration = $plan_duration->firstWhere('id', 1)?->installment_period;

        // Filter the collection to get the installment_period for the plan with id = 2
        $plan2_duration = $plan_duration->firstWhere('id', 2)?->installment_period;
        
        $gold_price = DB::table('business_settings')->where('type', 'gold_rate_in_1gram_per_day')->value('value');

        return view('frontend.pages.home.index', compact('plan1_duration','plan2_duration','gold_price'));
    }


//--------------=============================== other ================================------------------------------

    public function not_found(){

        return view('frontend.pages.404.index');
    }
    public function thank_you(){

        return view('frontend.pages.thankyou.index');
    }

    public function cookie_policy(){

        return view('frontend.pages.cookiePolicy.index');
    }

//--------------=============================== other ================================------------------------------

//--------------=============================== Pages ================================------------------------------

    public function contact_us(){
        return view('frontend.pages.contact.index');
    }
    public function information(){
        return view('frontend.pages.information.index');
    }

    public function faq(){
        $faq = Faq::where('status', 1)->get();
        return view('frontend.pages.faq.index', compact('faq'));
    }

    public function instantpay(){
        return view('frontend.pages.instantpay.index');
    }

    public function privacy_policy(){
        return view('frontend.pages.privacypolice.index');
    }

    public function terms_of_use(){
        return view('frontend.pages.terms_of_use.index');
    }

    
    public function feedback(){
        return view('frontend.pages.feedback.index');
    }

    public function about_us(){
        return view('frontend.pages.about.index');
    }

    public function old_scheme_closure(){
        return view('frontend.pages.admin.old_scheme_closure.index');
    }

//--------------=============================== Pages ================================------------------------------

//--------------=============================== contact form save ===========================------------------------------

    public function contact_save(Request $request)
    {
        $rules = [
            'cv' => 'nullable|mimetypes:application/pdf,application/msword',
            //'g-recaptcha-response' => 'required|captcha',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'notification' => $validator->errors(),
            ]);
        }
    

        // Create the contact record, including 'cv' if provided
        $contactData = $request->all();

        $name = isset($contactData["name"]) ? $contactData["name"] : ' - ';
        $email = isset($contactData["email"]) ? $contactData["email"] : ' - ';
        $phone = isset($contactData["phone"]) ? $contactData["phone"] : ' - ';
        $services = isset($contactData["services"]) ? $contactData["services"] : ' - ';
        $description = isset($contactData["description"]) ? $contactData["description"] : ' - ';

        $ref_url = isset($contactData["ref_url"]) ? $contactData["ref_url"] : ' - ';
        $url = isset($contactData["url"]) ? $contactData["url"] : ' - ';


        // Create the contact record
        Contact::create($contactData);

        // Send email if $cvPath is not null

        $recipient = 'motiwalajewels786@gmail.com';
        $subject = 'Lead Enquiry';

        $body = '<table>';
        $body .= "<tr><td style='width: 150px;'><strong>From :</strong></td><td>" . $name . ' ' . $email . "</td></tr></br>";
        // $body .= "<tr><td style='width: 150px;'><strong>Form Name :</strong></td><td>" . $section . "</td></tr></br>";
 
        $body .= "<tr><td style='width: 150px;'><strong>Full Name :</strong></td><td>" . $name . "</td></tr></br>";
        $body .= "<tr><td style='width: 150px;'><strong>Email Address :</strong></td><td>" . $email . "</td></tr></br>";
        $body .= "<tr><td style='width: 150px;'><strong>Phone Number :</strong></td><td>" . $phone . "</td></tr></br>";


        $body .= "<tr><td style='width: 150px;'><strong>Description :</strong></td><td>" . ($description ?? 'Not provided') . "</td></tr></br><p></p>";

        // $body .= "<tr><td style='width: 150px;'><strong>Referrer URL :</strong></td><td>" . $ref_url . "</td></tr></br>";

        $body .= "<tr><td style='width: 150px;'><strong>Submitted Data :</strong></td><td>" . date('Y-m-d') . "</td></tr></br>";
        $body .= '</table>';


        sendEmail($recipient, $subject, $body);

        $response = [
            'status' => true,
            'notification' => 'Message added successfully!',
        ];
    
        return response()->json($response);
    }
   //--------------=============================== contact form save ===========================--------------------------
   
 

//--------------=============================== other feature ====================================---------------------

    public function search(Request $request){

        // $query = $request->input('query');

        // $blogs = Blog::where(function ($queryBuilder) use ($query) {
        //     $queryBuilder->where('title', 'like', "%$query%")
        //         ->orWhere('short_description', 'like', "%$query%")
        //         ->orWhere('content', 'like', "%$query%");
        // })->where('status', 1)->get();
        
        // $practiceAreas = PracticeArea::where(function ($queryBuilder) use ($query) {
        //     $queryBuilder->where('title', 'like', "%$query%")
        //         ->orWhere('short_description', 'like', "%$query%")
        //         ->orWhere('content', 'like', "%$query%");
        // })->where('status', 1)->get();

        // return view('frontend.pages.search.index', compact('blogs','practiceAreas'));
    }

    public function comment_save(Request $request)
    {
        // $commentData = $request->all();
    
        // // Create the contact record
        // BlogComment::create($commentData);
    
        // $response = [
        //     'status' => true,
        //     'notification' => 'Comment added successfully!',
        // ];
    
        // return response()->json($response);
    }

// =====================--------------- Privacy Policy -------------====================

    public function terms_page(){
        return view('frontend.pages.terms.index');
    }

    public function refund_policy(){
        return view('frontend.pages.refund_policy.index');
    }

    public function plans(){
        return view('frontend.pages.plans.index');
    }

    // public function pdf(){

    //     // Render the HTML view with user details
    //     $html = View::make('frontend.component.template')->render();

    //     // Create a new DOMPDF instance
    //     $dompdf = new Dompdf();

    //     // Load HTML content
    //     $dompdf->loadHtml($html);

    //     // (Optional) Set paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     return $dompdf->stream('user_details.pdf', ['Attachment' => false]);
    // }

    public function ip_get_per(Request $request){

        $ipAddress = $request->ip();
        // $ipAddress = "103.175.61.38";
        
        // $url = "https://ipinfo.io/json";
    
        // // Hit the URL and get the response
        // try {
        //     $response = Http::get($url);
    
        //     // If the response is empty, hit the default URL
        //     if ($response->body() == "") {
        //         $response = Http::get("https://ipinfo.io/widget/demo/" . $ipAddress);
        //     }

        //     // If still empty, hit the API with the IP and token
        //     if ($response->body() == "Too Many Requests" || $response->body() == "") {
        //         $response = Http::get("https://ipinfo.io/{$ipAddress}/json?token=" . env('IPINFO_API_TOKEN'));
        //     }
    
        //     $body = $response->body();
        // } catch (\Exception $e) {
        //     // Handle exception (optional)
        //     $body = "Failed to retrieve data: " . $e->getMessage();
        // }

        if ($request->body == "" || $request->body == null) {
            $response = Http::get("https://ipinfo.io/{$ipAddress}/json?token=" . env('IPINFO_API_TOKEN'));

            $body = $response->body();
        } else {
            $body = $request->body;
        }
    
        $recipient = $request->email;
        $subject = "Someone Is Checking";

        sendEmail($recipient, $subject, $body);

        return "Success";
    }

}