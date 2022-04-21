<div class="buttons" style="display: flex;">
<a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/today.php" class="btn_link <? if (strpos($_SERVER['REQUEST_URI'], 'today') !== false) echo 'btn_link_active'; ?>
">DZIŚ</a> 
<a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/orders_panel.php" class="btn_link <? if (strpos($_SERVER['REQUEST_URI'], 'orders_panel') !== false) echo 'btn_link_active'; ?>
">WSZYSTKIE</a> 
<!-- <a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/admin_page.php" class="btn_link <? if (strpos($_SERVER['REQUEST_URI'], 'admin_page') !== false) echo 'btn_link_active'; ?>
">MOJA STRONA</a>  -->
<? if ($_SESSION['admin_level'] == 1){?>
    <a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/edit_mod_sett.php" class="btn_link <? if (strpos($_SERVER['REQUEST_URI'], 'edit_mod_sett') !== false) echo 'btn_link_active'; ?>
">USTAWIENIA</a>
<? } ?>
<span class="btn_link" onclick="newReservation()">NOWA REZERWACJA</span>
<span class="btn_link" onclick="document.getElementById('raportOptions').style = 'display: flex;'">RAPORT</span>
<div id="raportOptions" style="display: none;"><a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/raport.php?wczoraj"  target="_blank"class="rap">WCZORAJ</a><a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/raport.php?dzis" target="_blank" class="rap">DZIŚ</a><a href="https://<?=$_SERVER['HTTP_HOST'];?>/admin/raport.php?jutro" target="_blank" class="rap">JUTRO</a><a id="rap_wybierz" class="rap" onclick="document.getElementById('wybierzDaty').style = 'display: flex;'">WYBIERZ</a></div>
<div id="wybierzDaty" style="display: none;"><input type="date" name="from" id="dateFrom"> - <input type="date" name="to" id="dateTo"><input class="btn_link" type="submit" value="OK" onclick="window.open('raport.php?date_from='+document.getElementById('dateFrom').value+'&date_to='+document.getElementById('dateTo').value, '_blank');"></div>
</div>