<title>Room Play</title>

@extends('components/Header')

@section('Content')

        <!-- START CONTENT -->
        <div class="flex-col flex items-center justify-center">
            <h1 class="z-[100] text-white text-2xl font-bold">Round {{ $room->status }}</h1>

            @if(Session::get('creator'))
            <div id="div-header-grid" class="z-[100] mt-[1em] grid grid-cols-2 items-center max-md:grid-cols-1">
            @else
            <div class="z-[100] mt-[1em] items-center">
            @endif
                <!-- START COUNDOWN TIMER -->
                <div class="z-[100] mx-auto col-span-2">
                    <h1 class="text-xl text-white font-bold uppercase">Round ends in:</h1>

                    <div id="div-countdown_timer" class="relative mx-auto w-[150px] h-fit p-3 rounded-full overflow-hidden text-center">
                        <span id="countdown_timer" class="text-white text-xl">00 : 00</span>
                        <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-50"></div>
                    </div>

                    @if(Session::get('creator'))
                        <div onclick={StartTimer()} id="btn-start-countdown" class="hidden mt-auto mb-0 bg-[#EE609A] rounded-full py-2.5 px-3 w-full border border-white text-white text-xl text-center hover:bg-[#d62c65] duration-300 cursor-pointer">START</div>
                    @endif
                </div>
                <!-- END COUNDOWN TIMER -->

                <input id="room_id" type="text" class="hidden" value="{{ $room->id }}">
                <!-- START INPUT CARD CODE -->
                @if(Session::get('creator'))
                    <div id="input_card_code" class="hidden z-[100] relative text-center p-4 w-[350px]">
                        <div class="relative">
                            <div class="opacity-70">
                                <input id="card_code_add" type="text" class="w-full rounded-full bg-indigo-200 border border-white text-gray-800 placeholder-gray-800 px-3 py-2" value="" placeholder="Enter card code...">
                            </div>
                            <button onclick="CardAdd()" class="absolute top-0 right-[6px] mt-[6px] bg-[#EE609A] rounded-full py-1 px-2 w-fit border border-white text-sm text-white hover:bg-[#d62c65] duration-300">ENTER</button>
                        </div>
                    </div>
                    <div onclick={} id="btn-next-round" class="hidden mt-auto mb-0 bg-[#EE609A] rounded-full py-2.5 px-3 w-full border border-white text-white text-xl text-center hover:bg-[#d62c65] duration-300 cursor-pointer">NEXT ROUND</div>
                    <!-- <div onclick={} id="btn-next-round" class="mx-auto bg-[#EE609A] rounded-full py-1 px-2 w-fit border border-white text-white text-xl hover:bg-[#d62c65] duration-300 cursor-pointer">NEXT ROUND</div> -->
                @endif
                <!-- END INPUT CARD CODE -->
            </div>

            <!-- START CARD -->
            <div id="grid-cards" class="z-[100] mt-[2em]">
                @if($room_card)
                    <div class="mb-[1em] relative grid grid-cols-3 gap-4 max-md:gap-0 max-md:grid-cols-1 max-md:w-[350px] max-lg:mx-3">
                        <!-- START CARD IMAGE -->
                        <div class="z-50 w-full m-auto">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                <div class="z-20 w-[300px] h-full overflow-hidden max-lg:w-full border-2">
                                    <img src="{{ URL('/assets/SETUP/'.$room_card->image) }}" class="w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END CARD IMAGE -->

                        <!-- START CARD DETAILS -->
                        <div class="z-50 w-full relative rounded p-2 overflow-hidden col-span-2 max-lg:mx-auto">
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-40"></div>
                            <div class="z-20 text-white grid grid-rows-2 h-full">
                                <div class="text-center">
                                    <h1 class="text-2xl font-bold">Card</h1>
                                    <p class="text-xl">{{ $room_card->card_name }}</p>
                                </div>
                                <div class="text-center">
                                    <h2 class="text-2xl font-bold">Detailed</h2>
                                    <p class="text-xl">{{ $room_card->details }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- END CARD DETAILS -->
                    </div>
                @else
                    <div class="relative grid grid-cols-3 gap-4 max-md:gap-0 max-md:grid-cols-1 max-md:w-[350px] max-lg:mx-3">
                        <!-- START CARD IMAGE -->
                        <div class="z-50 w-full m-auto max-md:hidden">
                            <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-40"></div>
                                <div class="z-20 w-[300px] h-full overflow-hidden max-lg:w-full border-2">
                                    <img src="{{ URL('/assets/mini-logo.png') }}" class="w-full h-auto object-cover" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- END CARD IMAGE -->

                        <!-- START CARD DETAILS -->
                        <div class="z-50 w-full relative rounded p-2 overflow-hidden col-span-2 max-lg:mx-auto">
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-40"></div>
                            <div class="z-20 h-full text-white flex items-center items-center justify-center">
                                <h1 class="text-2xl font-bold">Please input card code</h1>
                            </div>
                        </div>
                        <!-- END CARD DETAILS -->
                    </div>
                @endif
            </div>
            <!-- END CARD -->
        </div>
        <!-- END CONTENT -->

        <!-- START CARD PROTOTYPES -->
        <div class="mb-[1em] relative grid grid-cols-3 gap-4 max-md:gap-0 max-md:grid-cols-1 max-md:w-[350px] max-lg:mx-3 hidden CardBoxPt">
            <!-- START CARD IMAGE -->
            <div class="z-50 w-full m-auto">
                <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                    <div class="z-20 w-[300px] h-full overflow-hidden max-lg:w-full border-2">
                        <img src="{{ URL('/assets/cards/card1.png') }}" class="card_image w-full h-auto object-cover" alt="">
                    </div>
                </div>
            </div>
            <!-- END CARD IMAGE -->

            <!-- START CARD DETAILS -->
            <div class="z-50 w-full relative rounded p-2 overflow-hidden col-span-2 max-lg:mx-auto">
                <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-40"></div>
                <div class="z-20 text-white grid grid-rows-2 h-full">
                    <div class="text-center">
                        <h1 class="text-2xl font-bold">Card</h1>
                        <p class="card_name text-xl">Card name</p>
                    </div>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">Detailed</h2>
                        <p class="card_details text-xl">Details</p>
                    </div>
                </div>
            </div>
            <!-- END CARD DETAILS -->
        </div>
        <!-- END CARD PROTOTYPES -->

@endsection

@section('script')
<script>
    var isCreator = "<?php echo Session::get('creator') ?>";
    var currentTime = new Date().getTime();
    var newTime = currentTime + (5 * 60 * 1000); // 5 minutes
    var Timeout = new Date('<?php echo $room->round_time ?>').getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();
            
        var distance = Timeout - now;

        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        if(minutes < 10) {
            if(seconds < 10) {
                document.getElementById("countdown_timer").innerHTML = '0' + minutes + ' : ' + '0' + seconds;
            } else {
                document.getElementById("countdown_timer").innerHTML = '0' + minutes + ' : ' + seconds;
            }
        } else {
            if(seconds < 10) {
                document.getElementById("countdown_timer").innerHTML = minutes + ' : ' + '0' + seconds;
            } else {
                document.getElementById("countdown_timer").innerHTML = minutes + ' : ' + seconds;
            }
        }

        if(!Timeout) {
            $('#input_card_code').addClass('hidden');
            
            if(isCreator) {
                $('#div-countdown_timer').addClass('hidden');
                $('#btn-start-countdown').removeClass('hidden');
            }
        }
            
        if (distance < 0) {
            clearInterval(x);
            $('#input_card_code').addClass('hidden');
            $('#div-countdown_timer').parent().removeClass('col-span-2');
            $('#div-countdown_timer').removeClass('hidden');
            $('#div-header-grid').addClass('gap-8');
            $('#div-countdown_timer').removeClass('hidden');
            document.getElementById("countdown_timer").innerHTML = "TIMEOUT";

            if(isCreator) {
                $('#btn-next-round').removeClass('hidden');
            }
        } else if(distance > 0) {
            $('#input_card_code').removeClass('hidden');
            $('#div-countdown_timer').parent().removeClass('col-span-2');
        }
    }, 1000);

    document.addEventListener('DOMContentLoaded', function () {
        pollCards();
    });
    function pollCards(element){
        setInterval(() => {
            fetch("{{ Route('pollCards') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": '{{ csrf_token() }}'
                },
                body:JSON.stringify(
                    {
                        room_id: document.getElementById("room_id").value
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

                if(data.room.round_time)  {
                    Timeout = new Date(data.room.round_time).getTime();
                }
                
                if(data.rooms_card) {
                    $('#grid-cards').empty();

                    var CardBox = $('.CardBoxPt').clone();
                    CardBox.removeClass("hidden CardBoxPt");
                    const PathImage = "<?php echo URL('/assets/SETUP/'); ?>";
                    CardBox.find('.card_image').attr('src', PathImage + '/' + data.rooms_card.image);
                    CardBox.find('.card_name').text(data.rooms_card.card_name);
                    CardBox.find('.card_details').text(data.rooms_card.details);
                    $("#grid-cards").append(CardBox);
                }

            })
            .catch((er) => {
                console.log('Error' + er);
            });
        }, 1000);
    }

    var isLoading = false;

    function StartTimer(){
        if(!isLoading) {
            isLoading = true;
            fetch("{{ Route('StartTimer') }}", {
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
                        title: 'Something went wrong!',
                        html: `${data.status}`,
                    });
        
                    const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                    return Promise.reject(error);
                }

                Timeout = new Date(data.round_time).getTime();
                $('#btn-start-countdown').addClass('hidden');

                $('#div-countdown_timer').removeClass('hidden');
                $('#btn-start-countdown').parent().removeClass('col-span-2');
                $('#input_card_code').removeClass('hidden');

            }).catch((er) => {
                console.log('Error: ' + er);
            })
            .finally(() => {
                isLoading = false;
            });
        }
    }

    if(isCreator) {
        function CardAdd(){
            if(!isLoading) {
                isLoading = true;
                fetch("{{ Route('CardAdd') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-Token": '{{ csrf_token() }}'
                    },
                    body:JSON.stringify(
                        {
                            room_id: document.getElementById("room_id").value,
                            card_code: document.getElementById("card_code_add").value,
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
                            title: 'Something went wrong!',
                            html: `${data.status}`,
                        });
            
                        const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                        return Promise.reject(error);
                    }

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Card added successfully!',
                        timer: 1000,
                        timerProgressBar: true
                    });

                    $('#card_code_add').val('');

                }).catch((er) => {
                    console.log('Error: ' + er);
                })
                .finally(() => {
                    isLoading = false;
                });
            }
        }
    }
</script>
@endsection