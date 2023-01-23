const fileInput = document.querySelector('#profile-picture');
const showUploadedFile = function() {
    let paragraph = document.querySelector('#pfp-name'),
        fileName = fileInput.files[0].name;
    paragraph.innerHTML = fileName;    
}

fileInput.addEventListener('change', showUploadedFile);