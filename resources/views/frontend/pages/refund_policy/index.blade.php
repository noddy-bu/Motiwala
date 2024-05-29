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
        <section class="pt-5 pb80 terms_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title_heading text-center black_color pb-0 heading_font pb-3">Refund Policy</h4>
                    </div>
    
                    <div class="col-md-12">
                    <p>
                        We understand that your privacy is important to you, and we respect that.
                        Motiwala Jewels Gold And Diamonds Pvt Ltd. Company ensures complete confidentiality 
                        of the details you share with us and does not disclose them to any third party. 
                        We may request certain details such as name, date of birth, email address, 
                        residential address, and contact number for registration purposes, feedback, 
                        contests, newsletters, or placing an order.
                    </p>

                    <p>
                        You can unsubscribe from our newsletters or any other information you receive 
                        from Motiwala Jewels Gold And Diamonds Pvt Ltd. at any time. For enhanced security, 
                        Motiwala Jewels Gold and Diamonds Pvt Ltd. does not accept any financial information 
                        on its servers. All information provided by the customer is directly received through 
                        our payment gateway and transmitted to their respective banks' servers using 
                        industry-standard encryption protocols known as SSL (Secure Socket Layer).
                    </p>

                    <p>
                        Payments on our website are processed by a third party that has signed a 
                        non-disclosure agreement with us and is therefore not permitted to share 
                        any personal customer information.
                    </p>
	
                    </div>
    
                         
            
              </div>
            </div>
        </section>
    </main>

    <!-- -------------------- privacy content  end   ---------------- -->





    @endsection