$( document ).ready(function() {
    changeChatIcons();

    $('#contact-button').on('click', function() {
        $('#contact-button').addClass('hidden');
        $('#chat-info-container').removeClass('hidden');
        $('.title-chat-container').focus();
    });

    $('#chat-title-column').on('click keypress', function(e) {
        if(e.type=="click" || e.which==13){
            $('#contact-button').removeClass('hidden');
            $('#chat-info-container').addClass('hidden');
        }
    });

    $('#enter-chat-button').on('click', function() {
        window.open('http://contactochat.dane.gov.co/WebChatASP/','_blank');
    });
});

function changeChatIcons(){
    if($('#main_body').hasClass('orange-contrast')){
        $('.chat-icon-image').attr('src',base_url + 'assets/images/chat_naranja.png');
        $('.close-chat-info-icon').attr('src',base_url + 'assets/images/cerrar_negro.png');
        $('.logo-censo-image').attr('src',base_url + 'assets/images/logocensoblanco.png');
        $('.logo-dane-image').attr('src',base_url + 'assets/images/logodaneblanco.png');
    }else{
        $('.chat-icon-image').attr('src',base_url + 'assets/images/chat_blanco.png');
        $('.close-chat-info-icon').attr('src',base_url + 'assets/images/cerrar_blanco.png');
    }

    if($('#main_body').hasClass('white-contrast')){
        $('.logo-censo-image').attr('src',base_url + 'assets/images/logocenso_header.png');
        $('.logo-dane-image').attr('src',base_url + 'assets/images/logodane_header.png');
    }

    if($('#main_body').hasClass('black-contrast')){
        $('.logo-censo-image').attr('src',base_url + 'assets/images/logocensoblanco.png');
        $('.logo-dane-image').attr('src',base_url + 'assets/images/logodaneblanco.png');
    }
}

