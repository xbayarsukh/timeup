<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0" style="display:flex;height:fit-content">
      <h6 style="width:fit-content;margin:2px">Цалингийн Бодолт</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <table style="font-size:11px">
            <thead>
                <tr>
                    <th>Сар</th>
                    <th>Үндсэн цалин</th>
                    <th>Ажиллах өдөр</th>
                    <th>Ажиллах цаг</th>
                    <th>Ажилласан өдөр</th>
                    <th>Ажилласан цаг</th>
                    <th>Бодогдсон цалин</th>
                    <th>Нэг цагийн хөлс</th>
                    <th>Илүү цаг</th>
                    <th>Илүү цаг 1.5</th>
                    <th>Илүү цагийн бодолт</th>
                    <th>Хоолны мөнгө</th>
                    <th>ОТЦ</th>
                    <th>НДШ</th>
                    <th>ХАОАТ</th>
                    <th>Урьдчилгаа</th>
                    <th>ГО цалин</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salary as $salaries)
                    <tr>
                        <td><?php 


$day = '2019-10-30 18:29:19';
$date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $salaries->created_at);
$date->subMonth(); // Subtracts 1 day
echo $date->format('Y m');?></td>
                        <td>{{$salary2}}</td>
                        <td>{{$salaries->job_days}}</td>
                        <td>{{$salaries->job_hour}}</td>
                        <td>{{$salaries->jobed_days}}</td>
                        <td>{{$salaries->jobed_hour}}</td>
                        <td>{{$salaries->b_salary}}</td>
                        <td>{{$salaries->onet_salary}}</td>
                        <td>{{$salaries->more_time}}</td>
                        <td>{{$salaries->more_time * 1.5}}</td>
                        <td>{{$salaries->time_salary}}</td>
                        <td>{{$salaries->cook_money}}</td>
                        <td>{{$salaries->ot_salary}}</td>
                        <td>{{$salaries->nd_shimtgel}}</td>
                        <td>{{$salaries->haoat}}</td>
                        <td>{{$salaries->uridchilgaa}}</td>
                        <td>{{$salaries->go_salary}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
        