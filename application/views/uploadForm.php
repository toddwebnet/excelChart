<script language="JavaScript">
    function thisDocLoad()
    {
        output = <?=json_encode($output)?>;
        parent.uploadFormLoaded(output);
    }
    function saveClick()
    {
        parent.uploadFormSaved();
        return true;
    }
    function fileChanged()
    {
        filename = document.getElementById("fileUpload").value;
        if(parent.uploadFromFileChanged(filename))
        {
            $("#uploadButton").show(255);
        }
        else
        {
            $("#uploadButton").hide(255);
        }
    }

</script>
<body onload="thisDocLoad()">


<form action="/index.php/app/uploadProc" enctype="multipart/form-data" method="post" accept-charset="utf-8" onsubmit="return saveClick()">
    <input type="file" onchange="fileChanged()" id="fileUpload" name="fileUpload"> <input type="submit" id="uploadButton" value="Upload and Chart" onclick="saveClick()" style="display:none" >
</form>
<script src="/assets/jquery/jquery.js"></script>
</body>
