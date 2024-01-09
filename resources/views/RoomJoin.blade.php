<title>Join Room</title>

@extends('components/Header')

@section('Content')

    <!-- START BUTTON -->
    <li class="flex-col flex items-center justify-center">
        <!-- START LOGO -->
        <div class="z-50 w-[300px] max-sm:w-[250px]">
            <img src="{{ URL('assets/logo.png') }}" alt="" class="w-full">
        </div>
        <!-- END LOGO -->

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
    </li>
    <!-- END BUTTON -->


    <script>
        const sessionPlayerID = '<?php echo Session::get('player_id') ?>';
        const sessionUsername = '<?php echo Session::get('username') ?>';

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
                            player_id: sessionPlayerID,
                            username: sessionUsername,
                            name_ingame: document.getElementById("name_ingame_join").value,
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

@endsection