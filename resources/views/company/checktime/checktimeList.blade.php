@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="/fullcalendar/fullcalendar.min.css" />
<script src="/fullcalendar/lib/jquery.min.js"></script>
<script src="/fullcalendar/lib/moment.min.js"></script>
<script src="/fullcalendar/fullcalendar.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAY3cBfU10jCYn2u8BNMyUVC9z006s7xnk">
</script>

<div class="container-fluid py-4">
    <div class="row">
        <div class="user-cards col-5">
            @include('company.checktime.user')
        </div>
        <div class="check-cards col-7">
            @include('company.checktime.check_time')
        </div>

    </div>
</div>
<div class="modal fade" id="formModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBookModel">Дэлгэрэнгүй</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Цаг</label>
                        <div class="col-sm-12 morningset">

                        </div>
                    </div>
                    <div id="map_canvas" style="width:100%; height:200px"></div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Хаах</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var calendar = $('#calendar');
    jQuery(document).ready(function ($) {

        var users = 0;

        $('input[name="users"]').on('change', function (e) {
            users = 0;

            $('input[name="users"]:checked').each(function () {

                users = $(this).val();

            });
            fetchRole();

        });

        function fetchRole() {
            getCalendar(users);

        }

    });
    function getCalendar(id) {
        calendar.fullCalendar('destroy')
        calendar.fullCalendar({
            editable: true,
            events: "/admin/checktime/check/" + id,
            displayEventTime: false,
            firstDay: 1,
            locale: 'mn',
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            selectable: false,
            eventClick: function (event) {

                var map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 12,
                    disableDefaultUI: true,
                    center: new google.maps.LatLng(47.918722, 106.902556)
                });


                var mlat = parseFloat(event.lat);
                var mlong = parseFloat(event.long);

                $('.morningset').html(
                    '<input type="text" class="form-control" name="morning" placeholder="Ирсэн цаг" value="' +
                    event.title + '" disabled>');

                const myLatLng = {
                    lat: mlat,
                    lng: mlong
                };



                new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: "Энд",
                });


                jQuery('#myForm').trigger("reset");
                jQuery('#formModal').modal('show');
            }
        });

    }

</script>
@endsection
