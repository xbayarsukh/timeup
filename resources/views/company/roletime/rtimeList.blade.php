@extends('layouts.app')
@section('content')

<style>
    .selector:hover {
        overflow-x: scroll !important;
    }

    /* width */
    .selector::-webkit-scrollbar {
        height: 6px !important;
    }

    /* Track */
    .selector::-webkit-scrollbar-track {
        background: #f1f1f1;
        height: 6px !important
    }

    /* Handle */
    .selector::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
        height: 6px !important
    }

    /* Handle on hover */
    .selector::-webkit-scrollbar-thumb:hover {
        background: #555;
        height: 6px !important
    }

</style>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY3cBfU10jCYn2u8BNMyUVC9z006s7xnk&libraries=geometry">
</script>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card-header pb-0" style="display:flex;height:fit-content">
                <h6 style="width:fit-content;margin:10px">Байршил</h6>
            </div>
            <div class="selector" style="margin: 10px; height: 150px; overflow: hidden;white-space: nowrap;">
                <div class="card align-middle text-center" onclick="add_location()"
                    style="width:90px; height:90px; background-color:white;display:inline-flex;margin:5px">
                    <div style="margin:auto; font-size:30px">
                        +
                    </div>
                </div>
                <div class="location-cards" style="display:inline-flex">
                    @include('company.roletime.location')
                </div>
            </div>
        </div>
        <div class="role-cards col-6">
            @include('company.roletime.role_time')
        </div>
        <div class="user-cards col-6">
            @include('company.roletime.user')
        </div>
        
        
    </div>
</div>
<div class="modal fade" id="formLoc" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel">Байршил</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Нэр</label>
                        <div class="col-sm-12" id="name-set">
                        </div>
                    </div>
                    <div id="map" style="width:100%; height:300px">

                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content:space-between">
                <input type="hidden" id="todo_id" name="todo_id" value="0">
                
                <button type="submit" class="btn btn-primary" id="btn-loc-del" value="add">Устгах</button>
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Хаах</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formAdd" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel">Байршил нэмэх</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Нэр</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name-get" name="morning"
                                placeholder="Байршлын нэр" value="" required>
                        </div>
                    </div>
                    <div id="maps" style="width:100%; height:300px">

                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content:space-between">
                <input type="hidden" id="todo_id" name="todo_id" value="0">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Хаах</button>
                <button type="submit" class="btn btn-primary" id="btn-loc-save" value="add">Хадгалах</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel">Тохиргоо нэмэх</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ирэх цаг</label>
                        <div class="col-sm-12">
                            <input type="time" class="form-control" id="morning" name="morning" placeholder="Ирэх цаг"
                                value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Тарах цаг</label>
                        <div class="col-sm-12">
                            <input type="time" class="form-control" id="night" name="night" placeholder="Тарах цаг"
                                value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ажлын өдөр</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="week" name="week" placeholder="Ажлын өдөр"
                                value="" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content:space-between">
                <input type="hidden" id="todo_id" name="todo_id" value="0">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Хаах</button>
                <button type="submit" class="btn btn-primary" id="btn-save" value="add">Хадгалах</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var center=[], polygons=[];
    jQuery(document).ready(function ($) {

        
        //----- Open model CREATE -----//
        jQuery('#btn-add').click(function () {
            jQuery('#btn-save').val("add");
            jQuery('#myForm').trigger("reset");
            jQuery('#formModal').modal('show');
        });
        // CREATE
        $("#btn-save").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = {
                _token: '{{csrf_token()}}',
                morning: jQuery('#morning').val(),
                night: jQuery('#night').val(),
                week: jQuery('#week').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var todo_id = jQuery('#todo_id').val();
            var ajaxurl = 'set_time/add';
            console.log(formData);
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                success: function (data) {
                    $('.role-cards').html(data);
                    jQuery('#formModal').modal('hide');
                    
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });


        var roles = 0;
        var users = 0;

        $('input[name="roles"]').on('change', function (e) {
            roles = 0;

            $('input[name="roles"]:checked').each(function () {

                roles = $(this).val();

            });
            console.log(roles);
            fetchRole();

        });

        $('input[name="users"]').on('change', function (e) {
            users = 0;

            $('input[name="users"]:checked').each(function () {

                users = $(this).val();

            });

            console.log("sdfadsfadsf");
            checkUser();

        });

        function fetchRole() {
            $.ajax({
                type: "GET",
                url: "set_time/role_change",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    roles_id: roles,
                },
                success: function (response) {
                    $('.user-cards').html(response);
                    $('input[name="users"]').on('change', function (e) {
                        users = 0;

                        $('input[name="users"]').each(function () {
                            users = $(this).val();
                            if ($(this).is(':checked')) {
                                checkUser();
                            } else {
                                uncheckUser();
                            }

                        });

                    });
                }
            });

        }

        function checkUser() {
            console.log(roles);
            console.log(users);
            $.ajax({
                type: "GET",
                url: "set_time/user_change",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    roles_id: roles,
                    users_id: users,
                }
            });

        }

        function uncheckUser() {
            $.ajax({
                type: "GET",
                url: "set_time/user_changed",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    users_id: users,
                }
            });

        }

    });

    function thisclick(id) {
        $.ajax({
            type: "GET",
            url: "set_time/show",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            },
            data: {
                loc_id: id,
            },
            success: function (data) {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    disableDefaultUI: true,
                    center: new google.maps.LatLng(47.918722, 106.902556)
                });

                var mlat = parseFloat(data.lat);
                var mlong = parseFloat(data.long);

                $('#name-set').html(
                    '<input type="text" class="form-control" name="morning" placeholder="Байршлын нэр" value="' +
                    data.name + '" disabled>');
                const myLatLng = {
                    lat: mlat,
                    lng: mlong
                };

                $('#btn-loc-del').val(data.id);

                console.log(myLatLng);

                new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: "Энд",
                });
                new google.maps.Polygon({
                    map: map,
                    path: circlePath(myLatLng, 70, 8)
                });
                jQuery('#formLoc').modal('show');
            }
        });
    };

    function circlePath(center, radius, points) {
        var a = [],
            p = 360 / points,
            d = 0,
            b = [];
        for (var i = 0; i < points; ++i, d += p) {
            a.push(google.maps.geometry.spherical.computeOffset(center, radius, d));
        }
        for(var i=0; i<a.length; i++){
          b.push({lat: a[i].lat(), lng: a[i].lng()});
        }

        $('#tester').html('Center: ' + center + '<br>' + 'Latlng: ' + a);

        return b;
    }

    function add_location() {

        var mapOptions = {
            center: new google.maps.LatLng(47.918869258935786, 106.91757839173079),
            zoom: 12
        };
        var map = new google.maps.Map(document.getElementById("maps"),
            mapOptions);
        var marker = new google.maps.Marker({
            position: '',
            map: map,
        });
        var polygon = new google.maps.Polygon({
            map: map,
            path: ''
        });
        google.maps.event.addListener(map, 'click', function (e) {
            marker.setPosition(e.latLng);
            polygons = circlePath(e.latLng, 25, 8);
            
            center = {
                    lat: e.latLng.lat(),
                    lng: e.latLng.lng()
                };
            console.log(center);
            console.log(polygons);
            polygon.setPaths(polygons);
        });
        jQuery('#formAdd').modal('show');
    }

    $("#btn-loc-save").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = {
            _token: '{{csrf_token()}}',
            name: jQuery('#name-get').val(),
            center: center,
            polygons: polygons
        };
        var type = "POST";
        var ajaxurl = 'set_time/add_to_loc';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            success: function (data) {
                $('.location-cards').html(data);
                jQuery('#formAdd').modal('hide');
            },
            error: function (data) {
                console.log('error: ' + data.url);
            }
        });
    });

    $("#btn-loc-del").click(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = {
            _token: '{{csrf_token()}}',
            id: jQuery(this).val(),
        };
        var type = "POST";
        var ajaxurl = 'set_time/del_to_loc';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            success: function (data) {
                $('.location-cards').html(data);
                jQuery('#formLoc').modal('hide');
            },
            error: function (data) {
                console.log('error: ' + data.url);
            }
        });
    });



</script>
@endsection
