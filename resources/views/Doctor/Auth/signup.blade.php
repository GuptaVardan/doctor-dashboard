@section('title', 'Sign-Up')
@extends('Doctor.Layout.Auth.doctor')
@section('content')

<div class="card">
    <div class="card-header">
        Sign-Up
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('doctor.registration.save')}}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="mb-3">
              <label for="exampleInputName1" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="exampleInputName1" name="name">
            </div>
            <div class="mb-3">
              <label for="spl" class="form-label">Specialisation</label>
              <input type="text" class="form-control" name = "spl">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name = "email">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="exampleInputPassword2" name="password_confirmation">
            </div>
            <div class="mb-3"> 
              <label for="exampleInputImage" class="form-label">Doctor's Image</label> 
              <input type="file" class="form-control" id="exampleInputImage" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <span>Already registered?</span>
            <a href={{route('doctor.login')}}>Login</a>
          </form>
    </div>
</div>