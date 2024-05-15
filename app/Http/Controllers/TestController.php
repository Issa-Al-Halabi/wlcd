<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Auth;
use TwilioMsg;
use App\Notifications\AdminOrder;
use App\Notifications\UserEnroll;
use App\User;
use App\Course;
use Notification;


class TestController extends Controller
{
	public function test()
   	{
		   
      return view('test');
   	}

   	
   

}
