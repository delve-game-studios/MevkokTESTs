<?php
/*
 * Controller Pages
 */
class Pages extends Application {
    public function __construct() {
        $this->index_path = "/pages/index.php";
        $this->title = "Mevkok TESTs - ";
        parent::__construct();
    }
    
    public function newInstanceOf($table){
        $instance = "";
        $error = "";
        switch ($table){
            case 'pages':
                $instance = Page::db();
                break;
            default :
                $error = "Table not found!";
                break;
        }
        return array('instance'=>$instance, 'error'=>$error);
    }
    
    public function index() {
        $instance = $this->newInstanceOf("pages");
        if(!empty($instance['error'])){
            $this->error = $instance['error'];
            $this->render($this->index_path);
        }else{
            $this->title .= "Home";
            $this->description = "Description";
            $this->keywords = "Keywords";
            $this->pages = $instance['instance']->select('*')->paginate();
            $this->render($this->index_path);
        }
    }
    
    public function page() {
        $instance = $this->newInstanceOf("pages");
        if(!empty($instance['error'])){
            $this->title .= "Error";
            $this->error = $instance['error'];
            $this->render($this->index_path);
        }else{
            if(is_numeric($_REQUEST['pid'])){
                $this->page = $instance['instance']->select('*')->where('id=?')->prepare(array('id'=>$_REQUEST['pid']));
                if($this->page){
                    $this->title .= $this->page[0]->name;
                    $this->description = $this->page[0]->name;
                }
                $this->pages = $this->getMenuItems();
                $this->render('/pages/pid.php');
            }else{
                $this->title = "Error";
                $this->error = "Please select a valid page!";
                $this->render('/pages/pid.php');
            }
        }
    }
    public function getMenuItems(){
        $instance = $this->newInstanceOf('pages');
        $pages = $instance['instance']->select('*')->prepare();
        return $pages;
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

    public function steam(){
        $users = array('mevkok','thenextdecade','aleks_simona','cowwando');
        if(isset($_REQUEST['user'])){
            $player = $this->steamResults($_REQUEST['user']);
            $this->player = $player[0];
            $this->player->onlineState = $player[1];
        }elseif(!isset($_REQUEST['user'])){
            $i = 0;
            foreach($users as $user){
                $steam_user = $this->steamResults($user);
                $this->players[$i]['player'] = $steam_user[0];
                $this->players[$i]['onlineState'] = $steam_user[1];
                $i++;
            }
        }
    }
    public function steam_xml(){
        $this->renderPartial("/site/steam.php");
    }
}
?>