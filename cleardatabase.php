<?
include('functions.php');
dbconnect();
mysql_query('delete from uni_studienrichtung;
delete from studienfach_studienzweig;
delete from kurs_termine;
delete from lvleiter_kurs;
delete from studienplanpunkt_kurs;
delete from studienplanpunkt_studienfach;
delete from studienrichtung_studienzweig;
delete from lvleiter;
delete from studienfach;
delete from kurs;
delete from studienplanpunkt;
delete from studienrichtung;
delete from studienzweig;
delete from termine;
delete from uni;
')

?>