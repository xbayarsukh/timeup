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
            {!! Form::open(['url' => 'admin/employees/edit', 'method'=>'post', 'role'=>'form', 'files' => true, 'enctype'=>'multipart/form-data' ]) !!}
              
              <div class="mb-3">
                <input type="text" name="lname" class="form-control" placeholder="Овог" value="{{$employe->lname}}" required>
              </div>
              <div class="mb-3">
                <input type="text" name="fname" class="form-control" placeholder="Нэр" value="{{$employe->fname}}" required>
              </div>
              <div class="mb-3">
                <input type="file" name="image" class="form-control" placeholder="Зураг">
                <img src="/employees/img/{{ $employe->image }}" alt="" width="70" height="70">
              </div>
              <div class="mb-3">
                <input type="text" name="register" class="form-control" placeholder="РД" value="{{$employe->register}}" required>
              </div>
              <div class="mb-3">
                <input type="text" name="job_title" class="form-control" placeholder="Албан тушаал" value="{{$employe->job_title}}" required>
              </div> 
              <div class="mb-3">
                <input type="text" name="salary" class="form-control" placeholder="Цалин" value="{{$employe->salary}}" required>
              </div>
              <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Утас" value="{{$employe->phone}}" required>
              </div>
              <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="Цахим шуудан" value="{{$employe->email}}" required>
              </div>
              <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Нэвтрэх нэр" value="{{$employe->username}}" required>
              </div>
              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Нууц үг">
              </div>
              
              <hr style="background-color:black">
              <div class="text-center" style="display:flex">
                <input type="hidden" name="id" value="{{$employe->id}}">
                <button type="submit" class="btn bg-gradient-dark w-20 my-4 mb-2" style="margin:auto">Хадгалах</button>
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