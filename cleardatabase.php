<?
$sql = "DROP TABLE `kurs_termine`, `lvleiter_kurs`, `studienfach_studienplanpunkt`, `studienplanpunkt_kurs`, `studienrichtung_studienzweig`, `studienzweig_studienfach`, `uni_studienrichtung`, `kurs`, `lvleiter`, `studienfach`, `studienplanpunkt`, `studienrichtung`, `studienzweig`, `termine`, `uni`";
mysql_query($sql);
$sql = 'create table uni (id int(4) auto_increment primary key, title varchar(64));';
mysql_query($sql);
/*
$sql = 'create table studienrichtung(id int(4) auto_increment primary key,	title varchar(64));';
mysql_query($sql);
$sql = 'create table studienzweig (id int(4) auto_increment primary key, title varchar(64));';
mysql_query($sql);
$sql = 'create table studienfach(id int(4) auto_increment primary key,	title varchar(64));';
mysql_query($sql);
$sql = 'create table studienplanpunkt(id int(4) auto_increment primary key, title varchar(128));';
mysql_query($sql);
*/
$sql = 'create table kurs(id int(8) primary key, type varchar(32),	title varchar(128),	sst int(2),	language varchar(32));';
mysql_query($sql);
$sql = 'create table lvleiter(id int(8) auto_increment primary key, name varchar(128));';
mysql_query($sql);
/*
$sql = 'create table termine(id int(8) auto_increment primary key,	weekday varchar(8),	start datetime, end datetime, place varchar(128));';
mysql_query($sql);
$sql = 'create table uni_studienrichtung(uni_id int(4), foreign key (uni_id) references uni(id), studienrichtung_id int(4),foreign key (studienrichtung_id) references studienrichtung(id));';
mysql_query($sql);
$sql = 'create table studienrichtung_studienzweig(studienrichtung_id int(4), foreign key (studienrichtung_id) references studienrichtung(id), studienzweig_id int(4), foreign key (studienzweig_id) references studienzweig(id));';
mysql_query($sql);
$sql = 'create table studienzweig_studienfach(studienzweig_id int(4), foreign key (studienzweig_id) references studienzweig(id), studienfach_id int(4), foreign key (studienfach_id) references studienfach(id));';
mysql_query($sql);
$sql = 'create table studienfach_studienplanpunkt( studienfach_id int(4), foreign key(studienfach_id) references studienfach(id), studienplanpunkt_id int(4), foreign key(studienplanpunkt_id) references studienplanpunkt(id));';
mysql_query($sql);
$sql = 'create table studienplanpunkt_kurs( studienplanpunkt_id int(4), foreign key(studienplanpunkt_id) references studienplanpunkt(id), kurs_id int(8), foreign key(kurs_id) references kurs(id));';
mysql_query($sql);
$sql = 'create table kurs_termine( kurs_id int(8), foreign key(kurs_id) references kurs(id), termine_id int(8), foreign key(termine_id) references termine(id));';
mysql_query($sql);
*/
$sql = 'create table lvleiter_kurs( lvleiter_id int(8), foreign key (lvleiter_id) references lvleiter(id), kurs_id int(8),	foreign key (kurs_id) references kurs(id));';
mysql_query($sql);
?>