<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>Room Play</title>

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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
                <h1 class="z-[100] text-white text-2xl font-bold">Round {{ $room->status }}</h1>
                @if(Session::get('creator'))
                <div class="z-[100] mt-[1em] grid grid-cols-2 items-center max-md:grid-cols-1">
                @else
                <div class="z-[100] mt-[1em] items-center">
                @endif
                    <!-- START COUNDOWN TIMER -->
                    <div class="z-[100] mx-auto">
                        <h1 class="text-xl text-white font-bold uppercase">Round ends in:</h1>
                        <div class="relative mx-auto w-[150px] h-fit p-3 rounded-full overflow-hidden text-center">
                            <div class="z-10 w-full h-full absolute top-0 left-0 bg-white opacity-50"></div>
                            <span id="countdown_timer" class="text-white text-3xl">00 : 00</span>
                        </div>
                    </div>
                    <!-- END COUNDOWN TIMER -->

                    <input id="room_id" type="text" class="hidden" value="{{ $room->id }}">
                    
                    <!-- START INPUT CARD CODE -->
                    @if(Session::get('creator'))
                        <div id="input_card_code" class="z-[100] relative text-center p-4 w-[350px]">
                            <div class="relative">
                                <div class="opacity-70">
                                    <input id="card_code_add" type="text" class="w-full rounded-full bg-indigo-200 border border-white text-gray-800 placeholder-gray-800 px-3 py-2" value="" placeholder="Enter card code...">
                                </div>
                                <button onclick="CardAdd()" class="absolute top-0 right-[6px] mt-[6px] bg-[#EE609A] rounded-full py-1 px-2 w-fit border border-white text-sm text-white hover:bg-[#d62c65] duration-300">ENTER</button>
                            </div>
                        </div>
                    @endif
                    <!-- END INPUT CARD CODE -->
                </div>

                <!-- START CARD -->
                <div id="grid-cards" class="z-[100] mt-[2em]">
                    @if(sizeof($rooms_cards))
                        @foreach($rooms_cards as $card)
                            <div class="mb-[1em] relative grid grid-cols-3 gap-4 max-md:gap-0 max-md:grid-cols-1 max-md:w-[350px] max-lg:mx-3">
                                <!-- START CARD IMAGE -->
                                <div class="z-50 w-full m-auto">
                                    <div class="z-50 relative flex-col flex items-center justify-center w-full rounded overflow-hidden">
                                        <div class="z-20 w-[300px] h-full overflow-hidden max-lg:w-full border-2">
                                            <img src="{{ URL('/assets/cards/card1.png') }}" class="w-full h-auto object-cover" alt="">
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
                                            <p class="text-xl">{{ $card->card_name }}</p>
                                        </div>
                                        <div class="text-center">
                                            <h2 class="text-2xl font-bold">Detailed</h2>
                                            <p class="text-xl">{{ $card->details }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CARD DETAILS -->
                            </div>
                        @endforeach
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
        </div>

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

        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const creatorData = JSON.parse(window.sessionStorage.getItem('creator_room'));
        if (!creatorData) {
            console.error('Creator data not found in session.');
        }

        var currentTime = new Date().getTime();
        var newTime = currentTime + (5 * 60 * 1000); // 5 minutes
        // var countDownDate = new Date("Jan 1, 2024 20:30:00").getTime();
        var Timeout = new Date('<?php echo $room->round_time ?>').getTime();
        console.log(currentTime + ' | ' + Timeout);

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
                
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown_timer").innerHTML = "TIMEOUT";
                $('#countdown_timer').removeClass('text-3xl').addClass('text-xl');
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

                    if(data.rooms_cards.length > 0) {
                        $('#grid-cards').empty();

                        for(let i=0; i<data.rooms_cards.length; i++) {
                            var CardBox = $('.CardBoxPt').clone();
                            CardBox.removeClass("hidden CardBoxPt");
                            // CardBox.find('.card_image').attr('src', data.rooms_cards[i].image);
                            CardBox.find('.card_name').text(data.rooms_cards[i].card_name);
                            CardBox.find('.card_details').text(data.rooms_cards[i].details);
                            $("#grid-cards").append(CardBox);
                        }

                        if(data.rooms_cards.length === 2) {
                            $('#input_card_code').empty();
                            $('#input_card_code').html('<button class="bg-[#EE609A] rounded-full py-1 px-2 w-fit border border-white text-xl text-white hover:bg-[#d62c65] duration-300">NEXT ROUND</button>');
                        }
                    }

                })
                .catch((er) => {
                    console.log('Error' + er);
                });
            }, 1000);
        }

        console.log(<?php echo json_encode($rooms_cards); ?>);


        var isCreator = "<?php echo Session::get('creator') ?>";
        if(isCreator) {
            var isLoading = false;
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
</html>