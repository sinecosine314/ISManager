
<!DOCTYPE html>
<html lang="en">

  <?php $this->view ( 'view_head' ); ?>

  <body>

    <div class="container">

      <form class="form-signin" method="POST" action="<?=base_url()?>ismanager/forgot">

        <h2 class="form-signin-heading">Request a password reset</h2>

        <p>Please enter your email so we can send you a password reset code.</p>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Send reset</button>

      </form>

    </div><!-- /.container -->

    <?php $this->view ( 'view_bs_js_core.php' ); ?>

  </body>
</html>
