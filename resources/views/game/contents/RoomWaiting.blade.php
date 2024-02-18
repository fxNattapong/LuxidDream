<title>Room Waiting</title>

@extends('game.layouts.Layout')

@section('Content')
    <div class="flex-col flex items-center justify-center mt-[5em]">
        <!-- START LOGO -->
        <div class="z-50 w-[275px] max-sm:w-[250px] absolute">
            <img src="{{ URL('assets/logo.png') }}" alt="">
        </div>
        <!-- END LOGO -->

        <!-- START CONTENT -->
        <div class="flex-col flex items-center justify-center">
            <div class="z-[100] grid grid-cols-3 gap-8">
                <!-- START INVITE -->
                <div class="z-50 w-[350px] mx-auto max-lg:col-span-3">
                    <div class="z-50 relative flex-col flex items-center justify-center w-[350px] border border-gray-300 p-8 rounded-3xl space-y-[1em] overflow-hidden max-lg:py-4">
                        <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-50"></div>

                        <div class="z-20 relative flex-col flex items-center space-y-[2em]">
                            <h1 class="text-white text-3xl">Invite Code</h1>
                            <div class="w-full grid grid-cols-3 gap-2">
                                <input id="room_id" type="text" class="hidden" readonly>
                                <input id="invite_code" type="text" class="col-span-2 w-full rounded-full bg-indigo-200 border border-white placeholder-white px-2 py-1 cursor-default" value="{{ $room->invite_code }}" readonly>
                                <button onclick="CopyInviteCode()" class="bg-[#4A3F98] rounded-full py-1 w-full border border-white text-white hover:bg-[#3e3877] duration-300">COPY</button>
                            </div>
                            @if(Session::get('creator'))
                                <div onclick="StartGame()" class="z-[20] bg-[#8A66A7] rounded-full py-1 w-full border border-white text-white text-center cursor-pointer hover:bg-[#6e4f88] duration-300">START</div>
                            @endif
                            @if(Session::get('player'))
                            <div class="w-full gap-2">
                                <input id="player_id" type="text" class="hidden" readonly>
                                <input id="player_status" type="text" class="hidden" readonly>
                                <button onclick="ChangeStatus()" id="btn-status" class="bg-[#E69FBC] rounded-full py-1 w-full border border-white text-white hover:bg-[#d1638a] duration-300">READY</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END INVITE -->

                <!-- START PLAYER -->
                <div id="grid-players" class="z-50 relative border border-gray-300 rounded-3xl p-2 col-span-2 grid grid-cols-2 max-lg:col-span-3 max-lg:mx-auto max-lg:mt-[1em]">
                    <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-50 rounded-3xl"></div>
                    <div class="absolute right-0 mt-[-40px]">
                        <span class="flex items-center px-2 py-1 font-bold text-gray-50 bg-gray-400 rounded-3xl">
                            <i class='bx bx-user text-xl'></i>&nbsp;
                            <span class="number_player">1</span>&nbsp;Players
                        </span>
                    </div>

                    @if($players)
                        @foreach($players as $player)
                            <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2">
                                <div class="relative inline-flex items-center w-full whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <i class='bx bxs-user text-2xl text-white' ></i>
                                        <input type="text" class="hidden player_id" value="{{ $player->player_id }}">
                                        <span class="player_name text-xl font-bold text-white">{{ $player->name_ingame }}</span>
                                    </div>
                                    <span class="span-status bg-white w-[20px] h-[20px] rounded-full ml-auto mr-0"></span>
                                    <span class="span-creator hidden text-indigo-900 bg-indigo-300 px-2 rounded-full ml-auto mr-0">CREATOR</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- END PLAYER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>

    <!-- START PROTOTYPES -->
    <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-50 rounded-3xl hidden bg-set-opacity"></div>
        <div class="absolute right-0 mt-[-40px] hidden NumberPlayerBoxPt">
            <span class="flex items-center px-2 py-1 font-bold text-gray-50 bg-gray-400 rounded-3xl">
                <i class='bx bx-user text-xl'></i>&nbsp;
                <span class="number_player">5</span>&nbsp;Players
            </span>
        </div>

        <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2 hidden PlayerBoxPt">
        <div class="relative inline-flex items-center w-full whitespace-nowrap">
            <div class="flex items-center gap-2">
                <i class='bx bxs-user text-2xl text-white' ></i>
                <input type="text" class="hidden player_id">
                <span class="player_name text-xl font-bold text-white">name</span>
            </div>
            <span class="span-status-color w-[20px] h-[20px] rounded-full ml-auto mr-0"></span>
            <span class="span-creator hidden text-indigo-900 bg-indigo-300 px-2 rounded-full ml-auto mr-0">CREATOR</span>
        </div>
    </div>
    <!-- END PROTOTYPES -->
    
@endsection

@section('script')
    <script>
        const sessionUsername = '<?php echo Session::get('username') ?>';
        const sessionName = '<?php echo Session::get('name_ingame') ?>';
        const creatorName = '<?php echo $room->creator_name ?>';

        $(document).ready(function() {
            const room_id = '<?php echo $room->room_id ; ?>';
            $('#room_id').val(room_id);

        });

        function CopyInviteCode() {
            var copyText = document.getElementById("invite_code");

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);
        }

        document.addEventListener('DOMContentLoaded', function () {
            $('#loading').addClass('hidden');

            @if($players && !empty($players)) 
                var room_id = <?php echo $room->room_id ?>;
                pollPlayers(room_id);
            @endif
        });

        function pollPlayers(room_id){
            setInterval(() => {
                fetch("{{ Route('pollPlayers') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            room_id: room_id
                        }
                    )
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null; 

                    if(!response.ok){
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    console.log('data:', data);

                    if(data.room.status === 1) {
                        window.location.href = "{{ Route('RoomPlay', ['invite_code' => '']) }}" + data.room.invite_code;
                    }
                    
                    $('#grid-players').empty();
                    var BgBox = $('.bg-set-opacity').clone();
                    BgBox.removeClass("hidden");
                    $("#grid-players").append(BgBox);

                    var NumberPlayerBox = $('.NumberPlayerBoxPt').clone();
                    NumberPlayerBox.removeClass("hidden");
                    NumberPlayerBox.find('.number_player').text(data.players.length);
                    $("#grid-players").append(NumberPlayerBox);

                    if(data.players.length > 0) {
                        for(let i=0; i<data.players.length; i++) {
                            var PlayerBox = $('.PlayerBoxPt').clone();
                            PlayerBox.removeClass("hidden PlayerBoxPt");
                            PlayerBox.find('.player_id').val(data.players[i].player_id);
                            PlayerBox.find('.player_name').text(data.players[i].name_ingame);

                            if(data.players[i].status === 0) {
                                PlayerBox.find('.span-status-color').addClass('bg-[#FD0000]');
                            } else {
                                PlayerBox.find('.span-status-color').addClass('bg-[#50D255]');
                            }
                            
                            if(data.players[i].username === creatorName) {
                                PlayerBox.find('.span-status-color').removeClass('span-status-color w-[20px] h-[20px]')
                                                                    .addClass('text-indigo-900 bg-indigo-300 px-2')
                                                                    .text('Creator');
                            } else if(data.players[i].name_ingame === sessionName) {
                                if(data.players[i].status === 0) {
                                    PlayerBox.find('.span-status-color').removeClass('w-[20px] h-[20px]')
                                                                        .addClass('bg-[#FD0000] text-white px-2')
                                                                        .text('YOU');
                                    $('#player_id').val(data.players[i].player_id);
                                    $('#player_status').val(0);
                                    $('#btn-status').text('READY').removeClass('bg-[#ff5757] hover:bg-[#fd0000]')
                                                                    .addClass('bg-[#E69FBC] hover:bg-[#d1638a]');
                                } else {
                                    PlayerBox.find('.span-status-color').removeClass('w-[20px] h-[20px]')
                                                                        .addClass('bg-[#50D255] text-white px-2')
                                                                        .text('YOU');
                                    $('#player_id').val(data.players[i].player_id);
                                    $('#player_status').val(1);
                                    $('#btn-status').text('NOT READY').removeClass('bg-[#E69FBC] hover:bg-[#d1638a]')
                                                                        .addClass('bg-[#ff5757] hover:bg-[#fd0000]');

                                }
                            } else {
                                if(data.players[i].status === 0) {
                                    PlayerBox.find('.span-status-color').addClass('bg-[#FD0000] text-white px-2');
                                    $('#player_id').val(data.players[i].player_id);
                                    $('#player_status').val(0);
                                    $('#btn-status').text('READY').removeClass('bg-[#ff5757] hover:bg-[#fd0000]')
                                                                    .addClass('bg-[#E69FBC] hover:bg-[#d1638a]');
                                } else {
                                    PlayerBox.find('.span-status-color').addClass('bg-[#50D255] text-indigo-900 px-2'); 
                                    $('#player_id').val(data.players[i].player_id);      
                                    $('#player_status').val(1);
                                    $('#btn-status').text('NOT READY').removeClass('bg-[#E69FBC] hover:bg-[#d1638a]')
                                                                        .addClass('bg-[#ff5757] hover:bg-[#fd0000]');
                                }
                            }
                            

                            $("#grid-players").append(PlayerBox);
                        }
                    }

                })
                .catch((er) => {
                    console.log('Error' + er);
                });
            }, 1000);
        }


        var isLoading = false;

        function ChangeStatus(){
            if(!isLoading) {
                isLoading = true;
                $('#loading').removeClass('hidden');
                fetch("{{ Route('ChangeStatus') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            player_id: document.getElementById("player_id").value,
                            status: document.getElementById("player_status").value,
                        }
                    )
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null; 
            
                    if(!response.ok){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Can not change status!',
                            html: `${data.status}`,
                            confirmButtonText: 'ตกลง'
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                }).catch((er) => {
                    console.log('Error: ' + er);
                })
                .finally(() => {
                    isLoading = false;
                    $('#loading').addClass('hidden');
                });
            }
        }

        // window.addEventListener('beforeunload', function (event) {
        //     RoomDisconnect();
        // });

        function RoomDisconnect(){
            if(!isLoading) {
                isLoading = true;
                fetch("{{ Route('RoomDisconnect') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            player_id: document.getElementById("player_id").value,
                        }
                    )
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null; 
            
                    if(!response.ok){
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                }).catch((er) => {
                    console.log('Error: ' + er);
                })
                .finally(() => {
                    isLoading = false;
                });
            }
        }

        function StartGame(){
            if(!isLoading) {
                isLoading = true;
                fetch("{{ Route('StartGame') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            room_id: document.getElementById("room_id").value,
                        }
                    )
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null; 
            
                    if(!response.ok){
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Can not start game!',
                            html: `${data.status}`,
                            confirmButtonText: 'ตกลง'
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    window.location.href = "{{ Route('RoomPlay', ['invite_code' => '']) }}" + data.invite_code;
                    
                }).catch((er) => {
                    console.log('Error: ' + er);
                })
                .finally(() => {
                    isLoading = false;
                });
            }
        }
    </script>
@endsection