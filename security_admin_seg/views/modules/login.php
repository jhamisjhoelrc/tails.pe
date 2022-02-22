<div id="back"></div>
<div class="login-box">
   <div class="login-logo">

   </div>
   <!-- /.login-logo -->
   <div class="card">
      <img src="views/dist/img/template/logo.png" class="img-fluid" width="fluid-img">
      <div class="card-body login-card-body">
         <p class="login-box-msg">ACCESO AL SISTEMA</p>

         <form action="" method="post">
            <div class="input-group mb-3">
               <input type="email" id="emailLogin" name="emailLogin" class="form-control" placeholder="Email" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-envelope"></span>
                  </div>
               </div>
            </div>
            <div class="input-group mb-3">
               <input type="password" id="passwordLogin" name="passwordLogin" class="form-control" placeholder="Password" />
               <div class="input-group-append">
                  <div class="input-group-text">
                     <span class="fas fa-lock"></span>
                  </div>
               </div>
            </div>
            <div class="row">

               <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">
                     Ingresar al sistema
                  </button>
               </div>
               <!-- /.col -->
            </div>
            <?php
            $login = new ControllerUser();
            $login->ctrLogin();
            ?>
         </form>
      </div>
      <!-- /.login-card-body -->
   </div>
</div>
<!-- /.login-box -->