let textEditor;

// all the input fields
const checkWord = document.querySelector('#checkWord');
const fileName = document.querySelector('#fileName');
const fileCheckName = document.querySelector('#fileCheckName');
const filePDF = document.querySelector('#filePDF');
const AddWordDictionary = document.querySelector('#AddWordDictionary');
const errorAmount = document.querySelector('#errorAmount');
const errorValue = document.querySelector('#errorValue');
const wordsAmount = document.querySelector('#wordsAmount');
const wordsValue = document.querySelector('#wordsValue');
const essayGrade = document.querySelector('#essayGrade');
const finalGrade = document.querySelector('#finalGrade');

// TextArea Input
const textInFile = document.querySelector('#textInFile');
const findWords = document.querySelector('#findWords');
const mispellingFound = document.querySelector('#mispellingFound');
const occurrenceFound = document.querySelector('#occurrenceFound');

// ComboBox selector
const fileExtension = document.querySelector('#fileExtension');
const languageSelect = document.querySelector('#languageSelect');

// all the buttons
const btnGo = document.querySelector('#btnGo');
const btnUpload = document.querySelector('#btnUpload');
const btnCheck = document.querySelector('#btnCheck');
const btnClear = document.querySelector('#btnClear');
const btnAdd = document.querySelector('#btnAdd');
const btnAddClear = document.querySelector('#btnAddClear');
const btnGrade = document.querySelector('#btnGrade');
const btnNew = document.querySelector('#btnNew');
const btnSave = document.querySelector('#btnSave');

document.addEventListener('DOMContentLoaded', () => {
    btnGo.addEventListener('click', function () {
        if (checkWord.value == '') {
            customAlert('warning', 'PLEASE, TYPE A WORD');
        } else {
            const url = base_url + 'BinarySearchString';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                checkWord: checkWord.value,
                language: languageSelect.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText); 
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                }
            }
        }
    });
    btnUpload.addEventListener('click', function () {
        if (fileName.value == '') {
            customAlert('warning', 'PLEASE CHOOSE A FILE');
        } else {
            const formdata = new FormData();
            formdata.append('file', fileName.files[0]);
            const url = base_url + 'UploadFile/uploadfile';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(
                formdata
            );
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                    fileCheckName.value = res.fileName;
                }
            }
        }
    });
    btnCheck.addEventListener('click', function () {
        if (fileCheckName.value == '') {
            customAlert('warning', 'PLEASE, CHOOSE A FILE');
        } else if (fileExtension.value == 'select') {
            customAlert('warning', 'PLEASE, CHOOSE A FILE EXTENSION');
        } else {
            const url = base_url + 'binarySearchSpell';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                fileCheckName: fileCheckName.value,
                fileExtension: fileExtension.value,
                findWords: findWords.value,
                language: languageSelect.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res.status == 'pass') {
                        textEditor.setData(res.normalText);

                        //misspelling text area
                        let htmlMisspell = '';
                        for (const element of res.missPelledWords.missPelled) {
                            htmlMisspell += `${element}\n`;
                        }
                        mispellingFound.innerHTML = htmlMisspell;
                        //end misspelling text area
                        //occurrence text area
                        let htmlOccurrence = '';
                        for (const element of res.occurrence.occurrence) {
                            htmlOccurrence += `For "${element.word}", Found: ${element.count}\n`;
                        }
                        occurrenceFound.innerHTML = htmlOccurrence;
                        //occurrenceFound.value = res.occurrence;
                        //end occurrence text area
                        errorAmount.value = res.count;
                        wordsAmount.value = res.totalFound;
                        customAlert(res.type, res.msg);
                    } else {
                        customAlert(res.type, res.msg);
                    }
                }
            }
        }
    });
    btnClear.addEventListener('click', function () {
        fileCheckName.value = '';
        fileName.value = '';
        fileExtension.value = 'select';
    });
    btnAdd.addEventListener('click', function () {
        if (AddWordDictionary.value == '') {
            customAlert('warning', 'TYPE THE WORD TO ADD');
        } else {
            const url = base_url + 'addToDictionary/addtodictionary';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                addWord: AddWordDictionary.value,
                language: languageSelect.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                    AddWordDictionary.value = '';                    
                }
            }
        }
    });
    btnAddClear.addEventListener('click', function () {
        AddWordDictionary.value = '';
    });
    btnGrade.addEventListener('click', function () {
        if (errorAmount.value == '') {
            customAlert('warning', 'ERROR AMOUNT IS REQUIRED');
        } else if (errorValue.value == '') {
            customAlert('warning', 'ERROR VALUE IS REQUIRED');
        } else if (wordsAmount.value == '') {
            customAlert('warning', 'WORDS AMOUNT IS REQUIRED');
        } else if (wordsValue.value == '') {
            customAlert('warning', 'WORDS VALUE IS REQUIRED');
        } else if (essayGrade.value == '') {
            customAlert('warning', 'ESSAY GRADE IS REQUIRED');
        } else {
            const errorGrade = parseFloat((errorAmount.value * errorValue.value) / 100);
            const wordsGrade = parseFloat((wordsAmount.value * wordsValue.value) / 100);
            const essay = parseFloat(essayGrade.value);
            const tmpGrade = parseFloat(wordsGrade + essay - errorGrade);
            //console.log(finalGrade);
            finalGrade.value = tmpGrade.toFixed(2);
        }
    });
    btnNew.addEventListener('click', function () {
        window.location.reload();
    });
    btnSave.addEventListener('click', function () {
        
        if (fileCheckName.value == '') {
            customAlert('warning', 'FILE NAME IS REQUIRED');
        } else if (errorAmount.value == '') {
            customAlert('warning', 'ERROR AMOUNT IS REQUIRED');
        } else if (errorValue.value == '') {
            customAlert('warning', 'ERROR VALUE IS REQUIRED');
        } else if (wordsAmount.value == '') {
            customAlert('warning', 'WORDS AMOUNT IS REQUIRED');
        } else if (wordsValue.value == '') {
            customAlert('warning', 'WORDS VALUE IS REQUIRED');
        } else if (essayGrade.value == '') {
            customAlert('warning', 'ESSAY GRADE IS REQUIRED');
        } else if (finalGrade.value == '') {
            customAlert('warning', 'FINAL GRADE IS REQUIRED');
        } else {
            const url = base_url + 'addToDictionary/saveEssay';
            //instaciate the object XMLHttpRequest
            const http = new XMLHttpRequest();
            //open connection this time POST
            http.open('POST', url, true);
            //send data
            http.send(JSON.stringify({
                essayName: fileCheckName.value,
                errorAmount: errorAmount.value,
                errorValue: errorValue.value,
                wordsAmount: wordsAmount.value,
                wordsValue: wordsValue.value,
                essayGrade: essayGrade.value,
                finalGrade: finalGrade.value
            }));
            //verify status
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //Just for testing
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    customAlert(res.type, res.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            }
        }
    });

    //Inicialize the ckeditor5 editor
    ClassicEditor
        .create(document.querySelector('#textInFile'), {
            toolbar: {
                items: [
                    'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic',
                    'outdent', 'indent', '|',
                    'undo', 'redo', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed'
                ],
                shouldNotGroupWhenFull: true
            },
        })
        .then(editor => {
            textEditor = editor;
        })
        .catch(error => {
            console.error(error);
        })
});

function basename(path) {
    const path1 = path.split('\\').reverse()[0];
    path1.split('/').reverse()[0];
    return path1.split('/').reverse()[0];;
}

function customAlert(type, msg) {
    Swal.fire({
        toast: true,
        position: 'top-right',
        icon: type,
        title: msg,
        showConfirmButton: false,
        timer: 1500
    })
}