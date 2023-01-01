/*
	Script Title: Schema Initialization Script
    Author: Sam Gerstner
    Description: This script is part of the open source bus reservation system available on GitHub at the link below.
		This script initializes the database and schema for use with the application.
	Instructions: 
		1. Ensure that your MySQL does not have a database or user with the same name as the ones you plan to use. These will be created by the script.
        2. Update the database name on lines 16, 17, 18, & 21 to match your preferred name.
        3. Update the database user username and password on line 20. (Note: This user CANNOT exist on the MySQL server when you run this script.)
        4. Update the database user username on line 21.
        5. Update sales tax rate on line 85.
        6. Run this script as root or other administrative user with full access to the MySQL server.
        
	Project GitHub Link: <INSERT LINK HERE>
*/
-- Create datbase
DROP DATABASE IF EXISTS bus_reservation;
CREATE DATABASE bus_reservation;
USE bus_reservation;

-- Create database user and grant access to DB
CREATE USER 'USERNAME'@'%' IDENTIFIED WITH mysql_native_password BY 'PASSWORD';
GRANT ALL PRIVILEGES ON bus_reservation.* TO 'USERNAME'@'%';

-- Create tables needed for application
CREATE TABLE US_states (
	abbrev varchar(2) PRIMARY KEY,
    name varchar(30) NOT NULL
);

CREATE TABLE application_roles (
	abbrev varchar(8) PRIMARY KEY,
    name varchar(30) NOT NULL,
    description varchar(300) NOT NULL
);

CREATE TABLE Bus (
	vin varchar(17) PRIMARY KEY,
    make varchar(20),
    model varchar(20),
    passenger_capacity integer NOT NULL,
    odometer_reading integer,
    odometer_read_date date
);

CREATE TABLE Driver (
	dl_number varchar(15) PRIMARY KEY,
    first_name varchar(20) NOT NULL,
    last_name varchar(20) NOT NULL
);

CREATE TABLE Stop (
	stop_code varchar(3) PRIMARY KEY,
    stop_name varchar(30),
    city varchar(20) NOT NULL,
    state varchar(2) NOT NULL,
    FOREIGN KEY (state) REFERENCES US_states(abbrev)
);

CREATE TABLE Route (
	route_code varchar(6) PRIMARY KEY,
    departure_stop varchar(3) NOT NULL,
    destination_stop varchar(3) NOT NULL,
    ticket_price double NOT NULL,
    FOREIGN KEY (departure_stop) REFERENCES Stop(stop_code),
    FOREIGN KEY (destination_stop) REFERENCES Stop(stop_code)
);

CREATE TABLE Trip (
	trip_code varchar(10) PRIMARY KEY,
    route_code varchar(6) NOT NULL,
    trip_date date NOT NULL,
    departure_time time NOT NULL,
    arrival_time time,
    FOREIGN KEY (route_code) REFERENCES Route(route_code)
);

CREATE TABLE Customer (
	first_name varchar(20) NOT NULL,
    last_name varchar(20) NOT NULL,
    email varchar(30) NOT NULL,
    address varchar(100),
    phone_number varchar(10),
    PRIMARY KEY (first_name, last_name, email)
);

CREATE TABLE Purchase (
	transaction_id varchar(20) PRIMARY KEY,
    customer_first varchar(20) NOT NULL,
    customer_last varchar(20) NOT NULL,
    customer_email varchar(30) NOT NULL,
    trip_code varchar(10) NOT NULL,
    num_tickets integer NOT NULL,
    subtotal double NOT NULL,
    sales_tax double AS (subtotal * 0.0918),
    total double AS (subtotal + sales_tax)
);

CREATE TABLE application_users (
	id integer PRIMARY KEY AUTO_INCREMENT,
    username varchar(20) NOT NULL UNIQUE,
    password varchar(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Populate US_states lookup table
INSERT INTO US_states VALUES ('AL', 'Alabama');
INSERT INTO US_states VALUES ('AK', 'Alaska');
INSERT INTO US_states VALUES ('AZ', 'Arizona');
INSERT INTO US_states VALUES ('AR', 'Arkansas');
INSERT INTO US_states VALUES ('CA', 'California');
INSERT INTO US_states VALUES ('CO', 'Colorado');
INSERT INTO US_states VALUES ('CT', 'Connecticut');
INSERT INTO US_states VALUES ('DE', 'Deleware');
INSERT INTO US_states VALUES ('DC', 'District of Colombia');
INSERT INTO US_states VALUES ('FL', 'Florida');
INSERT INTO US_states VALUES ('GA', 'Georgia');
INSERT INTO US_states VALUES ('HI', 'Hawaii');
INSERT INTO US_states VALUES ('ID', 'Idaho');
INSERT INTO US_states VALUES ('IL', 'Illinois');
INSERT INTO US_states VALUES ('IN', 'Indiana');
INSERT INTO US_states VALUES ('IA', 'Iowa');
INSERT INTO US_states VALUES ('KS', 'Kansas');
INSERT INTO US_states VALUES ('KY', 'Kentucky');
INSERT INTO US_states VALUES ('LA', 'Louisiana');
INSERT INTO US_states VALUES ('ME', 'Maine');
INSERT INTO US_states VALUES ('MD', 'Maryland');
INSERT INTO US_states VALUES ('MA', 'Massachusetts');
INSERT INTO US_states VALUES ('MI', 'Michigan');
INSERT INTO US_states VALUES ('MN', 'Minnesota');
INSERT INTO US_states VALUES ('MS', 'Mississippi');
INSERT INTO US_states VALUES ('MO', 'Missouri');
INSERT INTO US_states VALUES ('MT', 'Montana');
INSERT INTO US_states VALUES ('NE', 'Nebraska');
INSERT INTO US_states VALUES ('NV', 'Nevada');
INSERT INTO US_states VALUES ('NH', 'New Hampshire');
INSERT INTO US_states VALUES ('NJ', 'New Jersey');
INSERT INTO US_states VALUES ('NM', 'New Mexico');
INSERT INTO US_states VALUES ('NY', 'New York');
INSERT INTO US_states VALUES ('NC', 'North Carolina');
INSERT INTO US_states VALUES ('ND', 'North Dakota');
INSERT INTO US_states VALUES ('OH', 'Ohio');
INSERT INTO US_states VALUES ('OK', 'Oklahoma');
INSERT INTO US_states VALUES ('OR', 'Oregon');
INSERT INTO US_states VALUES ('PA', 'Pennsylvania');
INSERT INTO US_states VALUES ('RI', 'Rhode Island');
INSERT INTO US_states VALUES ('SC', 'South Carolina');
INSERT INTO US_states VALUES ('SD', 'South Dakota');
INSERT INTO US_states VALUES ('TN', 'Tennessee');
INSERT INTO US_states VALUES ('TX', 'Texas');
INSERT INTO US_states VALUES ('UT', 'Utah');
INSERT INTO US_states VALUES ('VT', 'Vermont');
INSERT INTO US_states VALUES ('VA', 'Virginia');
INSERT INTO US_states VALUES ('WA', 'Washington');
INSERT INTO US_states VALUES ('WV', 'West Virginia');
INSERT INTO US_states VALUES ('WI', 'Wisconsin');
INSERT INTO US_states VALUES ('WY', 'Wyoming');

-- Populate application_roles lookup table
INSERT INTO application_roles VALUES ('SYSADM', 'System Administrator', 'Users with the System Administrators role have full read/write access to the system and can modify users and user roles.');
INSERT INTO application_roles VALUES ('FULL', 'Full Access', 'Users with the Full Access role have full read/write access to the system.');
INSERT INTO application_roles VALUES ('HR', 'Human Resources', 'Users with the Human Resources role can view/add/remove drivers.');
INSERT INTO application_roles VALUES ('STOPADM', 'Stop Administrator', 'Users');
INSERT INTO application_roles VALUES ('ROUTEADM', 'Route Administrator', 'Users with the Route Administrator role can view/add/remove routes.');
INSERT INTO application_roles VALUES ('TRIPADM', 'Trip Administrator', 'Users with the Trip Administrator role can view/add/remove trips.');
INSERT INTO application_roles VALUES ('SCHEDADM', 'Schedule Administrator', 'Users with the Schedule Administrator can view/add/remove stops, routes, and trips.');
INSERT INTO application_roles VALUES ('CASH', 'Cashier', 'Users with the Cashier role can view/add/remove customers and create/view purchases.');