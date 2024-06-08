<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <link rel="stylesheet" href="{{asset('login/fonts/material-icon/css/material-design-iconic-font.min.css')}}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('login/css/style.css')}}">
</head>
<body>

<div class="main">
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="{{asset('login/images/logo_course.jpg')}}" alt="sing up image"></figure>
                    <a href="{{ route('page.registre') }}" class="signup-image-link">Créer un compte</a>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">LOGIN</h2>
                    <form action="{{route('valide.login')}}" method="POST" class="register-form" id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="email" id="email" placeholder="Votre email" value="{{ old('email') }}" />
                            @error("email")
                                <span style="color: #cb1111;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Mot de passe"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="Votre mot de passe"/>
                            @error("password")
                                <span style="color: #cb1111;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                            <label for="remember-me" class="label-agree-term"><span><span></span></span></label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" class="form-submit" value="Log in"/>

                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Or login with</span>
                        <ul class="socials">
                            <li><a href="https://www.facebook.com/"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                            <li><a href="https://twitter.com/home?lang=fr"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                            <li><a href="https://www.google.com/?hl=fr"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

<script src="{{asset('login/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('login/js/main.js')}}"></script>
</body>
</html>
