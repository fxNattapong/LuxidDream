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

        $image = $(this).find('img');
    });
    $('#icon-nightmare-close').on('click', function () {
        var modal = $('#modal-nightmare');
        modal.addClass("fade-out-modal");

        $('#modal_card_1, #modal_card_2, #modal_card_3, #modal_card_4').attr('src', pathUploads + 'element-empty.png');

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

    // MODAL END TIMER
    $('#btn-end-timer').on('click', function() {
        Swal.fire({
            title: `รอบที่ ${RoomRound}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'สิ้นสุด',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                EndTimer();
            }
        })
    });

    $('.nightmare-select').on('click', function() {
        if(!($(this).hasClass('nightmare-selected')) && ($('.nightmare-selected').length >= 2)) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'เกิดข้อผิดพลาด!',
                html: `ไม่สามารถเลือกฝันร้ายเพิ่มได้`,
            });
        } else {
            if($('.nightmare-selected').length == 0 || $(this).hasClass('nightmare-selected')) {
                $(this).toggleClass('nightmare-selected');
                $(this).find('.circle').toggleClass('hidden');
            } else {
                var hasSelectedBefore = $(this).prevAll('.nightmare-selected').length > 0;
                var hasSelectedAfter = $(this).nextAll('.nightmare-selected').length > 0;
                console.log($(this).next().next());
                if (hasSelectedBefore || hasSelectedAfter) {
                    $(this).toggleClass('nightmare-selected');
                    $(this).find('.circle').toggleClass('hidden');
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด!',
                        html: `ฝันร้ายต้องอยู่ติดกัน`,
                    });
                }
            }
        }
    });

    // MODAL CONFIRM NIGHTMARE FOR OPEN
    $('#btn-next-round').on('click', function() {
        Swal.fire({
            title: `เริ่มรอบถัดไป`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                StartNextRound();
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
        $('#card_code_1, #card_code_2').addClass('hidden');
        if(isCreator) {
            $('#div-countdown_timer').addClass('hidden');
            $('#btn-start-countdown').removeClass('hidden');
        }
    }

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown_timer").innerHTML = "หมดเวลา";
        $('#div-countdown_timer').removeClass('hidden');

        $('#card_code_1, #card_code_2').addClass('hidden');

        $("#btn-timeout").addClass('hidden');
        // ModalTimeUp();
        
        if(isCreator) {
            $('#btn-next-round').removeClass('hidden');
            $('.nm_image').removeClass('btn-image-zoom').off('click');
            $('#modal-image-zoom').addClass('hidden');
            $('.nightmare-select').removeClass('hidden');
        }
    } else if(distance > 0) {
        $('#card_code_1, #card_code_2').removeClass('hidden');
    }
}, 1000);

document.addEventListener('DOMContentLoaded', function () {
    $('#loading').addClass('hidden');
    pollLinks(room_id);
});


function pollLinks(room_id){
    var pollLinks = setInterval(() => {
        fetch(RoutePollLinks, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_id: room_id,
                    circle: RoomCircle
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

            let status = 0;
            data.links.forEach(link => {
                if (link.room_link_status === 1) {
                    status++;
                }
            });
            
            if(status === 5) {
                var now = new Date().getTime();
                var distance = Timeout - now;
                // clearInterval(pollLinks);
                if(distance > 0) {
                    $('#btn-end-timer').removeClass('hidden');
                }
            }
            $('.link_image').each(function(index) {
                var newSource = data.links[index].link_image;
                $(this).attr('src', pathUploads + newSource);
            });

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

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function EndTimer(){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteEndTimer, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_id: document.getElementById("room_id").value,
                    circle: RoomCircle
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
            $('#btn-end-timer').addClass('hidden');

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

function ModalTimeUp() {
    var modal = $('#modal-timeup');
    modal.removeClass('hidden');

    setTimeout(function() {
        modal.addClass('hidden');
        $('#modal-result').removeClass('hidden');
    }, 3000);
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
                for (var i = 0; i < Math.min(data.cards.length, 4); i++) {
                    var card = data.cards[i];
                    var targetElements = ['#modal_card_1', '#modal_card_2', '#modal_card_3', '#modal_card_4'];
                    var targetElement = $(targetElements[card.position]);
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

function CardAdd(element){
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
                    card_code: $("#" + ($(element).data('button_input') === 'nm_left' ? "card_code_1" : "card_code_2")).val(),
                    from_nm: $(element).data('button_input') === 'nm_left' ? 'left' : 'right',
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

            var targetElements = ['#modal_card_1', '#modal_card_2', '#modal_card_3', '#modal_card_4'];
            var targetElement = $(targetElements[data.card.position]);
            targetElement.attr('src', pathUploads + data.card.card_image);
            if(data.cards.length === 4) {
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