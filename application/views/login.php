<?php require "top_template.php"; ?>

<section class="row">
    <div class="col-md-3">&nbsp;</div>
    <div class="col-md-4">
        <form role="form" action="/index.php/app/loginProc" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            <?php if(strlen(trim($message))>0){?>
            <div class="formErr"><?= $message ?></div>
            <?php } ?>
        </form>
    </div>
</section>

<?php require "bottom_template.php"; ?>
