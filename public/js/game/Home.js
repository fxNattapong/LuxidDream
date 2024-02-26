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
        var RouteURL = $("#form-room-create").data("route");
        fetch(RouteURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    player_id: sessionPlayerID,
                    username: sessionUsername,
                    name_ingame: document.getElementById("name_ingame_create").value,
                    player_rule_id: document.getElementById("player_rule_id_create").value,
                    level_id: document.getElementById("level_id_create").value,
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
                    title: 'เกิดข้อผิดพลาด',
                    html: `${data.status}`,
                });
    
                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'สร้างห้องสำเร็จ',
                timer: 1000,
                timerProgressBar: true
            }).then((result) => {
                window.location.href = data.redirect_url;
            })

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}