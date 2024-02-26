document.addEventListener('DOMContentLoaded', function () {
    $('#loading').addClass('hidden');
});

var isLoading = false;

function RoomJoining(){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteRoomJoining, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
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
                    title: 'เกิดข้อผิดพลาด!',
                    html: `${data.status}`,
                });
    
                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }

            window.location.href = data.redirect_url;

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}