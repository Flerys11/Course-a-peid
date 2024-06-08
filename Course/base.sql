create database course;
\c course

-- table
create table users(
    id serial primary key,
    nom varchar(100),
    email varchar(100),
    role varchar(50),
    password varchar(200)
);

create table etape(
    id serial primary key,
    nom varchar(100) not null ,
    longeur numeric(10,2) not null,
    nb_coureur integer,
    rang integer
);

-- donnee
insert into etape values (default,' Betsizaraina', 15, 2, 1);
insert into etape values (default,' Ampasimbe', 20, 2, 2);

update etape set nb_coureur = 3 where rang = 1;

create table genre(
    id serial primary key,
    nom varchar(100)
);
-- donnee
insert into genre values (default,'homme');
insert into genre values (default,'femme');

create table categorie(
    id serial primary key,
    nom varchar(100),
    marge integer
);

alter table categorie add column marge integer;
-- donnee
update categorie set marge = 10000 where id = 2;
select * from categorie where categorie.marge > 18;

create table coureur(
    id varchar(50) primary key ,
    nom varchar(100) not null ,
    numero integer not null unique,
    idGenre int references genre(id),
    idUser int references users(id),
    idCategorie int references categorie(id),
    dataNaissance date
);

-- requete coureur equipe
create or replace view Coureur_equipe as
select c.*, u.id as idEquipe, u.name as nom_equipe, g.nom as genre
from coureur as c join users u on c.idUser = u.id
join genre g on c.idGenre = g.id;

-- sequence coureur
create sequence coureur_sequence start with 1 increment by 1;

create or replace function coureur_id() RETURNS text as $$
DECLARE
next_id integer;
    type_text text;
BEGIN
    next_id := nextval('coureur_sequence');
    type_text := 'COUR' || lpad(next_id::text, 3, '0');
RETURN type_text;
END;
$$ LANGUAGE plpgsql;

-- donnee
insert into coureur values (coureur_id(), 'Jule', 10, 1, 2 , '2001-03-01');
insert into coureur values (coureur_id(), 'David', 11, 1, 2 , '2000-10-10');
insert into coureur values (coureur_id(), 'Daniela', 12, 2,2 , '2004-05-21');
insert into coureur values (coureur_id(), 'Marion', 13, 1, 2 , '2002-02-11');
insert into coureur values (coureur_id(), 'Paule', 14, 1, 3 , '1998-05-01');
insert into coureur values (coureur_id(), 'Keziah', 15, 2, 3 , '2000-09-10');
insert into coureur values (coureur_id(), 'Kanto', 16, 2, 3 , '2001-01-01');
insert into coureur values (coureur_id(), 'Tafita', 17, 1, 3 , '2003-06-14');



create table typeCoureur(
    idCoureur varchar(50) references coureur(id),
    idCategorie int references categorie(id)
);

-- donnee
insert into typeCoureur values ('COUR001', 1);
insert into typeCoureur values ('COUR002', 1);
insert into typeCoureur values ('COUR003', 2);
insert into typeCoureur values ('COUR004', 2);
insert into typeCoureur values ('COUR005', 2);
insert into typeCoureur values ('COUR006', 1);
insert into typeCoureur values ('COUR007', 2);
insert into typeCoureur values ('COUR008', 1);

create table points(
    id   serial primary key,
    rang  integer not null,
    point integer not null
);
-- donnee
insert into points values (default, 1, 10);
insert into points values (default, 2, 6);
insert into points values (default, 3, 4);
insert into points values (default, 4, 2);
insert into points values (default, 5, 1);


create table penalite(
    id serial primary key,
    nom varchar(50),
    temps time
);

create table course(
    id serial primary key,
    idEtape int references etape(id),
    idCoureur varchar(50) references coureur(id),
    etat integer
);

-- requete course_courreur
CREATE VIEW get_course_coureur AS
SELECT
    c.id, c.idetape, c.idcoureur, c.etat, c2.id as id_courreur, c2.nom, c2.numero, c2.idgenre, c2.iduser, c2.datanaissance, g.nom as genre, u.name as nom_equipe
FROM course AS c JOIN coureur AS c2 ON c.idCoureur = c2.id
join genre g on c2.idGenre = g.id
join users u on c2.idUser = u.id;


-- maka chrono
    create or replace view chrono_courruer as
    select g.*, (f.arrivee - f.depart) as duree
    from get_course_coureur g left join finalsEtape f on f.idcourse = g.id;


-- donnee
insert into course values (default, 1, 'COUR001');
insert into course values (default, 1, 'COUR004');
insert into course values (default, 1, 'COUR005');
insert into course values (default, 1, 'COUR006');

insert into course values (default, 2, 'COUR003');
insert into course values (default, 2, 'COUR002');
insert into course values (default, 2, 'COUR007');
insert into course values (default, 2, 'COUR005');

create table finalsEtape(
    idCourse int references course(id),
    depart timestamp,
    arrivee timestamp,
    penaltie time default '00:00:00'
);

alter table finalsEtape add column penaltie time default '00:00:00';

ALTER TABLE finalsEtape DROP COLUMN penaltie;
-- donnee
INSERT INTO finalsEtape (idCourse, depart, arrivee)
VALUES
    (1, '2024-05-03 08:00:00', '2024-05-03 09:31:00'),
    (2, '2024-05-03 08:00:00', '2024-05-03 09:32:00'),
    (3, '2024-05-03 08:00:00', '2024-05-03 09:29:00'),
    (4, '2024-05-03 08:00:00', '2024-05-03 09:29:30'),
    (5, '2024-05-03 09:00:00', '2024-05-03 10:30:00'),
    (6, '2024-05-03 09:00:00', '2024-05-03 10:30:40'),
    (7, '2024-05-03 09:00:00', '2024-05-03 10:31:00'),
    (8, '2024-05-03 09:00:00', '2024-05-03 10:35:00');

-- table histo_penalite;

create table histo_penalite(
    id serial primary key ,
    iduser int references users(id),
    idetape int references etape(id),
    penalite time,
    etat integer default 0
);

-- recuper penalite

create or replace view get_new_penalite as
select hp.*, e.nom as nom_etape, u.name as nom_equipe
from histo_penalite hp join etape e on hp.idetape = e.id
join users u on hp.iduser = u.id;

-- table import etape
create table import_etape(
    id serial primary key,
    etape varchar(100),
    longueur numeric(10,2),
    nb_courreur integer,
    rang integer,
    depart timestamp
);

-- table import resultat
create table import_resultat(
    id serial primary key,
    etape_rang integer not null ,
    numero_dossard integer not null ,
    nom varchar(100) not null ,
    genre varchar(50) not null ,
    datenaissance date not null ,
    equipe varchar(100),
    arrivee timestamp not null
);

-- insert import etape
CREATE OR REPLACE FUNCTION insert_etape()
RETURNS VOID AS $$
DECLARE
recS RECORD;
BEGIN
FOR recS IN SELECT DISTINCT etape,longueur,nb_courreur,rang FROM import_etape LOOP
            INSERT INTO etape (nom,longeur,nb_coureur,rang)
            VALUES (recS.etape,recS.longueur, recS.nb_courreur, recS.rang);
END LOOP;
END;
$$ LANGUAGE plpgsql;

-- insert import genre
CREATE OR REPLACE FUNCTION insert_genre()
RETURNS VOID AS $$
DECLARE
recS RECORD;
BEGIN
FOR recS IN SELECT DISTINCT genre FROM import_resultat LOOP
    INSERT INTO genre (nom)
            VALUES (recS.genre);
END LOOP;
END;
$$ LANGUAGE plpgsql;


-- insert courreur
CREATE OR REPLACE FUNCTION insert_courreur()
RETURNS VOID AS $$
DECLARE
recS RECORD;
g int;
e int;
courreur_id TEXT;
BEGIN
FOR recS IN SELECT DISTINCT nom,numero_dossard,genre,equipe,datenaissance FROM import_resultat LOOP
    select id into g from genre WHERE nom LIKE recS.genre LIMIT 1;
    select id into e from users WHERE name LIKE recS.equipe order by id desc LIMIT 1;
SELECT coureur_id() INTO courreur_id;
    INSERT INTO coureur (id,nom,numero,idgenre,iduser,datanaissance)
            VALUES (courreur_id,recS.nom,recS.numero_dossard,g,e,recS.datenaissance);
END LOOP;
END;
$$ LANGUAGE plpgsql;


-- inserte course
CREATE OR REPLACE FUNCTION insert_course()
RETURNS VOID AS $$
DECLARE
recS RECORD;
e int;
c varchar(100);
courreur_id TEXT;
BEGIN
    FOR recS IN SELECT DISTINCT nom,etape_rang, numero_dossard FROM import_resultat LOOP
    select id into c from coureur WHERE numero = recS.numero_dossard LIMIT 1;
    select id into e from etape WHERE rang = recS.etape_rang LIMIT 1;

            INSERT INTO course (idetape,idcoureur,etat)
            VALUES (e,c,10);
END LOOP;
END;
$$ LANGUAGE plpgsql;

-- insert finalsetape
CREATE OR REPLACE FUNCTION insert_finalEtape()
RETURNS VOID AS $$
DECLARE
recS RECORD;
e int;
c varchar(100);
f int;
d timestamp;
BEGIN
    FOR recS IN SELECT DISTINCT nom,etape_rang,arrivee,numero_dossard  FROM import_resultat LOOP
    select id into c from coureur WHERE numero = recS.numero_dossard LIMIT 1;
    select id into e from etape WHERE rang = recS.etape_rang LIMIT 1;
    select id into f from course where idcoureur = c and idetape = e LIMIT 1;
    select depart into d from import_etape where rang = recS.etape_rang LIMIT 1;

        INSERT INTO finalsetape (idcourse,depart,arrivee)
        VALUES (f,d,recS.arrivee);
END LOOP;
END;
$$ LANGUAGE plpgsql;

/////////////
insert into course values (default,24,'COUR020',0)

insert into typeCoureur values ('COUR011', 1);
insert into typeCoureur values ('COUR012', 1);
insert into typeCoureur values ('COUR013', 1);
insert into typeCoureur values ('COUR014', 1);
insert into typeCoureur values ('COUR015', 1);

insert into typeCoureur values ('COUR016', 2);
insert into typeCoureur values ('COUR017', 2);
insert into typeCoureur values ('COUR018', 2);
insert into typeCoureur values ('COUR019', 2);
insert into typeCoureur values ('COUR020', 2);

-- requete join finalsEtape et course et categorie
create or replace view Course_Categorie as
select fe.*, t.idcategorie, c.nom, g.nom as genre, co.nom as nom_courreur, co.numero, u.name as nom_equipe, u.id as id_equipe
from typeCoureur t join coureur as co on t.idCoureur = co.id
join genre g on g.id = co.idGenre
join users u on u.id = co.idUser
join categorie c on t.idCategorie = c.id
right join Course_FinalsEtape fe on t.idCoureur = fe.idcoureur;

-- rang trie equipe
CREATE OR REPLACE FUNCTION get_ranked_trie(trie varchar(50))
RETURNS TABLE (
    id INT,
    idetape INT,
    genre varchar(100),
    idCategorie INT,
    difference_heure INTERVAL,
    rang_coureur BIGINT,
    depart timestamp,
    arrivee timestamp,
    nom_courreur varchar(100),
    numero INT,
    nom_equipe varchar(100),
    id_equipe BIGINT,
    points INT
) AS $$
BEGIN
RETURN QUERY
SELECT rs.course_id, rs.idetape, rs.genre_col, rs.idCategorie, rs.difference_heure, rs.rang_coureur, rs.depart,
    rs.arrivee, rs.nom_courreur, rs.numero, rs.nom_equipe, rs.id_equipe ,
       COALESCE(p.point, 0) AS points
FROM (
         SELECT c.id AS course_id, c.idetape,
                c.depart, c.arrivee, c.nom_courreur,c.numero,c.nom_equipe, c.id_equipe,
                c.genre AS genre_col, c.idCategorie, (c.arrivee - c.depart) AS difference_heure,
                DENSE_RANK() OVER(PARTITION BY c.idetape ORDER BY ((c.arrivee + c.penaltie)  - c.depart) ASC) AS rang_coureur
         FROM Course_Categorie as c
         WHERE c.genre LIKE  trie OR c.nom LIKE trie
     ) AS rs
         LEFT JOIN points p ON rs.rang_coureur = p.rang
ORDER BY rs.idetape, rs.rang_coureur;
END;
$$ LANGUAGE plpgsql;

select * from get_ranked_trie('F');
select nom_equipe, sum(points) as points_finaux from get_ranked_trie('F')
group by nom_equipe;

select * from get_ranked_trie('F');
-- rang trie etape

CREATE OR REPLACE FUNCTION get_ranked_trie_etape(trie varchar(50), id_etape int)
RETURNS TABLE (
    id INT,
    idetape INT,
    genre varchar(100),
    idCategorie INT,
    difference_heure INTERVAL,
    rang_coureur BIGINT,
    depart timestamp,
    arrivee timestamp,
    nom varchar(100),
    numero INT,
    nom_equipe varchar(100),
    points INT,
    penaltie time
) AS $$
BEGIN
RETURN QUERY
SELECT rs.course_id, rs.idetape, rs.genre_col, rs.idCategorie, rs.difference_heure, rs.rang_coureur, rs.depart,
       rs.arrivee, rs.nom_courreur, rs.numero, rs.nom_equipe,
       COALESCE(p.point, 0) AS points, rs.penaltie
FROM (
         SELECT c.id AS course_id, c.idetape,
                c.depart, c.arrivee, c.nom_courreur,c.numero,c.nom_equipe,
                c.genre AS genre_col, c.idCategorie, (c.arrivee - c.depart) AS difference_heure,
                DENSE_RANK() OVER(PARTITION BY c.idetape ORDER BY ((c.arrivee + c.penaltie)  - c.depart) ASC) AS rang_coureur, c.penaltie
         FROM Course_Categorie as c
         WHERE c.genre LIKE  trie OR c.nom LIKE trie
     ) AS rs
         LEFT JOIN points p ON rs.rang_coureur = p.rang
        where rs.idetape = id_etape
ORDER BY rs.idetape, rs.rang_coureur;
END;
$$ LANGUAGE plpgsql;

select * from get_ranked_trie_etape('M', 100);

select nom_equipe, sum(points) as points_finaux from get_ranked_trie('F')
group by nom_equipe;


-- new requete join finalsEtape et course
create or replace view Course_FinalsEtape as
select *
from finalsEtape as fe right join course c2 on fe.idCourse = c2.id;

-- requete calcul defference heure
create or replace view get_Rang_Course as
WITH RankedByStage AS (
    SELECT *,
           DENSE_RANK() OVER(PARTITION BY idetape ORDER BY difference_heure ASC) AS rang_coureur
    FROM (
        SELECT *, (arrivee - depart) AS difference_heure
        FROM Course_FinalsEtape
    ) subquery
)
SELECT *
FROM RankedByStage
ORDER BY idetape, rang_coureur;


-- point vide = 0 calssement par etape ty
create or replace view classement_course as
WITH MaxPointsRankPerCourseAndStep AS (
    SELECT gc.id, gc.idetape, MAX(p.rang) AS max_rang
    FROM get_Rang_Course gc
             LEFT JOIN points p ON gc.rang_coureur <= p.rang
    GROUP BY gc.id, gc.idetape
),
     AttributedPoints AS (
         SELECT DISTINCT ON (gc.idcourse, gc.idetape) gc.idcourse, gc.depart, gc.arrivee, gc.id, gc.idetape, gc.idcoureur, gc.difference_heure, gc.rang_coureur, gc.penaltie,
    CASE
    WHEN p.point IS NOT NULL THEN p.point
    ELSE COALESCE(mp.max_rang, 0)
END AS points_attribues
    FROM get_Rang_Course gc
    LEFT JOIN points p ON gc.rang_coureur = p.rang
    INNER JOIN MaxPointsRankPerCourseAndStep mp ON gc.id = mp.id AND gc.idetape = mp.idetape
    ORDER BY gc.idcourse, gc.idetape
)
SELECT * FROM AttributedPoints;


-- requete classement globale
--     ensemble detail classement sans rang
    create or replace view ensemble_detail_classement as
    select cc.*, ce.nom , ce.numero, ce.nom_equipe, ce.genre, ce.idequipe, ce.iduser as id_equipe
    from classement_course cc join Coureur_equipe ce on cc.idcoureur = ce.id;
///


-- get penaltie equipe
create or replace view get_penaltie_equipe as
select edc.penaltie, edc.idequipe, edc.nom_equipe, edc.idetape, e.nom as nom_etape
from ensemble_detail_classement edc join etape e on edc.idetape = e.id
group by idequipe, nom_equipe, penaltie, idetape ,e.nom;

-- globale
create or replace view classement_global as
WITH EquipePoints AS (
    SELECT idequipe, nom_equipe, SUM(points_attribues) AS points_equipe
    FROM ensemble_detail_classement
    GROUP BY idequipe, nom_equipe
),
EquipeRangs AS (
    SELECT idequipe, nom_equipe, points_equipe,
           RANK() OVER(ORDER BY points_equipe DESC) AS rang_equipe
    FROM EquipePoints
)
SELECT idequipe, nom_equipe, points_equipe, rang_equipe
FROM EquipeRangs
ORDER BY rang_equipe;

-- requete temps vide
select distinct (e.idcourse), idcoureur, difference_heure
from ensemble_detail_classement e left join course c on c.id =  e.idcourse;

-- Supprime base
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

CREATE OR REPLACE PROCEDURE delete_all_table()
LANGUAGE plpgsql
AS $$
DECLARE
_table_names TEXT[] := ARRAY['genre','etape','typecoureur','course','finalsetape', 'coureur', 'import_etape', 'import_resultat', 'points', 'histo_penalite'];
    _table_name TEXT;
BEGIN
    FOREACH _table_name IN ARRAY _table_names
        LOOP
            EXECUTE FORMAT('TRUNCATE TABLE %I CASCADE;', _table_name);
END LOOP;

create or replace view Coureur_equipe as
select c.*, u.id as idEquipe, u.name as nom_equipe, g.nom as genre
from coureur as c join users u on c.idUser = u.id
                  join genre g on c.idGenre = g.id;

create or replace view Course_FinalsEtape as
select *
from finalsEtape as fe join course c2 on fe.idCourse = c2.id;

create or replace view get_Rang_Course as
WITH RankedByStage AS (
    SELECT *,
           DENSE_RANK() OVER(PARTITION BY idetape ORDER BY difference_heure ASC) AS rang_coureur
    FROM (
        SELECT *, ((arrivee + penaltie) - depart) AS difference_heure
        FROM Course_FinalsEtape
    ) subquery
)
SELECT *
FROM RankedByStage
ORDER BY idetape, rang_coureur;


create or replace view get_new_penalite as
select hp.*, e.nom as nom_etape, u.name as nom_equipe
from histo_penalite hp join etape e on hp.idetape = e.id
                       join users u on hp.iduser = u.id;

create or replace view get_penaltie_equipe as
select edc.penaltie, edc.idequipe, edc.nom_equipe, edc.idetape, e.nom as nom_etape
from ensemble_detail_classement edc join etape e on edc.idetape = e.id
group by idequipe, nom_equipe, penaltie, idetape ,e.nom;

-- requete classement globale
--     ensemble detail classement sans rang
create or replace view ensemble_detail_classement as
select cc.*, ce.nom , ce.numero, ce.nom_equipe, ce.genre, ce.idequipe, ce.iduser as id_equipe
from classement_course cc join Coureur_equipe ce on cc.idcoureur = ce.id;

-- requete join finalsEtape et course et categorie
create or replace view Course_Categorie as
select fe.*, t.idcategorie, c.nom, g.nom as genre, co.nom as nom_courreur, co.numero, u.name as nom_equipe
from typeCoureur t join coureur as co on t.idCoureur = co.id
                   join genre g on g.id = co.idGenre
                   join users u on u.id = co.idUser
                   join categorie c on t.idCategorie = c.id
                   right join Course_FinalsEtape fe on t.idCoureur = fe.idcoureur;

create or replace view classement_global as
WITH EquipePoints AS (
    SELECT idequipe, nom_equipe, SUM(points_attribues) AS points_equipe
    FROM ensemble_detail_classement
    GROUP BY idequipe, nom_equipe
),
EquipeRangs AS (
    SELECT idequipe, nom_equipe, points_equipe,
           RANK() OVER(ORDER BY points_equipe DESC) AS rang_equipe
    FROM EquipePoints
)
SELECT idequipe, nom_equipe, points_equipe, rang_equipe
FROM EquipeRangs
ORDER BY rang_equipe;

-- chrono
create or replace view chrono_courruer as
select g.*, (f.arrivee - f.depart) as duree
from get_course_coureur g left join finalsEtape f on f.idcourse = g.id;

delete from users where role = 'equipe';
alter sequence coureur_sequence RESTART with 1;

END;
$$;

-- requete detail classement generale
create or replace view get_courreur_equipe as
select fe.*, t.idcategorie, c.nom, g.nom as genre, co.nom as nom_courreur, co.numero, u.name as nom_equipe, u.id as id_equipe
from typeCoureur t join coureur as co on t.idCoureur = co.id
                   join genre g on g.id = co.idGenre
                   join users u on u.id = co.idUser
                   join categorie c on t.idCategorie = c.id
                   right join Course_FinalsEtape fe on t.idCoureur = fe.idcoureur;


-- appel
CALL delete_all_table();

-- import
CALL somme_import();

-- neccesaire import
CREATE OR REPLACE PROCEDURE somme_import()
LANGUAGE plpgsql
AS $$
BEGIN
    PERFORM insert_etape();
    PERFORM insert_genre();
    PERFORM insert_courreur();
    PERFORM insert_course();
    PERFORM insert_finalEtape();
END;
$$;
