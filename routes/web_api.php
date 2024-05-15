<?php

use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\OtherApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebApi\Auth\LoginController;
use App\Http\Controllers\WebApi\Auth\RegisterController;
use App\Http\Controllers\WebApi\CourseController;
use App\Http\Controllers\WebApi\MainController;
use App\Http\Controllers\WebApi\PaymentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('countries', [MainController::class, 'countries']);
Route::get('states',    [MainController::class, 'states']);
Route::get('cities',    [MainController::class, 'cities']);

Route::get('course/languages',  [MainController::class, 'CourseLanguages']);
Route::get('categories',     [MainController::class, 'homeCategories']);
Route::get('all-categories', [MainController::class, 'homeAllCategories']);
Route::get('course/filter',       [CourseController::class, 'filteredCourses']);
Route::get('featured/course',     [CourseController::class, 'featuredCourses']);
Route::get('top-discounted/course', [CourseController::class, 'topDiscountedCourses']);
Route::get('recent/course',       [CourseController::class, 'recentCourses']);
Route::get('best-selling/course', [CourseController::class, 'bestSellingCourses']);
Route::get('free/course',           [CourseController::class, 'freeCourses']);
Route::get('record/course',           [CourseController::class, 'recordCourses']);
Route::get('online/course',           [CourseController::class, 'onlineCourses']);
Route::get('about-us',   [MainController::class, 'aboutus']);
Route::get('blog',       [MainController::class, 'blog']);
Route::get('home_blog',  [MainController::class, 'home_blog']);
Route::get('blogdetail', [MainController::class, 'blogdetail']);
Route::get('faq',        [MainController::class, 'faq']);
Route::get('policy',     [MainController::class, 'terms']);
Route::get('deals',      [MainController::class, 'deals']);
Route::get('instructors/home',  [MainController::class, 'homeInstructors']);
Route::get('instructors/all',   [MainController::class, 'allInstructors']);
Route::get('instructor/get',    [MainController::class, 'instructor']);
Route::get('course/instructor', [MainController::class, 'courseInstructor']);
Route::get('bundle/course',           [CourseController::class, 'bundleCourses']);
Route::get('all-recent/course',       [CourseController::class, 'allRecentCourses']);
Route::get('all-featured/course',     [CourseController::class, 'allFeaturedCourses']);
Route::get('all-best-selling/course', [CourseController::class, 'allBestSellingCourses']);
Route::get('all-free/course',         [CourseController::class, 'allFreeCourses']);
Route::get('all-top-discounted/course', [CourseController::class, 'allTopDiscountedCourses']);
Route::get('all-bundle/course',         [CourseController::class, 'allBundleCourses']);
Route::get('all-record/course',         [CourseController::class, 'allRecordCourses']);
Route::get('all-online/course',         [CourseController::class, 'allOnlineCourses']);

Route::get('course/details',  [CourseController::class, 'courseDetails']);
Route::get('course/chapters', [CourseController::class, 'courseChpaters']);

Route::get('bundle/details',  [CourseController::class, 'bundleDetails']);



// Route::middleware(['ip_block'])->group(function () {
// Route::middleware(['corsMiddleware'])->group(function () {
Route::post('/login',         [LoginController::class, 'login']);
Route::post('register',       [RegisterController::class, 'register']);
Route::post('forgotpassword', [LoginController::class, 'forgotApi']); // 1
Route::post('verifycode',     [LoginController::class, 'verifyApi']); // 2
Route::post('resetpassword',  [LoginController::class, 'resetApi']); // 3

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout',         [LoginController::class, 'logoutApi']);
    Route::post('join_us',      [RegisterController::class, 'instructor']);
    Route::get('my-courses',    [CourseController::class, 'myCourses']);
    Route::get('my-allcourses', [CourseController::class, 'myAllCourses']);

    Route::post('follow',    [MainController::class, 'follow']);
    Route::post('unfollow',  [MainController::class, 'unfollow']);

    Route::get('course/progress',         [CourseController::class, 'courseProgress']);
    Route::post('course/progress/update', [CourseController::class, 'courseprogressupdate']);
    Route::get('course/googleMeetings',   [CourseController::class, 'courseGoogleMeetings']);
    Route::get('course/announcement',     [CourseController::class, 'courseAnnouncements']);
    Route::get('course/previousPapers',   [CourseController::class, 'coursePrevPapers']);
    Route::post('course/assignment',      [CourseController::class, 'submetAssignment']);
    Route::get('course/myAssignments',    [CourseController::class, 'myAssignments']);
    Route::post('course/assignment/delete',    [CourseController::class, 'deleteAssignment']);
    Route::post('review/submit',     [CourseController::class, 'submetReview']);
    Route::post('quiz/submit',       [CourseController::class, 'quizsubmit']);
    Route::get('quiz/reports/{id}',  [CourseController::class, 'quizReports']);
    Route::get('quiz/get',           [CourseController::class, 'getQuiz']);
    Route::get('course/quizzes',     [CourseController::class, 'courseQuizzes']);
    Route::post('question/submit',   [CourseController::class, 'submetQuestion']);
    Route::delete(' /delete/{id}',   [CourseController::class, 'deleteQuestion']);
    Route::get('course/questions',   [CourseController::class, 'courseQuestions']);
    Route::get('course/user-questions', [CourseController::class, 'userQuestions']);

    Route::post('answer/submit',  [CourseController::class, 'answer']);
    Route::delete('answer/delete/{id}',  [CourseController::class, 'deleteAnswer']);

    Route::post('course/report',    [MainController::class, 'reportCourse']);
    Route::post('question/report',  [MainController::class, 'reportQuestion']);
    Route::post('review/report',    [MainController::class, 'reportReview']);

    //wishlist
    Route::post('addtowishlist',   [MainController::class, 'addToWishlist']);
    Route::post('remove/wishlist', [MainController::class, 'removeWishlist']);
    Route::get('wishlist/course',  [CourseController::class, 'showWishlist']);

    //newNotifications
    Route::get('user-notifications',         [MainController::class, 'userNotifications']);
    Route::get('unread-notifications-count', [MainController::class, 'unreadNotificationsCount']);
    Route::post('edit-notifications-status', [MainController::class, 'editNotificationsStatus']);
    Route::post('delete-notification',     [MainController::class, 'deleteNotification']);
    Route::post('delete-all-notification', [MainController::class, 'bulkDeleteNotification']);

    //userprofile
    Route::post('show/profile',   [MainController::class, 'userprofile']);
    Route::post('update/profile', [MainController::class, 'updateprofile']);

    //Enrollment
    Route::post('free/enroll',        [PaymentController::class, 'enroll']);
    Route::post('bundle/free/enroll/{id}', [PaymentController::class, 'bundleEnroll']);
    Route::post('pay/store',          [PaymentController::class, 'payStore']);
    Route::get('manual/payment',      [PaymentController::class, 'getManual']);
    Route::get('purchase/history',   [PaymentController::class, 'purchaseHistory']);
    Route::get('invoice/{id}',   [PaymentController::class, 'invoice']);
    
    Route::post('stripe-pay',   [PaymentController::class, 'stripePay']);


    //cart
    Route::post('addtocart',   [PaymentController::class, 'addToCart']);
    Route::post('remove/cart', [PaymentController::class, 'removeCart']);
    Route::post('show/cart',   [PaymentController::class, 'showCart']);
    Route::post('remove-all/cart',  [PaymentController::class, 'removeAllCart']);
    Route::post('addtocart/bundle', [PaymentController::class, 'addBundleToCart']);
    Route::post('remove/bundle',    [PaymentController::class, 'removeBundleCart']);

    Route::post('apply/coupon',  [CouponController::class, 'applycoupon']);
    Route::post('remove/coupon', [CouponController::class, 'remove']);
    Route::post('remove/coupon-by-id', [CouponController::class, 'removeById']);

    Route::get('course/progress', [CourseController::class, 'courseProgress']);
    Route::post('course/progress/update', [CourseController::class, 'courseprogressupdate']);
    Route::get('course/googleMeetings', [CourseController::class, 'courseGoogleMeetings']);
});

//general api
Route::get('home/setting', [MainController::class, 'homeSetting']);
Route::get('sliders',      [MainController::class, 'homeSliders']);
Route::get('testimonials', [MainController::class, 'homeTestimonials']);
Route::get('videoSetting', [MainController::class, 'videoSetting']);
Route::post('contactus',   [MainController::class, 'contactus']);
Route::get('contactus/reasons', [MainController::class, 'contactReasons']);
Route::get('contact/details',   [MainController::class, 'contactDetails']);
Route::get('course/reviews',    [CourseController::class, 'courseReviews']);


Route::get('certificate/download/{progress_id}',    [OtherApiController::class, 'apipdfdownload']);
Route::get('/certificate/{progress_id}',    [OtherApiController::class, 'getCertificate']);




Route::get('save-stripe-pay/{userId}',   [PaymentController::class, 'SaveStripePay'])->name('save.stripe.pay');


Route::get('subcategory',    [MainController::class, 'subcategoryPage']);


// });

// });
