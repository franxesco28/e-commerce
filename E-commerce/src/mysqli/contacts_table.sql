-- auto-generated definition
use e_commerce_db;
create table if not exists contacts
(
    id           int auto_increment
primary key,
    name         varchar(40)                         not null,
    surname      varchar(40)                         null,
    phone_number varchar(40)                         not null,
    company      varchar(40)                         null,
    role         varchar(40)                         null,
    picture      varchar(100)                        null,
    email        varchar(40)                         not null,
    created_at   timestamp default CURRENT_TIMESTAMP not null
);

ALTER TABLE contacts ADD FULLTEXT (name);
ALTER TABLE contacts ADD FULLTEXT (surname);
ALTER TABLE contacts ADD FULLTEXT (email);
ALTER TABLE contacts ADD FULLTEXT (name,surname,email);
# FULLTEXT info https://typesense.org/learn/full-text-search-mysql/
    ALTER TABLE contacts ADD CONSTRAINT UNIQUE(email);

ALTER TABLE contacts ADD active bool not null default (1);

# Adds table to store images in blob..
create table pictures (
    id int  not null auto_increment primary key,
    content longblob not null,
    type varchar(150) null,
    created_at timestamp default CURRENT_TIMESTAMP
);
ALTER TABLE contacts ADD picture_id INT null;
ALTER TABLE contacts ADD FOREIGN KEY (picture_id) references pictures(id);