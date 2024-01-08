<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Rooms;
use App\Models\Players;
use App\Models\Cards;
use App\Models\Rooms_Cards;

use App\Events\RoomUpdated;

class GameController extends Controller
{
    public function Home() {
        $data = 'Home Page';

        return view('Home', compact('data'));
    }

    public function RegisterProcess(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        $email = ($request->has('email')) ? trim($request->input('email')) : null;
        $phone = ($request->has('phone')) ? trim($request->input('phone')) : null;

        if(!$username) {
            $status = 'กรุณากรอกชื่อผู้ใช้';
            return response()->json(['status' => $status], 401);
        }
        if(strlen($password) < 4) {
            $status = 'รหัสผ่านขั้นต่ำ 4 ตัวอักษร';
            return response()->json(['status' => $status], 401);
        }

        $isUser = Players::where('username', $username)->first();
        if($isUser) {
            $status = 'ชื่อผู้ใช้นี้ถูกใช้ไปแล้ว';
            return response()->json(['status' => $status], 401); 
        } else {
            $InsertRow = new Players;
            $InsertRow->username = $username;
            $InsertRow->password = $password;
            $InsertRow->email = $email;
            $InsertRow->phone = $phone;
            $InsertRow->save();
        }

        return response()->json(200);
    }

    public function LoginProcess(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        
        $isUser = Players::where('username', '=', $username)->where('password', '=', $password)->first();
        if($isUser) {
            $result = [
                'isOk' => true, 
                'username' => $username
            ];
            $statusCode = 200;

            session::put('authen', true);
            session::put('player_id', $isUser->id);
            session::put('username', $username);

            if($isUser->image) {
                session::put('image', $isUser->image);
            }
        } else {
            $result = [
                'isOk' => false,
                'status' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'
            ];
            $statusCode = 400;
        }

        return response()->json($result, $statusCode);
    }

    public function Logout() {
        session::flush();
        session::save();
        return redirect()->back();
    }

    public function RoomCreate(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $name_ingame = ($request->has('name_ingame')) ? trim($request->input('name_ingame')) : null;
        $level = ($request->has('level')) ? trim($request->input('level')) : null;
        
        if ($username && $name_ingame) {
            $InsertRow = new Rooms;
            $InsertRow->invite_code = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $InsertRow->creator_name = $username;
            $InsertRow->level = $level;
            $InsertRow->save();

            Players::where('username', $username)
                    ->update([
                        'room_id' => $InsertRow->id,
                        'name_ingame' => $name_ingame,
                        'status' => 1,
                        'updated_at' => now()
                    ]);

            session::put('creator', true);
            session::put('username', $username);
            session::put('name_ingame', $name_ingame);
        
            return response()->json([
                'status' => 'success',
                'id' => $InsertRow->id,
                'invite_code' => $InsertRow->invite_code,
                'number_player' => $InsertRow->number_player,
            ], 200);
        } else {
            $status = 'Please enter your in-game name.';
            return response()->json(['status' => $status], 401);
        }
    }

    public function RoomJoin() {

        return view('RoomJoin', compact('data'));
    }

    public function RoomJoining(Request $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $name_ingame = ($request->has('name_ingame')) ? trim($request->input('name_ingame')) : null;

        $isRoom = Rooms::where('invite_code', $invite_code)->first();
        if($isRoom) {
            Players::where('username', $username)
                    ->update([
                        'room_id' => $isRoom->id,
                        'name_ingame' => $name_ingame,
                        'updated_at' => now()
                    ]);

            session::put('player', true);
            session::put('username', $username);
            session::put('name_ingame', $name_ingame);
        
            return response()->json([
                'status' => 'success',
                'invite_code' => $invite_code,
            ], 200);
        } else {
            $status = 'กรุณากรอกรหัสและชื่อ';
            return response()->json(['status' => $status], 401);
        }
    }

    public function RoomWaiting(Request $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        
        $room = Rooms::where('invite_code', $invite_code)->first();

        $players = Players::where('room_id', $room->id)->get();
        
        return view('RoomWaiting', compact('room', 'players'));
    }

    public function PollPlayers(Request $request) {
        $room_id = $request->input('room_id');
        
        $room = Rooms::where('id', $room_id)->first();
    
        if (!$room) {
            return response()->json(['status' => 'error', 'message' => 'Room not found']);
        }
    
        $players = Players::where('room_id', $room->id)->get();
    
        return response()->json(['status' => 'success', 'room' => $room, 'players' => $players]);
    }

    public function ChangeStatus(Request $request) {
        $player_id = $request->input('player_id');
        $status = $request->input('status');

        if($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        
        Players::where('id', $player_id)
                ->update([
                    'status' => $status,
                    'updated_at' => now()
                ]);
    
        return response()->json(['status' => 'success'], 200);
    }

    public function RoomDisconnect(Request $request) {
        $player_id = $request->input('player_id');

        \Log::info('RoomDisconnect called for player ID: ' . $player_id);
        
        Players::where('id', $player_id)->delete();
    
        return response()->json(['status' => 'success'], 200);
    }

    public function StartGame(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        $isReady = Players::where('room_id', $room_id)->where('status', 0)->first();
        if($isReady) {
            return response()->json(['status' => 'Some players are not ready yet.'], 401);
        }

        Rooms::where('id', $room_id)
                ->update([
                    'status' => 1,
                    'round_time' => now()->addMinutes(5)->toDateTimeString(),
                    'updated_at' => now()
                ]);
        
        $room = Rooms::where('id', $room_id)->first();
    
        return response()->json([
            'status' => 'success', 
            'invite_code' => $room->invite_code
        ], 200);
    }

    public function RoomRound(Request  $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        // $invite_code = 544062;

        $room = Rooms::where('invite_code', $invite_code)->first();
        
        $players = Players::where('room_id', $room->id)->get();

        $rooms_cards = Rooms_Cards::leftJoin('cards', 'rooms_cards.card_code', '=', 'cards.card_code')
                                    ->select('rooms_cards.*', 'cards.card_name as card_name', 'cards.details as details',
                                            'cards.image as image')
                                    ->where('room_id', $room->id)
                                    ->get();
                                    
        return view('RoomRound', compact('room', 'players', 'rooms_cards'));
    }

    public function PollCards(Request $request) {
        $room_id = $request->input('room_id');
        
        $rooms_cards = Rooms_Cards::leftJoin('cards', 'rooms_cards.card_code', '=', 'cards.card_code')
                                    ->select('rooms_cards.*', 'cards.card_name as card_name', 'cards.details as details',
                                            'cards.image as image')
                                    ->where('room_id', $room_id)
                                    ->get();
    
        return response()->json([
            'status' => 'success', 
            'rooms_cards' => $rooms_cards
        ], 200);
    }

    public function CardAdd(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $card_code = ($request->has('card_code')) ? trim($request->input('card_code')) : null;
        
        if (!$card_code) {
            $status = 'Please enter card code.';
            return response()->json(['status' => $status], 401);
        }

        $isCard = Cards::where('card_code', $card_code)->first();
        if(!$isCard) {
            $status = 'Not the correct card code.';
            return response()->json(['status' => $status], 401);
        }

        $InsertRow = new Rooms_Cards;
        $InsertRow->room_id = $room_id;
        $InsertRow->card_code = $card_code;
        $InsertRow->save();

        return response()->json(['status' => 'success'], 200);
    }
    
}
