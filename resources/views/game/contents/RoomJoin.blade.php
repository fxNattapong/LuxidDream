<title>Join Room</title>

@extends('game.layouts.Layout')

@section('Content')

    <!-- START BUTTON -->
    <li class="flex-col flex items-center justify-center">
        <!-- START LOGO -->
        <div class="z-50 w-[275px] max-sm:w-[250px]">
            <img src="{{ URL('assets/logo.png') }}" alt="" class="w-full">
        </div>
        <!-- END LOGO -->

        <!-- START FORM -->
        <div class="z-50 relative flex-col flex items-center justify-center w-[350px] border border-gray-300 p-4 rounded-3xl space-y-[1em] overflow-hidden">
            <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-50"></div>

            <div class="z-20 relative flex-col flex items-center space-y-[2em]">
                <div class="w-full">
                    <h1 class="text-white text-3xl text-center mb-[0.5em]">Invite Code ...</h1>
                    <input id="invite_code_join" type="text" class="w-full rounded-full bg-indigo-200 border border-white placeholder-white px-2 py-1" value="" placeholder="Enter your code...">
                </div>
                <div>
                    <span class="text-white">Your name:</span>
                    <input id="name_ingame_join" type="text" class="w-full rounded-full bg-indigo-200 border border-white placeholder-white px-2 py-1" value="" placeholder="Enter your name...">
                </div>
                <button onclick="RoomJoining()" class="bg-[#EE609A] rounded-full py-1 w-full border border-white text-white hover:bg-[#d62c65] duration-300">JOIN</button>
            </div>
        </div>
        <!-- END FORM -->
    </li>
    <!-- END BUTTON -->

@endsection

@push('script')
    <script src="{{ URL('js/game/RoomJoin.js') }}" defer></script>
    <script>
        const RouteRoomJoining = "<?php echo Route('RoomJoining'); ?>";
        
        document.addEventListener('DOMContentLoaded', function () {
            $('#loading').addClass('hidden');

            @if($room) 
                window.location.href = '<?php echo Route('RoomWaiting', ['invite_code' => $room->invite_code]) ?>';
            @endif
        });
    </script>
@endpush