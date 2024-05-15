<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Alert;
use Session;
use Auth;
use Redirect;
use Crypt;
use Illuminate\Support\Facades\Http;
use DotenvEditor;
use App\Blog;
use App\InvoiceDesign;
use App\WidgetSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use ZIPARCHIVE;
use App\Videosetting;
use App\Breadcum;
use App\Homesetting;
use App\JoinInstructor;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Admincustomisation;

use Jackiedo\DotenvEditor\Facades\DotenvEditor as FacadesDotenvEditor;

class OtaUpdateController extends Controller
{

    public function getotaview()
    {
        
        return view('ota.update');
        
    }


    public function update(Request $request)
    {

        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d);  
        if(strstr($domain,'localhost') || strstr( $domain, '192.168.' ) || strstr($domain,'.test') || strstr($domain,'mediacity.co.in') || strstr($domain,'castleindia.in')){
             $put = 1;
            file_put_contents(public_path().'/config.txt', $put);

            

            return $this->process($request);
        }
        else{
            
            $request->validate([
                'eula' => 'required',
                'domain'=>'required',
                'code'=>'required'
            ],
            [
                'eula.required'=>'Please accept Terms and Conditions !',
                'domain.required'=>'Please enter your domain name !',
                'code.required'=>'Please enter your envato purchase code !'
            ]);

            $alldata = ['app_id' => "25613271", 'ip' => $request->ip(), 'domain' => $domain , 'code' => $request->code];
        
            $data = $this->make_request($alldata);

            if ($data['status'] == 1)
            {

                $put = 1;
                file_put_contents(public_path().'/config.txt', $put);
                return $this->process($request);
            }
            elseif ($data['msg'] == 'Already Register')
            {
                return back()->withErrors(['User is already registered']);
            }
            else
            {
                return back()->withErrors([$data['msg']]);
            }


        }

        

    }

    public function process($request){


            if(!empty(config('app.version')))
            {
                DotenvEditor::setKey('APP_VERSION', config('app.version'))->save();
            }

            DotenvEditor::setKey('ENABLE_INSTRUCTOR_SUBS_SYSTEM', 0)->save();

            ini_set('max_execution_time', '-1');

            ini_set('memory_limit', '-1');

            Artisan::call('migrate');

            \Artisan::call('migrate --path=database/migrations/update2_2');
            \Artisan::call('migrate --path=database/migrations/update2_3');
            \Artisan::call('migrate --path=database/migrations/update2_4');
            \Artisan::call('migrate --path=database/migrations/update2_5');
            \Artisan::call('migrate --path=database/migrations/update2_6');
            \Artisan::call('migrate --path=database/migrations/update2_7');
            \Artisan::call('migrate --path=database/migrations/update2_8');
            \Artisan::call('migrate --path=database/migrations/update2_9');
            \Artisan::call('migrate --path=database/migrations/update3_0_0');
            \Artisan::call('migrate --path=database/migrations/update3_1_0');
            \Artisan::call('migrate --path=database/migrations/update3_2_0');
            \Artisan::call('migrate --path=database/migrations/update3_3_0');
            \Artisan::call('migrate --path=database/migrations/update3_4_0');
            \Artisan::call('migrate --path=database/migrations/update3_5_0');
            \Artisan::call('migrate --path=database/migrations/update3_6_0');
            \Artisan::call('migrate --path=database/migrations/update3_9_0');
            \Artisan::call('migrate --path=database/migrations/update4_0_0');
            \Artisan::call('migrate --path=database/migrations/update4_2_0');
            \Artisan::call('migrate --path=database/migrations/update4_3_0');
            \Artisan::call('migrate --path=database/migrations/update4_4_0');
            \Artisan::call('migrate --path=database/migrations/update4_5_0');
            \Artisan::call('migrate --path=database/migrations/update4_6_0');
            \Artisan::call('migrate --path=database/migrations/update4_7_0');


            if(!InvoiceDesign::first()){
                \Artisan::call('db:seed --class=InvoiceDesignSeeder');
            }

            if(!WidgetSetting::first()){
                \Artisan::call('db:seed --class=WidgetSettingsTableSeeder');
            }
            if(!Breadcum::first()){
                \Artisan::call('db:seed --class=BreadcumSeeder');
            }
            if(!Homesetting::first()){
                \Artisan::call('db:seed --class=HomesettingSeeder');
            }
            if(!JoinInstructor::first()){
                \Artisan::call('db:seed --class=JoinInstructorSeeder');
            }
            if(!Videosetting::first()){
                \Artisan::call('db:seed --class=VideosettingSeeder');
            }
            \Artisan::call('passport:install');

            \Artisan::call('rename:video');
            if (Role::count() < 1) {
                Artisan::call('db:seed --class=RolesTableSeeder');
            }
    
            if (Permission::count() < 1) {
                Artisan::call('db:seed --class=PermissionsTableSeeder');
            }
    
            if (DB::table('role_has_permissions')->count() < 1) {
                Artisan::call('db:seed --class=RoleHasPermissionsTableSeeder');
            }
    
            if (DB::table('currencies')->count() < 1) {
                Artisan::call('db:seed --class=CurrenciesTableSeeder');
            }
            
            if (env('ACL_UPGRADE') == 0) {
    
                $users = User::get();
    
                $users->each(function ($user) {
    
                    if ($user->role == 'admin') {
    
                        $user->assignRole('Admin');
    
                    }
    
                    if ($user->role == 'instructor') {
    
                        $user->assignRole('Instructor');
    
                    }
    
                    if ($user->role == 'user') {
    
                        $user->assignRole('User');
    
                    }
    
                });
    
                $acl_status = DotenvEditor::setKeys([
                    'ACL_UPGRADE' => '1',
                ]);
    
                $acl_status->save();
            
            }


            try {

                $currencies = DB::table('currencies')->get();

                foreach($currencies as $currency)
                {
                    if($currency->currency != NULL || $currency->currency != '')
                    {
                        DB::table('currencies')->where('currency', '!=', NULL)->where('id', $currency->id)
                        ->update(['code' => $currency->currency, 'default' => '1']);

                        Artisan::call('currency:manage', ['action' => 'update', 'currency' => $currency->currency]);

                        Artisan::call('currency:update -o');
                    }

                    
                }
            }
            catch(\Swift_TransportException $e){

            }
             $d = \Request::getHost();
            $domain = str_replace("www.", "", $d); 
            if(strstr($domain, '!=','localhost') || strstr( $domain, '!=', '192.168.' ) || strstr($domain, '!=','.test') || strstr($domain, '!=','mediacity.co.in') || strstr($domain, '!=','castleindia.in')){

                if (!file_exists(storage_path() . '/app/keys/license.json')) {

                    $token = @file_get_contents(public_path() . '/intialize.txt');
                    $code = @file_get_contents(public_path() . '/code.txt');
                    $domain = @file_get_contents(public_path() . '/ddtl.txt');
        
                    if ($token != '' && $code != '') {
        
                        $lic_json = array(
                            
                            'name' => auth()->user()->name,
                            'code' => $code,
                            'type' => __('envato'),
                            'domain' => $domain,
                            'lic_type' => __('regular'),
                            'token' => $token
        
                        );
        
                    }
        
                    $file = json_encode($lic_json);
        
                    $filename = 'license.json';
        
                    Storage::disk('local')->put('/keys/' . $filename, $file);
                    
                    
        
                    /** Delete this token files */
        
                    try {
        
                        $token ? unlink(public_path() . '/intialize.txt') : '';
                        $code ? unlink(public_path() . '/code.txt') : '';
                        $domain ? unlink(public_path() . '/ddtl.txt') : '';
        
                    } catch (\Exception $e) {
                        Log::error('Failed to migrate license reason : ' . $e->getMessage());
                    }
                
                
                }
            }


            try{
                $blogs = Blog::where('slug', NULL)->get();

                if($blogs != NULL)
                {
                    foreach ($blogs as $key => $blog) {
                        $slug = str_slug($blog['heading'],'-');
                        Blog::where('id', $blog->id)
                                ->update([
                                    'slug' => $slug
                                ]);
                    }
                }
               
            }
            catch(\Swift_TransportException $e){

            }
            

            DotenvEditor::setKey('APP_DEBUG', 'false')->save();

            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');


            Alert::success('Updated to version' . config('app.version'), 'Your App Updated Successfully !')->persistent('Close')->autoclose(12000);
            

            
            return redirect('/');
        


    }

    


    public function updateprocess()
    {
       
            return view('ota.process');
        
    }


    public function make_request($alldata)
    {
        $response = Http::post('https://mediacity.co.in/purchase/public/api/verifycode', [
            'app_id' => $alldata['app_id'],
            'ip' => $alldata['ip'],
            'code' => $alldata['code'],
            'domain' => $alldata['domain']
        ]);

        $result = $response->json();
        
        if($response->successful()){
            if ($result['status'] == '1')
            {

                $lic_json = array(
                
                    'name'     => request()->user_id,
                    'code'     => $alldata['code'],
                    'type'     => __('envato'),
                    'domain'   => $alldata['domain'],
                    'lic_type' => __('regular'),
                    'token'    => $result['token']
                    
                );
    
                $file = json_encode($lic_json);
                
                $filename =  'license.json';
    
                Storage::disk('local')->put('/keys/'.$filename,$file);

                return array(
                    'msg' => $result['message'],
                    'status' => '1'
                );
            }
            else
            {
                $message = $result['message'];
                return array(
                    'msg' => $message,
                    'status' => '0'
                );
            }
        }else
        {
            $message = "Failed to validate";
            return array(
                'msg' => $message,
                'status' => '0'
            );
        }

       
    }



    public function checkforupate(Request $request)
    {

        if ($request->ajax()) {

            $version = @file_get_contents(storage_path() . '/app/bugfixer/version.json');

            $version = json_decode($version, true);

            $current_version = $version['version'];

            $current_subversion = $version['subversion'];

            $new_version = str_replace('.', '', $current_subversion) + 1;
            $new_version = implode('.', str_split($new_version));

            $repo = @file_get_contents('https://raw.githubusercontent.com/mediacity/eClass-web/' . $current_version . '/' . $new_version . '.json');

            if($repo != ''){
                
                $repo = json_decode($repo);
            
                return response()->json([
                    'status' => 'update_avbl',
                    'msg' => __('Update available'),
                    'version' => $repo->subversion,
                    'filename' => $repo->filename,
                ]);

                
            }else{
                
                return response()->json([
                    'status' => 'uptodate',
                    'msg' => __('Your application is up to date'),
                ]);
            }

        }

    }

    public function mergeQuickupdate(Request $request)
    {
        
        $file = @file_get_contents('https://raw.githubusercontent.com/mediacity/eClass-web/' . config('app.version') . '/' . $request->filename);

        if(!$file){
            
            return back()->with('delete', 'Update file not found !');
        }

        $version = $request->version;

        Storage::disk('local')->put('/bugfixer/' . $request->filename, $file);

        $file = storage_path().'/app/bugfixer/' . $request->filename;

        $zip = new ZipArchive;

        $zipped = $zip->open($file, ZIPARCHIVE::CREATE);

        if ($zipped) {

            $extract = $zip->extractTo(base_path());

            if ($extract) {

                

                $version_json = array(

                    'version' => config('app.version'),
                    'subversion' => $version,

                );

                $version_json = json_encode($version_json);

                $filename = 'version.json';

                $zip->close();

                Storage::disk('local')->put('/bugfixer/' . $filename, $version_json);
                
                try{
                    unlink(storage_path().'/app/bugfixer/'.$request->filename);
                }catch(\Exception $e){
                    
                }

                return back()->with('success', 'Quick Hot fix update has been merged successfully !');
            }

        }

    }

   
}
