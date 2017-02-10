<?php
 require 'config.php';
 $mysqli = new mysqli(DBHOST,DBUSER,DBPASS);
 // $mysqli->select_db(DBNAME);
 $res = $mysqli->query('create database if not exists '.DBNAME);
 if(!$res)
 {
   echo "database creation faild :( (".$mysqli->errno.") ".$mysqli->error;
   exit;
 }
 if($mysqli->connect_error)
 {
   echo "Sorry, connection to MySQL faild :( (". $mysqli->connect_errno .")". $mysqli->connect_error;
 }
 //select database
 $mysqli->select_db(DBNAME);
 if($mysqli->errno)
 {
   echo "database selection failed (".$mysqli->errno.") ".$mysqli->error;
   exit;
 }

  // create user table
  $query = "create table if not exists user
  (
    user_id smallint unsigned auto_increment primary key,
    user_name varchar(20) not null unique,
    first_name varchar(20),
    last_name varchar(20),
    pass char(10) not null,
    email varchar(40) not null,
    birth_of_date Date,
    gender varchar(6),
    job varchar(40),
    limitcredit DOUBLE,
    is_admin Boolean,
    is_deleted Boolean,
    register_at DateTime DEFAULT CURRENT_TIMESTAMP,
    updated_at DateTime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  )";
  $res = $mysqli->query($query);
  if(!$res)
  {
    echo "user table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
  }
  //create table category
  $query = "create table if not exists category
  (
    cat_id smallint unsigned auto_increment primary key,
    cat_name varchar(20) not null,
    parent int,
    updated_at DateTime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   )";
  $res = $mysqli->query($query);
  if(!$res)
  {
    echo "category table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
  }
  // create product table
  $query = "create table if not exists product
  (
    product_id smallint unsigned auto_increment primary key,
    user_id smallint unsigned,
    cat_id smallint unsigned,
    product_name varchar(100) not null,
    img_path varchar(200),
    description text,
    price double,
    quantity int unsigned,
    updated_at DateTime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    foreign key (user_id) references user(user_id),
    foreign key (cat_id) references category(cat_id)
  )";
  $res = $mysqli->query($query);
  if(!$res)
  {
    echo "product table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
  }

  //create table user interest
  $query = "create table if not exists interest
  (
    cat_id smallint unsigned,
    user_id smallint unsigned,
    foreign key (user_id) references user(user_id),
    foreign key (cat_id) references category(cat_id)
  )";
  $res = $mysqli->query($query);
  if(!$res)
  {
    echo "interest table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
  }
  //create table Shop Cart
  $query = "create table if not exists shop_cart
  (
    shop_cart_id smallint unsigned auto_increment primary key,
    user_id smallint unsigned,
    product_id smallint unsigned,
    buy_at DateTime DEFAULT CURRENT_TIMESTAMP,
    quantity tinyint unsigned,
    paied Boolean,
    total_price double,
    foreign key (user_id) references user(user_id),
    foreign key (product_id) references product(product_id)
   )";
  $res = $mysqli->query($query);
  if(!$res)
  {
    echo "shop_cart table creation failed (".$mysqli->errno.") ".$mysqli->error;
    exit;
  }
  // $query = "create table if not exists user_order
  // (
  //   order_id smallint unsigned auto_increment primary key,
  //   user_id smallint unsigned,
  //   product_id smallint unsigned,
  //   order_date DateTime DEFAULT CURRENT_TIMESTAMP,
  //   foreign key (user_id) references user(user_id),
  //   foreign key (product_id) references product(product_id)
  //
  //  )";
  // $res = $mysqli->query($query);
  // if(!$res)
  // {
  //   echo "user_ouserrder table creation failed (".$mysqli->errno.") ".$mysqli->error;
  //   exit;
  // }
  $mysqli->close();
  ?>
