<?php require_once APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Create an account</h2>
            <p>Please fill the form below</p>
            <form action="<?php echo URLROOT;?>/users/register" method="post">
                <div class="form-group">
                    <label for="username">Username: <sup>*</sup></label>
                    <input type="text" name="username" autocomplete="off" class="form-control form-control-lg <?php echo (!empty($data
                    ['username_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['username']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['username_err']?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" name="email" autocomplete="off" class="form-control form-control-lg <?php echo (!empty($data
                    ['email_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['email']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['email_err']?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" autocomplete="off" class="form-control form-control-lg <?php echo (!empty($data
                    ['password_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['password']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['password_err']?></span>
                </div>
                <div class="form-group"> 
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" autocomplete="off" class="form-control form-control-lg <?php echo (!empty($data
                    ['confirm_password_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['confirm_password']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']?></span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value ="Register" class="btn btn-success btn-block">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once APPROOT . '/views/inc/footer.php';?>