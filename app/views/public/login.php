<div class="form-wrapper text-center">
    <div class="container">
        <form class="form-signin" action="" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
            <label for="inputEmail" class="sr-only" >Email</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email" name="email"  autofocus>
            <label for="inputPassword" class="sr-only">Пароль</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Пароль" name="password" >
            <div class="checkbox mb-3">
                <label>
                    <input name='remember' type='checkbox' value='1'> Запомнить меня
                </label>
            </div>
            <button name="btn-login" class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
            <a href="/registration">Зарегистрироваться</a>
            <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
        </form>
        <p><?=$message?></p>
    </div>
</div>