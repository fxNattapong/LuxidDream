<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

        <title>Home</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>

        <div class="z-10 relative min-h-screen">
            <div class="absolute top-0 left-0 flex-shrink-0 h-full w-full object-cover">
                <img src="{{ URL('/assets/'.'bg.png') }}" alt="" class="w-full h-full object-cover my-auto" alt="bg">
            </div>

            <div class="z-[100] top-0 left-0 flex w-full mb-[2em] max-lg:flex-col">
                <!-- START IMAGES -->
                <div class="z-[100] flex items-center w-fit ml-[5em] mt-[3em] max-lg:mx-auto">
                    <div class="max-w-[125px] max-h-[125px] overflow-hidden">
                        <img src="{{ URL('assets/mini-logo.png') }}" alt="" class="w-full h-full my-auto" alt="logo">
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

            <!-- START BUTTON -->
            <li class="flex-col flex items-center justify-center">
                <!-- START LOGO -->
                <div class="z-50 w-[350px]">
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
        </div>
    </body>

    <!-- START MODAL LOGIN -->
    <div id="modal-room-create" class="modal hidden fixed z-[100] flex left-0 top-0 w-[100%] h-[100%] overflow-auto max-md:px-[10px]">
        <!-- START MODAL CONTENT -->
        <div class="z-50 modal-content relative flex-col flex items-center justify-center w-[350px] h-fit m-auto border border-gray-300 p-8 rounded-3xl space-y-[1em] overflow-hidden">
            <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-70"></div>
            <span id="icon-close-room-create" class="z-20 text-white text-[30px] font-medium absolute top-0 right-0 m-0 mr-6 hover:text-gray-400 cursor-pointer duration-300">&times;</span>

            <div class="z-20 relative flex-col flex items-center space-y-[0.75em] w-full">
                <form action="#!" method="post" onsubmit="return false;">
                    @csrf
                    <h1 class="uppercase text-white text-3xl font-bold">Create Room</h1>
                    <div class="flex-col w-full text-white font-bold">
                        <i class='bx bxs-user-account text-xl' ></i>
                        <label for="">Your name:</label>
                        <input id="name_create" type="text" class="w-full rounded-full bg-indigo-200 border border-white text-gray-700 placeholder-gray-500 px-2 py-1" value="" placeholder="Enter your name...">
                    </div>
                    <div class="flex-col w-full text-white font-bold pb-[1em]">
                        <i class='bx bxs-user text-xl' ></i>
                        <label for="">Number players:</label>
                        <input id="number_player_create" type="number" min="1" max="8" value="1" class="w-full rounded-full bg-indigo-200 border border-white text-gray-700 placeholder-gray-500 px-2 py-1">
                    </div>

                    <button onclick="RoomCreate()" class="bg-[#EE609A] rounded-full py-1 w-full border border-white text-white hover:bg-[#d62c65] duration-300">CREATE</button>
                </form>
            </div>
        </div>
        <!-- END MODAL CONTENT -->
    </div>
    <!-- END MODAL LOGIN -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
                            name: document.getElementById("name_create").value,
                            number_player: document.getElementById("number_player_create").value,
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
                            title: 'สร้างห้องไม่สำเร็จ!',
                            html: `${data.status}`,
                            confirmButtonText: 'ตกลง'
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    window.sessionStorage.setItem('creator_room', JSON.stringify({
                        room_id: data.id,
                        invite_code: data.invite_code,
                        number_player: data.number_player,
                        name: document.getElementById("name_create").value,
                    }));

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'สร้างห้องสำเร็จ',
                        confirmButtonText: 'ตกลง',
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
</html>