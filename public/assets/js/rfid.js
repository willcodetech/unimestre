
console.log("leitor rfid");
$(document).on("click", ".read_rfid", async function() {
  console.log("CLICOU");
  if ('NDEFReader' in window) {
      try {
        const ndef = new NDEFReader();
        await ndef.scan();
        ndef.onreading = event => {
          $('#external_id').val(event.serialNumber);
        };
    } catch (error) {
      console.error(`Error: ${error}`);
    }
  } else {
    alert("NFC reader is not available on this device.");
  }
});
