update servizi set nome = 'admin.php' where id = 1;  
update servizi set nome = 'userfavoritegrid.php' where id = 2;  
update servizi set nome = 'userrate.php' where id = 3;
update servizi set nome = 'login.php' where id = 4;
insert into gruppo_utente (id, utente_id, gruppo_id) values (null, 8 , 2);
insert into servizi_gruppo (id, id_gruppo, id_servizi) values (null,1,2);  
insert into servizi_gruppo (id, id_gruppo, id_servizi) values (null,1,3);  
insert into servizi_gruppo (id, id_gruppo, id_servizi) values (null,1,4);  