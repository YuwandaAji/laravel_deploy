<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login-Nonchalant Coffe</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container" id="container">
        <!--sign-up Start-->

        <div class="form-container sign-up">
            
            <span style="color: yellow">{{ $errors->first('email') }}<br></span>
            <span style="color: red">{{ $errors->first('password') }}<br></span>

            @include('message')
            <form method="POST" action="{{ url('register_post') }}">
                @csrf
                <h1>Create Account</h1>
                <div class="sosial-icon">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>

                <div class="divider">
                    <span>or use your email for register</span>
                </div>
            
                <input type="text" placeholder="Name" id="username" name="name" value="{{ old('name') }}" required >
                <input type="email" placeholder="Email" id="emailnew" name="email" value="{{ old('email') }}" required>
                <input type="password" placeholder="Password" id="passwordnew" name="password" value="{{ old('password') }}" required>
                <button type="submit" onclick="signupbtn()">Sign Up</button>
            </form>

            @if ($errors->any())
                <div style="color: red; margin-bottom: 10px;">
                    <ul>
                        <li>{{ $errors->first() }}</li> 
                    </ul>
                </div>
            @endif
        </div>

        <!--SignUp End-->

        <!--SignIn Start-->

        <div class="form-container sign-in">
            
            <span style="color: yellow">{{ $errors->first('email') }}<br></span>
            <span style="color: red">{{ $errors->first('password') }}<br></span>

            @include('message')
            <form method="POST" action="{{ url('login_post') }}">
                @csrf
                <h1>Sign In</h1>
                <div class="sosial-icon">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>

                <div class="divider">
                    <span>or use your email for login</span>
                </div>

                <input type="email" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required>
                <input type="password" placeholder="Password" id="password" name="password" value="{{ old('password') }}" required>
                <a href="#">Forgot your password?</a>
                <button type="submit" onclick="signinbtn()">Sign In</button>
            </form>
            @if ($errors->any())
                <div style="color: red; margin-bottom: 10px;">
                    <ul>
                        <li>{{ $errors->first() }}</li> 
                    </ul>
                </div>
            @endif
        </div>

        <!--Sign In End-->

        <!--Toggle Start-->

        <div class="toggle-container">
            
            <div class="toggle">

                <!--toggle login -->
                <div class="toggle-panel toggle-left">
                    <h1>Hello, Nonchalant Lover</h1>
                    <p>Enter your personal information to use all features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <!--toggle login End-->

                <!--toggle register-->
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Guys!</h1>
                    <p>If this your first time in our site, register your personal information to use all features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>

                <!--toggle register End-->

                <script src="{{ asset('js/login.js') }}"></script>
            </div>
        </div>
    </div>
</body>
</html>