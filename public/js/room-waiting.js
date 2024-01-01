const creatorData = JSON.parse(window.sessionStorage.getItem('creator_room'));

if (creatorData) {
    const roomID = creatorData.id;
    const creatorName = creatorData.name;

    if (creatorName) {
        document.getElementById('room_id').value = roomID;
        document.getElementById('creator_name').innerText = creatorName;
    } else {
        console.error('Failed to retrieve creator name from session.');
    }
    
} else {
    console.error('Creator data not found in session.');
}

// const playerData = JSON.parse(window.sessionStorage.getItem('player'));

// if (playerData) {
//     const playerID = playerData.id;
//     const playerName = playerData.name;

//     if (playerName) {
//         console.log(playerName);
//         var _newBox = $('.PlayerBoxPt').clone();
//         _newBox.removeClass("hidden");
//         _newBox.find('.player_id').text(playerID);
//         _newBox.find('.player_name').text(playerName);
//         $("#grid-players").append(_newBox);
//     } else {
//         console.error('Failed to retrieve player name from session.');
//     }
// } else {
//     console.error('Player data not found in session.');
// }

window.Echo.channel('room.' + creatorData.id)
    .listen('RoomUpdated', (event) => {
        console.log('Room updated:', event);
        if (!Array.isArray(event.data)) {
            console.error('Invalid data format:', event);
            return;
        }

        const numberOfPlayersElement = document.getElementById('number_player');
        numberOfPlayersElement.innerText = parseInt(numberOfPlayersElement.innerText) + 1;

        var _newBox = $('.PlayerBoxPt').clone();
        _newBox.removeClass("hidden");
        _newBox.find('.player_id').text(event.player_id);
        _newBox.find('.player_name').text(event.player_name);
        $("#grid-player").append(_newBox);
    });
