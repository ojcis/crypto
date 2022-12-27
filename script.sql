create table cryptocurrencies
(
    id      int auto_increment
        primary key,
    symbol  varchar(255) not null,
    price   float        not null,
    amount  int          not null,
    user_id int          not null
);

create table shorts
(
    id      int auto_increment
        primary key,
    symbol  varchar(255) not null,
    price   float        not null,
    amount  int          not null,
    user_id int          not null
);

create table transactions
(
    user_id      int          not null,
    transaction  varchar(255) not null,
    coin_symbol  varchar(255) null,
    coin_amount  int          null,
    money_amount float        not null,
    date         varchar(255) not null
);

create table users
(
    id       int auto_increment
        primary key,
    email    varchar(255)    not null,
    name     varchar(255)    not null,
    password varchar(255)    not null,
    money    float default 0 null
);


