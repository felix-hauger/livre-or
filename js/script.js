const fileInput = document.querySelector('#profile-picture');
const showUploadedFile = function() {
    let paragraph = document.querySelector('#pfp-name'),
        fileName = fileInput.files[0].name;

    // display only part on the file name if too long
    fileName = fileName.length > 15 ? fileName.substring(0, 15) + '...' : fileName; 
    paragraph.innerHTML = fileName;
}

fileInput.addEventListener('change', showUploadedFile);