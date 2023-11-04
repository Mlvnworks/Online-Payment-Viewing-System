const fileInput = document.querySelector('#file-input');
const binaryUrlInput = document.querySelector('#binary-url-input');

fileInput.addEventListener('change', e => {
    const file = e.target.files[0];

    // Check file type
    if (!file.type.includes('image')) return window.alert('Please select and valid profile image.');

    const fReader = new FileReader();
    fReader.readAsDataURL(file);
    fReader.onload = () => {
        console.log(file);
        binaryUrlInput.value = fReader.result;
    };
});
