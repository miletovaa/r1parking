<div id="header">
    <div id="info_line_header">
        <div class="container header_info">
            <div class="info_link">ul. Równoległa 1, Warszawa</div>
            <div class="info_link"><a href="tel:+48 797 650 599">+48 797 650 599</a></div>
        </div>
    </div>
    <div class="container header">
    <a href="https://<?=$_SERVER['HTTP_HOST'];?>/PL/R1.php"><img id="header_img" src="../img/logo-parking.svg" alt=""></a>
    <div id="header_links">
        <div class="link"><a href="https://<?=$_SERVER['HTTP_HOST'];?>/PL/R1.php" <? if ((strpos($_SERVER['REQUEST_URI'], 'book') !== false) or (strpos($_SERVER['REQUEST_URI'], 'PL') !== false)) echo 'style="color: #51bdfe;"'; ?>><?=$translate['home'];?></a></div>
        <div class="link"><a href="https://<?=$_SERVER['HTTP_HOST'];?>/price.php" <? if (strpos($_SERVER['REQUEST_URI'], 'price') !== false) echo 'style="color: #51bdfe;"'; ?>><?=$translate['price'];?></a></div>
        <div class="link"><a href="https://<?=$_SERVER['HTTP_HOST'];?>/contacts.php" <? if (strpos($_SERVER['REQUEST_URI'], 'contacts') !== false) echo 'style="color: #51bdfe;"'; ?>><?=$translate['contacts'];?></a></div>
        <? if (isset($_COOKIE['client_tel']) OR $_COOKIE['client_tel'] != ''){ ?>
            <div class="login_tel"><?=$_COOKIE['client_tel'];?><a href="?logout"><img style="width: 20px; margin: 0 0 0 3px; cursor: pointer;" src="../img/log-out.png" alt=""></a></div>
        <? }else if ((strpos($_SERVER['REQUEST_URI'], 'R1') !== false) or (strpos($_SERVER['REQUEST_URI'], 'R-1') !== false)){ ?>
        <form action="" method="post" style="display: flex; 
    margin: -5px 0;"><div class=""><input type="text" id="header_input" name="header_input" placeholder="<?=$translate['enter_your_phone'];?>"></div><input class="loginbtn" type="submit" value="LOG IN"></form>
        <div id="langs">
        <? } ?>
            <select name="lang" id="langSelect" onchange="changeLang()">
                <option value="pl" <? if($lang == 'pl' or $_GET['lang'] == 'pl') echo 'selected'; ?>>PL</option>
                <option value="en" <? if($lang == 'en' or $_GET['lang'] == 'en') echo 'selected'; ?>>EN</option>
                <option value="ru" <? if($lang == 'ru' or $_GET['lang'] == 'ru') echo 'selected'; ?>>RU</option>
            </select>
        </div>
    </div>
    </div>
</div>