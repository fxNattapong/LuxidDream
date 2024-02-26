$(document).ready(function() {
    // MODAL ROOM DELETE
    $('#icon-room-delete').on('click', function() {
        Swal.fire({
            title: `คุณต้องการลบห้องนี้ใช่หรือไม่?`,
            text: "การดำเนินการนี้ไม่สามารถเรียกคืนได้",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                RoomDelete($(this).data('room_id'));
            }
        })
    });

    // MODAL PLAYER REMOVE
    $(document).on('click', '.btn-player-remove', function () {
        Swal.fire({
            title: `คุณต้องการลบผู้เล่นนี้ใช่หรือไม่?`,
            html: `<b class="font-medium">ชื่อ: ${$(this).data('name_ingame')}</b>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบ',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                PlayerRemove($(this).data('room_id'), $(this).data('room_player_id'));
            }
        })
    });
});

function CopyInviteCode() {
    var copyText = document.getElementById("invite_code");

    copyText.select();
    copyText.setSelectionRange(0, 99999);

    navigator.clipboard.writeText(copyText.value);
}

function pollPlayers(room_id){
    setInterval(() => {
        fetch(RoutePollPlayers, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_id: room_id
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
            if(data.status === 'error') {
                window.location.href = data.redirect_url;
            }

            if(data.room.status === 1) {
                window.location.href = data.redirect_url;
            }
            
            $('#grid-players').empty();
            var BgBox = $('.bg-set-opacity').clone();
            BgBox.removeClass("hidden");
            $("#grid-players").append(BgBox);

            var NumberPlayerBox = $('.NumberPlayerBoxPt').clone();
            NumberPlayerBox.removeClass("hidden");
            // NumberPlayerBox.find('.number_player').text(data.players.length);
            $("#grid-players").append(NumberPlayerBox);

            if(data.players.length > 0) {
                for(let i=0; i<data.players.length; i++) {
                    var PlayerBox = $('.PlayerBoxPt').clone();
                    PlayerBox.removeClass("hidden PlayerBoxPt");
                    PlayerBox.find('.btn-player-remove').attr('data-room_player_id', data.players[i].room_player_id);
                    PlayerBox.find('.btn-player-remove').attr('data-name_ingame', data.players[i].name_ingame);
                    PlayerBox.find('.btn-player-remove').attr('data-room_id', data.room.room_id);
                    PlayerBox.find('.player_id').val(data.players[i].player_id);
                    PlayerBox.find('.player_name').text(data.players[i].name_ingame);

                    if(data.players[i].username !== creatorName) {
                        if(data.players[i].status === 0) {
                            PlayerBox.find('.span-status-color').removeClass('bg-[#FD0000]').addClass('bg-[#FD0000]');
                        } else if(data.players[i].status === 1) {
                            PlayerBox.find('.span-status-color').removeClass('bg-[#FD0000]').addClass('bg-[#50D255]');
                        } else if(data.players[i].status === 2) {
                            PlayerBox.find('.span-status-color').removeClass('bg-[#FD0000]').addClass('bg-gray-300');
                        }
                    }
                    
                    if(data.players[i].username === creatorName) {
                        PlayerBox.find('.span-status-color').removeClass('span-status-color w-[20px] h-[20px]')
                                                            .addClass('text-indigo-900 bg-indigo-300 px-2')
                                                            .text('ผู้สร้าง');
                        PlayerBox.find('.btn-player-remove').remove();
                        $('#player_id').val(data.players[i].player_id);
                    } else if(data.players[i].name_ingame === sessionName) {
                        if(data.players[i].status === 0) {
                            PlayerBox.find('.span-status-color').removeClass('w-[20px] h-[20px]')
                                                                .addClass('bg-[#FD0000] text-white px-2')
                                                                .text('คุณ');
                            $('#player_id').val(data.players[i].player_id);
                            $('#player_status').val(0);
                            $('#btn-status').text('พร้อม').removeClass('bg-[#ff5757] hover:bg-[#fd0000]')
                                                            .addClass('bg-[#E69FBC] hover:bg-[#d1638a]');
                        } else {
                            PlayerBox.find('.span-status-color').removeClass('w-[20px] h-[20px]')
                                                                .addClass('bg-[#50D255] text-white px-2')
                                                                .text('คุณ');
                            $('#player_id').val(data.players[i].player_id);
                            $('#player_status').val(1);
                            $('#btn-status').text('ไม่พร้อม').removeClass('bg-[#E69FBC] hover:bg-[#d1638a]')
                                                                .addClass('bg-[#ff5757] hover:bg-[#fd0000]');
                        }
                    } else {
                        if(data.players[i].status === 0) {
                            PlayerBox.find('.span-status-color').addClass('bg-[#FD0000] text-white px-2');
                            $('#player_id').val(data.players[i].player_id);
                            $('#player_status').val(0);
                            $('#btn-status').text('พร้อม').removeClass('bg-[#ff5757] hover:bg-[#fd0000]')
                                                            .addClass('bg-[#E69FBC] hover:bg-[#d1638a]');
                        } else {
                            PlayerBox.find('.span-status-color').addClass('bg-[#50D255] text-indigo-900 px-2'); 
                            $('#player_id').val(data.players[i].player_id);      
                            $('#player_status').val(1);
                            $('#btn-status').text('ไม่พร้อม').removeClass('bg-[#E69FBC] hover:bg-[#d1638a]')
                                                                .addClass('bg-[#ff5757] hover:bg-[#fd0000]');
                        }
                    }
                    

                    $("#grid-players").append(PlayerBox);
                }
            }

        })
        .catch((er) => {
            console.log('Error' + er);
        });
    }, 1000);
}


var isLoading = false;

function RoomDelete(room_id){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteRoomDelete, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_id: room_id
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
                    confirmButtonText: 'ตกลง'
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

function PlayerRemove(room_id, room_player_id){
    console.log(room_player_id);
    if(!isLoading) {
        isLoading = true;
        fetch(RoutePlayerRemove, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    room_id: room_id,
                    room_player_id: room_player_id
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
                    confirmButtonText: 'ตกลง',
                })

                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function ChangeStatus(){
    if(!isLoading) {
        isLoading = true;
        $('#loading').removeClass('hidden');
        fetch(RouteChangeStatus, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    player_id: document.getElementById("player_id").value,
                    status: document.getElementById("player_status").value,
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
                    confirmButtonText: 'ตกลง'
                });
    
                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
            $('#loading').addClass('hidden');
        });
    }
}

var gameIsOver = false;
window.addEventListener('beforeunload', function (event) {
    if (!gameIsOver) {
        RoomDisconnect();
    }
});

function gameOver() {
    gameIsOver = true;
    window.removeEventListener('beforeunload', function (event) {
        RoomDisconnect();
    });
}

function RoomDisconnect(){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteRoomDisconnect, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    player_id: document.getElementById("player_id").value,
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

        }).catch((er) => {
            console.log('Error: ' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function StartGame(){
    if(!isLoading) {
        isLoading = true;
        fetch(RouteStartGame, {
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
                    title: 'ไม่สามารถเริ่มเกมได้!',
                    html: `${data.status}`,
                    confirmButtonText: 'ตกลง'
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