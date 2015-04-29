
<!DOCTYPE html>
<html lang="en">

  <?php $this->view ( 'view_head' ); ?>

    <body role="document">

    <div class="container">

      <form class="form-signin" method="POST" action="<?=base_url()?>ismanager/register">
        <h2 class="form-signin-heading">Registration</h2>

        <label for="inputFirstName" class="sr-only">First name</label>
        <input type="text" name="inputFirstName" id="inputFirstName" class="form-control" placeholder="First name" required autofocus>

        <label for="inputLastName" class="sr-only">Last name</label>
        <input type="text" name="inputLastName" id="inputLastName" class="form-control" placeholder="Last name" required autofocus>

        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <label for="inputTelephone" class="sr-only">Telephone number</label>
        <input type="tel" name="inputTelephone" id="inputTelephone" class="form-control" placeholder="Telephone number" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required autofocus>

        <label for="inputConfirm" class="sr-only">Confirm</label>
        <input type="password" name="inputConfirm" id="inputConfirm" class="form-control" placeholder="Password confirm" required autofocus>

        <br>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

      </form>

    </div><!-- /.container -->

    <?php $this->view ( 'view_bs_js_core.php' ); ?>

  </body>
</html>
