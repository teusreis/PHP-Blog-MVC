<div class="loginCard">
    <h3>Login</h3>
    <form action="login" method="post" name="login">

        <?php if(isset($error['login'])): ?>
            <div class="error" style="text-align: center;">
                <?= $error["login"]; ?>
            </div>
        <?php endif ?>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="login[email]" id="email" placeholder="myname@gmail.com">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="login[password]" id="password">
            <div class="errorMenagem">
    
            </div>
        </div>
        <button class="btn-submit" type="submit">Login</button>
    </form>
    <div class="newAccount">
        <a id="" href="register">Create an account</a>
    </div>
</div>

<script src="./js/login.js"></script>
