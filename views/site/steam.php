<?php
    $this->steam();
    $this->account_types = array(0=>'Individual',1=>'Public',2=>'Beta',3=>'Internal',4=>'Dev',5=>'RC');
    ?>
<style>
        img{
            border-radius: 15px;
        }
        a{
            margin-left: 0;
            color: whitesmoke;
        }
        span{
            color:whitesmoke;
            font-weight: none;
        }
        #profile{
            clear: both;
            margin: 20px;
            background: black;
            border: 2px solid whitesmoke;
            border-radius: 20px;
            color: orange;
            font-weight: bolder;
            width: 600px;
            box-shadow: 0 0 10px 2px black;
            margin-left: auto;
            margin-right: auto;
        }
        #profile *{
            margin: 0px ;/*15px;*/
        }
        #profile div:first-of-type{
            margin-top: 17px;
        }
        .offline{
            background: rgb(120,20,20) !important;
        }
        .online{
            background: rgb(20,20,120) !important;
        }
        .in-game{
            background: rgb(20,120,20) !important;
        }
    </style>
<?php
if(!isset($_REQUEST['user'])){
    ?>
        
            <center><h1>Users</h1></center>
        <?php
    foreach($this->players as $ply){
        $accType_1 = $ply['player']->profilestate;
        $accType = $this->account_types[(int) $accType_1];
            ?>
        <div id="profile" class="<?= $ply['onlineState'] ?>">
            <img style="float: left;" src="<?= $ply['player']->avatarmedium ?>">
            <div>
                Profile: <a href="<?= $ply['player']->profileurl ?>"><span><?= $ply['player']->personaname ?></span></a><br>
            </div>
            <div>
                Real Name: <span><?= $ply['player']->realname ?></span><br>
            </div>
            <div>
                Account Type: <span><?php echo (!empty($ply['player']->steamid)) ? $accType : ''; ?></span><br>
            </div>
            <div>
                Steam ID 32bit: <span><?php echo (!empty($ply['player']->steamid)) ? $this->get32bitSteamID((int) $ply['player']->steamid) : ''; ?></span><br>
            </div>
            <div>
                Steam ID 64bit: <span><?= $ply['player']->steamid ?></span><br>
            </div>
            <div>
                Location: <span><?= $ply['player']->loccountrycode ?></span>
            </div>
        </div>    
        <?php
    }
}else{
    $ply = $this->player;
    if(isset($this->player->personaname) && !empty($this->player->personaname)){
    $accType_1 = $this->player->profilestate;
    $accType = $this->account_types[(int) $accType_1];
    $avatars['full'] = $ply->avatarfull;
    $avatars['medium'] = $ply->avatarmedium;
    $avatars['icon'] = $ply->avatar;
    ?>
    <div id="profile" class="<?= $ply->onlineState ?> <?= (isset($_REQUEST['size'])) ? $_REQUEST['size'] : "full" ?>">
        <img style="float: left;" src="<?= (isset($_REQUEST['size'])) ? $_REQUEST['size'] : $ply->avatarfull ?>">
        <div>
            Profile: <a href="<?= $ply->profileurl ?>"><span><?= $ply->personaname ?></span></a><br>
        </div>
        <div>
            Real Name: <span><?= $ply->realname ?></span><br>
        </div>
        <div>
            Account Type: <span><?php echo (!empty($ply->steamid)) ? $accType : ''; ?></span><br>
        </div>
        <div>
            Steam ID 32bit: <span><?php echo (!empty($ply->steamid)) ? $this->get32bitSteamID((int) $ply->steamid) : ''; ?></span><br>
        </div>
        <div>
            Steam ID 64bit: <span><?= $ply->steamid ?></span><br>
        </div>
        <div>
            Location: <span><?= $ply->loccountrycode ?></span>
        </div>
    </div>
    <?php
    }
}
?>