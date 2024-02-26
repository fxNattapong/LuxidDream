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
    $('#loading').addClass('hidden');
    
    pollCards();
});

function pollCards(element){
    setInterval(() => {
        fetch(RoutePollCards, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
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
        fetch(RouteStartTimer, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
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
                    title: 'เกิดข้อผิดพลาด!',
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
            fetch(RouteCardAdd, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-Token": csrfToken
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
                        title: 'เกิดข้อผิดพลาด!',
                        html: `${data.status}`,
                    });
        
                    const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                    return Promise.reject(error);
                }

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'เพิ่มการ์ดสำเร็จ!',
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