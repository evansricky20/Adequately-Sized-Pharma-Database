use asp;

-- Create Tables
create table customer(
	cust_id int,
    cust_fname varchar(20) not null,
    cust_lname varchar(20) not null,
    cust_dob date not null,
    cust_address varchar(50)not null,
	cust_phonenumber BIGINT not null,
    cust_insurancenum int not null,
    primary key (cust_id)
);

create table employee(
	emp_id int,
	emp_fname varchar(20)not null,
    emp_mname varchar(20)not null,
    emp_lname varchar(20)not null,
    emp_address varchar(50)not null,
    emp_phonenumber int not null,
    primary key (emp_id)
);

create table pharmacist(
	pharm_id int,
    pharm_lisc int not null,
    primary key (pharm_id),
    foreign key (pharm_id) references employee(emp_id)
);

create table pharmtech(
	tech_id int,
    tech_certnum int not null,
    tech_pharm_id int not null,
    primary key (tech_id),
	foreign key (tech_id) references employee(emp_id),
    foreign key (tech_pharm_id) references pharmacist(pharm_id)
);

create table doctor(
	doc_lisc int,
    doc_spec varchar(20)not null,
    doc_name varchar(50)not null,
    doc_phonenumber int not null,
	clinic_name varchar(30)not null,
    primary key (doc_lisc)
);

create table supplier(
	supp_id int,
    supp_name varchar(30)not null,
    supp_address varchar(50)not null,
    primary key (supp_id)
);

create table prescription(
	pres_id int,
    pres_name varchar(30)  not null,
    pres_price decimal(9,2) not null,
    pres_stock int not null,
    pres_pharm_id int not null,
    pres_tech_id int not null,
    pres_doc_lisc int not null,
    primary key (pres_id),
    foreign key (pres_pharm_id) references pharmacist(pharm_id),
    foreign key (pres_tech_id)references pharmtech(tech_id),
    foreign key (pres_doc_lisc)references doctor(doc_lisc)
);

-- Tables that represent relationships
create table supplies(
	supps_id int,
    supps_pres_id int,
    supps_count int not null,
    primary key (supps_id, supps_pres_id),
    foreign key (supps_id) references supplier(supp_id),
    foreign key (supps_pres_id) references prescription(pres_id)
);

create table buys(
	buys_cust_id int,
    buys_pres_id int,
    buys_date date not null,
    buys_cost int  not null,
    primary key (buys_cust_id, buys_pres_id),
    foreign key (buys_cust_id) references customer(cust_id),
    foreign key (buys_pres_id) references prescription(pres_id)
);

INSERT INTO `customer` (`cust_id`, `cust_fname`, `cust_lname`, `cust_dob`, `cust_address`, `cust_phonenumber`, `cust_insurancenum`) VALUES
(1000, 'Alec', 'McCall', '1995-07-19', '7878 32nd St, Lubbock, TX', 8065664442, 900234),
(1001, 'Carl', 'Stewart', '1984-05-06', '3398 82nd St, Lubbock, TX', 8067773377, 900235),
(1002, 'Wayne', 'Tate', '1977-11-13', '3378 76th St, Lubbock, TX', 8068810093, 900236),
(1003, 'Ruth', 'Jackson', '1960-01-25', '777 2nd St, Lubbock, TX', 8062223437, 700654),
(1004, 'Abby', 'Dixon', '1991-09-22', '898 Slide Rd, Lubbock, TX', 8065655511, 700655),
(1005, 'Henry', 'Ford', '1989-04-12', '3037 54th St, Lubbock, TX', 8063323333, 800678),
(1009, 'Mike', 'Trump', '2024-04-22', '123 Street', 1111111111, 9823754),
(1010, 'Bob', 'Stevens', '1980-01-01', '123 Street, Lubbock, TX', 8061112222, 12345),
(1011, 'John', 'Snow', '1980-01-01', '876 32nd St, Lubbock, TX', 8061112929, 90095);

INSERT INTO `doctor` (`doc_lisc`, `doc_spec`, `doc_name`, `doc_phonenumber`, `clinic_name`) VALUES
(40063, 'Diagnostician', 'Dr. House', 1234567890, 'Princeton Plainsboro Teaching '),
(40064, 'Pediatrics', 'Dr. Smith', 8065559999, 'The Clinic'),
(40065, 'Cardiology', 'Dr. Doe', 8067471010, 'The Heart Clinic'),
(40066, 'Oncology', 'Dr. Wilson', 8069593342, 'Princeton Plainsboro Teaching');

INSERT INTO `employee` (`emp_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_address`, `emp_phonenumber`) VALUES
(1, 'John', 'A', 'Miller', '442 North Rd, Lubbock, TX', 8063331212),
(2, 'Terry', 'S', 'Ballard', '3563 34th St, Lubbock, TX', 8068742309),
(11, 'Amanda', 'H', 'O\'Brien', '101 4th St, Lubbock, TX', 8068895611),
(112, 'Alex', 'S', 'Reynolds', '336 Indiana Ave, Lubbock, TX', 8061347769);

INSERT INTO `pharmacist` (`pharm_id`, `pharm_lisc`) VALUES
(112, 100123);

INSERT INTO `pharmtech` (`tech_id`, `tech_certnum`, `tech_pharm_id`) VALUES
(1, 100111, 112),
(2, 100222, 112),
(11, 100333, 112);

INSERT INTO `supplier` (`supp_id`, `supp_name`, `supp_address`) VALUES
(1111, 'AAA Drugs', '123 Drugs St, Dallas, TX'),
(1112, 'Cardinal Health', '7000 Cardinal Place, Dublin, OH'),
(1113, 'Burlington Drug', '91 Catamount Drive Milton, VT'),
(1114, 'ASD Healthcare', '5025 Plano Pkwy, Carrollton, TX');

INSERT INTO `prescription` (`pres_id`, `pres_name`, `pres_price`, `pres_stock`, `pres_pharm_id`, `pres_tech_id`, `pres_doc_lisc`) VALUES
(550, 'Amoxicillin', 12.50, 20, 112, 1, 40064),
(551, 'Penicillin', 15.00, 5, 112, 2, 40064),
(991, 'Warfarin', 75.00, 3, 112, 11, 40065),
(992, 'Prednisone', 100.00, 1, 112, 11, 40063);

INSERT INTO `buys` (`buys_cust_id`, `buys_pres_id`, `buys_date`, `buys_cost`) VALUES
(1005, 551, '2024-04-22', 15),
(1010, 550, '2024-04-22', 12);

INSERT INTO `supplies` (`supps_id`, `supps_pres_id`, `supps_count`) VALUES
(1111, 550, 20),
(1113, 991, 3),
(1114, 551, 5);

SELECT * FROM customer WHERE cust_lname = "Ford";

SELECT * FROM employee WHERE emp_id = 112;

SELECT employee.emp_fname, employee.emp_mname, employee.emp_lname, employee.emp_address, employee.emp_phonenumber, pharmacist.pharm_id, pharmacist.pharm_lisc 
FROM pharmacist 
JOIN employee ON pharmacist.pharm_id = employee.emp_id;

SELECT employee.emp_fname, employee.emp_mname, employee.emp_lname, employee.emp_address, employee.emp_phonenumber, pharmtech.tech_id, pharmtech.tech_certnum
FROM pharmtech
JOIN employee ON pharmtech.tech_id = employee.emp_id;

SELECT prescription.pres_id, prescription.pres_name, pharmacist.pharm_id, 
emp_pharm.emp_lname AS pharm_lname, pharmtech.tech_id, 
emp_pharmtech.emp_lname AS tech_lname, doctor.doc_name 
FROM prescription 
JOIN employee AS emp_pharm ON prescription.pres_pharm_id = emp_pharm.emp_id 
JOIN employee AS emp_pharmtech ON prescription.pres_tech_id = emp_pharmtech.emp_id JOIN pharmacist ON prescription.pres_pharm_id = pharmacist.pharm_id 
JOIN pharmtech ON prescription.pres_tech_id = pharmtech.tech_id 
JOIN doctor ON prescription.pres_doc_lisc = doctor.doc_lisc;
