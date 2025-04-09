$(document).ready(function() {
  let currentStream = null;
  let currentCameraIndex = 0;
  let cameras = [];
  
  // Função para listar as câmeras disponíveis
  function listCameras() {
    navigator.mediaDevices.enumerateDevices()
      .then(devices => {
        cameras = devices.filter(device => device.kind === 'videoinput');
        console.log(cameras); // Adicionado para verificar os dispositivos encontrados
        if (cameras.length > 0) {
          startCamera(cameras[currentCameraIndex].deviceId);
        } else {
          console.error('Nenhuma câmera encontrada');
        }
      })
      .catch(err => {
        console.error('Erro ao listar dispositivos de mídia: ', err);
      });
  }
  
  function stopCamera(){
    console.log("parar camera")
    if (currentStream) {
      currentStream.getTracks().forEach(track => track.stop());
    }

  }
  
  function startCamera(deviceId) {
    
    stopCamera();

    const constraints = {
        video: {
          deviceId: deviceId ? { exact: deviceId } : undefined // Se deviceId não estiver definido, ignora a restrição
        }
    };

    navigator.mediaDevices.getUserMedia(constraints)
      .then(stream => {
        currentStream = stream;
        $('#video')[0].srcObject = stream;
      })
      .catch(err => {
        console.error('Erro ao acessar a câmera: ', err);
      });
  }


  // Evento para trocar de câmera ao clicar no botão
  $('.change_camera').on('click', function() {
    if (cameras.length > 1) {
      currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
      startCamera(cameras[currentCameraIndex].deviceId);
    }
  });

  $(".stop_camera").on("click", function(){
    stopCamera();
  });

  // Listar as câmeras disponíveis ao carregar a página
  listCameras();
  
});
