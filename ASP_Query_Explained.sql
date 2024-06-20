-- Insert query to add customer information into customer table such as customer ID, first and last name, date of birth, address, phone number, and insurance number --
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

-- Insert query to add doctor information into doctor table such as license number, specialty, name, phonenumber, and clinic name --
INSERT INTO `doctor` (`doc_lisc`, `doc_spec`, `doc_name`, `doc_phonenumber`, `clinic_name`) VALUES
(40063, 'Diagnostician', 'Dr. House', 1234567890, 'Princeton Plainsboro Teaching '),
(40064, 'Pediatrics', 'Dr. Smith', 8065559999, 'The Clinic'),
(40065, 'Cardiology', 'Dr. Doe', 8067471010, 'The Heart Clinic'),
(40066, 'Oncology', 'Dr. Wilson', 8069593342, 'Princeton Plainsboro Teaching');

-- Insert query to add employees information to employee table such as ID, first and middle and last name, address, and phonenumber --
INSERT INTO `employee` (`emp_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_address`, `emp_phonenumber`) VALUES
(1, 'John', 'A', 'Miller', '442 North Rd, Lubbock, TX', 8063331212),
(2, 'Terry', 'S', 'Ballard', '3563 34th St, Lubbock, TX', 8068742309),
(11, 'Amanda', 'H', 'O\'Brien', '101 4th St, Lubbock, TX', 8068895611),
(112, 'Alex', 'S', 'Reynolds', '336 Indiana Ave, Lubbock, TX', 8061347769);

-- Insert query to add pharmacist to pharmacist table, using the employee info from Alex Reynolds to make them the pharmacist --
INSERT INTO `pharmacist` (`pharm_id`, `pharm_lisc`) VALUES
(112, 100123);

-- Insert query to add pharmtech to pharmtech table, using the employee info from John Miller, Terry Ballard, and Amanda O'Brien to make them pharmtechs --
INSERT INTO `pharmtech` (`tech_id`, `tech_certnum`, `tech_pharm_id`) VALUES
(1, 100111, 112),
(2, 100222, 112),
(11, 100333, 112);

-- Insert query to add suppliers to supplier table, using infomration such as an ID, supplier name, and supplier address --
INSERT INTO `supplier` (`supp_id`, `supp_name`, `supp_address`) VALUES
(1111, 'AAA Drugs', '123 Drugs St, Dallas, TX'),
(1112, 'Cardinal Health', '7000 Cardinal Place, Dublin, OH'),
(1113, 'Burlington Drug', '91 Catamount Drive Milton, VT'),
(1114, 'ASD Healthcare', '5025 Plano Pkwy, Carrollton, TX');

-- Insert query to add prescriptions to prescription table, using information such as an ID, prescription name, price, stock, and the pharmacist and pharmtech ID's and the doctor license --
INSERT INTO `prescription` (`pres_id`, `pres_name`, `pres_price`, `pres_stock`, `pres_pharm_id`, `pres_tech_id`, `pres_doc_lisc`) VALUES
(550, 'Amoxicillin', 12.50, 20, 112, 1, 40064),
(551, 'Penicillin', 15.00, 5, 112, 2, 40064),
(991, 'Warfarin', 75.00, 3, 112, 11, 40065),
(992, 'Prednisone', 100.00, 1, 112, 11, 40063);

-- Insert query to add to the buys table, uses customer id, prescription id, purchase date, and the cost of the purchase --
INSERT INTO `buys` (`buys_cust_id`, `buys_pres_id`, `buys_date`, `buys_cost`) VALUES
(1005, 551, '2024-04-22', 15),
(1010, 550, '2024-04-22', 12);

-- Insert query to insert into the supplies table, uses supplier id, prescription id, and prescription count --
INSERT INTO `supplies` (`supps_id`, `supps_pres_id`, `supps_count`) VALUES
(1111, 550, 20),
(1113, 991, 3),
(1114, 551, 5);

-- An example select query used by the interface if the user entered "Ford" as last name in the search customer section --
SELECT * FROM customer WHERE cust_lname = "Ford";

-- An example select query used by the interface if the user entered 112 as the ID to find an employee in the database --
SELECT * FROM employee WHERE emp_id = 112;

-- An example select query used by the interface if the user was searching for pharmacists in the database. The query uses the pharmacist and employee table based on the pharmacist ID to get pharmacist information --
SELECT employee.emp_fname, employee.emp_mname, employee.emp_lname, employee.emp_address, employee.emp_phonenumber, pharmacist.pharm_id, pharmacist.pharm_lisc 
FROM pharmacist 
JOIN employee ON pharmacist.pharm_id = employee.emp_id;

-- An example select query used by the interface if the user was searching for pharmtechs in the database. The query uses the pharmtech and employee table based on the pharmtech ID to get pharmtech information --
SELECT employee.emp_fname, employee.emp_mname, employee.emp_lname, employee.emp_address, employee.emp_phonenumber, pharmtech.tech_id, pharmtech.tech_certnum
FROM pharmtech
JOIN employee ON pharmtech.tech_id = employee.emp_id;

-- An example select query that is used if the user tries to search for a prescription from the database. The query uses the prescription, employee, pharmacist, pharmtech, and doctor tables based on the employee/pharmtech/pharmacist ID and the doctor license number to display the respective information from each table --
SELECT prescription.pres_id, prescription.pres_name, pharmacist.pharm_id, 
emp_pharm.emp_lname AS pharm_lname, pharmtech.tech_id, 
emp_pharmtech.emp_lname AS tech_lname, doctor.doc_name 
FROM prescription 
JOIN employee AS emp_pharm ON prescription.pres_pharm_id = emp_pharm.emp_id 
JOIN employee AS emp_pharmtech ON prescription.pres_tech_id = emp_pharmtech.emp_id JOIN pharmacist ON prescription.pres_pharm_id = pharmacist.pharm_id 
JOIN pharmtech ON prescription.pres_tech_id = pharmtech.tech_id 
JOIN doctor ON prescription.pres_doc_lisc = doctor.doc_lisc;





