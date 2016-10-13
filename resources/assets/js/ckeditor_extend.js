
$("[wysiwyg='true']").each(function(index, value)
{
    var attrId = $(this).attr('id');
    editor = CKEDITOR.inline(attrId);
});
