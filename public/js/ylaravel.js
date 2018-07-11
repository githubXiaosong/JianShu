var editor = new wangEditor('content');

editor.config.uploadImgUrl = '/api/postImageUpload';

// JS 中获取CSRFtoken 方法
editor.config.uploadHeaders = {
    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
};

editor.create();