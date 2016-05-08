function showLoading()
{
    $("#divLoading").show();
}
function hideLoading()
{
    $("#divLoading").hide();
}

function uploadFormLoaded(feedback)
{
    hideLoading();
    $("#divUploadForm").show(255);
    if (feedback.hasOwnProperty('filename'))
    {
        processNewFile(feedback.filename);
    }
    if (feedback.hasOwnProperty('error'))
    {
        $("#uploadFormErr").html(feedback.error);
        $("#uploadFormErr").show(255);
    }
}

function processNewFile(filename)
{
    url2Post = "/index.php/app/processNewFile";
    PostVars = "filename=" + filename;
    $.ajax({
        url: url2Post,
        type: "POST",
        data: PostVars,
        cache: false,
    }).done(function (data)
    {
        $("#chartResults").html(data);
        $("#chartResults").show(255);
    });
}

function uploadFormSaved()
{
    showLoading();
    $("#chartResults").hide(255);
    $("#uploadFormErr").hide(255);
}

function uploadFromFileChanged(filename)
{
    ext = filename.split('.').pop().toLowerCase();
    errMsg = "";
    $("#uploadFormErr").hide(255);
    if (ext == "xlsx")
    {
        errMsg = "We cannot support MS Excel files of 2007 or greater (at least not yet)";
    }
    else if (ext != "xls")
    {
        errMsg = "Please upload MS Excel files only."
    }
    if (errMsg != "")
    {
        $("#uploadFormErr").html(errMsg);
        $("#uploadFormErr").show(255);
        return false;
    }
    else
    {
        return true;
    }


}