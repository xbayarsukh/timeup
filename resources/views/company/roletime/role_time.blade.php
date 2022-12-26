<div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0" style="display:flex;height:fit-content">
              <h6 style="width:fit-content;margin:2px">Цагийн тохиргоо</h6>
              <a href="#" id="btn-add" class="bg-gradient-warning shadow text-center border-radius-md" style="border:none;width:100px;margin-left:20px;color:white">Нэмэх</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ирэх цаг</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Тарах цаг</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ажлын хоног</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">*</th>
                    </tr>
                  </thead>
                  <tbody id="roles-list" name="roles-list">
                    @foreach ($roles as $role)
                    <tr>
                      <td class="align-middle">
                        <div class="form-check" style="display:flex">
                          <input class="form-check-input" style="margin-left:initial" type="radio" name="roles" value="{{$role->id}}">
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-center text-xs font-weight-bold">{{$role->morning}}</span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-secondary text-center text-xs font-weight-bold">{{$role->night}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-center text-xs font-weight-bold">{{$role->week}}</span>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{url('admin/set_time/delete/'.$role->id)}}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Delete event">
                            <div class="bg-gradient-warning shadow text-center border-radius-md" style="width:40px; height:40px; display:flex">
                                <i class="fa fa-trash" style="font-size: 18px; color:white; margin:auto"></i>
                            </div>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>