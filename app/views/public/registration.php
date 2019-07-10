<div class="form-wrapper text-center">
    <div class="container">
        <form class="form-signin" action="" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>
            <label for="inputEmail" class="sr-only">Имя</label>
            <input type="text" id="inputEmail" class="form-control" placeholder="Имя" autofocus name="username">
            <label for="inputEmail" class="sr-only">Email</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email">
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password">
            <button name="btn-register" class="btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
            <a href="/login">Войти</a>
            <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
        </form>
        <p><?=$message;?></p>
    </div>
</div>