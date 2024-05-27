@php
$practice_Area = DB::table('practice_areas')->where('parent_id', null)->limit(4)->orderBy('id', 'asc')->get();
@endphp


<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-6">
        <div class="footer-widget" data-aos-once="true" data-aos="fade-up">
          <h3 class="widget-title">USEFUL LINKS</h3>
          <ul class="widget-menu">
            <li>
              <a href="{{ url(route('account.new.enrollment.page')) }}">
                <i class="las la-angle-right"></i> New Account </a>
            </li>
            <li>
              <a href="{{ url(route('instantpay')) }}">
                <i class="las la-angle-right"></i> Instant Pay </a>
            </li>
            
          </ul>
        </div>
      </div>


      <div class="col-lg-2 col-md-6">
        <div class="footer-widget" data-aos-once="true" data-aos="fade-up">
          <h3 class="widget-title">QUICK LINKS</h3>
          <ul class="widget-menu">
            <li>
              <a href="{{ url(route('information')) }}">
                <i class="las la-angle-right"></i> Information </a>
            </li>
            <li>
              <a href="{{ url(route('faq')) }}">
                <i class="las la-angle-right"></i> FAQ </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-lg-2 col-md-6">
        <div class="footer-widget" data-aos-once="true" data-aos="fade-up">
          <h3 class="widget-title">CONSUMER POLICY</h3>
          <ul class="widget-menu">

          <li>
              <a href="{{ url(route('terms_use')) }}"> <i class="las la-angle-right"></i> Term of Use</a>
            </li>
            <li>
              <a href="{{ url(route('privacy-policy')) }}"> <i class="las la-angle-right"></i> Privacy Policy</a>
            </li>
            <li>
              <a href="{{ url(route('feedback')) }}"> <i class="las la-angle-right"></i> Give Us Feedback</a>
            </li>
          </ul>
        </div>
      </div>



      <div class="col-lg-3 col-md-6">
        <div class="footer-widget" data-aos-once="true" data-aos="fade-up">
          <h3 class="heading_font line-height35">Download <br>Our App </h3>
          <p>Shining new app, made just for you! It's Free, Easy & Smart</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-app-image" data-aos-once="true" data-aos="fade-up">
          <img src="/assets/frontend/images/app_images.png" class="d-block w-100" alt="...">
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="footer-widget mt-5" data-aos-once="true" data-aos="fade-up">
          <p class="pb-0 mb-0">Contact Us: <a href="tel:1800-255-10234">1800-255-10234</a></p>
          <p>Email: <a href="mailto:care@motiwalasons.in">care@motiwalasons.in</a></p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6">
        <h6 class="font-alt mt-4 mb-3 heading_font font-size20" data-aos-once="true" data-aos="fade-up">Subscribe to our Newsletter</h6>
        <form class="form-subscribe" action="#">
          <div class="input-group" data-aos-once="true" data-aos="fade-up">
            <input type="text" class="form-control input-lg" placeholder="Write Your Email Address">
            <span class="input-group-btn">
              <button class="btn btn-success btn-lg" type="submit">Subscribe</button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="copyright_section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <ul>
            
          </ul>
        </div>
        <div class="col-md-4">
          <p class="text-center">Copyright © 2024 Under Motiwala & Sons</p>
        </div>
        <div class="col-md-4">
          <ul class="float_right">
            <li>
              <a href="">
                <i class="lab la-whatsapp"></i>
              </a>
            </li>
            <li>
              <a href="">
                <i class="lab la-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="">
                <i class="lab la-instagram"></i>
              </a>
            </li>
            <li>
              <a href="">
                <i class="lab la-twitter"></i>
              </a>
            </li>
            <li>Let's Get Together</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- forgot password modal popup open-->
@include('frontend.component.forgot_password_modal_form')
<!--- forgot password Modal Popup ------->

<!-- login modal popup open-->
@include('frontend.component.login_modal_form')
<!--- Login Modal Popup ------->





<!-- Auto Debit modal popup open-->
<div class="modal fade modal_popup_cls" id="autodebit_modal" aria-hidden="true" aria-labelledby="autodebit_modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title title_heading black_color heading_font" id="autodebit_modal">Auto Debit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group mt-4">
            <input type="text" class="form-control" name="account_number" placeholder="Account Number*" />
          </div>
          <div class="form-group mt-5">
            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number*" />
          </div>
          <div class="form-group">
            <div class="buttonclass1 mt60">
              <button type="button">Proceed <i class="las la-arrow-right"></i>
              </button>
            </div>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>