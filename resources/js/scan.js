let scanBack = document.querySelector('.scan-back-btn');
let scanChoose = document.querySelector('.scan-choose');
let scanChooseManual = document.querySelector('#scan-choose-manual');
let scanChooseBarcode = document.querySelector('#scan-choose-barcode');
let scanManual = document.querySelector('.scan-manual');
let scanBarcode = document.querySelector('.scan-barcode');

scanBack.addEventListener('click', function(){
    console.log('Return back.');
    if(scanManual.classList.contains('scan-active') || scanBarcode.classList.contains('scan-active')){
        scanManual.classList.remove('scan-active');
        scanBarcode.classList.remove('scan-active');
        if(scanChoose.classList.contains('scan-inactive')){
            scanChoose.classList.remove('scan-inactive');
        }
    };
    Quagga.stop();
});

/*Repetition is the best, somehow the back button on barcode page is not working. I'm smart*/
let scanBack2 = document.querySelector('.scan-back-btn-2');
scanBack2.addEventListener('click', function(){
    console.log('Return back.');
    if(scanManual.classList.contains('scan-active') || scanBarcode.classList.contains('scan-active')){
        scanManual.classList.remove('scan-active');
        scanBarcode.classList.remove('scan-active');
        if(scanChoose.classList.contains('scan-inactive')){
            scanChoose.classList.remove('scan-inactive');
        }
    };
    Quagga.stop();
});

scanChooseManual.addEventListener('click', function(){
    scanChoose.classList.add('scan-inactive');
    scanManual.classList.add('scan-active');
    console.log('Chosen manual method!');
});

scanChooseBarcode.addEventListener('click', function(){
    scanChoose.classList.add('scan-inactive');
    scanBarcode.classList.add('scan-active');
    console.log('Chosen barcode method!');
    barcode_init();
});