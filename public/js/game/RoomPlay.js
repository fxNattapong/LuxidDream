var $image;
$(document).ready(function() {
    // MODAL IMAGE ZOOM
    $('.btn-image-zoom').on('click', function () {
        $('#image_zoom').attr('src', $(this).attr('src'));
        $("#modal-image-zoom").removeClass('hidden');
    });
    $('#icon-image-zoom-close').on('click', function () {
        var modal = $('#modal-image-zoom');
        modal.addClass("fade-out-modal");

        setTimeout(function() {
            modal.addClass('hidden');
            modal.removeClass("fade-out-modal");
        }, 500);
    });

    // MODAL TIPS
    $('#btn-tips').on('click', function () {
        $("#modal-tips").removeClass('hidden');
    });
    $('#icon-tips-close').on('click', function () {
        var modal = $('#modal-tips');
        modal.addClass("fade-out-modal");

        setTimeout(function() {
            modal.addClass('hidden');
            modal.removeClass("fade-out-modal");
        }, 500);
    });

    // MODAL NIGHTMARE CARD
    $('.btn-nightmare-card').on('click', function () {
        $('#modal_nightmare_1').attr('src', $(this).data('image_1'));
        $('#modal_nightmare_1').attr('data-nightmare_id_1', $(this).data('nightmare_id_1'));
        $('#modal_nightmare_2').attr('src', $(this).data('image_2'));
        $('#modal_nightmare_2').attr('data-nightmare_id_2', $(this).data('nightmare_id_2'));

        $("#modal-nightmare").removeClass('hidden');

        $image = $(this).next('div').find('img');
    });
    $('#icon-nightmare-close').on('click', function () {
        var modal = $('#modal-nightmare');
        modal.addClass("fade-out-modal");

        $('#modal_card_1').attr('src', pathUploads + 'element-empty.png');
        $('#modal_card_2').attr('src', pathUploads + 'element-empty.png');

        setTimeout(function() {
            modal.addClass('hidden');
            modal.removeClass("fade-out-modal");
        }, 500);
    });

    $('#icon-result-close').on('click', function () {
        var modal = $('#modal-result');
        modal.addClass("fade-out-modal");

        $('#modal_card_1').attr('src', pathUploads + 'element-empty.png');
        $('#modal_card_2').attr('src', pathUploads + 'element-empty.png');

        setTimeout(function() {
            modal.addClass('hidden');
            modal.removeClass("fade-out-modal");
        }, 500);
    });

    // MODAL START TIMER
    $('#btn-start-countdown').on('click', function() {
        Swal.fire({
            title: `รอบที่ ${RoomRound}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'เริ่ม',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                StartTimer();
            }
        })
    });
});

var x = setInterval(function() {
    var now = new Date().getTime();
        
    if(Timeout) {
        var distance = Timeout - now;
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const formattedMinutes = (minutes < 10) ? '0' + minutes : minutes;
        const formattedSeconds = (seconds < 10) ? '0' + seconds : seconds;
        document.getElementById("countdown_timer").innerHTML = `${formattedMinutes} : ${formattedSeconds}`;
    } else {
        document.getElementById("countdown_timer").innerHTML = "00 : 00";
        
        FetchTimeout().then((result) => {
            Timeout = new Date(result).getTime();
        });
    }
    
    if(!Timeout) {
        if(isCreator) {
            $('#div-countdown_timer').addClass('hidden');
            $('#btn-start-countdown').removeClass('hidden');
        }
    }

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown_timer").innerHTML = "00 : 00";
        $('#div-countdown_timer').removeClass('hidden');

        $("#btn-timeout").addClass('hidden');
        $("#modal-result").removeClass('hidden');

        if(isCreator) {
            $('#btn-next-round').removeClass('hidden');
        }
    } else if(distance > 0) {

    }
}, 1000);

document.addEventListener('DOMContentLoaded', function () {
    $('#loading').addClass('hidden');
});

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

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function FetchTimeout(){
    if(!isLoading) {
        isLoading = true;
        return fetch(RouteFetchTimeout, {
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

            return data.room.time;

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function FetchCards(element){
    var $image = $(element).next('div').find('img');
    if(!isLoading) {
        isLoading = true;
        fetch(RouteFetchCards, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_link_id: $(element).data('room_link_id'),
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
                    title: 'แจ้งเตือน!',
                    html: `${data.status}`,
                });
    
                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }
            console.log(data);

            $('#modal_link').attr('src', pathUploads + data.room_link.link_image);
            $('#modal_link').attr('data-room_link_id', data.room_link.room_link_id);

            if (data.cards) {
                for (var i = 0; i < Math.min(data.cards.length, 2); i++) {
                    var card = data.cards[i];
                    var targetElement = (card.position === 0) ? $('#modal_card_1') : $('#modal_card_2');
                    targetElement.attr('src', pathUploads + card.card_image);
                }
            }

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

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
                    nightmare_id_1: document.getElementById("modal_nightmare_1").dataset.nightmare_id_1,
                    room_link_id: document.getElementById("modal_link").dataset.room_link_id,
                    nightmare_id_2: document.getElementById("modal_nightmare_2").dataset.nightmare_id_2,
                    card_code: document.getElementById("card_code").value,
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
            console.log(data);

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'เพิ่มการ์ดสำเร็จ!',
                timer: 1000,
                timerProgressBar: true
            });

            $('#card_code').val('');

            var targetElement = (data.card.position === 0) ? $('#modal_card_1') : $('#modal_card_2');
            targetElement.attr('src', pathUploads + data.card.card_image);
            if(data.cards.length === 2) {
                isLoading = false;
                CheckNightmareLink();
            }

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function CheckNightmareLink(){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteCheckNightmareLink, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_link_id: document.getElementById("modal_link").dataset.room_link_id,
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
            console.log(data);

            $('#modal_link').attr('src', pathUploads + data.room_link.link_image);
            $image.attr('src', pathUploads + data.room_link.link_image);

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}
