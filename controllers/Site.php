<?php
/*
 * Controller Site
 */
class Site extends Application {
    public function __construct() {
        parent::__construct();
    }
    
    public function newInstanceOf($table){
        $instance = "";
        switch ($table){
            case 'users':
                $instance = User::db();
                break;
            default :
                $instance = Page::db();
                break;
        }
        return $instance;
    }
    
    public function index() {
        
    }
    
    public function login_page(){
        $this->render('/site/login.php');
    }
    
    public function password_encrypt($password){
        $password_start = md5(substr($password, 0, round(strlen($password)/2)));
        $password_end = sha1(substr($password, round(strlen($password)/2), strlen($password)));
        $encrypted_password = md5(sha1($password_end.''.$_SERVER['SERVER_NAME'].''.$password_start));
        return $encrypted_password;
    }

    public function login(){
        $instance = $this->newInstanceOf("users");
        $this->user = current($instance
                            ->select('*')
                            ->where('username = ?')
                            ->prepare(array($_REQUEST['username'])));
        if($this->user->username == $_REQUEST['username']){
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $this->user->id;
            $_SESSION['user'] = $this->user->username;
            $_SESSION['password'] = $this->password_encrypt($this->user->password);
            $_SESSION['fullname'] = $this->user->full_name;
            $_SESSION['faction'] = $this->user->faction;
            $_SESSION['rank'] = $this->user->rank;
            $_SESSION['age'] = $this->user->age;
            $_SESSION['country'] = $this->user->country;
            $_SESSION['city'] = $this->user->city;
            $_SESSION['updated_at'] = $this->user->updated_at;
            redirectTo('/');
            exit();
        }else{
            $_SESSION['logged_in'] = false;
            redirectTo('/login');
            exit();
        }
    }
    
    public function logout(){
        session_destroy();
        redirectTo('/login');
        exit();
    }
    
    public function signup_page(){
        $this->render('/site/signup.php');
    }
    
    public function signup(){
        
    }
}
?>