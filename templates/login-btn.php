<?php 

$calc_html = '
    <!--Calc Module Start-->
    <div class="card login-card">
    <div class="row no-gutters">
      <div class="col-md-5">
      </div>
      <div class="col-md-7">
        <div class="card-body">
          <div class="brand-wrapper">
            <img src="'.get_site_url().'/wp-content/plugins/opp-debt-calculator/assets/images/logo.svg" alt="logo" class="logo">
          </div>
          <p class="login-card-description">Sign into your account</p>
          <form action="" id="tokenly-login-form">
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email address">
              </div>
              <div class="form-group mb-4">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="***********">
              </div>
              <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
            </form>
            <a href="#!" class="forgot-password-link">Forgot password?</a>
            <p class="login-card-footer-text">Dont have an account? <a href="#!" class="text-reset">Register here</a></p>
            <a href="'.get_site_url().'/wp-content/plugins/tokenpass/account/authorize/auth.php" id="tk-login-btn"> Login with Tokenly </a>
            <nav class="login-card-footer-nav">
              <a href="#!">Terms of use.</a>
              <a href="#!">Privacy policy</a>
            </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- TOKENLY LOGIN Modal -->
  <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Authorization</h4>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  
  ';

        echo $calc_html;
?>