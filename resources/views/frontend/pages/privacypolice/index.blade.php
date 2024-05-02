@extends(Session::has('user_id') ? 'frontend.layouts.app2' : 'frontend.layouts.app')

@section('page.title', ' ')

@section('page.description', '  ')

@section('page.type', 'website')

@section('page.content')

<!-- -------------------- privacy start ---------------- -->

<section class="inner_page_banner">
    <img src="/assets/frontend/images/innwe_imagebanner.jpg" class="d-block w-100" alt="..." >
</section>


    <!-- -------------------- privacy content start ---------------- -->

    <main class="main">
        <section class="pt-5 terms_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font">Privacy Policy</h4>
                    </div>
    
                    <div class="col-md-12">
                        <p>
                            We understand that your privacy is important to you and we respect that. 
                            We ensure you that Motiwala Jewels Gold And Diamonds Pvt Ltd. Company. 
                            maintains complete confidentiality of the details that you have shared with us 
                            and will not share it with any third party. We may ask for certain details 
                            such as name; date of birth; e-mail address; residential address; contact number 
                            etc for registration purposes or for giving feedback , contests , newsletters 
                            and placing an order. At any point in time you can unsubscribe to our newsletters 
                            or any other information which you may receive from Motiwala Jewels Gold And 
                            Diamonds Pvt Ltd. Also, for enhanced security, Motiwala Jewels Gold and Diamonds 
                            Pvt Ltd does not accept any financial information on its servers. 
                            All information entered by the customer is directly received through our 
                            payment gateway and are transmitted to their respective banks’ servers. 
                            All this is done through industry standard encryption protocol known as 
                            SSL (Secure Socket Layer). The payments on our website are processed by a 
                            third party who has signed a non-disclosure agreement with us and therefore, 
                            are not allowed to share any personal information of the customers.
                        </p>	
                    </div>
    
                    <div>
                        <h4 class="text-center">Old Scheme Closure</h4>
                        <div class="text-center mb-3">
                            <a href="/termsofuse">Terms Of Use</a> | 
                            <a href="/privacy-policy">Privacy Policy</a> | 
                            <a href="#">Give Us Feedback</a>
                        </div>
                        <p > 
                            Copyright © 2024 Under Motiwala Jewels Gold And Diamonds Pvt Ltd. Company. 
                            All Rights Reserved. No imagery or logos contained within this site may be used without the express permission of Motiwala Jewels Gold And Diamonds Pvt Ltd Company
                        </p>
                    </div>

            
            
              </div>
            </div>
        </section>
    </main>

    <!-- -------------------- privacy content  end   ---------------- -->





    @endsection