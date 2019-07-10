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
              <h2 class="box-title">Изменить изображение</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-md-6">
                    <form enctype="multipart/form-data" action=""  method="post">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Название</label>
                        <input type="text" name="title" class="form-control" id="exampleInputEmail1" value="<?=$post['title']; ?>">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Краткое описание</label>
                        <textarea class="form-control" name="description"><?=$post['description']; ?></textarea>
                      </div>

                      <div class="form-group">
                        <label>Категория</label>
                        <select name="category_id" class="form-control select2" style="width: 100%;">

                            <option value="<?=$post['category']; ?>" name="category_id" selected="selected">Текущая категория: <?=ucfirst($post['category']); ?></option>
                            <? foreach ($categoryInView as $category): ?>
                                <option value="<?=$category['title']; ?>"><?=ucfirst($category['title']); ?></option>
                            <? endforeach; ?>

                        </select>
                      </div>

                      <div class="form-group">
                        <label>Изображение</label>
                          <input type="hidden" name="MAX_FILE_SIZE" value="5000000"/>
                        <input  name="image" type="file"> <br>
                        <img name="image" src="/uploads/<?=$post['picture']; ?>" width="200" alt="">
                      </div>

                      <div class="form-group">
                        <button type="submit" name="btn-post-edit" class="btn btn-warning">Изменить</button>
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
