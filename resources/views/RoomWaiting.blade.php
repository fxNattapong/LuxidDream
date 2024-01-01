<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Room Waiting</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <script src="{{ asset('js/room-waiting.js') }}" defer></script>

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            Pusher.logToConsole = true;

            var pusher = new Pusher('747db8e1a1de6230bc8a', {
                cluster: 'ap1'
            });

            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                alert(JSON.stringify(data));
            });
        </script>
    </head>
    <body>

        <div class="z-10 relative min-h-screen">
            <div class="absolute top-0 left-0 flex-shrink-0 h-full w-full object-cover">
                <img src="{{ URL('/assets/'.'bg.png') }}" alt="" class="w-full h-full object-cover my-auto" alt="bg">
            </div>

            <!-- START IMAGES / RIGHT BAR -->
            <div class="z-[100] top-0 left-0 flex w-full mb-[2em] max-lg:flex-col">
                <!-- START IMAGES -->
                <div class="z-[100] flex items-center w-fit ml-[5em] gap-2 max-lg:mx-auto">
                    <div class="max-w-[125px] max-h-[125px] overflow-hidden">
                        <img src="{{ URL('assets/mini-logo.png') }}" alt="" class="w-full h-full my-auto" alt="logo">
                    </div>
                    <div class="max-w-[250px] h-auto overflow-hidden">
                        <img src="{{ URL('assets/logo.png') }}" alt="" class="w-full h-full my-auto" alt="logo">
                    </div>
                </div>
                <!-- END IMAGES -->

                <!-- START RIGHT BAR -->
                <ul class="z-[100] ml-auto mr-[5em] flex w-fit mt-[5em] gap-8 text-xl text-white font-medium whitespace-nowrap max-lg:mt-0 max-lg:mx-auto">
                    <li><a href="#!">How to play</a></li>
                    <li><a href="#!">Home</a></li>
                    <li><a href="#!">About</a></li>
                </ul>
                <!-- END RIGHT BAR -->
            </div>
            <!-- END IMAGES / RIGHT BAR -->

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
                                <i class='bx bx-user text-xl'></i>Max&nbsp;
                                <span class="number_player">{{ $room->number_player }}</span>&nbsp;Players
                            </span>
                        </div>

                        <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2">
                            <div class="relative inline-flex items-center w-full whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <i class='bx bxs-user text-2xl text-white' ></i>
                                    <span id="creator_name" class="text-xl font-bold text-white">{{ $room->creator_name }}</span>
                                </div>
                                <span class="text-indigo-900 bg-indigo-300 px-2 rounded-full ml-auto mr-0">CREATOR</span>
                            </div>
                        </div>

                        @if($players)
                            @foreach($players as $player)
                                <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2">
                                    <div class="relative inline-flex items-center w-full whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <i class='bx bxs-user text-2xl text-white' ></i>
                                            <input type="text" class="hidden player_id" value="{{ $player->id }}">
                                            <span class="player_name text-xl font-bold text-white">{{ $player->name }}</span>
                                        </div>
                                        <span class="bg-white w-[20px] h-[20px] rounded-full ml-auto mr-0"></span>
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
                <i class='bx bx-user text-xl'></i>Max&nbsp;
                <span class="number_player">5</span>&nbsp;Players
            </span>
        </div>

        <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2 hidden CreatorBoxPt">
            <div class="relative inline-flex items-center w-full whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <i class='bx bxs-user text-2xl text-white' ></i>
                    <span class="creator_name text-xl font-bold text-white">name</span>
                </div>
                <span class="text-indigo-900 bg-indigo-300 px-2 rounded-full ml-auto mr-0">CREATOR</span>
            </div>
        </div>

        <div class="z-20 border-[3px] border-dashed rounded-full m-1 h-fit px-4 py-2 hidden PlayerBoxPt">
            <div class="relative inline-flex items-center w-full whitespace-nowrap">
                <div class="flex items-center gap-2">
                    <i class='bx bxs-user text-2xl text-white' ></i>
                    <input type="text" class="hidden player_id">
                    <span class="player_name text-xl font-bold text-white">name</span>
                </div>
                <span class="status-color w-[20px] h-[20px] rounded-full ml-auto mr-0"></span>
            </div>
        </div>
        <!-- END PROTOTYPES -->
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const room_id = '<?php echo $room->id ; ?>';
            $('#room_id').val(room_id);

        });

        function CopyInviteCode() {
            var copyText = document.getElementById("invite_code");

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(copyText.value);
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if($players && !empty($players)) 
                var room_id = <?php echo $room->id ?>;
                pollPlayers(room_id);
            @endif
        });

        function pollPlayers(element){
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
                            room_id: element
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
                        window.location.href = "{{ Route('RoomRound', ['invite_code' => '']) }}" + data.room.invite_code;
                    }
                    
                    $('#grid-players').empty();
                    var BgBox = $('.bg-set-opacity').clone();
                    BgBox.removeClass("hidden");
                    $("#grid-players").append(BgBox);

                    var NumberPlayerBox = $('.NumberPlayerBoxPt').clone();
                    NumberPlayerBox.removeClass("hidden");
                    NumberPlayerBox.find('.number_player').text(data.room.number_player);
                    $("#grid-players").append(NumberPlayerBox);

                    var CreatorBox = $('.CreatorBoxPt').clone();
                    CreatorBox.removeClass("hidden");
                    CreatorBox.find('.creator_name').text(data.room.creator_name);
                    $("#grid-players").append(CreatorBox);

                    if(data.players.length > 0) {
                        const playerData = JSON.parse(window.sessionStorage.getItem('player'));
                        for(let i=0; i<data.players.length; i++) {
                            var PlayerBox = $('.PlayerBoxPt').clone();
                            PlayerBox.removeClass("hidden PlayerBoxPt");
                            PlayerBox.find('.player_id').val(data.players[i].id);
                            PlayerBox.find('.player_name').text(data.players[i].name);
                            if(data.players[i].status === 0) {
                                PlayerBox.find('.status-color').addClass('bg-[#FD0000]');
                            } else {
                                PlayerBox.find('.status-color').addClass('bg-[#50D255]');
                            }
                            if(playerData && data.players[i].name === playerData.name) {
                                if(data.players[i].status === 0) {
                                    PlayerBox.find('.status-color').removeClass('w-[20px] h-[20px] rounded-full ml-auto mr-0')
                                                                    .addClass('bg-[#FD0000] text-white px-2 rounded-full ml-auto mr-0')
                                                                    .text('YOU');
                                    $('#player_id').val(data.players[i].id);
                                    $('#player_status').val(0);
                                    $('#btn-status').text('READY').removeClass('bg-[#ff5757] hover:bg-[#fd0000]').addClass('bg-[#E69FBC] hover:bg-[#d1638a]');
                                } else {
                                    PlayerBox.find('.status-color').removeClass('w-[20px] h-[20px] rounded-full ml-auto mr-0')
                                                                    .addClass('bg-[#50D255] text-indigo-900 px-2 rounded-full ml-auto mr-0')
                                                                    .text('YOU'); 
                                    $('#player_id').val(data.players[i].id);      
                                    $('#player_status').val(1);
                                    $('#btn-status').text('NOT READY').removeClass('bg-[#E69FBC] hover:bg-[#d1638a]').addClass('bg-[#ff5757] hover:bg-[#fd0000]');
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
            console.log('status: ' + document.getElementById("player_status").value);
            if(!isLoading) {
                isLoading = true;
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
                            title: 'เปลี่ยนสถานะไม่สำเร็จ!',
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
                });
            }
        }

        window.addEventListener('beforeunload', function (event) {
            RoomDisconnect();
        });

        function RoomDisconnect(){
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

        function StartGame(){
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

                // window.location.href = "{{ Route('RoomRound') }}";
                window.location.href = "{{ Route('RoomRound', ['invite_code' => '']) }}" + data.invite_code;
                
            }).catch((er) => {
                console.log('Error: ' + er);
            })
            .finally(() => {
                isLoading = false;
            });
        }
    </script>
    
</html>