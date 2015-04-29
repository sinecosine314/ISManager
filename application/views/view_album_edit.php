
<!DOCTYPE html>
<html lang="en">

  <?php $this->view ( 'view_head' ); ?>

    <body role="document">

    <?php $this->view ( 'view_nav' ); ?>

    <div class="container" role="main">

      <div class="jumbotron">
        <h1>Welcome!</h1>
        <p>Welcome to the ImageServer. Here, you can manage your banner images.</p>
      </div>

      <div class="page-header">
        <h1>Edit Album Information</h1>
      </div>

      <form class="form-signin" method="POST" action="<?=base_url()?>ismanager/changealbum">

        <?=$html?>

        <br>

        <button class="btn btn-lg btn-primary btn-block" type="button">Cancel</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Change</button>

      </form>

    </div><!-- /.container -->

    <?php $this->view ( 'view_bs_js_core.php' ); ?>

  </body>
</html>
