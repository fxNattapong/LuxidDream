<title>Home</title>

@extends('game.layouts.Layout')

@section('Content')

    <!-- START BUTTON -->
    <li class="flex-col flex items-center justify-center">
        <!-- START LOGO -->
        <div class="z-50 w-[275px] max-sm:w-[250px]">
            <img src="{{ URL('assets/logo.png') }}" alt="">
        </div>
        <!-- END LOGO -->

        <!-- START BUTTON -->
        <div class="z-50">
            <div class="relative w-[350px]">
                <button id="btn-room-create" class="bg-violet-900 rounded-md w-full text-white text-center font-bold py-2 hover:text-gray-400 duration-300">
                    CRATE GAME
                </button>

                <a href="{{ Route('RoomJoin') }}">
                    <div class="mt-[1em] bg-violet-900 rounded-md w-full text-white text-center font-bold py-2 hover:text-gray-400 duration-300">
                        JOIN GAME
                    </div>
                </a>
            </div>
        </div>
        <!-- END BUTTON -->
    </li>
    <!-- END BUTTON -->


    <!-- START MODAL ROOM CREATE -->
    <div id="modal-room-create" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="z-50 modal-content relative flex-col flex items-center justify-center w-[350px] h-fit m-auto border border-gray-300 p-8 rounded-3xl space-y-[1em] overflow-hidden">
            <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-70"></div>
            <span id="icon-close-room-create" class="z-20 text-white text-[30px] font-medium absolute top-0 right-0 m-0 mr-6 hover:text-gray-400 cursor-pointer duration-300">&times;</span>

            <div class="z-20 relative flex-col flex items-center w-full mt-[-50px]">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <h1 class="uppercase text-white text-3xl font-bold text-center">Create Room</h1>
                    <div class=" mt-[0.75em] flex-col w-full text-white font-bold">
                        <i class='bx bxs-user-account text-xl' ></i>
                        <label for="">Your in-game name:</label>
                        <input id="name_ingame_create" type="text" class="w-full rounded-full bg-indigo-200 border border-white text-gray-700 placeholder-gray-500 px-2 py-1" value="" placeholder="Enter your name...">
                    </div>
                    <div class="mt-[0.75em] flex-col w-full text-white font-bold pb-[1em]">
                        <i class='bx bxs-layer text-xl' ></i>
                        <label for="">Level:</label>
                        <select id="level_id_create" class="bg-gray-50 border border-gray-300 rounded-full text-gray-700 text-md font-light focus:ring-indigo-500 focus:border-indigo-500 block w-full px-2 py-1 overflow-hidden">
                            @foreach($levels as $level)
                                <option value="{{ $level->level_id }}" class="font-light">
                                    @if($level->level === 0)
                                        ง่าย
                                    @elseif($level->level === 1)
                                        ปานกลาง
                                    @elseif($level->level === 2)
                                        ยาก
                                    @endif</option>
                            @endforeach
                        </select>
                    </div>

                    <button onclick="RoomCreate()" class="bg-[#EE609A] rounded-full py-1 w-full border border-white text-white hover:bg-[#d62c65] duration-300">CREATE</button>
                </form>
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL ROOM CREATE -->

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#loading').addClass('hidden');
        });

        $(document).ready(function() {
            // MODAL ROOM CREATE
            $('#btn-room-create').on('click', function() {
                $('#modal-room-create').removeClass('hidden');
            });
            $('#icon-close-room-create').on('click', function() {
                var modal = $('#modal-room-create');
                modal.addClass('fade-out-modal');

                setTimeout(function() {
                    modal.addClass('hidden');
                    modal.removeClass("fade-out-modal");
                }, 500);
            });
        });

        var sessionPlayerID = "<?php echo Session::get('player_id');  ?>";
        var sessionUsername = "<?php echo Session::get('username');  ?>";

        var isLoading = false;
        function RoomCreate(){
            if(!isLoading) {
                isLoading = true;
                fetch("{{ Route('RoomCreate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            player_id: sessionPlayerID,
                            username: sessionUsername,
                            name_ingame: document.getElementById("name_ingame_create").value,
                            level: document.getElementById("level_create").value,
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
                            title: 'Failed to create!',
                            html: `${data.status}`,
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Successfully created',
                        timer: 1000,
                        timerProgressBar: true
                    }).then((result) => {
                        window.location.href = "{{ Route('RoomWaiting', ['invite_code' => '']) }}" + data.invite_code;
                    })

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