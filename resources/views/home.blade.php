@extends('home')

@section('content')  
  
 <!--header starts-->
        <header class="header transparent scroll-hide">
            <!--Main Menu starts-->
            <div class="site-navbar-wrap v2">
                <div class="container">
                    <div class="site-navbar">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-6">
                                <a class="navbar-brand" href="#"><img src="images/logo-red.png" alt="logo" class="img-fluid"></a>
                            </div>
                            <div class="col-md-8 col-6">
                                <nav class="site-navigation float-left">
                                    <div class="container">
                                        <ul class="site-menu js-clone-nav d-none d-lg-block">
                                            <li class="has-children">
                                                <a href="#">Home</a>
                                                <ul class="dropdown">
                                                    <li><a href="home-v1.html">Home Tab</a></li>
                                                    <li><a href="home-v2.html">Home Hero</a></li>
                                                    <li><a href="home-v3.html">Home Video</a></li>
                                                    <li><a href="home-v4.html">Home parallax</a></li>
                                                    <li><a href="home-v5.html">Home Classic</a></li>
                                                    <li><a href="home-v6.html">Home Map</a></li>
                                                    <li><a href="home-v7.html">Home Slider</a></li>
                                                    <li><a href="home-v8.html">Home Video Fullscreen</a></li>
                                                    <li><a href="home-v9.html">Home Hero Fullscreen</a></li>
                                                    <li><a href="home-v10.html">Home Map Fullscreen</a></li>
                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#">Listings</a>
                                                <ul class="dropdown">
                                                    <li class="has-children">
                                                        <a href="#">List Layout</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="list-fullwidth.html">Full Width</a></li>
                                                            <li><a href="list-fullwidth-map.html">Fullwidth with map</a></li>
                                                            <li><a href="list-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a href="list-right-sidebar.html">Right Sidebar</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">Grid Layout</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="grid-fullwidth.html">Full Width</a></li>
                                                            <li><a href="grid-fullwidth-map.html">Fullwidth with map</a></li>
                                                            <li><a href="grid-two-column.html">Grid two column</a></li>
                                                            <li><a href="grid-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a href="grid-right-sidebar.html">Right Sidebar</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">Map sidebar Layout</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="list-left-sidemap.html">List Left sidemap</a></li>
                                                            <li><a href="list-right-sidemap.html">List Right sidemap</a></li>
                                                            <li><a href="grid-left-sidemap.html">grid Left sidemap</a></li>
                                                            <li><a href="grid-right-sidemap.html">grid Right sidemap</a></li>
                                                           <li><a href="grid-search-half-map.html">advanced search</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">OpenStreet Map</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="grid-fullwidth-leaflet-map.html">Grid Fullwidth</a></li>
                                                            <li><a href="list-fullwidth-leaflet-map.html">List FullWidth</a></li>
                                                            <li><a href="grid-left-leaflet-sidemap.html">Grid Left Sidemap</a></li>
                                                            <li><a href="list-left-leaflet-sidemap.html">List Left Sidemap</a></li>
                                                            <li><a href="grid-right-leaflet-sidemap.html">Grid Right Sidemap</a></li>
                                                            <li><a href="list-right-leaflet-sidemap.html">List Right Sidemap</a></li>
                                                            <li><a href="grid-search-half-leaflet-map.html">Advance Map Search</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">Category Listings</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="all-categories.html">All Category</a></li>
                                                            <li><a href="all-locations.html">All Locations</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">Listing Details</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="single-listing-one.html">Single Listing one</a></li>
                                                            <li><a href="single-listing-two.html">Single Listing two</a></li>
                                                            <li><a href="single-listing-three.html">Single Listing three</a></li>
                                                            <li><a href="single-listing-four.html">Single Listing four</a></li>
                                                            <li><a href="single-listing-five.html">Single Listing five</a></li>

                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#">Pages</a>
                                                <ul class="dropdown">
                                                    <li><a href="about.html">About us</a></li>
                                                    <li><a href="contact.html">Contact us</a></li>
                                                    <li class="has-children">
                                                        <a href="#">News Layout</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="news-left-sidebar.html">News Left sidebar</a></li>
                                                            <li><a href="news-right-sidebar.html">News right sidebar</a></li>
                                                            <li><a href="news-without-sidebar.html">News without sidebar</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="has-children">
                                                        <a href="#">Single News Layout</a>
                                                        <ul class="dropdown sub-menu">
                                                            <li><a href="single-news-one.html">Single News one</a></li>
                                                            <li><a href="single-news-two.html">Single News two</a></li>
                                                            <li><a href="single-news-three.html">Single News three</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="404-page.html">404 error</a></li>
                                                    <li><a href="add-listing.html">Add Listing</a></li>
                                                    <li><a href="booking.html">Booking Page</a></li>
                                                    <li><a href="booking-confirmation.html">Booking Confirmation</a></li>
                                                    <li><a href="login.html">Login</a></li>
                                                    <li><a href="pricing-table.html">Pricing Table</a></li>
                                                    <li><a href="user-profile.html">User profile</a></li>
                                                    <li><a href="faq.html">FAQ</a></li>
                                                    <li><a href="invoice.html">invoice</a></li>

                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#">User Panel</a>
                                                <ul class="dropdown">
                                                    <li><a href="db.html">Dashboard</a></li>
                                                    <li><a href="db-my-listing.html">My Listings</a></li>
                                                    <li><a href="db-bookings.html">Bookings</a></li>
                                                    <li><a href="db-messages.html">Inbox</a></li>
                                                    <li><a href="db-favourites.html">Favourite Listing</a></li>
                                                    <li><a href="db-add-listing.html">Add Listing</a></li>
                                                    <li><a href="db-recieve-reviews.html">Reviews</a></li>
                                                    <li><a href="db-my-profile.html">User  Profile</a></li>
                                                    <li><a href="db-invoices.html">Invoices </a></li>

                                                </ul>
                                            </li>
                                            <li class="d-lg-none"><a class="btn v1" href="add-listing.html">Add Listing <i class="ion-plus-round"></i></a></li>
                                        </ul>
                                    </div>
                                </nav>
                                <div class="d-lg-none sm-right">
                                    <a href="#" class="mobile-bar js-menu-toggle">
                                        <span class="ion-android-menu"></span>
                                    </a>
                                </div>
                                <div class="add-list float-right">
                                    <a class="btn v8" href="add-listing.html">Add Listing <i class="ion-plus-round"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--mobile-menu starts -->
                    <div class="site-mobile-menu">
                        <div class="site-mobile-menu-header">
                            <div class="site-mobile-menu-close  js-menu-toggle">
                                <span class="ion-ios-close-empty"></span>
                            </div>
                        </div>
                        <div class="site-mobile-menu-body"></div>
                    </div>
                    <!--mobile-menu ends-->
                </div>
            </div>
            <!--Main Menu ends-->
        </header>
        <!--Header ends-->
        <!--Hero section starts-->
        <div class="hero v2 section-padding" style="background-image: url(images/header/hero-2.jpg)">
            <div class="overlay op-5"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="hero-title v2">
                            Explore Your City.
                        </h1>
                        <p class="hero-desc v2">
                            You can’t imagine, what is waiting for you around your city
                        </p>
                    </div>
                    <div class="col-md-12 text-center mar-top-20">
                        <form class="hero__form v2">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <input class="hero__form-input custom-select" type="text" name="place-event" id="place-event" placeholder="What are you looking for?">
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <select class="hero__form-input  custom-select">
                                        <option>Select Location </option>
                                        <option>New York</option>
                                        <option>California</option>
                                        <option>Washington</option>
                                        <option>New Jersey</option>
                                        <option>Los Angeles</option>
                                        <option>Florida</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <select class="hero__form-input  custom-select">
                                        <option>Select Categories</option>
                                        <option>Art's</option>
                                        <option>Health</option>
                                        <option>Hotels</option>
                                        <option>Real Estate</option>
                                        <option>Rentals</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <div class="submit_btn text-right md-left">
                                        <button class="btn v3  mar-right-5" type="submit"><i class="ion-search" aria-hidden="true"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-10 offset-md-1">
                        <div class="hero-catagory-menu text-center">
                            <p>Or browse Popular Categories</p>
                            <ul>
                                <li><a href="all-categories.html"><i class="ion-android-restaurant"></i> Restaurant</a></li>
                                <li><a href="all-categories.html"><i class="ion-ios-musical-notes"></i> Event</a></li>
                                <li><a href="all-categories.html"><i class="ion-ios-home-outline"></i> Hotel</a></li>
                                <li><a href="all-categories.html"><i class="ion-ios-cart-outline"></i> Shopping</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Hero section ends-->
        <!--Popular City starts-->
        <div class="popular-cities section-padding mar-top-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1">Explore Your Dream Places</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="swiper-container popular-place-wrap v2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide popular-item">
                                    <div class="single-place">
                                        <img class="single-place-image" src="images/category/france.jpg" alt="place-image">
                                        <div class="single-place-content">
                                            <h2 class="single-place-title">
                                                <a href="grid-fullwidth-map.html">France</a>
                                            </h2>
                                            <ul class="single-place-list">
                                                <li><span>5</span> Cities</li>
                                                <li><span>255</span> Listing</li>
                                            </ul>
                                            <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide popular-item">
                                    <div class="single-place">
                                        <img class="single-place-image" src="images/category/thailand.jpg" alt="place-image">
                                        <div class="single-place-content">
                                            <h2 class="single-place-title">
                                                <a href="grid-fullwidth-map.html">Thailand</a>
                                            </h2>
                                            <ul class="single-place-list">
                                                <li><span>5</span> Cities</li>
                                                <li><span>255</span> Listing</li>
                                            </ul>
                                            <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide popular-item">
                                    <div class="single-place">
                                        <img class="single-place-image" src="images/category/italy-5.jpg" alt="place-image">
                                        <div class="single-place-content">
                                            <h2 class="single-place-title">
                                                <a href="grid-fullwidth-map.html">Italy</a>
                                            </h2>
                                            <ul class="single-place-list">
                                                <li><span>5</span> Cities</li>
                                                <li><span>255</span> Listing</li>
                                            </ul>
                                            <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide popular-item">
                                    <div class="single-place">
                                        <img class="single-place-image" src="images/category/spain.jpg" alt="place-image">
                                        <div class="single-place-content">
                                            <h2 class="single-place-title">
                                                <a href="grid-fullwidth-map.html">Spain</a>
                                            </h2>
                                            <ul class="single-place-list">
                                                <li><span>5</span> Cities</li>
                                                <li><span>255</span> Listing</li>
                                            </ul>
                                            <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide popular-item">
                                    <div class="single-place">
                                        <img class="single-place-image" src="images/category/turkey.jpg" alt="place-image">
                                        <div class="single-place-content">
                                            <h2 class="single-place-title">
                                                <a href="grid-fullwidth-map.html">Turkey</a>
                                            </h2>
                                            <ul class="single-place-list">
                                                <li><span>5</span> Cities</li>
                                                <li><span>255</span> Listing</li>
                                            </ul>
                                            <a class="btn v6 explore-place" href="grid-fullwidth-map.html">Explore</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="slider-btn v1 popular-next style2"><i class="ion-arrow-right-c"></i></div>
                        <div class="slider-btn v1 popular-prev style2"><i class="ion-arrow-left-c"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <!--Popular City ends-->
        <!--Trending events starts-->
        <div class="trending-places section-padding pad-bot-130 bg-pn">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1">What's happening?</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="swiper-container trending-place-wrap">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide trending-place-item">
                                    <div class="trending-img">
                                        <img src="images/category/event/muay.jpg" alt="#">
                                        <span class="trending-rating-orange">6.5</span>
                                        <span class="save-btn"><i class="icofont-heart"></i></span>
                                    </div>
                                    <div class="trending-title-box">
                                        <h4><a href="single-listing-one.html">Muay Thai Live Show</a></h4>
                                        <div class="customer-review">
                                            <div class="rating-summary float-left">
                                                <div class="rating-result" title="60%">
                                                    <ul class="product-rating">
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="review-summury float-right">
                                                <p><a href="#">3 Reviews</a></p>
                                            </div>
                                        </div>
                                        <ul class="trending-address">
                                            <li><i class="ion-ios-location"></i>
                                                <p>1690 Brown Avenue,Barline</p>
                                            </li>
                                            <li><i class="ion-ios-telephone"></i>
                                                <p>+864-940-3419</p>
                                            </li>
                                            <li><i class="ion-android-globe"></i>
                                                <p>www.thaishow.com</p>
                                            </li>
                                        </ul>
                                        <div class="trending-bottom mar-top-15 pad-bot-30">
                                            <div class="trend-left float-left">
                                                <span class="round-bg green"><i class="icofont-movie"></i></span>
                                                <p><a href="#">Movie</a></p>
                                            </div>
                                            <div class="trend-right float-right">
                                                <div class="trend-open mar-top-5"><i class="ion-clock"></i> 2.30 pm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide trending-place-item">
                                    <div class="trending-img">
                                        <img src="images/category/event/photo1.jpg" alt="#">
                                        <span class="trending-rating-pink">6.5</span>
                                        <span class="save-btn"><i class="icofont-heart"></i></span>
                                    </div>
                                    <div class="trending-title-box">
                                        <h4><a href="single-listing-one.html">Carolina photo exibition</a></h4>
                                        <div class="customer-review">
                                            <div class="rating-summary float-left">
                                                <div class="rating-result" title="60%">
                                                    <ul class="product-rating">
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="review-summury float-right">
                                                <p><a href="#">10 Reviews</a></p>
                                            </div>
                                        </div>
                                        <ul class="trending-address">
                                            <li><i class="ion-ios-location"></i>
                                                <p>32 down Ave, North Carolina,USA</p>
                                            </li>
                                            <li><i class="ion-ios-telephone"></i>
                                                <p>+251 7336 8898</p>
                                            </li>
                                            <li><i class="ion-android-globe"></i>
                                                <p>www.photoexpo.com</p>
                                            </li>
                                        </ul>
                                        <div class="trending-bottom mar-top-15 pad-bot-30">
                                            <div class="trend-left float-left">
                                                <span class="round-bg pink"><i class="icofont-camera"></i></span>
                                                <p><a href="#">Photography</a></p>
                                            </div>
                                            <div class="trend-right float-right">
                                                <div class="trend-open mar-top-5"><i class="ion-clock"></i>5.00 pm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide trending-place-item">
                                    <div class="trending-img">
                                        <img src="images/category/event/coffee.jpg" alt="#">
                                        <span class="trending-rating-green">6.5</span>
                                        <span class="save-btn"><i class="icofont-heart"></i></span>
                                    </div>
                                    <div class="trending-title-box">
                                        <h4><a href="single-listing-one.html">European coffee expo </a></h4>
                                        <div class="customer-review">
                                            <div class="rating-summary float-left">
                                                <div class="rating-result" title="60%">
                                                    <ul class="product-rating">
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="review-summury float-right">
                                                <p><a href="#">7 Reviews</a></p>
                                            </div>
                                        </div>
                                        <ul class="trending-address">
                                            <li><i class="ion-ios-location"></i>
                                                <p>1301 Avenue, Brooklyn, NY 11230</p>
                                            </li>
                                            <li><i class="ion-ios-telephone"></i>
                                                <p>+44 20 7336 8898</p>
                                            </li>
                                            <li><i class="ion-android-globe"></i>
                                                <p>www.burgerandlobster.com</p>
                                            </li>
                                        </ul>
                                        <div class="trending-bottom mar-top-15 pad-bot-30">
                                            <div class="trend-left float-left">
                                                <span class="round-bg red"><i class="icofont-tea"></i></span>
                                                <p><a href="#">Eat &amp; Drink</a></p>
                                            </div>
                                            <div class="trend-right float-right">
                                                <div class="trend-open mar-top-5"><i class="ion-clock"></i> 10.30 am</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide trending-place-item">
                                    <div class="trending-img">
                                        <img src="images/category/event/3.jpg" alt="#">
                                        <span class="trending-rating-pink">6.5</span>
                                        <span class="save-btn"><i class="icofont-heart"></i></span>
                                    </div>
                                    <div class="trending-title-box">
                                        <h4><a href="single-listing-one.html">Bolton music fair </a></h4>
                                        <div class="customer-review">
                                            <div class="rating-summary float-left">
                                                <div class="rating-result" title="60%">
                                                    <ul class="product-rating">
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="review-summury float-right">
                                                <p><a href="#">3 Reviews</a></p>
                                            </div>
                                        </div>
                                        <ul class="trending-address">
                                            <li><i class="ion-ios-location"></i>
                                                <p>20 Hogh Street, Bolton, France</p>
                                            </li>
                                            <li><i class="ion-ios-telephone"></i>
                                                <p>+33 20 7336 8898</p>
                                            </li>
                                            <li><i class="ion-android-globe"></i>
                                                <p>www.bookmusic.com</p>
                                            </li>
                                        </ul>

                                        <div class="trending-bottom mar-top-15 pad-bot-30">
                                            <div class="trend-left float-left">
                                                <span class="round-bg green"><i class="icofont-music-alt"></i></span>
                                                <p><a href="#">Music</a></p>
                                            </div>
                                            <div class="trend-right float-right">
                                                <div class="trend-open mar-top-5"><i class="ion-clock"></i> 5.00 pm</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide trending-place-item">
                                    <div class="trending-img">
                                        <img src="images/category/event/sea6.jpg" alt="#">
                                        <span class="trending-rating-green">6.5</span>
                                        <span class="save-btn"><i class="icofont-heart"></i></span>
                                    </div>
                                    <div class="trending-title-box">
                                        <h4><a href="single-listing-one.html">Miami seafood show</a></h4>
                                        <div class="customer-review">
                                            <div class="rating-summary float-left">
                                                <div class="rating-result" title="60%">
                                                    <ul class="product-rating">
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                        <li><i class="ion-android-star-half"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="review-summury float-right">
                                                <p><a href="#">3 Reviews</a></p>
                                            </div>
                                        </div>
                                        <ul class="trending-address">
                                            <li><i class="ion-ios-location"></i>
                                                <p>400 NW North River Dr, Miami, USA</p>
                                            </li>
                                            <li><i class="ion-ios-telephone"></i>
                                                <p>+00 20 536 551</p>
                                            </li>
                                            <li><i class="ion-android-globe"></i>
                                                <p>www.opentable.com</p>
                                            </li>
                                        </ul>
                                        <div class="trending-bottom mar-top-15 pad-bot-30">
                                            <div class="trend-left float-left">
                                                <span class="round-bg green"><i class="icofont-restaurant"></i></span>
                                                <p><a href="#">Eat &amp; Drink</a></p>
                                            </div>
                                            <div class="trend-right float-right">
                                                <div class="trend-right float-right">
                                                    <div class="trend-open mar-top-5"><i class="ion-clock"></i> 9.00 am</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="trending-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--Trending events ends-->
        <!--Popular Category starts-->
        <div class="popular-catagory pad-bot-50 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1">Explore What To do</h2>
                    </div>
                    <div class="col-md-4">
                        <a href="#">
                            <div class="popular-catagory-content">

                                <div class="popular-catagory-img">
                                    <img src="images/category/cat-1.jpg" alt="hotel" class="img_fluid">
                                </div>
                                <div class="cat-content">
                                    <h4 class="title">Hotel</h4>
                                    <span>23 Listings</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <a href="#">
                            <div class="popular-catagory-content">
                                <div class="popular-catagory-img">
                                    <img src="images/category/cat-2.jpg" alt="hotel" class="img_fluid">
                                </div>
                                <div class="cat-content">
                                    <h4 class="title">Shopping</h4>
                                    <span>15 Listings</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-8">
                        <a href="#">
                            <div class="popular-catagory-content">
                                <div class="popular-catagory-img">
                                    <img src="images/category/cat-3.jpg" alt="restaurent" class="img_fluid">
                                </div>
                                <div class="cat-content">
                                    <h4 class="title">Eat &amp; Drink</h4>
                                    <span>34 Listings</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#">
                            <div class="popular-catagory-content">
                                <div class="popular-catagory-img">
                                    <img src="images/category/cat-4.jpg" alt="hotel" class="img_fluid">
                                </div>
                                <div class="cat-content">
                                    <h4 class="title">Travel</h4>
                                    <span>20 Listings</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--Popular Category ends-->
        <!--Work-process starts-->
        <div class="work-process pad-bot-90 section-padding" style="background-image: url(images/others/dots-bg.svg)">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1">See How It Works</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="work-process-content v1 text-center">
                            <div class="process-icon v1">
                                <img src="images/others/1.png" alt="...">
                                <span>1</span>
                            </div>
                            <h4 class="title">Explore The City</h4>
                            <p class="info">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique iste aliquam possimus, quaerat aut veritatis minima atque quam. Placeat, molestiae?
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="work-process-content v1 text-center">
                            <div class="process-icon v1">
                                <img src="images/others/2.png" alt="...">

                                <span>2</span>

                            </div>
                            <h4 class="title">Find The Best Place</h4>
                            <p class="info">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique iste aliquam possimus, quaerat aut veritatis minima atque quam. Placeat, molestiae?
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="work-process-content v1 text-center">
                            <div class="process-icon v1">
                                <img src="images/others/3.png" alt="...">

                                <span>3</span>
                            </div>
                            <h4 class="title">Add Your Listing</h4>
                            <p class="info">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique iste aliquam possimus, quaerat aut veritatis minima atque quam. Placeat, molestiae?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Work-process ends-->
        <!--Coupon starts-->
        <div class="coupon-section section-padding">
            <div class="container ">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1"> Coupons &amp; Deals</h2>
                    </div>
                    <div class="col-md-12">
                        <div class="swiper-container coupon-wrap">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide coupon-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="coupon-img">
                                                <img class="img-fluid" src="images/category/coupon/3.jpg" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="coupon-desc float-right">
                                                <h4>30% Discount</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="coupon-owner mar-top-20">
                                                <a href="store.html">Favola Restaurant</a>
                                                <a href="#" class="rating">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star-half"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-left">
                                                <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                                    Get Coupon
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide coupon-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="coupon-img">
                                                <img class="img-fluid" src="images/category/coupon/5.jpg" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="coupon-desc float-right">
                                                <h4>20% Off</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="coupon-owner mar-top-20">
                                                <a href="store.html">Orion Spa</a>
                                                <a href="#" class="rating">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star-half"></i>
                                                    <i class="ion-android-star-half"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-left">
                                                <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                                    Get Coupon
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="swiper-slide coupon-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="coupon-img">
                                                <img class="img-fluid" src="images/category/coupon/4.jpg" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="coupon-desc float-right">
                                                <h4>25% Discount</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="coupon-owner mar-top-20">
                                                <a href="store.html">Hotel La Muro</a>
                                                <a href="#" class="rating">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star-half"></i>
                                                    <i class="ion-android-star-half"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-left">
                                                <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                                    Get Coupon
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide coupon-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="coupon-img">
                                                <img class="img-fluid" src="images/category/coupon/1.jpg" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="coupon-desc float-right">
                                                <h4>50% OFF</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id porta leo.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="coupon-owner mar-top-20">
                                                <a href="store.html">Penguin Shop</a>
                                                <a href="#" class="rating">
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star"></i>
                                                    <i class="ion-android-star-half"></i>
                                                    <i class="ion-android-star-half"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-left">
                                                <a class="btn v1" data-toggle="modal" data-target="#coupon_wrap">
                                                    Get Coupon
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="slider-btn v1 coupon-next"><i class="ion-arrow-right-c"></i></div>
                        <div class="slider-btn v1 coupon-prev"><i class="ion-arrow-left-c"></i></div>
                        <div class="modal fade" id="coupon_wrap">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Get a Coupon</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="ion-ios-close-empty"></i></span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-coupon-code">
                                            <div class="store-content">
                                                <div class="text">
                                                    Stores :
                                                    <span> La Poma ,</span>
                                                    <span>Gucci</span>
                                                </div>
                                                <div class="store-content">Cashback : <span>25% cashback </span></div>
                                                <div class="store-content">Valid till : <span>25-5-2019 </span></div>
                                                <div class="cashback-text">
                                                    <p>Cashback will be added in your wallet in next 5 Minute of your purchase.</p>
                                                </div>
                                            </div>
                                            <div class="coupon-code">
                                                <h5>
                                                    Coupon Code: <span class="coupon-code-wrapper">
                                                        <i class="fa fa-scissors"></i>
                                                        12345
                                                    </span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="coupon-bottom">
                                        <div class="float-left"><a href="single-listing-one.html" class="btn v1">Go to Deal</a></div>
                                        <button type="button" class="btn v1 float-right" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Coupon ends-->
        <!--Blog Posts starts-->
        <div class="blog-posts v1 pad-bot-60 pad-top-70">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2 text-center">
                        <h2 class="section-title v1">Popular Posts</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card single-blog-item v1">
                            <img src="images/blog/news_7.jpg" alt="...">
                            <a href="#" class="blog-cat btn v6 red">Hotel</a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="single-news-one.html">Top 10 Homestay in London That you don't miss out</a></h4>
                                <div class="bottom-content">
                                    <p class="date">Sep 28th , 2018 by <a href="#" class="text-dark">Louis Fonsi</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card single-blog-item v1">
                            <img src="images/blog/news_8.jpg" alt="...">
                            <a href="#" class="blog-cat btn v6 red">Restaurant</a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="single-news-one.html">Cappuccino Coffee at Broklyn for Coffee Lover.</a></h4>
                                <div class="bottom-content">
                                    <p class="date">Dec 5th , 2018 by <a href="#" class="text-dark">Adam D'Costa</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card single-blog-item v1">
                            <img src="images/blog/news_9.jpg" alt="...">
                            <a href="#" class="blog-cat btn v6 red">Travel</a>
                            <div class="card-body">
                                <h4 class="card-title"><a href="single-news-one.html">Top 50 Greatest Street Arts in Paris</a></h4>
                                <div class="bottom-content">
                                    <p class="date">Mar 13th , 2018 by <a href="#" class="text-dark">Mark Henri</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
            
@stop

