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
