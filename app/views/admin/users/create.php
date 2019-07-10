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
              <h2 class="box-title">Добавить пользователя</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <form enctype="multipart/form-data" action=""  method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Имя</label>
                        <input name="username" type="text" class="form-control" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Пароль</label>
                        <input name="password" type="password" class="form-control" id="exampleInputEmail1" >
                      </div>

                      <div class="form-group">
                        <label>Роль</label>
                        <select name="role" class="form-control select2" style="width: 100%;">
                          <option value="user" selected="selected">Обычный пользователь</option>
                          <option value="admin">Администратор</option>
                        </select>
                      </div>

                        <div class="form-group">
                            <label>Аватар</label>
                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                            <!--            <input type="submit" value="upload"/>-->
                            <input type="file" name="image" ">
                        </div>

                      <div class="form-group">
                        <div class="checkbox">
                          <label>
                            <input name="status" value="isBanned" type="checkbox">
                            Бан
                          </label>
                        </div>
                      </div>

                      <div class="form-group">
                        <button type="submit" name="btn-admin-create" class="btn btn-success">Добавить</button>
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
