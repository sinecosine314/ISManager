
<!DOCTYPE html>
<html lang="en">

  <?php $this->view ( 'view_head' ); ?>

  <body>

    <div class="container">

      <form class="form-signin" method="POST" action="<?=base_url()?>ismanager/login">

        <h2 class="form-signin-heading">Please sign in</h2>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword"id="inputPassword" class="form-control" placeholder="Password" required>

        <div class="checkbox">
          <label>
            <input type="checkbox" name="checkboxRemember-me" value="remember-me"> Remember me
          </label>
        </div>

        <?php echo anchor_base('ismanager/view/forgot', 'Forgot password?'); ?>

        <br><br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

        <br>

        <p>Need a login? <?php echo anchor_base('ismanager/view/register', 'Register here'); ?>

      </form>

    </div><!-- /.container -->

    <?php $this->view ( 'view_bs_js_core.php' ); ?>

  </body>
</html>
