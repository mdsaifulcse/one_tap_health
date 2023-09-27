@extends('client.layout.app')
@section('title')
    Home - One Tap Health
@endsection

@section('main-content')

    <!-- Dark Version Btn -->
    <div class="dark-version-btn">
        <label id="switch" class="switch">
            <input type="checkbox" onchange="toggleTheme()" id="slider">
            <span class="slider round"></span>
        </label>
    </div>

    <!-- Start Page Title Area -->
    <div class="page-title bg-f9faff">
        <div class="container">
            <h3>Terms & Condition - One Tab Health</h3>
        </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start News Area -->
    <section class="blog-details-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="blog-details">
                        <!-- <div class="thumb">
                            <img src="assets/img/blog-details.jpg" alt="details">

                            <div class="date">
                                <span>12 Dec</span>
                            </div>
                        </div>

                        <div class="blog-details-heading">
                            <h3>Risus commodo viverra maecenas accumsan lacus vel facilisis.</h3>
                            <ul>
                                <li>Posted By: <a href="#">Admin</a></li>
                                <li><a href="#"><i class="icofont-comment"></i> 05</a></li>
                                <li><a href="#"><i class="icofont-thumbs-up"></i> 15</a></li>
                            </ul>
                        </div> -->

                        <div class="blog-details-content">
                            <h6><strong> শর্তাবলী</strong></h6>
                            <p>নিম্নলিখিত নিয়ম ও শর্তাবলী (T&C) <strong>OneTapHealth</strong> অ্যাপ-এ আপনার প্রবেশ এবং ব্যবহার নিয়ন্ত্রণ করে৷ এই শর্তাবলী আপনার এবং OneTapHealth লিমিটেডের মধ্যে একটি চুক্তি তৈরি করছে৷ আপনার বয়স ১৮ বছরের কম হয়ে থাকলে, আপনি এতদ্বারা নিশ্চিত করছেন যে, এই প্ল্যাটফর্মটি ব্যবহার করার জন্য আপনার বাবা-মা বা আইনী অভিভাবকের অনুমতি রয়েছে৷ এই প্ল্যাটফর্মটি ব্যবহার শুরু করার আগে দয়া করে এই শর্তাবলী সাবধানতার সাথে পড়ুন৷ "সম্মত/মেনে নিন"- এ ক্লিক করার মাধ্যমে আপনি সব সময় এই নিয়ম এবং শর্তাবলী দ্বারা আবদ্ধ হতে সম্মত হবেন। নিয়ম এবং শর্তাবলীতে সম্মত না হলে আপনাকে প্ল্যাটফর্মটি ব্যবহার করার জন্য অগ্রহণযোগ্য হিসেবে গণ্য করা হবে।</p>

                            <br>
                            <h6><strong>পেমেন্ট পদ্ধতি</strong></h6>
                            <br>
                            <ul>
                                <li>১. প্ল্যাটফর্মটি শুধুমাত্র পরিষেবাগুলির বিনিময়ে সমস্ত আর্থিক লেনদেন পরিচালনা করবে৷</li>

                                <li>২. পরিষেবাগুলির জন্য অর্থপ্রদান শুধুমাত্র প্ল্যাটফর্মের পেমেন্ট গেটওয়ের মাধ্যমে গৃহীত হবে৷</li>

                                <li>৩. পরিষেবাগুলির জন্য অর্থপ্রদান শুধুমাত্র প্ল্যাটফর্মের পেমেন্ট গেটওয়ের মাধ্যমে গৃহীত হবে৷</li>
                            </ul>
                            <br>

                            <h6><strong>রিফান্ড  পদ্ধতি</strong></h6>
                            <br>
                            <ul>
                                <li>১. যেকোনো বাতিল এবং ফেরতের জন্য অনুগ্রহ করে ইমেল করুন: refund@onetaphealth.com</li>
                                <li>২. ফেরত প্রক্রিয়া সম্পন্ন করতে ৭ থেকে ১০ কার্যদিবস পর্যন্ত সময় লাগতে পারে।</li>
                            </ul>

                            <br>
                            <h6><strong>সেবাসমূহ</strong></h6>
                            <br>
                            <p>১. তথ্য ও যোগাযোগ প্রযুক্তি ব্যবহার করে (পরিষেবাগুলি) যাদের চিকিৎসা সেবা (রোগীদের) প্রয়োজন, প্ল্যাটফর্মটি তাদের জন্য একটি প্রযুক্তি প্ল্যাটফর্ম হিসেবে গঠিত হয়েছে, স্বাস্থ্যসেবা এবং স্বাস্থ্য-সম্পর্কিত পরিষেবাগুলিকে সহজ করে। OneTapHealth মোবাইল অ্যাপ্লিকেশনের ব্যবহারকারীরা এখানে প্রদত্ত শর্তাবলী এবং প্রযোজ্য আইন সাপেক্ষে প্ল্যাটফর্মের মাধ্যমে পরিষেবাগুলি গ্রহণ করতে সক্ষম হবেন। তাছাড়া, ডাক্তাররা তথ্য ও যোগাযোগ প্রযুক্তি আইন, ২০০৬; ডিজিটাল নিরাপত্তা আইন, ২০১৮ এবং রোগীর গোপনীয়তা ও গোপনীয়তা রক্ষা ও রোগীর ব্যক্তিগত যেকোনো তথ্য তৃতীয় পক্ষের কাছে হস্তান্তর ও স্থানান্তরের বিষয়ে সময়ে সময়ে প্রণীত যেকোনো প্রযোজ্য নিয়মের প্রাসঙ্গিক বিধানগুলো মেনে চলবেন।</p>
                            <br>

                            <p>২. <strong>OneTapHealth</strong> পরিষেবাগুলি সম্পাদন করার জন্য রোগীর রেকর্ড এবং তথ্যের আদান-প্রদান, প্রেসক্রিপশন এবং প্রতিদান, স্বাস্থ্য শিক্ষা, কাউন্সেলিং ইত্যাদি নির্দেশিকা, আচরণবিধি এবং এই জাতীয় অন্যান্য আইন ও প্রবিধান বাংলাদেশের চিকিৎসা পেশাজীবীদের জন্য প্রযোজ্য সঠিক চিকিৎসা অনুশীলনের অনুসরণ করবেন এবং ডাক্তার-রোগী সম্পর্ক, মূল্যায়ন, ব্যবস্থাপনা এবং চিকিৎসা, অবহিত সম্মতি, যত্নের ধারাবাহিকতা, জরুরি পরিষেবার জন্য রেফারেল, মেডিকেল রেকর্ড, গোপনীয়তা এবং সুরক্ষা সম্পর্কিত নিয়ম এবং প্রোটোকলগুলি অনুসরণ করবেন।</p>

                            <br>
                            <p>৩. <strong>OneTapHealth</strong> অ্যাপটি ডাক্তারের অ্যাপয়েন্টমেন্ট নেয় এবং ব্যবহারকারীকে অবহিত করে। ব্যবহারকারীকে অবশ্যই ডাক্তারের সাথে অ্যাপয়েন্টমেন্টের সময় দেখা করতে হবে।যদি কোনো রোগী নির্ধারিত সময়ে ডক্টরের সাথে দেখা করতে ব্যর্থ হয় সেক্ষেত্রে এপয়েন্টমেনটি বাতিল হবে .</p>

                            <br>

                            <p> ৪.<strong>OneTapHealth</strong>  বিভিন্ন হাসপাতালের প্যাথলজী টেস্টের তথ্য দেয় যা সে সকল হাসপাতালের কর্র্তৃপক্ষ দ্বারা যাচাই করা হয়।  যদি কোনো তথ্যগত ভুল থাকে সেক্ষেত্রে OneTapHealth রোগীর অর্ডারটি পরিশোধন করে দিতে বাধ্য  থাকিবে বা রোগী চাইলেই তা বাতিল হিসেবে জোগ্য হবে.
                                ৫. উপরোক্ত সত্ত্বেও, <strong>OneTapHealth</strong> যেকোনো কারণে আপনার অ্যাকাউন্ট স্থগিত বা স্থায়ীভাবে নিষিদ্ধ করার অধিকারও সংরক্ষণ করে।
                                ৬. প্ল্যাটফর্মের সুনামকে ক্ষতিগ্রস্ত করতে বা প্ল্যাটফর্মকে অবাঞ্ছিত বা প্রতিকূল প্রচারের দিকে পরিচালিত করার উদ্দেশ্যে সম্ভাব্য যেকোনো পদক্ষেপ নেওয়া থেকে আপনি বিরত থাকবেন৷
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End News Area -->

    @endsection
