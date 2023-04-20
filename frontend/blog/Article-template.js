function chooseFile() {
  document.getElementById("fileInput").click();
}

function changeImage(event) {
  let articleImg = document.getElementById("article-image");
  articleImg.src = URL.createObjectURL(event.target.files[0]);
}

function updateHeader() {
  const headerInputElement = document.getElementById("articleHeader");
  const headerElement = document.getElementById("headerDisplay");
  headerElement.textContent = headerInputElement.value;
}

function updateContent() {
  const contentInputElement = document.getElementById("articleContent");
  const contentElement = document.getElementById("contentDisplay");
  contentElement.textContent = contentInputElement.value;
}

let previewing = false;


function previewBtn() {
  let articleImg = document.getElementById("article-image");
  let btn = document.getElementById("preview-btn");
  

  if (!previewing){
    previewing = true;
    articleImg.removeAttribute('onclick');
    btn.textContent = "Edit Page"
  }
  
  else {
    previewing = false;
    articleImg.setAttribute('onclick', 'chooseFile()');
    btn.textContent = "Preview Page"
  }
  
  articleImg.classList.toggle('custom-article-image-hover');
  togglePreview();
}

function togglePreview() {
  const headerInputElement = document.getElementById("articleHeader");
  const headerElement = document.getElementById("headerDisplay");
  headerInputElement.classList.toggle('custom-hidden');
  headerElement.classList.toggle('custom-hidden');
  const saveBtn = document.getElementById('save-btn')

  const contentInputElement = document.getElementById("articleContent");
  const contentElement = document.getElementById("contentDisplay");
  contentInputElement.classList.toggle('custom-hidden');
  contentElement.classList.toggle('custom-hidden');
  saveBtn.classList.toggle('custom-hidden');
}

function saveBtn()
{
  alert("upload to database");
}