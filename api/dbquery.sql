create database job_task2;
use job_task2;

create table employees(
    `id` int(11) primary key auto_increment,
    `name` varchar(255) not null,
    `email` varchar(255) not null,
    `mobile` varchar(255) not null,
    `designation` varchar(255) not null,
    `salary` varchar(255) not null,
    `status` boolean default 1,
    `created_at` timestamp default current_timestamp
);

INSERT into `employees` (`name`, `email`, `mobile`, `designation`, `salary`) values
('user1', 'user1@gmail.com', '142536625', 'team lead', '10'),
('user2', 'user2@gmail.com', '122142234', 'senior developer', '6'),
('user3', 'user3@gmail.com', '142534564', 'junior developer', '3.5'),
('user4', 'user4@gmail.com', '142522222', 'intern', '2.5'),
('user5', 'user5@gmail.com', '142511111', 'manager', '16'),
('user6', 'user6@gmail.com', '142536232', 'intern', '2.5');

