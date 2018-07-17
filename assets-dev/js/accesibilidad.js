/*
 @since 2017-05-19
 @Author ViveLab
 */

 var arrayClass = [
 'not-assigned',
 'not-assigned',
 'not-assigned',
 'not-assigned'
 ];

 $(function () {
    $('li.event-bar').click(function () {
        activateEvent($(this));
    });

    setClassNameBody(window.localStorage.classNameBody);
    setClassNameHeader(window.localStorage.classNameHeader);
    setArrayClass(window.localStorage.classNameBody);

    var x = document.getElementById('nav_barleft_side');

    if(window.localStorage.navBarleft == undefined){
        window.localStorage.navBarleft = 'nav-barleft-side deployed';
    }

    x.className = window.localStorage.navBarleft;
    initialBarAccessibilityStatus();

    if(searchEventArrayClass('sign-language') == -1) {
        $('#divForm').removeClass('col-md-6').addClass('col-md-12');
        $('#divVideo').addClass('hidden');
        arrayClass[3] = 'not-assigned';
    }

$('#myCarousel').addClass('hidden');
    initialOptionSignLanguageStatus();
});

 $(window).resize(function () {
    if ($(document).width() < 600) {
        closeHiddenNavBarLeftSide();
    }
});

 function closeHiddenNavBarLeftSide() {
    var x = document.getElementById('nav_barleft_side');
    x.className = 'nav-barleft-side not-deployed';
    x.setAttribute('aria-expanded', false);
}

function activateEvent(e) {
    applyBarEvents(e.attr('activate-event'));
    if ($(document).width() < 605) {
        closeHiddenNavBarLeftSide();
    }
}

function searchEventArrayClass(event) {
    return $.inArray(event, arrayClass);
}

function applyBarEvents(eventBarActivate) {
    switch (eventBarActivate) {
        case 'signLanguage':
        signLanguage();
        break;
        case 'fontSize':
        fontSize();
        break;
        case 'colorContrast':
        colorContrast();
        break;
        case 'resetBar':
        resetBar();
        break;
        default:
        return false;
    }
}

function hiddenNavBarleftSide() {
    var x = document.getElementById('nav_barleft_side');
    var textOpenAXBarButton = document.getElementById('nav_barleft_side').children[0].children[0].children[0].children[2];
    var ariaLabelOpenAXBarButton = document.getElementById('nav_barleft_side').children[0].children[0].children[0];

    if (x.className == 'nav-barleft-side not-deployed') {
        x.className = 'nav-barleft-side deployed';
        x.setAttribute('aria-expanded', true);
        textOpenAXBarButton.innerHTML = 'CONFIGURE SU PÁGINA<br>X Cerrar';
        ariaLabelOpenAXBarButton.setAttribute('aria-label', 'Boton para ocultar la barra de accesibilidad');
        window.localStorage.navBarleft = x.className;
    } else {
        x.className = 'nav-barleft-side not-deployed';
        x.setAttribute('aria-expanded', false);
        textOpenAXBarButton.innerHTML = 'ABRIR OPCIONES<br>DE ACCESIBILIDAD';
        ariaLabelOpenAXBarButton.setAttribute('aria-label', 'Boton para abrir la barra de accesibilidad');
        window.localStorage.navBarleft = x.className;
    }
}

function getAttrElement(idElement) {
    var element = document.getElementById(idElement);
    return element;
}

function isValidEmptyClassBody() {
    var element = getAttrElement('main_body');
    if (element.className == '')
        return true;
    else
        return false;
}

function isValidEmptyClassHeader() {
    var element = getAttrElement('imagesHeader');
    if (element.className === null)
        element = window.localStorage.classNameBody;

    return element;
}

function signLanguage() {
    if(searchEventArrayClass('sign-language') == -1) {
        $('#divForm').removeClass('col-md-12').addClass('col-md-6');
        $('#divVideo').removeClass('hidden');
        $('#myCarousel').addClass('hidden');
        arrayClass[3] = 'sign-language';
    } else {
        $('#divForm').removeClass('col-md-6').addClass('col-md-12');
        $('#divVideo').addClass('hidden');
        $('#myCarousel').removeClass('hidden');
        arrayClass[3] = 'not-assigned';
    }
    setClassNameBody(getClassNameBody());
}

function fontSize() {
    var classBar = 'letter-great';
    var elementLink = getAttrElement('link_font_size');
    var elementSpan = getAttrElement('icon_font_size');
    var headerClassName = '';

    var isActivateClass = searchEventArrayClass(classBar);

    if (isActivateClass == -1 && searchEventArrayClass('letter-small') == -1) {
        arrayClass[1] = 'letter-great';
        elementSpan.className = 'icon-letter-small';
        elementLink.innerHTML = 'Letra pequeña';
        changeIconFontSize('big');
        headerClassName = 'left-content col-xs-12 col-sm-6 col-md-6 col-lg-9';
    }else{
        if(searchEventArrayClass('letter-small') == -1){
            arrayClass[1] = 'letter-small';
            elementSpan.className = 'icon-letter-great';
            elementLink.innerHTML = 'Letra grande';
            changeIconFontSize('small');
            headerClassName = 'left-content col-xs-12 col-sm-6 col-md-6 col-lg-5';
        }else{
            arrayClass[1] = 'letter-median';
            elementSpan.className = 'icon-letter-great';
            elementLink.innerHTML = 'Letra grande';
            changeIconFontSize('small');
            headerClassName = 'left-content col-xs-12 col-sm-6 col-md-6 col-lg-5';
        }
    }
    setClassNameBody(getClassNameBody());
    setClassNameHeader(headerClassName);
    try {
        setLineSeparatorHeight();
    }catch (e){}
}

function getClassNameBody() {
    var className = '';
    $.each(arrayClass, function (key, value) {
        className += ' ' + value;
    });
    return $.trim(className);
}

function setClassNameBody(classNameBody) {
    var elementBody = getAttrElement('main_body');
    elementBody.className = classNameBody;
    window.localStorage.classNameBody = classNameBody;
}

function setClassNameHeader(classNameHeader) {
    if (classNameHeader == '' || classNameHeader == undefined || classNameHeader == null)
        classNameHeader = 'left-content col-xs-12 col-sm-6 col-md-6 col-lg-9';

    $('#imagesHeader').attr('class',classNameHeader);
    window.localStorage.classNameHeader = classNameHeader;
}

function colorContrast() {
    if (searchEventArrayClass('orange-contrast') != -1) {
        arrayClass[2] = 'black-contrast';
    } else {
        if (searchEventArrayClass('white-contrast') == -1) {
            arrayClass[2] = 'white-contrast';
        } else {
            arrayClass[2] = 'orange-contrast';
        }
    }
    setClassNameBody(getClassNameBody());
    changeChatIcons();
    changeAccesibilityBarIcon();
}

function resetBar() {
    arrayClass[1] = 'not-assigned';
    arrayClass[2] = 'not-assigned';
    setClassNameBody(getClassNameBody());
    changeChatIcons();
    changeAccesibilityBarIcon();
    setIconsToWhiteContrast();
}


function changeAccesibilityBarIcon(){
    if($('#main_body').hasClass('orange-contrast') || $('#main_body').hasClass('black-contrast')){
        $('.icon-letter-great').css('background-image','url(' + base_url + 'assets/images/letragrande_blanco.png)');
        $('.icon-letter-small').css('background-image','url(' + base_url + 'assets/images/letrapequena_blanco.png)');
        $('.icon-reset').css('background-image','url(' + base_url + 'assets/images/reestablecer_blanco.png)');
        $('.logo-censo-image').attr('src',base_url + 'assets/images/logocensoblanco.png');
        $('.logo-dane-image').attr('src',base_url + 'assets/images/logodaneblanco.png');

    }

    if($('#main_body').hasClass('white-contrast')){
        setIconsToWhiteContrast();
    }
}

function setIconsToWhiteContrast(){
    $('.icon-letter-great').css('background-image','url(' + base_url + 'assets/images/letragrande_negro.png)');
    $('.icon-letter-small').css('background-image','url(' + base_url + 'assets/images/letrapequena_rojo.png)');
    $('.icon-reset').css('background-image','url(' + base_url + 'assets/images/reestablecer_negro.png)');
    $('.logo-censo-image').attr('src',base_url + 'assets/images/logocenso_header.png');
    $('.logo-dane-image').attr('src',base_url + 'assets/images/logodane_header.png');

}

function changeIconFontSize(size){
    if($('#main_body').hasClass('orange-contrast') || $('#main_body').hasClass('black-contrast')){
        if(size=='small') {
            $('.icon-letter-great').css('background-image','url(' + base_url + 'assets/images/letragrande_blanco.png)');
        } else {
            $('.icon-letter-small').css('background-image','url(' + base_url + 'assets/images/letrapequena_blanco.png)');
        }
    }

    if($('#main_body').hasClass('white-contrast')){
        if(size=='small'){
            $('.icon-letter-great').css('background-image','url(' + base_url + 'assets/images/letragrande_negro.png)');
        } else {
            $('.icon-letter-small').css('background-image','url(' + base_url + 'assets/images/letrapequena_rojo.png)');
        }
    }
}

function setArrayClass(className){
    var array = className.split(' ');
    $.each(array, function (key, value) {
        arrayClass[key] = value;
    });
}


function login(e){
    if (e.keyCode == 13) {
        if ($("#frmIngreso").valid() === true) {
            $(':button').addClass('disabled').prop('disabled', true);
            $("#frmIngreso").submit();
        }
    }
}

function initialBarAccessibilityStatus(){
    var textOpenAXBarButton = document.getElementById('nav_barleft_side').children[0].children[0].children[0].children[2];
    var ariaLabelOpenAXBarButton = document.getElementById('nav_barleft_side').children[0].children[0].children[0];
    if (window.localStorage.navBarleft == 'nav-barleft-side not-deployed') {
        textOpenAXBarButton.innerHTML = 'ABRIR OPCIONES<br>DE ACCESIBILIDAD';
        ariaLabelOpenAXBarButton.setAttribute('aria-label', 'Boton para abrir la barra de accesibilidad');
    } else {
        textOpenAXBarButton.innerHTML = 'CONFIGURE SU PÁGINA<br>X Cerrar';
        ariaLabelOpenAXBarButton.setAttribute('aria-label', 'Boton para ocultar la barra de accesibilidad');
    }
}

function initialOptionSignLanguageStatus(){
    if(searchEventArrayClass('sign-language') == -1) {
       $('#divForm').removeClass('col-md-6').addClass('col-md-12');
       $('#divVideo').addClass('hidden');
       $('#myCarousel').removeClass('hidden');
       arrayClass[3] = 'not-assigned';
   } else {
    $('#divForm').removeClass('col-md-12').addClass('col-md-6');
    $('#divVideo').removeClass('hidden');
    $('#myCarousel').addClass('hidden');
    arrayClass[3] = 'sign-language';
}
setClassNameBody(getClassNameBody());
}

var windowsize = $(window).width();
if(document.getElementById('nav_barleft_side')) {
    var fontSizeSection = document.getElementById('nav_barleft_side').children[0].children[2];
}

if (windowsize < 990) {
    fontSizeSection.setAttribute('activate-event', 'Boton para abrir la barra de accesibilidad');
    resetBar();
}

$(window).resize(function() {
    windowsize = $(window).width();
    if (windowsize < 990) {
        resetBar();
        fontSizeSection.setAttribute('activate-event', 'Boton para abrir la barra de accesibilidad');
    } else {
        fontSizeSection.setAttribute('activate-event', 'fontSize');
    }
});
