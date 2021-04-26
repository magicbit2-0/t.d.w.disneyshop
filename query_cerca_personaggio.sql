(SELECT distinct p.id as idCercato, p.nome as nomeEntita, p.nome as votazione, k.testo as categoria, p.data_nascita
                                        FROM personaggio p join parola_chiave_personaggio ppk on ppk.personaggio_id = p.id join parola_chiave k on k.id = ppk.parola_chiave_id
                                        WHERE p.nome like 'jasmine' and k.testo like 'personaggio' and year(p.data_nascita)>= 1937 and year(p.data_nascita) <= 2021
                                        ORDER BY p.data_nascita desc) union
                                        (SELECT distinct r.id as idCercato, concat(r.nome,' ',r.cognome) as nomeEntita, r.nome as votazione, k.testo as categoria,  r.anno_nascita as data_nascita
                                        FROM regia r join parola_chiave_regia rpk on rpk.regia_id = r.id join parola_chiave k on k.id = rpk.parola_chiave_id
                                        WHERE (concat(r.nome,' ',r.cognome) like 'naomi scott' or r.nome like 'naomi' or r.cognome like 'scott') and k.testo like 'attore' and year(r.anno_nascita)>= 1937 and year(r.anno_nascita) <= 2021
                                        ORDER BY r.anno_nascita desc)