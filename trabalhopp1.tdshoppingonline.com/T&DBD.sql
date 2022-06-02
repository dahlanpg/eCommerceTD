CREATE DATABASE td;
create table tdclient (
	   id int not null auto_increment,
	   name varchar(64) not null,
	   gender char(1) not null,
	   birthdaydate date not null,
	   email varchar(64) unique not null,
	   maritalstatus varchar(10) not null,
	   cpf varchar (20) unique null,
	   avatar varchar(100) null,
	   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	   primary key(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tduser(
		iduser int not null auto_increment,
		idclient int,
		login varchar(32),
		password varchar(60),
		foreign key(idclient) references tdclient(id)
		on delete cascade on update cascade,
		primary key(iduser)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdphone (
		id_phone int not null auto_increment,
		ddi int not null,
		ddd int not null,
		phone varchar(9) not null,
		idclient int,
		foreign key(idclient) references tdclient(id) on delete cascade on update cascade,
		primary key(id_phone)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdaddress (
		id_address int not null auto_increment,
		ad_street varchar(32) not null,
		ad_numberstreet int not null,
		ad_district varchar(32) not null,
		ad_city varchar(32) not null,
		ad_state char(2) not null,
		ad_zipcode char(9) not null,
		ad_complement varchar(32),
		idclient int not null,
		foreign key(idclient) references tdclient(id) on delete cascade on update cascade,
		primary key(id_address)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdproducts (
		idproduct int not null auto_increment,
		name varchar(64) not null,
		offertitle varchar(150) not null,
		category varchar(10) not null,
		description varchar(1000) not null,
		manufacturer varchar(64) null,
		oldprice decimal(10,2) null,
		price decimal(10,2) not null,
		quantity int not null,
		image1 varchar (64) null,
		image2 varchar(64) null,
		attributes varchar(3000) null,
		sold int not null,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		primary key(idproduct) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdfavorites(
	iduser int,
	idproduct int,
	foreign key(iduser) references tduser(iduser) on delete cascade on update cascade,
	foreign key(idproduct) references tdproducts(idproduct) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdorders (
		id_order int not null auto_increment,
		totalvalue decimal(10,2) not null,
		status varchar(32) not null,
		iduser int,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		paymentMethod varchar(20) not null,
		foreign key(iduser) references tduser(iduser) on delete cascade on update cascade,
		primary key(id_order)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table tdorders_products (
		idorders int,
		idproduct int,
		unitValue decimal(10,2) not null,
		finalValue decimal(10,2) not null,
		quantity int not null,
		foreign key(idorders) references tdorders(id_order) on delete cascade on update cascade,
		foreign key(idproduct) references tdproducts(idproduct) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table tdbannershome (
		image1 varchar (64) null,
		image2 varchar (64) null,
		image3 varchar (64) null,
		image4 varchar (64) null
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into tdbannershome values('bannerAMD.png', 'bannerIntel.jpg',
 'bannerMSI.png', 'BannerP.jpg');
