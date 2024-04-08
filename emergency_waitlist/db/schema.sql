CREATE TABLE admin(
    username varchar(255) NOT NULL, 
    password varchar(255) NOT NULL
);

CREATE TABLE patient(
    name varchar(255) NOT NULL,
    code varchar(255) NOT NULL,
    injury_severity int CHECK (0 < injury_severity AND injury_severity <= 5 ) NOT NULL,
    operating boolean NOT NULL,
    PRIMARY KEY (name, code)
);

CREATE TABLE waitlist(
    patient varchar(255) NOT NULL, 
    patient_code varchar(255) NOT NULL,
    start_of_wait TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient, patient_code) REFERENCES patient(name, code)
);