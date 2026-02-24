<?php

namespace App\Http\Controllers\Api\AuthenticationCenter;

use App\Models\User;
use App\Models\People\People;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Laravolt\Avatar\Avatar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class TelegramController extends Controller
{

    public function updateOrCreate(Request $request){
        // User Data
        /*
        id: 38846216 -> telegram_user_id
        username: "chamroeunoum" -> telegram_user_username
        hash: "d344bc5f619baafc2287cbcca883c58cd89d90e6a13c51a061e85d9a7618fae5" -> telegram_user_hash
        auth_date: 1718086049 -> telegram_user_auth_date
        first_name: "Chamroeun" -> telegram_user_firstname
        last_name: "OUM" -> telegram_user_lastname
        photo_url: "https://t.me/i/userpic/320/17SfzmPHs2An_FggmTXO5jGxH-MlK1RrKPQ4sT3OG0E.jpg" -> telegram_user_picture
        */
        $email = '' ;
        if( isset( $request->email ) && strlen(trim($request->email))>0 ){
            $email = $request->email;
        }else{
            $email = $request->first_name . $request->last_name . $request->id . "@telegram.otc";
        }
        // Check whether has been already registerd
        $user = \App\Models\User::
            where('telegram_user_id', $request->id)
            ->whereNotNull('telegram_user_id')
            ->first();
        
        // Check whether the user is already our member with the email
        if( $user == null ){
            $user = \App\Models\User::
            where('email', $email)
            ->whereNotNull('email')
            ->first();
        }

        // Check whether the user is already our member with the email
        if( $user == null && $request->hash != "" ){
            $user = \App\Models\User::
            where('telegram_user_hash', $request->hash)
            ->whereNotNull('telegram_user_hash')
            ->first();
        }

        /** Just in case admin has deleted user from system with SoftDeletes */
        if (( $user = \App\Models\User::where(function($query) use($request, $email ){
                $query->where('telegram_user_id', $request->id)
                ->whereNotNull('telegram_user_id');
            })
            ->orWhere(function($query) use($request, $email){
                $query->where('telegram_user_hash', $request->hash)
                ->whereNotNull('telegram_user_hash');
            })
            ->orWhere(function($query) use($request, $email){
                $query->where('email', $email)
                ->whereNotNull('email');
            })
            ->onlyTrashed()
            ->first() ) !== null) {
            $user->restore();
        }

        if( $user != null ){
            $user
            ->update([
                'telegram_user_id' => $request->id ,
                'telegram_user_lastname' => $request->lastname ,
                'telegram_user_firstname' => $request->firstname ,
                'telegram_user_username' => $request->username ,
                'telegram_user_picture' => $request->photo_url ,
                'telegram_user_hash' => $request->hash , 
                'telegram_user_auth_date' => $request->auth_date ,
            ]);
            if( strlen(trim($user->email)) <= 0 || $user->email == null ){
                $user->update(['email' => $email ]);
            }
            if( strlen(trim($user->username)) <= 0 || $user->username == null ){
                $user->update(['username' => $request->username ]);
            }
        }else{
            /** If does not exist then create account for user */
            $user = \App\Models\User::create([
                'firstname' => $request->last_name,
                'lastname' => $request->first_name,
                'name' => $request->last_name . ' ' . $request->first_name,
                'password' => bcrypt('1234567890!@#$%^&*()'),
                'active' => 1,
                'telegram_user_id' => $request->id ,
                'telegram_user_lastname' => $request->last_name ,
                'telegram_user_firstname' => $request->first_name ,
                'telegram_user_username' => $request->username ,
                'telegram_user_picture' => $request->photo_url ,
                'telegram_user_hash' => $request->hash ,
                'telegram_user_auth_date' => $request->auth_date ,
                'email' => $email ,
                'username' => $request->username
            ]);
            $backendRole = \App\Models\Role::where('name','backend')->where('tag','core_service')->first();
            if( $backendRole != null ){
                $user->assignRole( $backendRole );
            }
        }

        /** Check member with his/her email or phone */
        if( $user->person == null ){
            if( $user->people_id > 0 && ( $person = \App\Models\People\People::find( $user->people_id )->onlyTrashed()->first() ) != null ){
                $person->restore();
                $person->update([
                    'firstname' => $request->first_name ,
                    'lastname' => $request->last_name ,
                    'email' => $email
                ]);
            }else{
                $person = \App\Models\People\People::create([
                    'firstname' => $request->first_name ,
                    'lastname' => $request->last_name ,
                    'email' => $email
                ]);
            }
            $user->people_id = $person->id;
            $user->save();
            $user->person;
        }
        /** Then create access token for api access */
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        /** Create user profile picture */
        if ( $user->avatar_url == null || strlen(trim($user->avatar_url))<1 || 
            (
                strlen(trim($user->avatar_url))>0 && !Storage::disk(env("FILESYSTEM_DRIVER","public"))->exists($user->avatar_url)
            )
        ) {
            $profile_picture = null;
            if (file_exists($request->picture) && ($content = file_get_contents($request->picture)) !== false) {
                $profile_picture = $content;
            } else {
                $avatar = new Avatar();
                $profile_picture = $avatar->create($user->name)->getImageObject()->encode('png');
            }
            $path = 'avatars/' . $user->id ;
            if( !Storage::disk('public')->exists( $path ) ){
                if( Storage::makeDirectory( $path ) ){
                    $uniqeName = md5( $user->name );
                    Storage::disk(env("FILESYSTEM_DRIVER","public"))->put( $path . '/'.$uniqeName.'.png', (string) $profile_picture, "public");
                    $user->avatar_url = $path . '/'.$uniqeName.'.png';
                    $user->save();
                }
            }
        }

        if( $user ){
            if( $user->avatar_url !== null && Storage::disk('public')->exists( $user->avatar_url ) ){
                $user->avatar_url = Storage::disk("public")->url( $user->avatar_url  );
            }
        }

        return response()->json([
            'ok' => true ,
            'upload_max_filesize' => ini_get("upload_max_filesize") ,
            'token' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ],
            'record' => $user ,
            'message' => 'ចូលប្រើប្រាស់បានជោគជ័យ !'
        ],200);
    }
    public function sendOtp(Request $request)
        {
            $request->validate(
                [
                    'telegram_user_id' => 'required|string'
                ],
                [
                    'telegram_user_id.required' => 'សូមភ្ជាប់គណនី Telegram ជាមុនសិន។'
                ]
            );

            $user = User::where('telegram_user_id', $request->telegram_user_id)
                ->whereNull('deleted_at')
                ->first();

            if (!$user) {
                return response()->json([
                    'ok' => false,
                    'message' => 'គណនី Telegram មិនទាន់បានភ្ជាប់ជាមួយប្រព័ន្ធទេ។'
                ], 404);
            }


            // 3️⃣ Check cooldown (LOCK)
            if ($user->otp_locked_until && now()->lt($user->otp_locked_until)) {
                $seconds = now()->diffInSeconds($user->otp_locked_until);

                $minutes = intdiv($seconds, 60);
                $secs = $seconds % 60;

                $waitText = $minutes > 0
                    ? "សូមរង់ចាំ {$minutes} នាទី {$secs} វិនាទី មុនពេលស្នើសុំលេខកូដម្ដងទៀត។"
                    : "សូមរង់ចាំ {$secs} វិនាទី មុនពេលស្នើសុំលេខកូដម្ដងទៀត។";

                return response()->json([
                    'ok' => false,
                    'message' => $waitText
                ], 429);
            }

            // 4️⃣ Resend limit (max 3)
            if ($user->otp_resend_count >= 3) {
                return response()->json([
                    'ok' => false,
                    'message' => 'អ្នកបានស្នើសុំលេខកូដ OTP ច្រើនដងពេក។ សូមព្យាយាមម្ដងទៀតពេលក្រោយ។'
                ], 429);
            }

            // ✅ Generate OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $cooldownMinutes = match ($user->otp_resend_count) {
                    0 => 1, // after 1st send
                    1 => 3, // after 2nd send
                    default => 5 // after 3rd send
                };

            $user->update([
                'forgot_password_token' => $otp,
                'otp_sent_at' => now(),
                'otp_expires_at' => now()->addMinutes(5),
                'otp_attempts' => 0,
                'otp_resend_count' => $user->otp_resend_count + 1,
                'otp_locked_until' => now()->addMinutes($cooldownMinutes)

            ]);

            // 📩 Send Telegram
            Http::withOptions([
                    'verify' => false
                ])->post("https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/sendMessage", [
                    'chat_id' => $user->telegram_user_id,
                    'text' => "🔐 Your OTP code is: {$otp}\nThis code expires in 5 minutes."
                ]);

            return response()->json([
                'ok' => true,
                'message' => 'លេខកូដ OTP បានផ្ញើទៅ Telegram របស់អ្នករួចរាល់។'
            ]);
        }
    public function verifyOtp(Request $request)
        {
            $request->validate(
                [
                    'telegram_user_id' => 'required|string',
                    'otp' => 'required|string|size:6'
                ],
                [
                    'telegram_user_id.required' => 'សូមភ្ជាប់គណនី Telegram ជាមុនសិន។',
                    'otp.required' => 'សូមបញ្ចូលលេខកូដ OTP។',
                    'otp.size' => 'លេខកូដ OTP ត្រូវមាន ៦ ខ្ទង់។'
                ]
            );

            $user = User::where('telegram_user_id', $request->telegram_user_id)->first();

            if (!$user || !$user->forgot_password_token) {
                return response()->json([
                    'ok' => false,
                    'message' => 'មិនមានការស្នើសុំលេខកូដ OTP ទេ។'
                ], 400);
            }

            // ⏰ Expired
            if (now()->gt($user->otp_expires_at)) {
                return response()->json([
                    'ok' => false,
                    'message' => 'លេខកូដ OTP បានផុតកំណត់។ សូមស្នើសុំលេខកូដថ្មី។'
                ], 410);
            }

            // ❌ Wrong OTP
            if (trim($request->otp) !== $user->forgot_password_token) {
                $user->increment('otp_attempts');

                return response()->json([
                    'ok' => false,
                    'message' => 'លេខកូដ OTP មិនត្រឹមត្រូវទេ។'
                ], 400);
            }

            // ✅ Success
            return response()->json([
                'ok' => true,
                'message' => 'លេខកូដ OTP ត្រឹមត្រូវ។'
            ]);
        }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'telegram_user_id' => 'required|string',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('telegram_user_id', $request->telegram_user_id)->first();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->update([
            'password' => bcrypt($request->password),
            'forgot_password_token' => null,
            'otp_sent_at' => null,
            'otp_expires_at' => null,
            'otp_attempts' => 0,
            'otp_resend_count' => 0,
            'otp_locked_until' => null
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'ពាក្យសម្ងាត់បានផ្លាស់ប្តូរដោយជោគជ័យ។ សូមចូលប្រើប្រាស់វិញ។'
        ]);
    }

}
