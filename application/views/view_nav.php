
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">ISManager</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <div class="navbar-form navbar-right">
          <?php
          if ( $loggedin )
              echo anchor_base('ismanager/logout', 'Logout', array('class'=>'btn btn-primary'));
          else
              echo anchor_base('ismanager/view/login', 'Sign in', array('class'=>'btn btn-primary'))
          ?>
      </div>
    </div><!--/.nav-collapse -->
  </div>
</nav>
