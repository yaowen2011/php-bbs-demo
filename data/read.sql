set names utf8;
-- 新建数据库 messageboard
create database messageboard;
-- 进入这个数据库
use messageboard;
-- 创建数据表
create table user(
    user_id int primary key auto_increment,
    name varchar(16) not null unique key,
    password varchar(64) not null,
    sex char(2) not null default "1",
    phonenumber varchar(11),
    profile varchar(64) not null default "./pic/default.jpg"
)charset=utf8;


create table comment(
    comment_id int primary key auto_increment,
    name varchar(70) not null,
    comment_title varchar(30) not null,
    content text,
    comment_time datetime not null,
    category varchar(20) not null
)charset=utf8;


create table category(
    category_id int primary key auto_increment,
    name varchar(20) not null
)charset=utf8;

insert into category values(null,"农业");
insert into category values(null,"我爱吃");
insert into category values(null,"一只猫");
insert into category values(null,"鹿晗快分手");