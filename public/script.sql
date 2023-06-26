create database fdg;
 use fdg;

create table nahuek( 
 id int,
 nombre varchar(50), 
 primary key(id) 
 );
create table alison( 
 id bigint, 
 primary key(id) 
 );
create table cristian( 
 asda date,
 id_nahuek int, 
primary key(asda, id_nahuek), 
 FOREIGN KEY (id_nahuek) REFERENCES nahuek(id) ON DELETE CASCADE  ON UPDATE CASCADE);
