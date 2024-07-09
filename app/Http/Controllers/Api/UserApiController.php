<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\AppUserLog;
use App\Models\AppUserMac;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserApiController extends Controller
{


    public function store(Request $request) : object
    {

        $response="";
        $ip = request()->ip();
        $u_agent=$request->server('HTTP_USER_AGENT');
        $resultArray['stat']="0";
        try
        {
            $newUser= AppUser::create([
                'email' => $request->email ,
                'machine_id' =>  $request->machine_id,
                'created_at' => Date("Y-m-d H:i:s"),
            ]);

            if($newUser) {
                $data = AppUserLog::create([
                    'email' => $request->email,
                    'app_user_id' => $newUser->id,
                    'activity' => "register user successful",
                    'machine_id' => $request->machine_id,
                    'ip_address' => $ip,
                    'browser_agent' =>$u_agent,
                    'os_version' => $request->os_version,
                    'app_version' => $request->app_version,
                    'created_at' => Date("Y-m-d H:i:s")
                ]);
                $resultArray['stat']=1;
            }
            else {
                $response = "User not created";
                $data = AppUserLog::create([
                    'email' => $request->email,
                    'app_user_id' => $newUser->id,
                    'activity' => "register user failed",
                    'machine_id' => $request->machine_id,
                    'ip_address' => $ip,
                    'browser_agent' =>$u_agent,
                    'os_version' => $request->os_version,
                    'app_version' => $request->app_version,
                    'created_at' => Date("Y-m-d H:i:s")
                ]);

            }
            $response = $resultArray;
        }
        catch ( \Exception $exp)
        {
            $data = AppUserLog::create([
                'email' => $request->email,
                'app_user_id' => 0,
                'activity' => "register user failed : ".$exp->getMessage(),
                'machine_id' => $request->machine_id,
                'ip_address' => $ip,
                'browser_agent' =>$u_agent,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'created_at' =>Date("Y-m-d H:i:s"),

            ]);
            return response()->json($exp->getMessage(), 501);
        }



     return response()->json($response, 201);
    }

    public function getuser(Request $request) : object
    {



        try {
            $ip = request()->ip();
            $u_agent=$request->server('HTTP_USER_AGENT');
            $resultArray['email']="";
            $resultArray['sl_num']="";
            $resultArray['fw_num']="";
            $resultArray['active']=0;
            $resultArray['setdate']="";
            $resultArray['machine_id']="";
            $resultArray['varified_at']="";
            $resultArray['notification_text']="";

            $response = "";
            if(strlen($request->machine_id)>10) {

                $appseting=Setting::all()->toarray();
                foreach ($appseting as $apset)
                {
                    if($apset['type']=="firmware")
                        $resultArray['fw_num'] =$apset['value'];
                    if($apset['type']=="notification")
                        $resultArray['notification'] =$apset['value'];
                    if($apset['type']=="default_date")
                        $resultArray['setdate'] =$apset['value'];

                }

                $user = AppUser::where('machine_id', $request->machine_id)->get()->toarray();

                if (count($user) > 0) {

                    $resultArray['email'] = $user[0]['email'];
                    $resultArray['sl_num'] = $user[0]['sl_num'];
                    $resultArray['active'] = ($user[0]['active'])?1:0;
                    $resultArray['machine_id'] = $user[0]['machine_id'];
                    $resultArray['varified_at'] = $user[0]['varified_at'];


                    $data = AppUserLog::create([

                        'email' => $user[0]['email'],
                        'app_user_id' =>$user[0]['id'],
                        'activity' => "get user status : login successful",
                        'machine_id' => $request->machine_id,
                        'ip_address' => $ip,
                        'browser_agent' =>$u_agent,
                        'os_version' => $request->os_version,
                        'app_version' => $request->app_version,
                        'created_at' =>Date("Y-m-d H:i:s"),

                    ]);


                }
                else
                {

                    $auser =AppUser::whereRelation('machines', 'machine_id', '=', $request->machine_id)->get()->toarray();
                    if (count($auser) > 0) {

                        $resultArray['email'] = $auser[0]['email'];
                        $resultArray['sl_num'] = $auser[0]['sl_num'];
                        $resultArray['active'] =  ($auser[0]['active'])?1:0;
                        $resultArray['machine_id'] = $request->machine_id;
                        $resultArray['varified_at'] = $auser[0]['varified_at'];


                        $data = AppUserLog::create([

                            'email' => $auser[0]['email'],
                            'app_user_id' =>$auser[0]['id'],
                            'activity' => "get user status : login successful",
                            'machine_id' => $request->machine_id,
                            'ip_address' => $ip,
                            'browser_agent' =>$u_agent,
                            'os_version' => $request->os_version,
                            'app_version' => $request->app_version,
                            'created_at' =>Date("Y-m-d H:i:s"),

                        ]);
                    }
                }
            }
            $response = $resultArray;
            return response()->json($response, 201);
        }
        catch ( \Exception $exp)
        {
            $data = AppUserLog::create([
                'email' => $auser[0]['email'],
                'app_user_id' =>$auser[0]['id'],
                'activity' => "get user status : ".$exp->getMessage(),
                'machine_id' => $request->machine_id,
                'ip_address' => $ip,
                'browser_agent' =>$u_agent,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'created_at' =>Date("Y-m-d H:i:s"),

            ]);
            return response()->json($exp->getMessage(), 501);
        }
    }

    public function checkuser(Request $request) : object
    {



        try {
            $ip = request()->ip();
            $u_agent=$request->server('HTTP_USER_AGENT');
            $resultArray['stat']=0;
                $appseting=Setting::all()->toarray();
                foreach ($appseting as $apset)
                {
                    if($apset['type']=="firmware")
                        $resultArray['fw_num'] =$apset['value'];
                    if($apset['type']=="notification")
                        $resultArray['notification'] =$apset['value'];
                    if($apset['type']=="default_date")
                        $resultArray['setdate'] =$apset['value'];

                }

                $user = AppUser::where('email', $request->email)->get()->toarray();

                if (count($user) > 0) {

                    $usermac = AppUserMac::where('user_email', $request->email)->get()->toarray();
                    if (count($usermac) > 17)
                        $resultArray['stat']=2;
                    else
                        $resultArray['stat']=1;

                }
                else
                {

                    $auser =AppUserMac::where( 'machine_id', $request->machine_id)->get()->toarray();
                    if (count($auser) > 0) {
                        $resultArray['stat']=3;
                    }
               }
            $response = $resultArray;
            $data = AppUserLog::create([
                'email' => $request->email,
                'app_user_id' =>0,
                'activity' => "check user status : ".$resultArray['stat'],
                'machine_id' => $request->machine_id,
                'ip_address' => $ip,
                'browser_agent' =>$u_agent,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'created_at' =>Date("Y-m-d H:i:s"),

            ]);


            return response()->json($response, 201);
        }
        catch ( \Exception $exp)
        {
            $data = AppUserLog::create([
                'email' => $request->email,
                'app_user_id' =>0,
                'activity' => "check user status : ".$exp->getMessage(),
                'machine_id' => $request->machine_id,
                'ip_address' => $ip,
                'browser_agent' =>$u_agent,
                'os_version' => $request->os_version,
                'app_version' => $request->app_version,
                'created_at' =>Date("Y-m-d H:i:s"),

            ]);
            return response()->json($exp->getMessage()."at line".$exp->getLine(), 501);
        }

      }
}
