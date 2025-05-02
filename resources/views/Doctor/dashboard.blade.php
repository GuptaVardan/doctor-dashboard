@extends('Doctor.Layout.Doc.Header')
@section('title','dashboard')
@section('content')

  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/doctor/dashboard">Appointments</a>
    <a href="/">Log Out</a>
  </div>
  
  <!-- Use any element to open the sidenav -->
  <span onclick="openNav()" style="font-size: 40px; cursor: pointer">≡</span>
  
  <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
  <div id="main">
    <h1 style="text-align: center">Appointments</h1>
    <table class="table" style="font-size: 30px">  
      <thead>  
        <tr>  
          <th scope="col">S.No</th>  
          <th scope="col">Name</th>  
          <th scope="col">Email</th>  
          <th scope="col">Timing</th>  
          <th scope="col">Doctor</th>  
        </tr>  
      </thead>  
      <tbody>  
        @php  
          $appoint = DB::table('appointments')->get();  
          $i = 1;  
        @endphp  
        @foreach ($appoint as $apt)  
        <tr>  
          <th scope="row">{{$i++}}</th>  
          <td>{{$apt->name}}</td>  
          <td>{{$apt->email}}</td>  
          <td>{{$apt->timing}}</td>  
          <td>{{$apt->doctor_name}}</td>  
        </tr>  
        @endforeach  
      </tbody>  
    </table>    
  </div>

@endsection