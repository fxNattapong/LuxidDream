<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Players;
use App\Models\Players_Stats;
use App\Models\Players_Rule;
use App\Models\Levels;
use App\Models\Nightmares;
use App\Models\Cards;
use App\Models\Links;
use App\Models\Rooms;
use App\Models\Rooms_Players;
use App\Models\Rooms_Cards;
use App\Models\Rooms_Nightmares;
use App\Models\Rooms_Links;

// use App\Events\RoomUpdated;

class GameController extends Controller
{
    public function Home() {
        $levels = Levels::All();

        $players_rule = Players_Rule::All();

        $room = [];
        if(Session::get('player_id')) {
            $isCreated = Rooms_Players::where('player_id', Session::get('player_id'))
                                        ->whereIn('status', [0, 1])
                                        ->first();

            if($isCreated) {
                $room = Rooms::where('room_id', $isCreated->room_id)->first();

                $status = (Session::get('username') === $room->creator_name) ? 1 : 0;

                Rooms_Players::where('room_id', $room->room_id)
                                ->where('player_id', Session::get('player_id'))
                                ->update([
                                    'status' => $status,
                                    'updated_at' => now()
                                ]);

                $isCreator = (Session::get('username') === $room->creator_name);
                Session::put('creator', $isCreator);
                Session::put('player', !$isCreator);
                Session::put('username', Session::get('username'));
                Session::put('name_ingame', $isCreated->name_ingame);

                return redirect()->Route('RoomWaiting', ['invite_code' => $room->invite_code]);
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
            return response()->json(['status' => $status], 400);
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
                                        ->whereIn('status', [0, 1])
                                        ->first();

            if($isCreated) {
                $room = Rooms::where('room_id', $isCreated->room_id)->first();

                $status = (Session::get('username') === $room->creator_name) ? 1 : 0;

                Rooms_Players::where('room_id', $room->room_id)
                                ->where('player_id', Session::get('player_id'))
                                ->update([
                                    'status' => $status,
                                    'updated_at' => now()
                                ]);

                $isCreator = (Session::get('username') === $room->creator_name);
                Session::put('creator', $isCreator);
                Session::put('player', !$isCreator);
                Session::put('username', Session::get('username'));
                Session::put('name_ingame', $isCreated->name_ingame);

                return redirect()->Route('RoomWaiting', ['invite_code' => $room->invite_code]);
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
        $isJoining = Rooms_Players::where('room_id', $isRoom->room_id)
                                ->where('player_id', $player->player_id)
                                ->first();
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
                    ->select('rooms.*', 'players_rule.amount as amount', 'levels.level as level', 'levels.round as level_round')
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

        if($room->round !== 0) {
            return redirect()->Route('RoomPlay', ['invite_code' => $room->invite_code]);
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

        if ($room->round !== 0) {
            return redirect()->Route('RoomPlay', ['invite_code' => $room->invite_code]);
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
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;
        $status = ($request->has('status')) ? trim($request->input('status')) : null;

        if($status == 0) {
            $status = 1;
        } else {
            $status = 0;
        }
        
        Rooms_Players::where('room_id', $room_id)
                    ->where('player_id', $player_id)
                    ->update([
                        'status' => $status,
                        'updated_at' => now()
                    ]);
    
        return response()->json(200);
    }

    public function RoomDisconnect(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $player_id = ($request->has('player_id')) ? trim($request->input('player_id')) : null;

        if(Session::get('player')) {
            Rooms_Players::where('room_id', $room_id)
                        ->where('player_id', $player_id)
                        ->update([
                            'status' => 0,
                            'updated_at' => now()
                        ]);
        }

    
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
                    'round' => 1,
                    'circle' => 1,
                    'updated_at' => now()
                ]);
        
        $room = Rooms::where('room_id', $room_id)->first();
        $nmStart = Nightmares::where('type', 5)->first();
        $link_empty = Links::where('type', 1)->first();
        $link_dream = Links::where('type', 2)->first();
        
        $InsertRoomLinkEmpty = new Rooms_Links;
        $InsertRoomLinkEmpty->room_id = $room_id;
        $InsertRoomLinkEmpty->link_id = $link_empty->link_id;
        $InsertRoomLinkEmpty->status = 1;
        $InsertRoomLinkEmpty->save();
        
        $InsertRoomNM = new Rooms_Nightmares;
        $InsertRoomNM->room_id = $room_id;
        $InsertRoomNM->room_link_id = $InsertRoomLinkEmpty->id;
        $InsertRoomNM->nightmare_id = $nmStart->nightmare_id;
        $InsertRoomNM->circle = 1;
        $InsertRoomNM->save();

        Rooms_Links::where('room_link_id', $InsertRoomLinkEmpty->id)
                    ->update([
                        'nightmare_id' => $InsertRoomNM->id,
                        'updated_at' => now()
                    ]);

        // $existingNightmaresIds = Rooms_Nightmares::pluck('nightmare_id')->toArray();
        // $nmRandom = Nightmares::whereNotIn('nightmare_id', array_merge($existingNightmaresIds, [17]))
        //                         ->inRandomOrder()
        //                         ->limit(4)
        //                         ->get()
        //                         ->toArray();

        $existingNightmaresIds = Rooms_Nightmares::pluck('nightmare_id')->toArray();
        $randomNightmareIds = [];
        $previousType = null;

        $excludedNightmares = array_merge($existingNightmaresIds, [17]);

        while (count($randomNightmareIds) < 4) {
            $randomNightmare = Nightmares::whereNotIn('nightmare_id', $excludedNightmares)
                                          ->where('type', '!=', $previousType)
                                          ->inRandomOrder()
                                          ->first();
        
            if ($randomNightmare) {
                $randomNightmareIds[] = $randomNightmare->nightmare_id;
                $previousType = $randomNightmare->type;
                $excludedNightmares[] = $randomNightmare->nightmare_id;
            }
        }
        $nmRandom = Nightmares::whereIn('nightmare_id', $randomNightmareIds)
                                ->get()
                                ->toArray();
        $fourthNightmare = end($nmRandom);

        foreach ($nmRandom as $nightmare) {
            $InsertRoomLinkDream = new Rooms_Links;
            $InsertRoomLinkDream->room_id = $room_id;
            $InsertRoomLinkDream->link_id = $link_dream->link_id;
            if ($nightmare === $fourthNightmare) {
                $InsertRoomLinkDream->link_id = $link_empty->link_id;
                $InsertRoomLinkDream->status = 1;
            }
            $InsertRoomLinkDream->save();

            $InsertNM = new Rooms_Nightmares;
            $InsertNM->room_id = $room_id;
            $InsertNM->room_link_id = $InsertRoomLinkDream->id;
            $InsertNM->nightmare_id = $nightmare['nightmare_id'];
            $InsertNM->circle = 1;
            $InsertNM->save();

            Rooms_Links::where('room_link_id', $InsertRoomLinkDream->id)
                    ->update([
                        'nightmare_id' => $InsertNM->id,
                        'updated_at' => now()
                    ]);
        }

        return response()->json([
            'redirect_url' => Route('RoomPlay', ['invite_code' => $room->invite_code])
        ], 200);
    }


    
    public function RoomPlay(Request  $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;

        $room = Rooms::where('invite_code', $invite_code)->first();

        if(!$room) {
            return redirect()->Route('Home');
        }
        
        $players = Rooms_Players::where('room_id', $room->room_id)->get();

        $room_nightmares = Rooms_Nightmares::leftJoin('nightmares', 'rooms_nightmares.nightmare_id', '=', 'nightmares.nightmare_id')
                                            ->leftJoin('rooms_links', 'rooms_nightmares.room_link_id', '=', 'rooms_links.room_link_id')
                                            ->leftJoin('links', 'rooms_links.link_id', '=', 'links.link_id')
                                            ->where('rooms_nightmares.room_id', $room->room_id)
                                            ->where('rooms_nightmares.circle', $room->circle)
                                            ->select('rooms_nightmares.*', 
                                                    'nightmares.type as nm_type', 'nightmares.description as nm_description', 'nightmares.image as nm_image', 
                                                    'rooms_links.room_link_id as room_link_id', 'links.type as link_type', 'links.image as link_image')
                                            ->get();

        // echo '<pre>';
        // print_r($room_nightmares);
        // echo '</pre>';
                                    
        return view('game/contents/RoomPlay', compact('room', 'players', 'room_nightmares', 'room_card'));
    }

    public function PollLinks(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $circle = ($request->has('circle')) ? trim($request->input('circle')) : null;
        $room = Rooms::where('room_id', $room_id)->first();
        
        if (!$room) {
            return redirect()->Route('Home');
        }

        if(Session::get('player_id')) {
            $isJoined = Rooms_Players::where('player_id', Session::get('player_id'))
                                    ->where('room_id', $room_id)
                                    ->first();
            if(!$isJoined) {
                return redirect()->Route('Home');
            }
        }

        $links = Rooms_Nightmares::leftJoin('rooms_links', 'rooms_nightmares.room_link_id', '=', 'rooms_links.room_link_id')
                                ->leftJoin('links', 'rooms_links.link_id', '=', 'links.link_id')
                                ->select('rooms_nightmares.*', 'rooms_links.status as room_link_status', 'links.image as link_image')
                                ->where('rooms_nightmares.room_id', $room_id)
                                ->where('rooms_nightmares.circle', $circle)
                                ->orderBy('rooms_nightmares.room_nightmare_id', 'asc')
                                ->get();
        
        return response()->json([
            'room' => $room, 
            'links' => $links
        ], 200);
    }

    public function StartTimer(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        $isTime = Rooms::leftJoin('levels', 'rooms.level_id', '=', 'levels.level_id')
                        ->where('rooms.room_id', $room_id)
                        ->select('rooms.*', 'levels.level as level', 'levels.round as level_round',
                                'levels.time_1 as time_1', 'levels.time_2 as time_2', 'levels.time_3 as time_3', 
                                'levels.time_4 as time_4', 'levels.time_5 as time_5')
                        ->first();

        $roundTimes = [
            1 => $isTime->time_1,
            2 => $isTime->time_2,
            3 => $isTime->time_3,
            4 => $isTime->time_4,
            5 => $isTime->time_5,
        ];
        $set_time = $roundTimes[$isTime->round] ?? null;

        Rooms::where('room_id', $room_id)
                ->update([
                    'time' => now()->addMinutes($set_time)->toDateTimeString(),
                    'updated_at' => now()
                ]);
        
        $room = Rooms::where('room_id', $room_id)->first();
    
        return response()->json([
            'status' => 'success', 
            'round_time' => $room->time
        ], 200);
    }

    public function EndTimer(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;
        $circle = ($request->has('circle')) ? trim($request->input('circle')) : null;

        Rooms::where('room_id', $room_id)->update([
            'time' => now(),
            'updated_at' => now()
        ]);

        $room = where('room_id', $room_id)->first();
        
        return response()->json([
            'round_time' => $room->time
        ], 200);
    }

    public function FetchTimeout(Request $request) {
        $room_id = ($request->has('room_id')) ? trim($request->input('room_id')) : null;

        $room = Rooms::where('room_id', $room_id)
                    ->select('time')
                    ->first();
        
        return response()->json(['room' => $room], 200);
    }

    public function FetchCards(Request  $request) {
        $room_link_id = ($request->has('room_link_id')) ? trim($request->input('room_link_id')) : null;

        $room_link = Rooms_Links::leftJoin('links', 'rooms_links.link_id', '=', 'links.link_id')
                                ->where('rooms_links.room_link_id', $room_link_id)
                                ->select('rooms_links.*', 'links.type as link_type', 'links.image as link_image')
                                ->first();

        $cards = Rooms_Cards::leftJoin('cards', 'rooms_cards.code', '=', 'cards.code')
                            ->where('room_link_id', $room_link_id)
                            ->select('rooms_cards.*', 'cards.color as card_color', 'cards.image as card_image', 
                                    'cards.name as card_name', 'cards.description as card_description')
                            ->get();

                                    
        return response()->json([
            'room_link' => $room_link,
            'cards' => $cards
        ], 200);
    }

    public function CardAdd(Request $request) {
        $nightmare_id_1 = ($request->has('nightmare_id_1')) ? trim($request->input('nightmare_id_1')) : null;
        $room_link_id = ($request->has('room_link_id')) ? trim($request->input('room_link_id')) : null;
        $nightmare_id_2 = ($request->has('nightmare_id_2')) ? trim($request->input('nightmare_id_2')) : null;
        $card_code = ($request->has('card_code')) ? trim($request->input('card_code')) : null;
        $from_nm = ($request->has('from_nm')) ? trim($request->input('from_nm')) : null;
        
        if (!$card_code) {
            $status = 'กรุณากรอกรหัสการ์ด';
            return response()->json(['status' => $status], 400);
        }

        $isCard = Cards::where('code', $card_code)->first();
        if(!$isCard) {
            $status = 'รหัสการ์ดไม่ถูกต้อง';
            return response()->json(['status' => $status], 400);
        }

        $nightmares = Nightmares::whereIn('nightmare_id', [$nightmare_id_1, $nightmare_id_2])->get();
        if($isCard->color !== $nightmares[0]->type && $isCard->color !== $nightmares[1]->type) {
            $status = 'การ์ดใบนี้ไม่เข้าเงื่อนไข';
            return response()->json(['status' => $status], 400);
        }

        if($from_nm === 'left') {
            $isInsertedPosition0 = Rooms_Cards::where('room_link_id', $room_link_id)
                                                ->where('position', 0)
                                                ->exists();
    
            $isInsertedPosition1 = Rooms_Cards::where('room_link_id', $room_link_id)
                                                ->where('position', 1)
                                                ->exists();
        } else {
            $isInsertedPosition0 = Rooms_Cards::where('room_link_id', $room_link_id)
                                                ->where('position', 2)
                                                ->exists();
    
            $isInsertedPosition1 = Rooms_Cards::where('room_link_id', $room_link_id)
                                                ->where('position', 3)
                                                ->exists();
        }


        if($isInsertedPosition0 && $isCard->color === $nightmares[1]->type) {
            $status = 'การ์ดช่องที่ 1 ถูกใส่แล้ว';
            return response()->json(['status' => $status], 400);
        } else if ($isInsertedPosition1 && $isCard->color === $nightmares[0]->type) {
            $status = 'การ์ดช่องที่ 2 ถูกใส่แล้ว';
            return response()->json(['status' => $status], 400);
        } else {
            $InsertRow = new Rooms_Cards;
            $InsertRow->room_link_id = $room_link_id;
            $InsertRow->code = $card_code;
            if ($from_nm === 'left') {
                $InsertRow->position = ($isCard->color === $nightmares[1]->type) ? 0 : (($isCard->color === $nightmares[0]->type) ? 1 : null);
            } else {
                $InsertRow->position = ($isCard->color === $nightmares[1]->type) ? 2 : (($isCard->color === $nightmares[0]->type) ? 3 : null);
            }            
            
            $InsertRow->save();

            $card = Rooms_Cards::leftJoin('cards', 'rooms_cards.code', '=', 'cards.code')
                                ->where('rooms_cards.room_card_id', $InsertRow->id)
                                ->select('rooms_cards.*', 'cards.color as card_color', 'cards.image as card_image', 
                                        'cards.name as card_name', 'cards.description as card_description')
                                ->first();

            $cards = Rooms_Cards::where('room_link_id', $room_link_id)->get();
        }

        return response()->json([
            'card' => $card,
            'cards' => $cards
        ], 200);
    }

    public function CheckNightmareLink(Request $request) {
        $room_link_id = ($request->has('room_link_id')) ? trim($request->input('room_link_id')) : null;
        
        $isCards = Rooms_Cards::where('room_link_id', $room_link_id)->get();

        if($isCards->count() == 4) {
            $existingLinksIds = Rooms_Links::pluck('link_id')->toArray();
            $linkRandom = Links::whereNotIn('link_id', array_merge($existingLinksIds, [21, 22]))
                                ->inRandomOrder()
                                ->first();

            Rooms_Links::where('room_link_id', $room_link_id)
                        ->update([
                            'link_id' => $linkRandom->link_id,
                            'status' => 1,
                            'updated_at' => now()
                        ]);

            $room_link = Rooms_Links::leftJoin('links', 'rooms_links.link_id', '=', 'links.link_id')
                                    ->where('rooms_links.room_link_id', $room_link_id)
                                    ->select('rooms_links.*', 'links.type as link_type', 'links.image as link_image')
                                    ->first();
        }

        return response()->json(['room_link' => $room_link], 200);
    }
    
}
