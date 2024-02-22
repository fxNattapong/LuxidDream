<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use App\Models\Players;
use App\Models\Players_Stats;
use App\Models\Levels;
use App\Models\Cards;
use App\Models\Rooms;
use App\Models\Rooms_Players;
use App\Models\Rooms_Cards;

class AdminController extends Controller
{
    public function Dashboard() {
        return view('admin/contents/Dashboard');
    }



    public function Players(Request $request) {
        $keyword = $request->input('keyword');

        $players = Players::when($keyword, function ($query, $keyword) {
            return $query->where('username', 'like', "%$keyword%")
                        ->orWhere('phone', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
        })
        ->paginate(5, ['*'], 'page');

        return view('admin/contents/Players', compact('players', 'keyword'));
    }

    public function SubmitPlayerAdd(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        $phone = ($request->has('phone')) ? trim($request->input('phone')) : null;
        $email = ($request->has('email')) ? trim($request->input('email')) : null;
        $role = ($request->has('role')) ? trim($request->input('role')) : null;
        $image64 = ($request->has('image64')) ? trim($request->input('image64')) : null;

        if(!$username) {
            $status = 'กรุณากรอกชื่อผู้ใช้';
            return response()->json(['status' => $status], 400);
        }
        if(strlen($username) < 4 || strlen($password) < 4) {
            $status = 'ชื่อผู้ใช้และรหัสผ่านขั้นต่ำ 4 ตัวอักษร';
            return response()->json(['status' => $status], 400);
        }
        if($phone && strlen($phone) < 10 || strlen($phone) > 10) {
            $status = 'รูปแบบหมายเลขโทรศัพท์ไม่ถูกต้อง';
            return response()->json(['status' => $status], 400);
        }
        if($email) {
            if (!(Str::endsWith($email, '@gmail.com') || Str::endsWith($email, '@hotmail.com') || Str::endsWith($email, '@outlook.com'))) {
                $status = 'กรุณารูปแบบอีเมลให้ถูกต้อง';
                return response()->json(['status' => $status], 400);
            }

            $isEmailAlready = Players::where('email', $email)->first();
            if($isEmailAlready) {
                $status = 'อีเมลดังกล่าวถูกใช้ไปแล้ว';
                return response()->json(['status' => $status], 400);
            }
        }

        $isUser = Players::where('username', $username)->first();
        if($isUser) {
            $status = 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว';
            return response()->json(['status' => $status], 400); 
        } else {
            $InsertRow = new Players;
            $InsertRow->username = $username;
            $InsertRow->password = $password;

            if($phone) {
                $InsertRow->phone = $phone;
            }
            if($email) {
                $InsertRow->email = $email;
            }

            $InsertRow->role = $role;

            if($image64) {
                @list($type, $file_data) = explode(';', $image64);
                @list(, $file_data) = explode(',', $file_data); 
                $imageName = Str::random(10).'.'.'png';   
                file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));
                
                $InsertRow->image = $imageName;
            }
            
            $InsertRow->save();
        }
        return response()->json(200);
    }

    public function SubmitPlayerEdit(Request $request) {
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;
        $username_current = ($request->has('username_current')) ? trim($request->input('username_current')) : null;
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        $phone = ($request->has('phone')) ? trim($request->input('phone')) : null;
        $email = ($request->has('email')) ? trim($request->input('email')) : null;
        $role = ($request->has('role')) ? trim($request->input('role')) : null;
        $image64 = ($request->has('image64')) ? trim($request->input('image64')) : null;
        
        if(strlen($password) < 4) {
            $status = 'รหัสผ่านขั้นต่ำ 4 ตัวอักษร';
            return response()->json(['status' => $status], 400);
        }
        if(strlen($password) < 4) {
            $status = 'รหัสผ่านขั้นต่ำ 4 ตัวอักษร';
            return response()->json(['status' => $status], 400);
        }
        if($phone && strlen($phone) < 10 || strlen($phone) > 10) {
            $status = 'รูปแบบหมายเลขโทรศัพท์ไม่ถูกต้อง';
            return response()->json(['status' => $status], 400);
        }
        if($email) {
            if (!(Str::endsWith($email, '@gmail.com') || Str::endsWith($email, '@hotmail.com') || Str::endsWith($email, '@outlook.com'))) {
                $status = 'กรุณารูปแบบอีเมลให้ถูกต้อง';
                return response()->json(['status' => $status], 400);
            }

            $isEmailAlready = Players::where('email', $email)->first();
            if($isEmailAlready && $isEmailAlready->player_id != $player_id) {
                $status = 'อีเมลดังกล่าวถูกใช้ไปแล้ว';
                return response()->json(['status' => $status], 400);
            }
        }
        
        if($username != $username_current) {
            $isMember = Players::where('username', $username)->first();
            if($isMember) {
                $status = 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว';
                return response()->json(['status' => $status], 400);
            }
        }

        if($image64) {
            @list($type, $file_data) = explode(';', $image64);
            @list(, $file_data) = explode(',', $file_data); 
            $imageName = Str::random(10).'.'.'png';   
            file_put_contents(config('pathImage.uploads_path') . '/' . $imageName, base64_decode($file_data));

            Players::where('player_id', $player_id)
                ->update([
                'username' => $username,
                'password' => $password,
                'phone' => $phone,
                'email' => $email,
                'role' => $role,
                'image' => $imageName,
                'updated_at' => now()
            ]);
        } else {
            Players::where('player_id', $player_id)
                ->update([
                'username' => $username,
                'password' => $password,
                'phone' => $phone,
                'email' => $email,
                'role' => $role,
                'updated_at' => now()
            ]);
        }

        return response()->json(200);
    }

    public function SubmitPlayerDelete(Request $request) {
        $player_id = ($request->has('player_id')) ? ($request->input('player_id')) : null;

        Players::where('player_id', $player_id)->delete();

        return response()->json(200);
    }



    public function Levels(Request $request) {
        $levels = Levels::All();

        return view('admin/contents/Levels', compact('levels'));
    }

}
