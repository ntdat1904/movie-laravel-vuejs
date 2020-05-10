<div id="login" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="login-content" class="">
                    <button data-dismiss="modal" class="close">&times;</button>
                    <h4>Login</h4>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <input type="email" name="email" class="username form-control" placeholder="Email"/>
                        <input type="password" name="password" class="password form-control" placeholder="Password"/>
                        @if(!empty($errors->login->all()))
                            <div class="main-error-message">
                                @foreach ($errors->login->all() as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-actions">
                            <div class="pull-left">
                                <label class="rememberme mt-checkbox mt-checkbox-outline">
                                    <input type="checkbox" name="remember" value="1"/> Remember me
                                    <span></span>
                                </label>
                            </div>
                            <div class="pull-right forget-password-block">
                                <a href="javascript:;" data-target="#forget-password" data-toggle="modal"
                                   class="forget-password">Forgot Password?</a>
                            </div>
                        </div>
                        <button class="btn login" type="submit">Login</button>
                        <div class="login-options">
                            <h4 class="pull-left">Or login with</h4>
                            <ul class="social-icons pull-right">
                                <li>
                                    <a class="social-icon-color facebook" data-original-title="facebook"
                                       href="{{route('redirect')}}"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color twitter" data-original-title="Twitter"
                                       href="{{route('redirectTwitter')}}"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color googleplus" data-original-title="Goole Plus"
                                       href="{{route('redirectGoogle')}}"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color linkedin" data-original-title="Linkedin"
                                       href="javascript:;"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="create-account">
                            <p>
                            <h4>Or <a href="" data-target="#register" data-toggle="modal">create new account</a></h4>
                            </p>
                        </div>
                    </form>
                </div>
                <div id="register-content" class="hidden">
                    <h4>Register</h4>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="username form-control" placeholder="Username"/>
                        @if(!empty($errors->register->get('name')))

                            <div class="main-error-message">
                                @foreach ($errors->register->get('email') as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <input type="email" name="email" class="username form-control" placeholder="Email"/>
                        @if(!empty($errors->register->get('email')))

                            <div class="main-error-message">
                                @foreach ($errors->register->get('email') as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <input type="password" name="password" class="password form-control" placeholder="Password"/>
                        @if(!empty($errors->register->get('password')))

                            <div class="main-error-message">
                                @foreach ($errors->register->get('password') as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <input type="password" name="password_confirmation" class="password form-control"
                               placeholder="Password confirmation"/>
                        @if(!empty($errors->register->get('password_confirmation')))

                            <div class="main-error-message">
                                @foreach ($errors->register->get('password_confirmation') as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a class="btn back"><span>Back</span></a>
                        <button class="btn register" type="submit"><span>Register</span></button>
                    </form>
                </div>
                <div id="forgot-password-content" class="hidden">
                    <h4>Forgot Password</h4>

                    <form action="{{route('password.email')}}" method="POST">
                        @csrf
                        <input type="email" name="email" class="username form-control" placeholder="Email"/>
                        @if(!empty($errors->reset->get('email')))
                            <div class="main-error-message">
                                @foreach ($errors->reset->get('email') as $error)
                                    <span class="error-message">{{$error }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a class="btn back"><span>Back</span></a>
                        <button class="btn register" type="submit"><span>Send</span></button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script !src="">
    $(document).ready(function () {
        let valRegister = {{$errors->register->count()}}
            let valLogin = {{$errors->login->count()}}
            let valReset = {{$errors->reset->count()}}

        $('.create-account a').click(function () {
            $('#login-content').addClass('hidden');
            $('#register-content').removeClass('hidden');
        });

        $('.forget-password').click(function () {
            $('#login-content').addClass('hidden');
            $('#forgot-password-content').removeClass('hidden');
        });

        $('a.back').click(function () {
            $('#login-content').removeClass('hidden');
            $('#register-content').addClass('hidden');
            $('#forgot-password-content').addClass('hidden');
        });
        if (valRegister > 0) {
            $('#login').modal('show');
            $('.create-account a').trigger('click');
        }

        if (valReset > 0) {
            $('#login').modal('show');
            $('.forget-password-block a').trigger('click');
        }
        if (valLogin > 0) {
            $('#login').modal('show');
        }
    });
</script>
