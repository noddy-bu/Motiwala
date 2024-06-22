

<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-6">
        <div class="footer-widget">
          <h3 class="widget-title">USEFUL LINKS</h3>
          <ul class="widget-menu">
            <li>
              <a href="{{ url(route('about_us')) }}">
                <i class="las la-angle-right"></i> About Us </a>
            </li>

            <li>
              <a href="{{ url(route('faq')) }}">
                <i class="las la-angle-right"></i> FAQ </a>
            </li>

             <li>
              <a href="{{ url(route('information')) }}">
                <i class="las la-angle-right"></i> Information </a>
            </li>
             <li>
              <a href="contact-us">
                <i class="las la-angle-right"></i> Contact Us </a>
            </li>
            
          </ul>
        </div>
      </div>


      <div class="col-lg-2 col-md-6">
        <div class="footer-widget">
          <h3 class="widget-title">QUICK LINKS</h3>
          <ul class="widget-menu">
            <li>
              <a href="{{ url(route('account.new.enrollment.page')) }}">
                <i class="las la-angle-right"></i> New Account </a>
            </li>           
           
             <li>
              <a href="{{ url(route('feedback')) }}"> <i class="las la-angle-right"></i> Give Us Feedback</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-lg-2 col-md-6 pt-lg-0 pt-0 pt-md-5">
        <div class="footer-widget">
          <h3 class="widget-title">CONSUMER POLICY</h3>
          <ul class="widget-menu">

          <li>
              <a href="terms-conditions"> <i class="las la-angle-right"></i> Terms Conditions</a>
            </li>
            <li>
              <a href="{{ url(route('privacy-policy')) }}"> <i class="las la-angle-right"></i> Privacy Policy</a>
            </li>
<li>
              <a href="refund-policy"> <i class="las la-angle-right"></i> Refund Policy</a>
            </li>
            
           
          </ul>
        </div>
      </div>



      <div class="col-lg-3 col-md-6 pt-lg-0 pt-0 pt-md-4">
        <div class="footer-widget">
          <h3 class="heading_font line-height35">Download <br>Our App </h3>
          <p class="d-md-block d-none">Shining new app, made just for you! It's Free, Easy & Smart</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="footer-app-image">
          <img src="/assets/frontend/images/app_images.png" class="d-block w-100" alt="...">
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="footer-widget mt-md-5 mt-3">
          <p class="pb-0 mb-0"><strong> Contact Us: </strong> <a href="tel:+91 9920077780">+91 9920077780</a></p>
          <p><strong>Email: </strong> <a href="mailto:motiwalajewels786@gmail.com">motiwalajewels786@gmail.com</a></p>
        </div>
      </div>
      <div class="col-lg-5 col-md-6">
        <h6 class="font-alt mt-md-4 mt-2 mb-3 heading_font font-size20">Subscribe to our Newsletter</h6>
        <form class="form-subscribe" action="#">
          <div class="input-group">
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
      <div class="row flex-md-row flex-column-reverse gap-md-0 gap-2">
       
        <div class="col-md-6">
          <p class="text-md-start text-center mb-1 mb-md-3">Copyright © 2024 Under Motiwala & Sons</p>
        </div>
        <div class="col-md-6 text-md-end text-center footer_social">
          <ul class="float_right">
            <li>
              <a target="_blank" href="https://api.whatsapp.com/send?phone=+919920077780&text=Hi%2C+I+am+contacting+you+through+your+website+from+desktop+view+https%3A%2F%2Fhttps://motiwalajewels.in/%2F">
                <i class="lab la-whatsapp"></i>
              </a>
            </li>
            <li>
              <a target="_blank" href="https://www.facebook.com/MOTIWALA.JEWELS">
                <i class="lab la-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="">
                <i class="lab la-instagram"></i>
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
          <div class="form-group mt-md-4 mt-3">
            <input type="text" class="form-control" name="account_number" placeholder="Account Number*" />
          </div>
          <div class="form-group mt-md-5 mt-4 pt-0">
            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number*" />
          </div>
          <div class="form-group text-md-start text-center">
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