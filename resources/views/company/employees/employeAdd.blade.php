@extends('layouts.app')
@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxVucBtLP4XefoM4syoigBgXntwkVGxv8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0" style="display:flex;height:fit-content">
          <h6 style="width:fit-content;margin:2px">Ажилчид</h6>
        </div>
        <div class="col-xl-10 col-lg-10 col-md-10 mx-auto mb-5">
        <div class="card z-index-0">
          
          <div class="card-body">
            {!! Form::open(['url' => 'admin/employees/add', 'method'=>'post', 'role'=>'form', 'files' => true, 'enctype'=>'multipart/form-data' ]) !!}
              
              <div class="mb-3">
                <input type="text" name="lname" class="form-control" placeholder="Овог" required>
              </div>
              <div class="mb-3">
                <input type="text" name="fname" class="form-control" placeholder="Нэр" required>
              </div>
              <div class="mb-3">
                <input type="file" name="image" class="form-control" placeholder="Зураг" required>
              </div>
              <div class="mb-3">
                <input type="text" name="register" class="form-control" placeholder="РД" required>
              </div>
              <div class="mb-3">
                <input type="text" name="job_title" class="form-control" placeholder="Албан тушаал" required>
              </div> 
              <div class="mb-3">
                <input type="text" name="salary" class="form-control" placeholder="Цалин" required>
              </div>
              <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Утас" required>
              </div>
              <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="Цахим шуудан" required>
              </div>
              <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Нэвтрэх нэр" required>
              </div>
              <div class="mb-3">
                <input type="text" name="password" class="form-control" placeholder="Нууц үг" required>
              </div>
              
              <hr style="background-color:black">
              <div class="text-center" style="display:flex">
                <button type="submit" class="btn bg-gradient-dark w-20 my-4 mb-2" style="margin:auto">Нэмэх</button>
                <a href="{{url('admin/employees')}}" class="btn bg-gradient-light w-20 my-4 mb-2" style="margin:auto">Болих</a>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

@endsection