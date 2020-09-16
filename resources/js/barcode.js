function barcode_init(){
  /* QuaggaJS Stuff*/
  Quagga.init({
    inputStream : {
      name : "Live",
      type : "LiveStream",
      target: document.querySelector('#barcode-scanner'),    // Or '#yourElement' (optional)
      numOfWorkers: navigator.hardwareConcurrency,
    },
    decoder : {
      readers : ["code_128_reader"]
    }
  }, function(err) {
      if (err) {
          console.log(err);
          return
      }
      console.log("Initialization finished. Ready to start");
      Quagga.start();
  });
}

/*This is just unnecessary code just to resize the camera view..bruh*/
document.querySelector('video').style.width = "80vw";
document.querySelector('video').style.height = "50vh";
document.querySelector('.drawingBuffer').style.width = "80vw";
document.querySelector('.drawingBuffer').style.height = "50vh";
/* Redirect to verify page with GET data when barcode detected*/
Quagga.onDetected(function(result) {
  var last_code = result.codeResult.code;
  Quagga.stop();
  setTimeout(() =>{
    document.querySelector('.barcode-identification').value = last_code;
    var barcodeForm = document.querySelector('#barcode-form');
    barcodeForm.submit();
  }, 1000);
});