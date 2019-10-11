<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <!-- Metas -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LionCoders" />
    <!-- Links -->
    <link rel="icon" type="image/png" href="#" />
    <!-- google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
    <!-- Plugins CSS -->
     <link href="{{asset("css/app.css")}}" rel="stylesheet" />
   
    <title>listagram - Directory Listing HTML Template</title>
</head>  

<body>
   <!--Preloader starts-->
    <div class="preloader js-preloader">
        <img src="images/preloader.gif" alt="...">
    </div>
    <!--Preloader ends-->
    <!--Page Wrapper starts-->
    <div class="page-wrapper">
               @yield('content')
    </div>
    
        <!--Blog Posts ends-->
      <!-- Scroll to top starts-->
        <span class="scrolltotop"><i class="ion-arrow-up-c"></i></span>
        <!-- Scroll to top ends-->
    <!--Page Wrapper ends-->
    <!--Footer Starts-->
    <div class="footer-wrapper no-pad-tb v2">
        <div class="footer-top-area section-padding">
            <div class="container">
                <div class="row nav-folderized">
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-logo">
                            <a href="index.html"> <img src="images/logo-red.png" alt="logo"></a>
                            <div class="company-desc">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio excepturi nam totam sequi, ipsam consequatur repudiandae libero illum.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-content nav">
                            <h2 class="title">Helpful Links</h2>
                            <ul class="list">
                                <li><a class="link-hov style2" href="#">Login</a></li>
                                <li><a class="link-hov style2" href="#">My Account</a></li>
                                <li><a class="link-hov style2" href="#">Add Listing</a></li>
                                <li><a class="link-hov style2" href="#">Privacy policy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-content nav">
                            <h2 class="title">Category</h2>
                            <ul class="list">
                                <li><a class="link-hov style2" href="#">Shop</a></li>
                                <li><a class="link-hov style2" href="#">Travel</a></li>
                                <li><a class="link-hov style2" href="#">Sport</a></li>
                                <li><a class="link-hov style2" href="#">Restaurant</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="footer-content nav">
                            <h2 class="title">Contact us</h2>
                            <ul class="list footer-list">
                                <li>
                                    <div class="contact-info">
                                        <div class="icon">
                                            <i class="ion-ios-location"></i>
                                        </div>
                                        <div class="text">13th North Ave, Florida, USA</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-info">
                                        <div class="icon">
                                            <i class="ion-email"></i>
                                        </div>
                                        <div class="text"><a href="#">info@listagram.com</a></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-info">
                                        <div class="icon">
                                            <i class="ion-ios-telephone"></i>
                                        </div>
                                        <div class="text">+44 078 767 595</div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="social-buttons style2">
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                                <li><a href="#"><i class="ion-social-youtube"></i></a></li>
                                <li><a href="#"><i class="ion-social-dribbble"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="payment-method">
                            <img src="images/payment/payment-1.png" alt="...">
                            <img src="images/payment/payment-2.png" alt="...">
                            <img src="images/payment/payment-3.png" alt="...">
                        </div>
                    </div>
                    <div class="col-md-6 text-right sm-left">
                        <ul class="additional-link">
                            <li><a href="#">Terms &amp; Condition</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="login.html">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer ends-->
   <!--Color switcher starts-->
 
    <!--Color switcher ends-->
    <!--Scripts starts-->
    <!--plugin js-->
    <script src="js/plugin.js"></script>
    <!--google maps-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_8C7p0Ws2gUu7wo0b6pK9Qu7LuzX2iWY&amp;libraries=places&amp;callback=initAutocomplete"></script>
    <!--Main js-->
    <script src="js/main.js"></script>
    <!--Scripts ends-->
</body>

</html>