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
              <h2 class="box-title">Все посты</h2>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <a href="/admin/post/create" class="btn btn-success btn-lg">Добавить</a> <br> <br>
              <table id="example1" class="table table-bordered table-striped">

                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Категория</th>
                    <th>Автор</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                  </tr>
                </thead>

                <tbody>
                <? $i=1; foreach ($posts as $post): ?>
                  <tr>
                    <td> <?=$i++; ?></td>
                    <td><?=$post['title']; ?></td>
                    <td><?=ucfirst($post['category']); ?></td>
                    <td><?=$post['author']; ?></td>
                    <td>
                      <img src="/uploads/<?=$post['picture']; ?>" width="200">
                    </td>
                    <td>
                      <a href="/post/?id=<?=$post['id']; ?>" target="_blank" class="btn btn-info">
                        <i class="fa fa-eye"></i>
                      </a>
                      <a href="/admin/posts/edit/<?=$post['id']; ?>" class="btn btn-warning">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="/admin/posts/delete/<?=$post['id']; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">
                        <i class="fa fa-remove"></i>
                      </a>
                    </td>
                  </tr>
                <? endforeach; ?>
                </tbody>

                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Название</th>
                      <th>Категория</th>
                      <th>Автор</th>
                      <th>Изображение</th>
                      <th>Действия</th>
                    </tr>
                  </tfoot>
                </table>
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

