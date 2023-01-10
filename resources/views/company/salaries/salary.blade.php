<div class="col-12">
  <div class="card mb-4">
    <div class="card-header pb-0" style="display:flex;height:fit-content">
      <h6 style="width:fit-content;margin:2px">Цалингийн Бодолт</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <form id="myForm" name="myForm" action="{{ url('/admin/salaries/calculate') }}" class="card-body" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Ажиллах өдөр</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="allworkday" name="allworkday" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Ажилласан өдөр</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="allday" name="allday" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Ажиллах цаг</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="allworkhour" name="allworkhour" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Ажилласан цаг</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="alltime" name="alltime" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Цалин</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="salary" name="salary" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Илүү цаг</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="moretime" name="moretime" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Хоолны мөнгө өдрийн</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="food" name="food">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Урьдчилгаа</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="uridchilgaa" name="uridchilgaa" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Бусад суутгал</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="bsuutgal" name="bsuutgal" value="0">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ХАОАТ Хөнгөлөлт</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="haoat_sale" name="haoat_sale" value="20000">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Шагнал, амралт</label>
                <div class="col-sm-12 morningset">
                    <input type="text" class="form-control" id="amralt" name="amralt" value="0">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12 morningset">
                    <input type="hidden" name="id" id="usid" value="">
                    <button type="submit" class="btn btn-success">Бодох</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
        