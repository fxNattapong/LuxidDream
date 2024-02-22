if(currentRoute === currentRoute) {
    if(currentRoute === 'Members' || currentRoute === 'Admins') {
        $('#' + currentRoute).removeClass('text-indigo-600');
        openMenuMembers();
    }

    $('#' + currentRoute).addClass('text-indigo-600 bg-[#E4E9F7]');
}

$(document).ready(function() {
    $('#btn-menu-switch').on('click', function() {
        $('#sidebar').toggleClass('max-md:min-w-0 max-md:max-w-[60px]');
        $('#btn-menu-switch').toggleClass('rotate-180');
        $('#img-logo').toggleClass('max-md:h-full');
        $('#text-logo').toggleClass('max-md:hidden');
    });

    // MODAL EDIT
    $('#btn-account-edit').on('click', function() {
        $('#modal-account-edit').removeClass('hidden');
        $('#menu-logged').toggleClass("hidden");
        $('#btnLoggedMenu').toggleClass("bg-[#E4E9F7]");
        $('#btnLoggedMenu .flex').toggleClass("text-gray-700 text-blue-700");
        $('#icon-settings').toggleClass("rotate-180");
    });
    $('#icon-account-edit-close').on('click', function() {
        var modal = $('#modal-account-edit');
        modal.addClass('fade-out-modal');

        setTimeout(function() {
            modal.addClass('hidden');
            modal.removeClass("fade-out-modal");
        }, 500);
    });

    $('#account_phone').on('input', function () {
        var phoneInput = $(this).val();
        var phoneLengthWarning = $('#phoneLengthWarning');
    
        if (phoneInput.length == 10) {
            phoneLengthWarning.addClass('hidden');
        } else if (phoneInput.length > 10) {
            phoneLengthWarning.text('หมายเลขเกิน 10 หลัก');
            phoneLengthWarning.removeClass('hidden');
        } else {
            phoneLengthWarning.text('หมายเลขไม่ถูกต้อง')
            phoneLengthWarning.removeClass('hidden');
        }
    });

    // SWEETALERT LOGOUT
    $('#btn-logout').on('click', function () {
        Swal.fire({
            title: `คุณต้องการออกจากระบบใช่หรือไม่`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ตกลง',
            cancelButtonText: 'ยกเลิก',
            }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = $('#btn-logout').data('route');
            }
        })
    });
});

$('.js-password-toggle').on('change', function() {
    const password = $('.js-password'),
        passwordLabel = $('.js-password-label');
    if (password.attr('type') === 'password') {
        password.attr('type', 'text');
        passwordLabel.html('ซ่อน');
    } else {
        password.attr('type', 'password');
        passwordLabel.html('แสดง');
    }
    password.focus();
});


// START GET SINGLE IMAGE BASE64
var _image64_single = '';
function fileChosen_Single(event) {
    this.fileToDataUrl_Single(event, src => this.fileHanddle_Single(src));
}
function fileToDataUrl_Single(event, callback) {
    if (! event.target.files.length){ 
        callback('');
        return
    }

    let file = event.target.files[0],
        reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = function (e) {
        var img = new Image;
        img.src = e.target.result;
        img.onload = function(){
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var cw = canvas.width;
            var ch = canvas.height;
            var maxW = '1920';
            var maxH = '1080';

            var iw = img.width;
            var ih = img.height;
            if(iw <= maxW || ih <= maxH) {
                var _avatar_base64 = img.src;
            }else {
                var scale = Math.min((maxW/iw),(maxH/ih));
                var iwScaled = iw * scale;
                var ihScaled = ih * scale;
                canvas.width = iwScaled;
                canvas.height = ihScaled;
                ctx.drawImage(img,0,0,iwScaled,ihScaled);
                var converted_img = canvas.toDataURL();
                var _avatar_base64 = converted_img;        
            }                        
            callback(_avatar_base64);                        
        }					
    };
}
function fileHanddle_Single(src){
    $("#account_image").attr("src", src);

    $("#image_add").attr("src", src);
    $("#image_edit").attr("src", src);
    
    _image64_single = src;
}
// END GET SINGLE IMAGE BASE64


function openMenuMembers() {
    $('#menu-members').toggleClass("hidden");
    $('#btnMenuMembers').toggleClass("bg-[#E4E9F7]");
    $('#btnMenuMembers').toggleClass("text-gray-700 text-blue-700");
    $('#icon-arrow').toggleClass("rotate-180");

    $('#sidebar').toggleClass('max-md:min-w-0 max-md:max-w-[60px]');
    $('#btn-menu-switch').toggleClass('rotate-180');
}

// BUTTON LOGGED SORT
function openMenuLogged() {
    var btnLogged = $('#btnLoggedMenu .flex');
    var popup = $('#menu-logged');
    var icon = $('#icon-settings');

    if (btnLogged.hasClass('text-gray-700')) {
        btnLogged.removeClass('text-gray-700').addClass('text-indigo-600');
        popup.removeClass('hidden');
        popup.addClass('h-full');
        icon.addClass('rotate-180');
    } else {
        btnLogged.removeClass('text-indigo-600').addClass('text-gray-700');
        popup.addClass('hidden');
        popup.removeClass('h-full');
        icon.removeClass('rotate-180');
    }
}
$(document).mouseup(function(e) {
    var btnLogged = $('#btnLoggedMenu .flex');
    var popup = $('#menu-logged');
    var icon = $('#icon-settings');

    if (!btnLogged.is(e.target) && btnLogged.has(e.target).length === 0 &&
        !popup.is(e.target) && popup.has(e.target).length === 0) {
        btnLogged.removeClass('text-blue-700').addClass('text-gray-700');
        popup.addClass('hidden');
        icon.removeClass('rotate-180');
    }
});

var isLoading = false;

function FetchAccountData(element){
    if(!isLoading) {
        isLoading = true;
        var RouteURL = $("#btn-account-edit").data("route");
        fetch(RouteURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    username: $(element).data('username')
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
    
            $('.modal-content #account_id').val(data.admin_id);
            $('.modal-content #account_username').val(data.username);
            $('.modal-content #account_password').val(data.password);
            $('.modal-content #account_firstname').val(data.firstname);
            $('.modal-content #account_lastname').val(data.lastname);
    
            if(data.phone) {
                $('.modal-content #account_phone').val(data.phone);
            }
    
            if(data.image) {
                $('.modal-content #account_image').attr("src", pathUploads + data.image);
            }
            $("#modal-account-edit").removeClass('hidden');
        })
        .catch((er) => {
            console.log('Error' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}

function SubmitAccountEdit() {
    if(!isLoading) {
        var RouteURL = $("#form-account-edit").data("route");
        isLoading = true;
        fetch(RouteURL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-Token": csrfToken
            },
            body:JSON.stringify(
                {
                    id: document.getElementById("account_id").value,
                    password: document.getElementById("account_password").value,
                    firstname: document.getElementById("account_firstname").value,
                    lastname: document.getElementById("account_lastname").value,
                    phone: document.getElementById("account_phone").value,
                    image64: _image64_single
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
                    title: 'แก้ไขบัญชีไม่สำเร็จ!',
                    html: `${data.status}`,
                    confirmButtonText: 'ตกลง',
                })
    
                const error = (data && data.errorMessage) || "{{trans('general.warning.system_failed')}}" + " (CODE:"+response.status+")";
                return Promise.reject(error);
            }
    
            Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'แก้ไขบัญชีสำเร็จ',
                    confirmButtonText: 'ตกลง',
                    timer: 1000,
                    timerProgressBar: true
            }).then((result) => {
                location.reload();
            })
        })
        .catch((er) => {
            console.log('Error' + er);
        })
        .finally(() => {
            isLoading = false;
        });
    }
}