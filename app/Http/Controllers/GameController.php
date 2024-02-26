<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Players;
use App\Models\Players_Stats;
use App\Models\Players_Rule;
use App\Models\Levels;
use App\Models\Cards;
use App\Models\Rooms;
use App\Models\Rooms_Players;
use App\Models\Rooms_Cards;
use App\Models\Rooms_Nightmares;

// use App\Events\RoomUpdated;

class GameController extends Controller
{
    public function Home() {
        $levels = Levels::All();

        $players_rule = Players_Rule::All();

        $room = [];
        if(Session::get('player_id')) {
            $isCreated = Rooms_Players::where('player_id', Session::get('player_id'))
                                        ->where('status', 2)
                                        ->first();

            if($isCreated) {
                $room = Rooms::where('room_id', $isCreated->room_id)->first();

                $status = (Session::get('username') === $room->creator_name) ? 1 : 0;

                Rooms_Players::where('player_id', Session::get('player_id'))
                                ->update([
                                    'status' => $status,
                                    'updated_at' => now()
                                ]);

                $isCreator = (Session::get('username') === $room->creator_name);
                Session::put('creator', $isCreator);
                Session::put('player', !$isCreator);
                Session::put('username', Session::get('username'));
                Session::put('name_ingame', $isCreated->name_ingame);
            }
        }


        return view('game/contents/Home', compact('levels', 'players_rule', 'room'));
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
            $InsertPlayer = new Players;
            $InsertPlayer->username = $username;
            $InsertPlayer->password = $password;
            $InsertPlayer->email = $email;
            $InsertPlayer->phone = $phone;
            $InsertPlayer->save();

            $InsertStats = new Players_Stats;
            $InsertStats->player_id = $InsertPlayer->id;
            $InsertStats->save();
        }

        return response()->json(200);
    }

    public function LoginProcess(Request $request) {
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $password = ($request->has('password')) ? trim($request->input('password')) : null;
        
        $isPlayer = Players::where('username', $username)->where('password', $password)->first();
        if($isPlayer) {
            $result = [
                'isOk' => true, 
                'username' => $username
            ];
            $statusCode = 200;

            session::put('authen', true);
            session::put('player_id', $isPlayer->player_id);
            session::put('username', $username);

            if($isPlayer->image) {
                session::put('image', $isPlayer->image);
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
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $name_ingame = ($request->has('name_ingame')) ? trim($request->input('name_ingame')) : null;
        $player_rule_id = ($request->has('player_rule_id')) ? trim($request->input('player_rule_id')) : null;
        $level_id = ($request->has('level_id')) ? trim($request->input('level_id')) : null;

        if(!$username) {
            $status = 'กรุณาเข้าสู่ระบบ';
            return response()->json(['status' => $status], 400);
        }
        if (!$name_ingame) {
            $status = 'กรุณากรอกชื่อในเกม';
            return response()->json(['status' => $status], 401);
        }

        $InsertRoom = new Rooms;
        $InsertRoom->player_rule_id = $player_rule_id;
        $InsertRoom->invite_code = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        $InsertRoom->creator_name = $username;
        $InsertRoom->level_id = $level_id;
        $InsertRoom->save();

        $InsertPlayer = new Rooms_Players;
        $InsertPlayer->player_id = $player_id;
        $InsertPlayer->room_id = $InsertRoom->id;
        $InsertPlayer->name_ingame = $name_ingame;
        $InsertPlayer->status = 1;
        $InsertPlayer->role = 1;
        $InsertPlayer->save();

        session::put('creator', true);
        session::put('username', $username);
        session::put('name_ingame', $name_ingame);
    
        return response()->json([
            'redirect_url' => Route('RoomWaiting', ['invite_code' => $InsertRoom->invite_code])
        ], 200);
    }



    public function RoomJoin() {
        $room = [];
        if(Session::get('player_id')) {
            $isCreated = Rooms_Players::where('player_id', Session::get('player_id'))
                                        ->where('status', 2)
                                        ->first();

            if($isCreated) {
                $room = Rooms::where('room_id', $isCreated->room_id)->first();

                $status = (Session::get('username') === $room->creator_name) ? 1 : 0;

                Rooms_Players::where('player_id', Session::get('player_id'))
                                ->update([
                                    'status' => $status,
                                    'updated_at' => now()
                                ]);

                $isCreator = (Session::get('username') === $room->creator_name);
                Session::put('creator', $isCreator);
                Session::put('player', !$isCreator);
                Session::put('username', Session::get('username'));
                Session::put('name_ingame', $isCreated->name_ingame);
            }
        }

        return view('game/contents/RoomJoin', compact('room'));
    }

    public function RoomJoining(Request $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;
        $username = ($request->has('username')) ? trim($request->input('username')) : null;
        $name_ingame = ($request->has('name_ingame')) ? trim($request->input('name_ingame')) : null;
        
        $isRoom = Rooms::where('invite_code', $invite_code)->first();
        if(!$isRoom) {
            $status = 'กรุณากรอกรหัสและชื่อ';
            return response()->json(['status' => $status], 400);
        }

        $player = Players::where('username', $username)->first();
        $isJoining = Rooms_Players::where('player_id', $player->player_id)->first();
        if($isJoining) {
            session::put('player', true);
            session::put('username', $username);
            session::put('name_ingame', $name_ingame);

            return response()->json([
                'redirect_url' => Route('RoomWaiting', ['invite_code' => $invite_code])
                ], 200);
        }

        $InsertPlayer = new Rooms_Players;
        $InsertPlayer->player_id = $player_id;
        $InsertPlayer->room_id = $isRoom->room_id;
        $InsertPlayer->name_ingame = $name_ingame;
        $InsertPlayer->save();

        session::put('player', true);
        session::put('username', $username);
        session::put('name_ingame', $name_ingame);
    
        return response()->json([
            'redirect_url' => Route('RoomWaiting', ['invite_code' => $invite_code])
        ], 200);
    }



    public function RoomWaiting(Request $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        
        $room = Rooms::leftJoin('players_rule', 'rooms.player_rule_id', '=', 'players_rule.player_rule_id')
                    ->leftJoin('levels', 'rooms.level_id', '=', 'levels.level_id')
                    ->select('rooms.*', 'players_rule.amount as amount', 'levels.level as level', 'levels.round as round')
                    ->where('invite_code', $invite_code)
                    ->first();

        if(Session::get('player_id')) {
            $isJoined = Rooms_Players::where('player_id', Session::get('player_id'))
                                    ->where('room_id', $room->room_id)
                                    ->first();
            if(!$isJoined) {
                return redirect()->Route('Home');
            }
        }

        $players = Rooms_Players::leftJoin('players', 'rooms_players.player_id', '=', 'players.player_id')
                                ->select('rooms_players.*', 'players.player_id as player_id', 'players.username as username')
                                ->where('room_id', $room->room_id)
                                ->get();

        $isStatus = Rooms_Players::where('player_id', Session::get('player_id'))
                                    ->where('status', 2)
                                    ->first();
        if($isStatus) {
            $status = (Session::get('username') === $room['creator_name']) ? 1 : 0;
            Rooms_Players::where('player_id', Session::get('player_id'))
                            ->update([
                                'status' => $status,
                                'updated_at' => now()
                            ]);
        }
        
        return view('game/contents/RoomWaiting', compact('room', 'players'));
    }

    public function RoomDelete(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        Rooms::where('room_id', $room_id)->delete();

        Rooms_Players::where('room_id', $room_id)->delete();
        
        return response()->json([
            'redirect_url' => Route('Home')
        ], 200);
    }

    public function PlayerRemove(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $room_player_id = ($request->has('room_player_id')) ? trim($request->input('room_player_id')) : null;

        $isPlayer = Rooms_Players::where('room_player_id', $room_player_id)->first();
        if(!$isPlayer) {
            $status = 'ไม่พบข้อมูลผู้เล่น';
            return response()->json(['status' => $status], 400);
        }

        $isCreator = Players::where('player_id', $isPlayer->player_id)->first();
        $isRoom = Rooms::where('room_id', $room_id)->first();
        if($isCreator->username === $isRoom->creator_name) {
            $status = 'ไม่สามารถลบตัวเองได้';
            return response()->json(['status' => $status], 400);
        }

        Rooms_Players::where('room_player_id', $room_player_id)->delete();
    
        return response()->json(200);
    }

    public function PollPlayers(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $room = Rooms::where('room_id', $room_id)->first();
        
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'redirect_url' => Route('Home')
            ], 200);
        }

        if(Session::get('player_id')) {
            $isJoined = Rooms_Players::where('player_id', Session::get('player_id'))
                                    ->where('room_id', $room_id)
                                    ->first();
            if(!$isJoined) {
                return redirect()->Route('Home');
            }
        }

        $players = Rooms_Players::leftJoin('players', 'rooms_players.player_id', '=', 'players.player_id')
                                ->select('rooms_players.*', 'players.player_id as player_id', 'players.username as username')
                                ->where('room_id', $room->room_id)
                                ->get();
        
        return response()->json([
            'room' => $room, 
            'players' => $players,
            'redirect_url' => Route('RoomPlay', ['invite_code' => $room->invite_code])
        ], 200);
    }

    public function ChangeStatus(Request $request) {
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;
        $status = ($request->has('status')) ? trim($request->input('status')) : null;

        if($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        
        Rooms_Players::where('player_id', $player_id)
                    ->update([
                        'status' => $status,
                        'updated_at' => now()
                    ]);
    
        return response()->json(200);
    }

    public function RoomDisconnect(Request $request) {
        Rooms_Players::where('player_id', Session::get('player_id'))
                    ->update([
                        'status' => 2,
                        'updated_at' => now()
                    ]);
    
        return response()->json(200);
    }

    public function StartGame(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        $isReady = Rooms_Players::where('room_id', $room_id)->where('status', 0)->first();
        if($isReady) {
            return response()->json(['status' => 'ผู้เล่นบางคนยังไม่พร้อม'], 400);
        }
        
        Rooms::where('room_id', $room_id)
                ->update([
                    'status' => 1,
                    'updated_at' => now()
                ]);
        
        $room = Rooms::where('room_id', $room_id)->first();

        $NightmaresRandom = Nightmares::inRandomOrder()->limit(5)->get()->toArray();
        foreach ($NightmaresRandom as $nightmare) {
            Rooms_Nightmares::create([
                'room_id' => $room_id,
                'nightmare_id' => $nightmare['nightmare_id'],
            ]);
        }

        return response()->json(['message' => 'บันทึกข้อมูลเรียบร้อยแล้ว'], 200);
    
        return response()->json([
            'redirect_url' => Route('RoomPlay', ['invite_code' => $room->invite_code])
        ], 200);
    }


    
    public function RoomPlay(Request  $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;

        $room = Rooms::where('invite_code', $invite_code)->first();
        
        $players = Rooms_Players::where('room_id', $room->id)->get();

        $room_card = Rooms_Cards::leftJoin('cards', 'rooms_cards.code', '=', 'cards.code')
                                    ->select('rooms_cards.*', 'cards.name as card_name', 'cards.description as description',
                                            'cards.image as image')
                                    ->where('room_id', $room->id)
                                    ->latest()
                                    ->first();
                                    
        return view('game/contents/RoomPlay', compact('room', 'players', 'room_card'));
    }

    public function StartTimer(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        Rooms::where('room_id', $room_id)
                ->update([
                    'status' => 1,
                    'round_time' => now()->addMinutes(5)->toDateTimeString(),
                    'updated_at' => now()
                ]);
        
        $room = Rooms::where('room_id', $room_id)->first();
    
        return response()->json([
            'status' => 'success', 
            'round_time' => $room->round_time
        ], 200);
    }

    public function PollCards(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        $room = Rooms::where('room_id', $room_id)->first();
        
        $room_cards = Rooms_Cards::leftJoin('cards', 'rooms_cards.card_code', '=', 'cards.card_code')
                                    ->select('rooms_cards.*', 'cards.card_name as card_name', 'cards.details as details',
                                            'cards.image as image')
                                    ->where('room_id', $room_id)
                                    ->latest()
                                    ->first();
    
        return response()->json([
            'room' => $room,
            'room_cards' => $rooms_cards
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
