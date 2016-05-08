<?php require "top_template.php"; ?>
<h1>Excel Uploader</h1>
<div class="row" style="text-align: center;display:none" id="divLoading"><img src="/assets/images/loading.gif"/></div>
<div class="row" id="form">
    <div class="col-md-12" style="display:none" id="divUploadForm">
        <iframe src="/index.php/app/uploadForm" style="border: 0px; height: 50px;width:600px;"></iframe>
        <div class="formErr" id="uploadFormErr"></div>
    </div>

</div>


<div class="row" id="chartResults">


</div>
<?php require "bottom_template.php"; ?>
