//seleccionando todos los elementos requeridos
const dropArea = document.querySelector(".drag-area");
dragText = dropArea.querySelector("header");
button = dropArea.querySelector("button");
input = dropArea.querySelector("input");
let file; //esta es una variable global y la usaremos dentro de múltiples funciones

button.onclick = () => {
  input.click(); //si el usuario hace clic en el botón, hace click a input file
}

input.addEventListener("change", function () {
  //obteniendo el archivo de selección del usuario y [0] esto significa que si el usuario selecciona varios archivos, seleccionaremos solo el primero
  file = this.files[0];
  dropArea.classList.add("active");
  showFile(); //muestra previsualizador
});


//Si la usuario arrastra el archivo sobre DropArea
dropArea.addEventListener("dragover", (event) => {
  event.preventDefault(); //evitando el comportamiento predeterminado
  dropArea.classList.add("active");
  dragText.textContent = "Suelta para cargar imagen";
});

//Si el usuario deja el archivo arrastrado desde DropArea
dropArea.addEventListener("dragleave", () => {
  dropArea.classList.remove("active");
  dragText.textContent = "Arrastra y suelta la imagen aquí";
});

//If user drop File on DropArea
dropArea.addEventListener("drop", (event) => {
  event.preventDefault(); //evitando el comportamiento predeterminado
  //obteniendo el archivo de selección del usuario y [0] esto significa que si el usuario selecciona varios archivos, seleccionaremos solo el primero
  file = event.dataTransfer.files[0];
  showFile(); //calling function
});

function showFile() {
  let fileReader = new FileReader(); //creating new FileReader object
  let fileType = file.type; //getting selected file type
  let validExtensions = ["image/jpeg", "image/jpg", "image/png"]; //adding some valid image extensions in array
  const containerArchivoCargado = document.querySelector(".img-cargada");//se obtiene contenedor de la vista previa

  const fileLoaded = containerArchivoCargado.querySelector(".toast-body");

  const boxNombreArchivo = containerArchivoCargado.querySelector("#imgName");

  //cierra el previsualizador al presionar el boton de X
  containerArchivoCargado.querySelector("#closePrev").onclick = () => {
    containerArchivoCargado.classList.add("d-none");
    dropArea.classList.remove("d-none");
    dropArea.classList.remove("active");
    fileReader = null;
    input.value = "";
    fileLoaded.querySelector(".img-prev").setAttribute("src", "");
  }

  if (validExtensions.includes(fileType)) { //if user selected file is an image file
    containerArchivoCargado.querySelector(".toast-header").classList.remove("bg-danger", "text-dark");
    fileReader.onload = () => {
      fileLoaded.querySelector("span").textContent = "";
      fileLoaded.classList.remove("alert", "alert-danger");
      let fileURL = fileReader.result; //passing user file source in fileURL variable
      // UNCOMMENT THIS BELOW LINE. I GOT AN ERROR WHILE UPLOADING THIS POST SO I COMMENTED IT
      boxNombreArchivo.innerHTML = file.name;
      fileLoaded.querySelector(".img-prev").setAttribute("src", fileURL);
      fileLoaded.querySelector("img").classList.remove("d-none");

    }
    fileReader.readAsDataURL(file);
    containerArchivoCargado.classList.remove("d-none");
    dropArea.classList.add("d-none");
  } else {
    input.value = "";
    boxNombreArchivo.innerHTML = 'intentar de nuevo <i class="fas fa-arrow-right"></i>';
    containerArchivoCargado.querySelector(".toast-header").classList.add("bg-danger", "text-dark");
    fileLoaded.classList.add("alert", "alert-danger");
    containerArchivoCargado.classList.remove("d-none");
    dropArea.classList.add("d-none");
    fileLoaded.querySelector("img").classList.add("d-none");
    fileLoaded.querySelector("span").textContent = "Este no es un archivo de imagen!";
    dropArea.classList.remove("active");
    dragText.textContent = "Arrastra y suelta la imagen aquí";
  }
}