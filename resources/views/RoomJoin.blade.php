<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Join Room</title>

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
                <div class="z-50 w-[350px]">
                    <!-- START LOGO -->
                    <img src="{{ URL('assets/logo.png') }}" alt="" class="w-full">
                    <!-- END LOGO -->
                    
                    <div class="z-50 relative flex-col flex items-center justify-center w-[350px] border border-gray-300 p-8 rounded-3xl space-y-[1em] overflow-hidden">
                        <div class="z-10 w-full h-full absolute top-0 left-0 bg-[#4A4098] opacity-50"></div>

                        <div class="z-20 relative flex-col flex items-center space-y-[2em]">
                            <div class="w-full">
                                <h1 class="text-white text-3xl text-center mb-[0.5em]">Invite Code ...</h1>
                                <input id="invite_code_join" type="text" class="w-full rounded-full bg-indigo-200 border border-white placeholder-white px-2 py-1" value="" placeholder="Enter your code...">
                            </div>
                            <div>
                                <span class="text-white">Your name:</span>
                                <input id="name_join" type="text" class="w-full rounded-full bg-indigo-200 border border-white placeholder-white px-2 py-1" value="" placeholder="Enter your name...">
                            </div>
                            <button onclick="RoomJoining()" class="bg-[#EE609A] rounded-full py-1 w-full border border-white text-white hover:bg-[#d62c65] duration-300">JOIN</button>
                        </div>
                    </div>
                </div>
            </li>
            <!-- END BUTTON -->
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        
        var isLoading = false;

        function RoomJoining(){
            if(!isLoading) {
                isLoading = true;
                fetch("{{ Route('RoomJoining') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            invite_code: document.getElementById("invite_code_join").value,
                            name: document.getElementById("name_join").value,
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
                            title: 'เข้าห้องไม่สำเร็จ!',
                            html: `${data.status}`,
                            confirmButtonText: 'ตกลง'
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    window.sessionStorage.setItem('player', JSON.stringify({
                        player_id: data.id,
                        name: data.name,
                    }));

                    window.location.href = "{{ Route('RoomWaiting', ['invite_code' => '']) }}" + data.invite_code;

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