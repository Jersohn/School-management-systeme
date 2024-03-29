<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../images/favicon.ico">

  <title>ITA-SMS - Log in </title>

  <!-- Vendors Style-->
  <link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">

  <!-- Style-->
  <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">

</head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">

  <div class="container h-p100">
    <div class="row align-items-center justify-content-md-center h-p100">

      <div class="col-12">
        <div class="row justify-content-center no-gutters">
          <div class="col-lg-4 col-md-5 col-12">
            <div class="container text-center">
              <div class="row">
                <div class="col-md-6 offset-md-3">
                  <div class="content-top-agile p-10">


                    <h2 class="text-white"><i class="text-warning mr-0 font-size-24 mdi mdi-school"></i> I N S E T</h2>

                    <div class="clearfix"></div> <!-- Clear the floats -->

                    <hr style="border-color:darkgoldenrod;">
                    <p class="text-white-50">Connexion</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="p-30 rounded30 box-shadowed b-2 b-dashed">

              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-transparent text-white"><i class="ti-user"></i></span>
                    </div>
                    <input type="email" id="email" name="email"
                      class="form-control pl-15 bg-transparent text-white plc-white" placeholder="email">
                  </div>
                  @error('email')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text  bg-transparent text-white"><i class="ti-lock"></i></span>
                    </div>
                    <input type="password" id="password" name="password"
                      class="form-control pl-15 bg-transparent text-white plc-white" placeholder="mot de passe">
                  </div>
                  @error('password')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="row">
                  <div class="col-6"></div>
                  <div class="col-6">
                    <div class="fog-pwd text-right">
                      <a href="{{ route('password.request') }}" class="text-white hover-info"><i
                          class="ion ion-locked"></i> Forgot pwd?</a><br>
                    </div>
                  </div>

                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-outline btn-white btn-rounded mt-10">Connexion</button>
                  </div>
                </div>
              </form>


              <div class="text-center text-white">
                <p class="mt-20">- Connexion à partir de -</p>
                <p class="gap-items-2 mb-20">
                  <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i
                      class="fa fa-facebook"></i></a>
                  <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i
                      class="fa fa-twitter"></i></a>
                  <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i
                      class="fa fa-google-plus"></i></a>
                  <a class="btn btn-social-icon btn-round btn-outline btn-white" href="#"><i
                      class="fa fa-instagram"></i></a>
                </p>
              </div>

              <div class="text-center">
                <p class="mt-15 mb-0 text-white">Vous n'avez pas encore de compte? <a href="{{ route('register') }}"
                    class="text-secondary ml-5">S'inscrire</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Vendor JS -->
  <script src="{{ asset('backend/js/vendors.min.js') }}"></script>
  <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>







</body>

</html>