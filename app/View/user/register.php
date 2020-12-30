<div class="loginCard">
    <h3>Register</h3>
    <form id="register" action="register" method="POST" name="register">
        <div class="form-group">
            <label for="name">First name</label>
            <input type="text" name="user[name]" id="name" placeholder="" max="50">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="lastName">Last name</label>
            <input type="text" name="user[lastName]" id="lastName" placeholder="">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="nickname">Nickname</label>
            <input type="text" name="user[nickname]" id="nickname" placeholder="">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="user[email]" id="email" placeholder="Ex: myname@gmail.com">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="user[password]" id="password">
            <div class="errorMenagem">

            </div>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="user[confirmPassword]" id="confirmPassword">
            <div class="errorMenagem">

            </div>
        </div>
        <button class="btn-submit" type="submit">Create Account</button>
    </form>
</div>

<script src="./js/register.js"></script>