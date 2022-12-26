@extends('layouts.app')
@section('content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0" style="display:flex;height:fit-content">
                    <h6 style="width:fit-content;margin:2px">Чөлөөний хүсэлт</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        №</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Нэр</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Албан тушаал</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Төрөл</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Өдөр/цаг</th>

                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Шалтгаан</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Хэн</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Төлөв</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Он сар өдөр</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $number = 1;?>
                                @foreach ($freetimes as $freetime)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$number}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$freetime->fname}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$freetime->job_title}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$freetime->category}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <?php 
                            if($freetime->category == 'Цагийн') {
                              $shour = new DateTime($freetime->start_hour);
                              $ehour = new DateTime($freetime->end_hour);
                              
                              $diffh = $ehour->diff($shour);
                              
                              $hours = $diffh->h;
                              
                              echo $hours;
                            }else {
                              $date1 = new DateTime($freetime->start_day);
                              $date2 = new DateTime($freetime->end_day);
                              
                              $diff = $date2->diff($date1);
                              
                              $day = $diff->d;
                              $day = $day;
                              
                              echo $day;
                            }
                          ?></p>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$freetime->description}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            <?php
                          foreach ($users as $user) {
                           if ($user->id == $freetime->admin_id) {
                            echo $user->fname;
                           }
                          }
                        ?>
                                        </p>
                                    </td>
                                    <td>

                                        <?php 
                            if($freetime->status == 1) 
                              echo '<div class="text-xs font-weight-bold mb-0" style="color:red">Татгалзсан</div>'; 
                            elseif($freetime->status == 2) 
                              echo '<div class="text-xs font-weight-bold mb-0" style="color:green">Зөвшөөрсөн</div>'; 
                            else 
                              echo '<div class="text-xs font-weight-bold mb-0" style="color:orange">Хүсэлт илгээсэн</div>';?>

                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$freetime->created_at}}</p>
                                    </td>
                                    <td class="align-middle" style="display:flex">
                                        <div id="description" class="text-secondary font-weight-bold text-xs"
                                            onclick="description({{$freetime->id}})">
                                            <div class="bg-gradient-warning shadow text-center border-radius-md"
                                                style="width:40px; height:40px; display:flex">
                                                <i class="fas fa-file-alt"
                                                    style="font-size: 18px; color:white; margin:auto"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $number++;?>
                                @endforeach
                            </tbody>
                        </table>
                        {{$freetimes->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formLoc" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel">Байршил</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Овог нэр</label>
                        <div class="form-control" id="name-set">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Албан тушаал</label>
                        <div class="form-control" id="job-set">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Төрөл</label>
                        <div class="form-control" id="cat-set">
                        </div>
                    </div>
                    <div class="form-group dater">
                        <label for="name" class="col-sm-12 control-label">Хэзээ</label>
                        <div class="form-control" id="date-set">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label start">Эхлэх</label>
                                <div class="form-control" id="start-set">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label end">Дуусах</label>
                                <div class="form-control" id="end-set">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Шалтгаан</label>
                        <div class="form-control" id="desc-set">
                            
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content:space-between">
                <input type="hidden" id="todo_id" name="todo_id" value="0">

                <button type="submit" class="btn btn-primary" id="btn-loc-del" value="add">Зөвшөөрөх</button>
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Татгалзах</button>
            </div>
        </div>
    </div>
</div>
<script>
    function description(id) {
        $.ajax({
            type: "GET",
            url: "/admin/freetime/show",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            },
            data: {
                id: id,
            },
            success: function (data) {
                $('#name-set').text(data.fname + ' ' + data.lname);
                $('#job-set').text(data.job_title);
                var category;
                var date;
                if (data.category == "Өдрийн") {
                  $('#start-set').text(data.start_day);
                  $('#end-set').text(data.end_day);
                  $('.dater').hide();
                } else {
                  $('#start-set').text(data.start_hour);
                  $('#end-set').text(data.end_hour);
                  $('.dater').show();
                  $('#date-set').text(data.date);
                }
                $('#cat-set').text(data.category);
                $('#date-set').text(date);
                $('#desc-set').text(data.description);
                jQuery('#formLoc').modal('show');
            }
        });
    }

</script>
@endsection
