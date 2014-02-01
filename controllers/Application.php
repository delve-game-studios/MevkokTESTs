<?php
class Application extends Controller {
    public function __construct() {
        if(!isset($_SESSION['logged_in'])){
            $_SESSION['logged_in'] = false;
        }
        parent::__construct();
    }
    public function newInstanceOf($table){
        $instance = "";
        switch ($table){
            case 'users':
                $instance = User::db();
                break;
            case 'pages':
                $instance = Page::db();
                break;
            default :
                $instance = Page::db();
                break;
        }
        return $instance;
    }
    public function createCategory(){
        $instance = $this->newInstanceOf('pages');
        $all_pages = $instance->select('name')->prepare();
        if(in_array($_REQUEST['category-name'], $all_pages)){
            redirectTo('/?page=downloads');
            exit("This Category already Exists!");
        }else{
            $name = $_REQUEST['category-name'];
            $path = $_REQUEST['categoty-path'];
            $instance->init(array(
                    'name'=>$name,
                    'path'=>$path
                ));
                $instance->save();
            if (!file_exists('./views/pages/p/'.$path)) {
                mkdir('./views/pages/p/'.$path.'/', 0777);
                $handle = fopen('./views/pages/p/'.$path.'/index.php', 'w')or die("Cannot create index.php");
                fwrite($handle, '<?php $this->renderPartial("/pages/SlideMenu/index.php"); ?>');
                fwrite($handle, "\n<center><h1>".$name."</h1></center>");
                fclose($handle);
                mkdir('./views/pages/p/'.$path.'/downloads/', 0777);
                $handle = fopen('./views/pages/p/'.$path.'/downloads/index.php', 'w')or die("Cannot create index.php");
                fwrite($handle, '');
                fclose($handle);
                chmod("./views/pages/p/".$path."/index.php", 0777);
                chmod("./views/pages/p/".$path."/downloads/index.php", 0777);
            }
            redirectTo('/?page=downloads');
        }
    }
    public function delTree($dir) { 
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach ($files as $file) { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        return rmdir($dir); 
    } 
    public function removeCategory(){
        if(isset($_REQUEST['pid']) && !empty($_REQUEST['pid'])){
            $arr = explode("%7C", $_REQUEST['pid']);
            $id = $arr[0];
            $name = $arr[1];
            $instance = $this->newInstanceOf('pages');
            $instance->delete(array('id' => $id));
            $dirPath = './views/pages/p';
            $this->delTree($dirPath.'/'.$name.'/downloads');
            $this->delTree($dirPath.'/'.$name);
        }
        redirectTo("/?page=downloads");
    }
    
    public function getSteamFullbyUsername($username){        
        $info = "http://steamcommunity.com/id/".$username."/?xml=1";
        $steam_data = file_get_contents($info);
        $xml = new SimpleXMLElement($steam_data);
        return $xml;
    }
    public function getSteamPersonalByID($steam_id){
        $info = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=7EF88C8A29F4BA97DF120EE9F95A1E4F&steamids=".$steam_id."&format=xml";
        $steam_data = file_get_contents($info);
        $xml = new SimpleXMLElement($steam_data);
        return $xml;
    }
    public function steamResults($user){
        $user_stats = $this->getSteamFullbyUsername($user);
        $steam_xml = $this->getSteamPersonalByID($user_stats->steamID64);
        $player = $steam_xml->players->player;
        return array($player,$user_stats->onlineState);
    }
    public function get32bitSteamID($steamID64){
        $v = 76561197960265728;
        $w = $steamID64;
        $x = 0;
        $y = $w%2;
        $z = round((-$v+$w-$y)/2);
        return 'STEAM_'.$x.':'.$y.':'.$z;
    }
    public function updateUsers(){
        $users_steam = $this->newInstanceOf('users')->select('username')->prepare();
        $users_db = $this->newInstanceOf('users');
        
    }

    public function steam(){
        $users = $this->newInstanceOf('users')->select('username')->prepare();//array('mevkok','thenextdecade','aleks_simona','cowwando');
        if(isset($_REQUEST['user'])){
            $player = $this->steamResults($_REQUEST['user']);
            $this->player = $player[0];
            $this->player->onlineState = $player[1];
        }elseif(isset($_REQUEST['users'])){
            $i = 0;
            foreach($users as $user){
                $steam_user = $this->steamResults($user->username);
                $this->players[$i]['player'] = $steam_user[0];
                $this->players[$i]['onlineState'] = $steam_user[1];
                $i++;
            }
        }
        if(isset($_REQUEST['update'])){
            $this->updateDB();
        }
    }
    public function steam_xml(){
        if(isset($_REQUEST['var_dump'])){
            $this->renderPartial("/site/steam_var_dumb.php");
        }elseif(isset($_REQUEST['xml'])){
            $this->renderPartial("/site/steam_xml.php");
        }else{
            $this->renderPartial("/site/steam.php");
        }
    }
    
}
?>