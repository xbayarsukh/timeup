@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0" style="display:flex;height:fit-content">
              <h6 style="width:fit-content;margin:2px">Ажилчид</h6>
              <a href="{{url('admin/employees/add')}}" class="bg-gradient-warning shadow text-center border-radius-md" style="border:none;width:100px;margin-left:20px;color:white">Нэмэх</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Зураг</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Овог нэр</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Дугаар</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Нас</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Хүйс</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Албан тушаал</th>
                      <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td>
                        <div style="display:flex">
                        <img src="/employees/img/{{ $user -> image }}" alt="" width="30px" height="30px" style="margin:auto">
                        </div>
                        
                      </td>
                      <td>
                        <div class="d-flex px-2 py-1">
                         
                          <div class="d-flex flex-column justify-content-center">
                            <p class="text-xs text-secondary mb-0">{{$user->lname}}</p>
                            <h6 class="mb-0 text-sm">{{$user->fname}}</h6>
                          </div>
                        </div>
                      </td>
                      <td>
                        <?php
                            $phone = $user->phone;
                            $title = "";

                            if(strlen($phone) == 8){
                                if(substr($phone,0,2) == '85' || substr($phone,0,2) == '94' || substr($phone,0,2) == '95' || substr($phone,0,2) == '99'){
                                    $title = "Мобиком";
                                }
                                if(substr($phone,0,2) == '90' || substr($phone,0,2) == '91' || substr($phone,0,2) == '96'){
                                    $title = "Скайтел";
                                }
                                if(substr($phone,0,2) == '80' || substr($phone,0,2) == '86' || substr($phone,0,2) == '88' || substr($phone,0,2) == '89'){
                                    $title = "Юнител";
                                }
                                if(substr($phone,0,3) == '830' || substr($phone,0,3) == '831' || substr($phone,0,3) == '930' || substr($phone,0,3) == '931' || substr($phone,0,3) == '932' || substr($phone,0,3) == '933' || substr($phone,0,3) == '934' || substr($phone,0,3) == '970' || substr($phone,0,3) == '971' || substr($phone,0,2) == '98'){
                                    $title = "Жи-Мобайл";
                                }
                                if(substr($phone,0,3) == '700' || substr($phone,0,3) == '701' || substr($phone,0,3) == '702' || substr($phone,0,3) == '703' || substr($phone,0,3) == '704' || substr($phone,0,3) == '705' || substr($phone,0,4) == '7128'){
                                    $title = "Монголын Цахилгаан Холбоо";
                                }
                                if(substr($phone,0,2) == '92'){
                                    $title = "Мэдээллийн аюулгүй байдлын газар";
                                }
                                if(substr($phone,0,4) == '7500' || substr($phone,0,4) == '7505' || substr($phone,0,4) == '7507' || substr($phone,0,4) == '7509' || substr($phone,0,4) == '7510' || substr($phone,0,4) == '7511' || substr($phone,0,4) == '7515' || substr($phone,0,4) == '7533' || substr($phone,0,4) == '7535' || substr($phone,0,4) == '7555' || substr($phone,0,4) == '7557' || substr($phone,0,4) == '7575' || substr($phone,0,4) == '7577' || substr($phone,0,4) == '7585' || substr($phone,0,4) == '7595'){
                                    $title = "Мобинет";
                                }
                                if(substr($phone,0,2) == '77'){
                                    $title = "Юнивишн";
                                }
                                if(substr($phone,0,3) == '760' || substr($phone,0,3) == '761' || substr($phone,0,3) == '766' || substr($phone,0,3) == '767'){
                                    $title = "Скаймедиа";
                                }
                                if(substr($phone,0,3) == '780' || substr($phone,0,3) == '781'){
                                    $title = "Жи-Мобайлнэт";
                                }
                                if(substr($phone,0,4) == '7979' || substr($phone,0,4) == '7996' || substr($phone,0,4) == '7997' || substr($phone,0,4) == '7998' || substr($phone,0,4) == '7999'){
                                    $title = "Оранжком";
                                }
                                if(substr($phone,0,4) == '7210' || substr($phone,0,4) == '7211' || substr($phone,0,4) == '7270' || substr($phone,0,4) == '7272' || substr($phone,0,4) == '7277'){
                                    $title = "Онлайм нетворк";
                                }
                            }
                            if(strlen($phone) == 6){
                                if(substr($phone,0,1) == '3' || substr($phone,0,2) == '45' || substr($phone,0,2) == '46' || substr($phone,0,2) == '48'){
                                    $title = "Монголын Цахилгаан Холбоо";
                                }
                                if(substr($phone,0,2) == '26'){
                                    $title = "Мэдээллийн аюулгүй байдлын газар";
                                }
                            }
                                
                        ?>
                        <p class="text-xs font-weight-bold mb-0" title="{{$title}}">
                            {{$phone}}
                        </p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php
                           $register = $user->register;
                           $mounth = substr($register, 6, 2);
                           $yearoldindex = "19";
                           $yearindex = substr($register, 4, 2);
                           if($mounth > 12){
                            $yearoldindex = "20";
                            $mounth -= 20;
                           }
                           $year = $yearoldindex . $yearindex;
                           $day = substr($register, 8, 2);
                           $birthday = $year . "/" . $mounth . "/" . $day;

                            $currentDate = date("Y/m/d");

                            $age = date_diff(date_create($birthday), date_create($currentDate));

                            echo $age->format("%y");

                        ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <?php
                            $register = $user->register;
                            $number = substr($register, 10, 1);
                            if($number % 2 == 0){
                                echo "Эмэгтэй";
                            }else{
                                echo "Эрэгтэй";
                            }
                        ?>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$user->job_title}}</span>
                      </td>
                      <td class="align-middle" style="display:flex">
                        <a href="{{url('admin/employees/edit/'.$user->id)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit event">
                            <div class="bg-gradient-warning shadow text-center border-radius-md" style="width:40px; height:40px; display:flex">
                                <i class="fa fa-edit" style="font-size: 18px; color:white; margin:auto"></i>
                            </div>
                        </a>
                        
                        <a href="{{url('admin/employees/delete/'.$user->id)}}" style="margin-left:20px" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete event">
                            <div class="bg-gradient-warning shadow text-center border-radius-md" style="width:40px; height:40px; display:flex">
                                <i class="fa fa-trash" style="font-size: 18px; color:white; margin:auto"></i>
                            </div>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$users->links()}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection