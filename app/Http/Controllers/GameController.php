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

    public function RoomCreate(Request $request) {
        $number_player = ($request->has('number_player')) ? trim($request->input('number_player')) : null;
        $name = ($request->has('name')) ? trim($request->input('name')) : null;
        
        if ($name && $number_player) {
            $InsertRow = new Rooms;
            $InsertRow->invite_code = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            $InsertRow->number_player = $number_player;
            $InsertRow->creator_name = $name;
            $InsertRow->save();

            session::put('creator', true);
        
            return response()->json([
                'status' => 'success',
                'id' => $InsertRow->id,
                'invite_code' => $InsertRow->invite_code,
                'number_player' => $InsertRow->number_player,
            ], 200);
        } else {
            $status = 'กรุณากรอกชื่อและจำนวนผู้เล่น';
            return response()->json(['status' => $status], 401);
        }
    }

    public function RoomJoin() {

        return view('RoomJoin', compact('data'));
    }

    public function RoomJoining(Request $request) {
        $invite_code = ($request->has('invite_code')) ? trim($request->input('invite_code')) : null;
        $name = ($request->has('name')) ? trim($request->input('name')) : null;

        $isInvite = Rooms::where('invite_code', $invite_code)->first();
        if($isInvite) {
            $InsertRow = new Players;
            $InsertRow->room_id = $isInvite->id;
            $InsertRow->name = $name;
            $InsertRow->save();

            session::put('player', true);

            $data = [
                'room_id' => $InsertRow->room_id,
                'player_id' => $InsertRow->id,
                'player_name' => $InsertRow->name,
            ];
            
            // broadcast(new RoomUpdated($data));
            // event(new RoomUpdated($data));
        
            return response()->json([
                'status' => 'success',
                'invite_code' => $invite_code,
                'id' => $InsertRow->id,
                'name' => $InsertRow->name,
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
