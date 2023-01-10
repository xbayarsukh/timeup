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
            @include('company.salaries.user')
        </div>
        <div class="check-cards col-7">
            @include('company.salaries.salary')
        </div>
        <div class="check-cards list col-12">
            @include('company.salaries.salaries')
        </div>

    </div>
</div>

<script type="text/javascript">
    $('#myForm').hide();
    $('.list').hide();
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
            getSalary(users);
        }

    });
    function getCalendar(id) {
        $.ajax({
            type: "GET",
            url: "/admin/salaries/salary/"+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('#allworkday').val(data.allworkday);
                $('#allday').val(data.allday);
                $('#allworkhour').val(data.allworkhour);
                $('#alltime').val(data.alltime);
                $('#salary').val(data.salary);
                $('#usid').val(data.id);
                $('#myForm').show();
            }
        });
    }
    
    function getSalary(id) {
        $.ajax({
            type: "GET",
            url: "/admin/salaries/salarylist/"+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $('.list').html(data);
                $('.list').show();
            }
        });
    }

</script>
@endsection
