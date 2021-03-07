<?php require_once APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Reset your password</h2>
            <p>Please enter your email</p>
            <form action="<?php echo URLROOT;?>/users/pwd" method="post">
                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" name="email"  autocomplete="off"  class="form-control form-control-lg <?php echo (!empty($data
                     ['email_err'])) ? 'is-invalid' : '' ;?> " value="" >
                    <span class="invalid-feedback"><?php echo $data['email_err']?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value ="Edit" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once APPROOT . '/views/inc/footer.php';?>