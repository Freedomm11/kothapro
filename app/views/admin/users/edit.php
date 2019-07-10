<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content container-fluid">

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Админ-панель</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="">
            <div class="box-header">
              <h2 class="box-title">Изменить пользователя</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <form enctype="multipart/form-data" action=""  method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Имя</label>
                        <input name="username" type="text" class="form-control" id="exampleInputEmail1" value="<?=$oneUser['username']; ?>">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" value="<?=$oneUser['email']; ?>">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Пароль</label>
                        <input name="password" placeholder="Password" type="password" class="form-control" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label>Роль</label>
                        <select name="role" class="form-control select2" style="width: 100%;">
                            <? if($oneUser['roles_mask']==2) {
                            $role_1='Обычный пользователь'; $role_2='Администратор';
                            $value_1=2; $value_2=1; }
                            else if ($oneUser['roles_mask']==1){
                                $role_1='Администратор'; $role_2='Обычный пользователь';
                                $value_1=1; $value_2=2;
                            }?>
                          <option value="<?=$value_1?>" selected="selected"><?=$role_1?></option>
                          <option value="<?=$value_2?>"><?=$role_2?></option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Аватар</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                        <input name="image" type="file" id="exampleInputEmail1" >
                        <br>
                        <img src="/uploads/avatars/<?=$oneUser['avatar']; ?>" width="200" alt="">
                      </div>

                      <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input <? if($oneUser['status']==2) echo 'checked' ?> name="status" type="checkbox">
                            Бан
                          </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <button name="btn-user-edit" type="submit" class="btn btn-warning">Изменить</button>
                      </div>
                    </form>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            По вопросам к главному администратору.
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
