@extends('layouts.layout')
@section('content')
<section class="container forms" style="height: 100vh;">
    <div class="form login">
        <div class="form-content">
            <h2>Login Screen</h2>
            <form action="#" id="login">
                {!! csrf_field() !!}
                
                <div class="field input-field">
                    <input type="email" placeholder="Email" class="input email" name="email" id="email">
                </div>
                <div class="field input-field">
                    <input type="password" placeholder="Password" class="password password" name="password" id="password">
                    <i class='bx bx-hide eye-icon'></i>
                </div>
                
                <div class="field button-field">
                    <button id="login-btn" type="submit" name="button">Login</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection