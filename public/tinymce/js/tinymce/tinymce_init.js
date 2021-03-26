// function MCEInit(element, height = 400){
//     console.log("abc");
//     tinymce.init({
//         language: "ru",
//         mode: "exact",
//         elements: element,
//         height: height,
//         gecko_spellcheck: true,
//         relative_urls: false,
//         style_formats_merge: true,
//         style_formats: [{
//             title: 'Обёртки',
//             items: [
//             { title: "Спойлер", block: 'div',
//                 classes: 'hilitecolor spoiler',
//                 attributes: { title: 'Header1' },
//                 styles: { color: 'red', backgroundColor: 'blue' },
//                 wrapper: true  }
//         ]}],
//         // style_formats: [
//         //     { title: 'Custom format', format: 'customformat' },
//         //
//         // ],
//         plugins: [
//             "spoiler advlist autolink lists link image charmap print preview hr anchor pagebreak",
//             "searchreplace wordcount visualblocks visualchars code fullscreen",
//             "insertdatetime media nonbreaking save table directionality",
//             "emoticons template paste textpattern media imagetools"
//         ],
//         toolbar: "insertfile undo redo | styleselect | bold italic | forecolor backcolor emoticons | " +
//             "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | " +
//             "formatselect fontsizeselect | code media emoticons | spoiler-add spoiler-remove",
//         image_advtab: true,
//         image_title: true,
//         automatic_uploads:true,
//         file_picker_types: 'image',
//          // images_reuse_filename: true,
//         images_upload_url: 'index.php',
//         imagetools_toolbar: "editimage imageoptions",
//         // images_upload_handler: function(blobInfo, success, failure, progress){
//         //     var xhr, formData;
//         //
//         //     console.log("111");
//         //     xhr = new XMLHttpRequest();
//         //     xhr.withCredentials = false;
//         //     xhr.open('POST', '/application/lib/tinymce/postAcceptor.php');
//         //
//         //     xhr.upload.onprogress = function (e) {
//         //         progress(e.loaded / e.total * 100);
//         //     };
//         //
//         //     xhr.onload = function() {
//         //         var json;
//         //
//         //         if (xhr.status === 403) {
//         //             failure('HTTP Error: ' + xhr.status, { remove: true });
//         //             return;
//         //         }
//         //
//         //         if (xhr.status < 200 || xhr.status >= 300) {
//         //             failure('HTTP Error: ' + xhr.status);
//         //             return;
//         //         }
//         //
//         //         json = JSON.parse(xhr.responseText);
//         //
//         //         if (!json || typeof json.location != 'string') {
//         //             failure('Invalid JSON: ' + xhr.responseText);
//         //             return;
//         //         }
//         //
//         //         success(json.location);
//         //     };
//         //
//         //     xhr.onerror = function () {
//         //         failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
//         //     };
//         //
//         //     formData = new FormData();
//         //     formData.append('file', blobInfo.blob(), blobInfo.filename());
//         //
//         //
//         //     xhr.send(formData);
//         //
//         // },
//
//         file_picker_callback: function (callback, value, meta){
//             let input = document.createElement('input');
//             input.setAttribute('type', 'file');
//             input.setAttribute('accept', 'image/*')
//             input.click();
//
//             input.onchange = function(){
//                 let reader = new FileReader();
//                 reader.readAsDataURL(this.files[0]);
//
//                 reader.onload=()=>{
//                     let blobCache = tinymce.activeEditor.editorUpload.blobCache;
//
//                     let base64 = reader.result.split(',')[1];
//
//                     let blobInfo = blobCache.create(this.files[0].name, this.files[0], base64);
//
//                     blobCache.add(blobInfo);
//
//                     callback(blobInfo.blobUri(), {title: this.files[0].name});
//                 }
//             }
//         },
//         content_css: "/public/styles/elements.css"
//     })
// }
//
// // <textarea name="text">
// console.log("a");
// MCEInit("text");
//
tinymce.init({

    // document_base_url : "http://my-phpblog",
    // абсолютные адреса без хоста
    //relative_urls : false,
    //remove_script_host : true,


    // relative_urls : false,
    // remove_script_host : false,
    // convert_urls : true,

    language: "ru",
    //Проверка орфографии на русском, неправильно написанные слова будут подчёрктнуты
    gecko_spellcheck: true,
    //для каких лементов будет установлен tinyMCE
    selector: '.tinyMCE-editor',
    style_formats_merge: true,
    style_formats: [{
            title: 'Обёртки',
            items: [
            { title: "Спойлер", block: 'div',
                classes: 'hilitecolor spoiler',
                attributes: { title: 'Header1' },
                styles: { color: 'red', backgroundColor: 'blue' },
                wrapper: true  }
        ]}],
    imagetools_toolbar: "editimage imageoptions",
    image_class_list: [
        {title: 'img-responsive', value: 'img-responsive'},
    ],
    height: 500,

    setup: function (editor) {
        editor.on('init change', function () {
            editor.save();
        });
    },
    // plugins: [
    //     "advlist autolink lists link image charmap print preview anchor",
    //     "searchreplace visualblocks code fullscreen",
    //     "insertdatetime media table contextmenu paste imagetools"
    // ],
    // toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",
    plugins: [
            "spoiler advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern media imagetools"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | forecolor backcolor emoticons | " +
            "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | " +
            "formatselect fontsizeselect | code media emoticons | spoiler-add spoiler-remove",

    // использовать elfinder для обработки добавления изображений
    //file_picker_callback : elFinderBrowser,
    // пользовательские стили для кастомных элементов
    content_css: "/tinymce/css/elements.css",

     image_title: true,
    // automatic_uploads: true,
    //images_upload_url: '/admin/image-tinyMCE-upload',
    file_picker_types: 'image',
    // images_upload_url: '/elfinder/tinymce5',
     automatic_uploads: true,
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/admin/image-tinyMCE-upload');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    },
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/jpeg,image/png,image/webp,image/gif');
        input.onchange = function() {
            var file = this.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };
        input.click();
    },
    // content_css: "/public/styles/elements.css"
});

// function elFinderBrowser (callback, value, meta) {
//     tinymce.activeEditor.windowManager.openUrl({
//         title: 'File Manager',
//         url: '/elfinder/tinymce5',
//         /**
//          * On message will be triggered by the child window
//          *
//          * @param dialogApi
//          * @param details
//          * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
//          */
//         onMessage: function (dialogApi, details) {
//             if (details.mceAction === 'fileSelected') {
//                 const file = details.data.file;
//
//                 // Make file info
//                 const info = file.name;
//
//                 console.log(meta.filetype);
//
//                 // Provide file and text for the link dialog
//                 if (meta.filetype === 'file') {
//                     console.log('file');
//                     callback(file.url, {text: info, title: info});
//                 }
//
//                 // Provide image and alt text for the image dialog
//                 if (meta.filetype === 'image') {
//                     callback(file.url, {alt: info});
//                 }
//
//                 // Provide alternative source and posted for the media dialog
//                 if (meta.filetype === 'media') {
//                     callback(file.url);
//                 }
//
//                 dialogApi.close();
//             }
//         }
//     });
// }
