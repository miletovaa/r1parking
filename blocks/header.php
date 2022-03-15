<div id="header">
    <div id="info_line_header">
        <div class="container header_info">
            <div class="info_link">ul. Równoległa 1, Warszawa</div>
            <div class="info_link"><a href="tel:+48 797 650 599">+48 797 650 599</a></div>
        </div>
    </div>
    <div class="container header">
    <a href="http://sredarazrabotki.space"><img src="../img/logo-parking.svg" alt=""></a>
    <div id="header_links">
        <div class="link"><a href="?lang=<?=$lang;?>"><?=$translate['price'];?></a></div>
        <div class="link"><a href="?lang=<?=$lang;?>"><?=$translate['contacts'];?></a></div>
        <div class=""><a href="?lang=<?=$lang;?>"><div class="link rezerwacja"><?=$translate['booking'];?></div></a></div>
        <div id="langs">
            <select name="lang" id="langSelect" onchange="changeLang()">
                <option value="pl" <? if($lang == 'pl') echo 'selected'; ?>>PL</option>
                <option value="en" <? if($lang == 'en') echo 'selected'; ?>>EN</option>
                <option value="ru" <? if($lang == 'ru') echo 'selected'; ?>>RU</option>
            </select>
        </div>
    </div>
    </div>
</div>