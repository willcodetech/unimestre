const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const output = document.getElementById('output');
const imageDataInput = document.getElementById('imageData');
const cropperContainer = document.getElementById('cropper-container');
const croppedImage = document.getElementById('cropped-image');
let cropper;
let currentStream = null;
let currentCameraIndex = 0;
let cameras = [];
let facingMode = 'user'; // 'user' para frontal, 'environment' para traseira

 // Função para listar as câmeras disponíveis
 async function listCameras() {
  try {
    const devices = await navigator.mediaDevices.enumerateDevices();
    cameras = devices.filter(device => device.kind === 'videoinput');
     console.log(cameras); // Adicionado para verificar os dispositivos encontrados

     if (cameras.length > 0) {
        startCamera();
      } else {
        console.error('Nenhuma câmera encontrada');
      }
    
  } catch (err) {
      console.error('Erro ao listar dispositivos de mídia: ', err);
  }
}

function stopCamera(){
  console.log("parar camera")
  if (currentStream) {
    currentStream.getTracks().forEach(track => track.stop());
      currentStream = null;
  }
}

async function startCamera() {
  stopCamera();

    const constraints = {
        video: {
          facingMode: facingMode
        }
    };


    try {
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
       currentStream = stream;
      video.srcObject = stream;
    } catch (err) {
        console.error('Erro ao acessar a câmera: ', err);
        // Em caso de erro, tente usar a outra câmera como fallback
        facingMode = facingMode === 'user' ? 'environment' : 'user';
        startCamera();

    }
}


// Evento para trocar de câmera ao clicar no botão
$('.change_camera').on('click', function() {
    facingMode = facingMode === 'user' ? 'environment' : 'user';
    startCamera();
});

function handle_controls(action = null){
  if ( !action )
    return false;

  let capture_button = $("#controls").find(".capture_photo");
  let change_camera_button = $("#controls").find(".change_camera");
  let new_photo_button = $("#controls").find(".toggle_video");
  let crop_button = $("#controls").find(".crop");

  switch ( action ){
    case "crop": // crop image
      crop_image();
      break;

    case "new_photo": // new photo
      //toggleVideo();

      stopCamera();
      listCameras();
      imageDataInput.value = "";

      $(capture_button).show();
      $(change_camera_button).show();
      $(new_photo_button).hide();
      $(crop_button).hide();
      $(".crop_video_area").hide();
      $(".video_area").show();
      break;

    case "capture":
      capture_image();
      stopCamera();

      $(capture_button).hide();
      $(change_camera_button).hide();
      $(new_photo_button).hide();
      $(crop_button).hide();
      $(new_photo_button).fadeIn();
      $(".crop_video_area").fadeIn();
      $(".video_area").hide();
      
      break;

    default:
      console.log(`acao invalida ${action}`)
  }
}

function crop_image(){

  const croppedCanvas = cropper.getCroppedCanvas({
    width: 300,
    height: 300,
  });

  try {
    const croppedImageData = croppedCanvas.toDataURL('image/jpeg', 0.8);

    //console.log("Imagem recortada (Base64):", croppedImageData);

    output.src = croppedImageData;
    imageDataInput.value = croppedImageData;
  } catch (error) {
    console.error("Erro ao gerar o Base64 da imagem recortada:", error);
    alert('Erro ao processar a imagem. Tente novamente.');
  }
}

function capture_image(){

  const context = canvas.getContext('2d');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;

  context.drawImage(video, 0, 0, canvas.width, canvas.height);

  const imageData = canvas.toDataURL('image/jpeg', 0.8);

  console.log("Imagem capturada (Base64):", imageData);

  output.src = imageData;
  output.style.display = 'block';

  cropperContainer.style.display = 'block';
  croppedImage.src = imageData;

  if (cropper) {
    cropper.destroy();
  }
  cropper = new Cropper(croppedImage, {
    aspectRatio: NaN, 
    scalable: true,
    viewMode: 1,
    responsive: true,
    background: false,
  });

}
// Verificar antes de enviar o formulário
document.getElementById('form_upload_selfie').addEventListener('submit', (e) => {

  e.preventDefault();
  let submit_button = $(".generate");
  $(submit_button).prop('disabled', true);
  let formdata = new FormData($(`form[id='form_upload_selfie']`)[0]);
  let request_parameters = {
    type: "POST",
    form_data: formdata,
    link: "/api/",
    redirect_url: "/dolar_bill/",
    reload: true
  }

  if (!imageDataInput.value) {
    
    alert('Por favor, capture e recorte uma selfie antes de enviar.');
    $(submit_button).prop('disabled', false);
    return false;
  }

  custom_ajax(request_parameters);
  return false;

});

$(document).ready(function () {
  // Função para verificar o valor do campo e mostrar/esconder o botão
  function toggleButton() {
    const fieldValue = $('#table_code').val().trim(); // Captura o valor do campo e remove espaços extras
    if (fieldValue === '') {
      $('.generate').fadeOut(); // Esconde o botão se o campo estiver vazio
    } else {
      $('.generate').fadeIn(); // Mostra o botão se o campo tiver algum valor
    }
  }

  // Executa a verificação ao carregar a página
  toggleButton();

  // Verifica o valor do campo sempre que ele é alterado
  $(document).on('change', '#table_code', function () {
    toggleButton();
  });

  listCameras();
  
});
document.addEventListener('gesturestart', function (e) {
  e.preventDefault();
});
document.addEventListener('touchstart', function (event) {
  if (event.touches.length > 1) {
      event.preventDefault(); // Evita gestos de zoom
  }
}, { passive: false });

let lastTouchEnd = 0;
document.addEventListener('touchend', function (event) {
  const now = new Date().getTime();
  if (now - lastTouchEnd <= 300) {
      event.preventDefault(); // Evita zoom duplo toque
  }
  lastTouchEnd = now;
}, false);