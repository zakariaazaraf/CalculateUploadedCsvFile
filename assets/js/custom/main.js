const form = document.querySelector('#upload_csv');
const file = document.querySelector('#csv_file')
const message = document.querySelector('#message')
const bodyContent = document.querySelector('.body-content');
const downloadLink = document.querySelector('.downloadFile');

/* $(document).ready(function() {
    $('.content-table').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         true,
    } );
} ); */



form.addEventListener('submit', (event)=>{
    event.preventDefault();

    if(validateFile(file.files, 5, 'csv')){
        event.target.submit();
    }
})


validateFile = (file, sizeLimit, type)=>{

    let mesError = '';
    sizeLimit *= 1024 * 1024; // Convert to bytes

    bodyContent.innerHTML = ''; // remove table's body content
    downloadLink.innerHTML = '';

    if(!file[0]){ // check if file exists
        message.innerHTML = `<p class='message failed'>Please Select File</p>`;
        return false;   
    }

    // get the file data
    const {name, size} = file[0];

    // Extract the file extension
    let fileExtention = name.split('.').pop();

    // Cehck file type 
    if(fileExtention !== type) {
        mesError = `<p class='message failed'>${fileExtention} File Extenstion Not Allowed</p>`;
        message.innerHTML = mesError;
        return false;
    }

    // check file size
    if(size > sizeLimit){
        mesError = `<p class='message failed'>File size to large</p>`;
        message.innerHTML = mesError;
        return false;
    }

    return true;
}