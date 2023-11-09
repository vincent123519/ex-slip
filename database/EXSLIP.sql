drop database exslipdb;
create database exslipdb;
use exslipdb;

DROP DATABASE IF EXISTS exslipdb;
CREATE DATABASE exslipdb;
USE exslipdb;

CREATE TABLE Schools (
  school_code INT PRIMARY KEY,
  school_name VARCHAR(100)
);

CREATE TABLE UserRoles (
  role_id INT PRIMARY KEY,
  role_name VARCHAR(20) UNIQUE,
  role_description VARCHAR(255)
);


CREATE TABLE Users (
  user_id INT PRIMARY KEY,
  name VARCHAR(100),
  username VARCHAR(50) UNIQUE,
  password_hash VARCHAR(255),
  role_id INT,
  FOREIGN KEY (role_id) REFERENCES UserRoles(role_id)
);

CREATE TABLE Departments (
  department_id INT PRIMARY KEY,
  department_name VARCHAR(100),
  school_code INT,
  FOREIGN KEY (school_code) REFERENCES Schools(school_code)
);

CREATE TABLE HeadCounselors (
  head_counselor_id INT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100),
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  department_id INT,
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);




CREATE TABLE DepartmentDegrees (
  degree_id INT PRIMARY KEY,
  department_id INT,
  degree_name VARCHAR(100),
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

CREATE TABLE Teachers (
  teacher_id INT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100),
  department_id INT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

CREATE TABLE Counselors (
  counselor_id INT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100),
  department_id INT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

-- naay gilabot nga department_id

CREATE TABLE Deans (
  dean_id INT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100),
  school_code INT,
  department_id INT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (school_code) REFERENCES Schools(school_code),
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

CREATE TABLE Students (
  student_id INT PRIMARY KEY,
  user_id INT UNIQUE,
  name VARCHAR(100),
  degree_id INT,
  year_level INT,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (degree_id) REFERENCES DepartmentDegrees(degree_id)
);

CREATE TABLE Semesters (
  semester_id INT PRIMARY KEY,
  semester_name VARCHAR(50)
);

CREATE TABLE Courses (
  course_code VARCHAR(10) PRIMARY KEY,
  course_name VARCHAR(100),
  department_id INT,
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

CREATE TABLE CourseOfferings (
  offer_code INT PRIMARY KEY,
  course_code VARCHAR(10),
  semester_id INT,
  teacher_id INT,
  start_time TIME,
  end_time TIME,
  days_of_week VARCHAR(50),
  department_id INT,
  FOREIGN KEY (course_code) REFERENCES Courses(course_code),
  FOREIGN KEY (semester_id) REFERENCES Semesters(semester_id),
  FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id),
  FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);


CREATE TABLE ExcuseStatuses (
  status_id INT PRIMARY KEY,
  status_name VARCHAR(20) UNIQUE
);

CREATE TABLE ExcuseSlips (
  excuse_slip_id INT PRIMARY KEY,
  student_id INT,
  teacher_id INT,
  counselor_id INT,
  dean_id INT,
  course_code VARCHAR(50),
  reason VARCHAR(255),
  start_date DATE,
  end_date DATE,
  status_id INT,
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (teacher_id) REFERENCES Teachers(teacher_id),
  FOREIGN KEY (counselor_id) REFERENCES Counselors(counselor_id),
  FOREIGN KEY (dean_id) REFERENCES Deans(dean_id),
  FOREIGN KEY (course_code) REFERENCES Courses(course_code),
  FOREIGN KEY (status_id) REFERENCES ExcuseStatuses(status_id)
);

CREATE TABLE Feedback (
  feedback_id INT PRIMARY KEY,
  excuse_slip_id INT,
  feedback_remarks VARCHAR(255),
  feedback_date DATE,
  sender_id INT,
  feedback_type VARCHAR(20),  -- Added feedback_type
  FOREIGN KEY (excuse_slip_id) REFERENCES ExcuseSlips(excuse_slip_id),
  FOREIGN KEY (sender_id) REFERENCES Users(user_id)
);

CREATE TABLE SupportingDocuments (
  document_id INT PRIMARY KEY,
  excuse_slip_id INT,
  document_path VARCHAR(255),
  upload_date TIMESTAMP,  -- Changed to TIMESTAMP
  FOREIGN KEY (excuse_slip_id) REFERENCES ExcuseSlips(excuse_slip_id)
);


-- gipun-an nakog offer_code
CREATE TABLE StudyLoad (
  studyload_id INT PRIMARY KEY,
  student_id INT,
  semester_id INT,
  course_code VARCHAR(10),
  offer_code INT,
  FOREIGN KEY (student_id) REFERENCES Students(student_id),
  FOREIGN KEY (semester_id) REFERENCES Semesters(semester_id),
  FOREIGN KEY (course_code) REFERENCES Courses(course_code),
  FOREIGN KEY (semester_id) REFERENCES Semesters(semester_id),
  FOREIGN KEY (offer_code) REFERENCES CourseOfferings(offer_code)
);