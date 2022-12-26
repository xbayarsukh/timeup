<div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0" style="display:flex;height:fit-content">
              <h6 style="width:fit-content;margin:2px">Ажилчид</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-center text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Овог нэр</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Албан тушаал</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr id="{{$user->id}}">
                      <td class="align-middle">
                        <div class="form-check form-switch">
                          <input type="checkbox" class="form-check-input" style="margin:auto" name="users" id="" value="{{$user->id}}" <?php if($user->time_role_id == $roles_id) echo "checked"; ?>>
                        </div>
                      </td>
                      <td class="align-middle">
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <p class="text-xs text-secondary mb-0">{{$user->lname}}</p>
                                <h6 class="mb-0 text-sm">{{$user->fname}}</h6>
                            </div>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{$user->job_title}}</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>