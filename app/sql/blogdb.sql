create database blogdb;

use blogdb;

create table users(
	id int primary key auto_increment,
    name varchar(50) not null,
    lastName varchar(50) not null,
    password varchar(255) not null,
    email varchar(255) not null unique,
    created_at timestamp not null default now(),
    updated_at timestamp default null
);

describe users;

create table profiles(
	id int primary key auto_increment,
    nickname varchar(50) unique not null,
    hasPhoto boolean not null default false,
    photoPath varchar(255),
    user_id int not null,
    foreign key(user_id) references users(id) on delete cascade,
	created_at timestamp not null default now(),
    updated_at timestamp default null
);

create table posts(
	id int primary key auto_increment,
    title varchar(50) not null,
    description varchar(255) not null,
    paragraph varchar(255) not null,
    hasPhoto boolean not null default false,
    photoPath varchar(255),
    user_id int,
    foreign key(user_id) references users(id) on delete set null,
    created_at timestamp not null default now(),
    updated_at timestamp default null
);

alter table users
modify password varchar(255) not null;

insert into users(name, lastName, password, email)
value("admin", "admin", "$2y$10$.Z6C6DbZ/m.9PCGv3v486.AoqsgLITH/0XLg/38LLVzJV1HdcONRq", "admin@admin.com");

insert into profiles(nickname, user_id)
value("admin", 1);

select * from users;

delete from users
where id  = 4;

select * from profiles;