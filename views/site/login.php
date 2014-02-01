<?php
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false){
?>
<form method="POST" action="<?= routeTo('/auth') ?>">
    <table>
        <tr>
            <td>
                <input type="text" name="username" id="login-usrname" placeholder="Username">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" id="login-submit" value="Login">
            </td>
        </tr>
    </table>
</form>
<?php
}else{
    redirectTo('/site');
}
?>