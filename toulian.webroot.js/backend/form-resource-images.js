jQuery(function($) {
    $('#biaodan .upload').click(function(e) {
        layer.open({
            type: 1,
            title: '资源图片上传',
            closeBtn: 0,
            shadeClose: true,
            scrollbar: false,
            content: $('#biaodan .upload-dialog'),
            btn: ['保存', '取消'],
            yes: function(index) {
                var ImageName = $('.upload-dialog input[name="ImageName"]').val();
                var ImageCategoryID = $('.upload-dialog select[name="ImageCategoryID"]').val();
                var ImageCategoryName = $('.upload-dialog select[name="ImageCategoryID"]').find('option:selected').text();
                var ImagePath = $('.upload-dialog input[name="ImagePath"]').val();
                var ImageUrl = $('.upload-dialog input[name="ImageUrl"]').val();
                var SortNo = $('.upload-dialog input[name="SortNo"]').val();
                if ($.trim(ImageName) === '') {
                    layer.alert('名称必须填写', {icon: 0});
                    return;
                }
                if ($.trim(ImageCategoryID) === '') {
                    layer.alert('图片类型必须选择', {icon: 0});
                    return;
                }
                if ($.trim(ImagePath) === '') {
                    layer.alert('图片必须上传', {icon: 0});
                    return;
                }
                if ($.trim(SortNo) === '') {
                    layer.alert('排序号必须填写', {icon: 0});
                    return;
                } else if (isNaN($.trim(SortNo))) {
                    layer.alert('排序号只能是数字', {icon: 0});
                    return;
                }
                $('#table tbody').append($('<tr></tr>').attr('data-imageid', '').append(
                        $('<td></td>').attr('data-imagename', ImageName).text(ImageName),
                        $('<td></td>').attr('data-imagecategoryid', ImageCategoryID).text(ImageCategoryName),
                        $('<td></td>').attr('data-imagepath', ImagePath).append($('<img />').attr('alt', '').attr('src', ImageUrl).css({'height': '50px'})),
                        $('<td></td>').attr('data-sortno', SortNo).text(SortNo),
                        $('<td></td>').addClass('brnone').append($('<a></a>').attr('href', 'javascript:;').text('删除').click(deleteImage))
                        ));
                $('.upload-dialog input[name="ImageName"]').val('');
                $('.upload-dialog input[name="ImagePath"]').val('');
                $('.upload-dialog input[name="ImageUrl"]').val('');
                $('.upload-dialog .tup').empty();
                $('.upload-dialog input[name="SortNo"]').val('0');
                layer.close(index);
            },
            success: function(layero, index) {
            }
        });
    });
    $('.upload-dialog .fileupload').fileupload({
        url: T.baseUrl + '/file/uploadImage.html',
        type: 'POST',
        dataType: 'json',
        paramName: 'file',
        formData: {type: 'images'},
        start: function(e) {
            window.imageUploading = layer.msg('上传中', {icon: 16});
        },
        done: function(e, data) {
            var data = data.result;
            if (data.code === 0) {
                $('.upload-dialog input[name="ImagePath"]').val(data.data.path);
                $('.upload-dialog input[name="ImageUrl"]').val(data.data.url);
                $('.upload-dialog .tup').html($('<img />').attr('alt', '').attr('src', data.data.url).css({'width': '100%', 'height': '100%'}));
            } else {
                layer.alert(data.msg, {icon: 0});
            }
            layer.close(window.imageUploading);
        },
        fail: function(e, data) {
            layer.close(window.imageUploading);
            layer.alert('上传失败，请重试！', {icon: 0});
        }
    });
    $('#table tbody .brnone a').click(deleteImage);
});
function deleteImage() {
    if (!confirm('确定要删除吗？')) {
        return;
    }
    var self = this;
    var imgId = $(self).closest('tr').attr('data-imageid');
    if (imgId) {
        var url = T.baseUrl + '/studio/resource/deleteImage';
        $.post(url, {imgId: imgId}, function(ret) {
            if (ret.code === 0) {
                layer.msg('删除成功', {
                    icon: 1,
                    time: 1500,
                    end: function() {
                        $(self).closest('tr').remove();
                    }});
            } else {
                layer.msg(ret.msg);
            }
        }, 'json');
    } else {
        $(self).closest('tr').remove();
    }
}