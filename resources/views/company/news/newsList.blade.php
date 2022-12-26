@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0" style="display:flex;height:fit-content">
              <h6 style="width:fit-content;margin:2px">Мэдээ</h6>
              <a href="{{url('admin/news/add')}}" class="bg-gradient-warning shadow text-center border-radius-md" style="border:none;width:100px;margin-left:20px;color:white">Нэмэх</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Зураг</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Гарчиг</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Тайлбар</th>
                      <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($news as $newslist)
                    <tr>
                    
                      <td class="align-middle text-center text-sm">
                      <img src="/news/img/{{ $newslist -> image }}" alt="" width="30px" height="30px" style="margin:auto">
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                         
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{$newslist->title}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{!!  substr(strip_tags($newslist->description), 0, 30) !!}</p>
                      </td>
                      
                      
                      <td class="align-middle" style="display:flex">
                        <a href="{{url('admin/news/edit/'.$newslist->id)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit event">
                            <div class="bg-gradient-warning shadow text-center border-radius-md" style="width:40px; height:40px; display:flex">
                                <i class="fa fa-edit" style="font-size: 18px; color:white; margin:auto"></i>
                            </div>
                        </a>
                        
                        <a href="{{url('admin/news/delete/'.$newslist->id)}}" style="margin-left:20px" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete event">
                            <div class="bg-gradient-warning shadow text-center border-radius-md" style="width:40px; height:40px; display:flex">
                                <i class="fa fa-trash" style="font-size: 18px; color:white; margin:auto"></i>
                            </div>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$news->links()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection