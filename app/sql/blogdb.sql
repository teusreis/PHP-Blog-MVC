create database blogdb;

use blogdb;

create table users(
	id int primary key auto_increment,
    name varchar(50) not null,
    secondNamce varchar(50) not null,
    password varchar(50) not null,
    email varchar(255) not null unique,
    created_at timestamp not null default now(),
    updated_at timestamp default null
);

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
    paragraph varchar(255) not null,
    hasPhoto boolean not null default false,
    photoPath varchar(255),
    user_id int not null,
    foreign key(user_id) references users(id) on delete set null,
    created_at timestamp not null default now(),
    updated_at timestamp default null
);