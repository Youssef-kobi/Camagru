<?php require_once APPROOT . '/views/inc/header.php';?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Edit Your Profile</h2>
            <p>Please fill the form to edit</p>
            <p>Empty forms wont be edited </p>
            <form action="<?php echo URLROOT;?>/users/profile" method="post">
                <div class="form-group">
                    <label for="username">Username:<sup>*</sup><i>  <?php echo $_SESSION['user_username'];?></i> </label>
                    <? echo $_SESSION['user_username']; ?> 
                    <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data
                    ['username_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['username']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['username_err']?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup><i>  <?php echo $_SESSION['user_email'];?></i> </label>
                    <input type="text" name="email" class="form-control form-control-lg <?php echo (!empty($data
                    ['email_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['email']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['email_err']?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data
                    ['password_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['password']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['password_err']?></span>
                </div>
                <div class="form-group"> 
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data
                    ['confirm_password_err'])) ? 'is-invalid' : '' ;?> " value="<?php echo $data['confirm_password']; ?>" >
                    <span class="invalid-feedback"><?php echo $data['confirm_password_err']?></span>
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