
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
        <h1>Current Albums</h1>
      </div>

      <div class="row">
        <div class="col-md-6">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <div class="row">
                <?=$html?>
              </div>
            </tbody>
          </table>
        </div><!-- /.col-md-6 -->
      </div>
      
      <div class="row">
        <button type="button" class="btn btn-sm btn-default">New Album</button>
      </div>

    </div> <!-- /container -->

    <?php $this->view ( 'view_bs_js_core' ); ?>

  </body>
</html>
