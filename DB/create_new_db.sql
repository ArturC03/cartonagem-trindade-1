CREATE DATABASE IF NOT EXISTS `plantdb_new`;
USE `plantdb_new`;

CREATE TABLE `sensor`(
    `id_sensor` VARCHAR(4) NOT NULL,
    `description` TEXT NULL,
    `id_location` INT UNSIGNED NOT NULL,
    `id_group` INT UNSIGNED NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `last_edited_at` DATETIME NOT NULL
);
ALTER TABLE
    `sensor` ADD PRIMARY KEY(`id_sensor`);
CREATE TABLE `location`(
    `id_location` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `location_x` INT NULL,
    `location_y` INT NULL,
    `size_x` INT NULL,
    `size_y` INT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `last_edited_at` DATETIME NOT NULL
);
CREATE TABLE `error_log`(
    `id_log` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_error` INT UNSIGNED NOT NULL,
    `error_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `id_user` INT UNSIGNED NULL
);
CREATE TABLE `user_type`(
    `id_type` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `type` VARCHAR(20) NOT NULL
);
ALTER TABLE
    `user_type` ADD UNIQUE `user_type_type_unique`(`type`);
CREATE TABLE `error`(
    `id_error` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `error` TEXT NOT NULL
);
CREATE TABLE `group`(
    `id_group` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `group_name` VARCHAR(100) NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `last_edited_at` DATETIME NOT NULL
);
ALTER TABLE
    `group` ADD UNIQUE `group_group_name_unique`(`group_name`);
CREATE TABLE `interval`(
    `id_interval` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `interval_code` VARCHAR(10) NOT NULL,
    `interval_name` VARCHAR(30) NOT NULL
);
CREATE TABLE `sensor_reading`(
    `id_reading` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_sensor` VARCHAR(4) NOT NULL,
    `date` DATE NOT NULL,
    `time` TIME NOT NULL,
    `setPoint` VARCHAR(3) NOT NULL,
    `deltaSetPoint` VARCHAR(3) NOT NULL,
    `addressCold` VARCHAR(3) NOT NULL,
    `addressHot` VARCHAR(3) NOT NULL,
    `slaveReply` VARCHAR(4) NOT NULL,
    `slaveCommand` VARCHAR(4) NOT NULL,
    `command1` VARCHAR(3) NOT NULL,
    `command2` VARCHAR(3) NOT NULL,
    `command3` VARCHAR(3) NOT NULL,
    `command4` VARCHAR(3) NOT NULL,
    `temperature` VARCHAR(10) NOT NULL,
    `humidity` VARCHAR(10) NOT NULL,
    `pressure` VARCHAR(10) NOT NULL,
    `altitude` VARCHAR(10) NOT NULL,
    `eCO2` VARCHAR(10) NULL,
    `eTVOC` VARCHAR(10) NULL,
    `communicationStatus` VARCHAR(2) NOT NULL,
    `f_Mount` VARCHAR(3) NOT NULL,
    `f_Open` VARCHAR(3) NOT NULL,
    `f_Lseek` VARCHAR(3) NOT NULL,
    `f_Write` VARCHAR(3) NOT NULL,
    `f_Close` VARCHAR(3) NOT NULL,
    `f_Dismount` VARCHAR(4) NOT NULL
);
CREATE TABLE `user`(
    `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(30) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` VARCHAR(300) NOT NULL,
    `id_type` INT UNSIGNED NOT NULL,
    `last_edited_by` INT UNSIGNED NOT NULL,
    `last_edited_at` DATETIME NOT NULL
);
ALTER TABLE
    `user` ADD UNIQUE `user_username_unique`(`username`);
ALTER TABLE
    `user` ADD UNIQUE `user_email_unique`(`email`);
CREATE TABLE `export`(
    `id_export` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_interval` INT UNSIGNED NOT NULL,
    `generation_format` TINYINT(1) NOT NULL,
    `existing_files` INT NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `edited_at` DATETIME NOT NULL
);
CREATE TABLE `export_sensor`(
    `id_export_sensor` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id_sensor` VARCHAR(4) NOT NULL,
    `id_export` INT UNSIGNED NOT NULL
);
CREATE TABLE `site_settings`(
    `id_setting` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(30) NOT NULL,
    `value` TEXT NOT NULL,
    `id_user` INT UNSIGNED NOT NULL,
    `last_edited_at` DATETIME NOT NULL
);
ALTER TABLE
    `sensor` ADD CONSTRAINT `sensor_id_group_foreign` FOREIGN KEY(`id_group`) REFERENCES `group`(`id_group`);
ALTER TABLE
    `sensor` ADD CONSTRAINT `sensor_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `group` ADD CONSTRAINT `group_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `location` ADD CONSTRAINT `location_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `site_settings` ADD CONSTRAINT `site_settings_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `export_sensor` ADD CONSTRAINT `export_sensor_id_sensor_foreign` FOREIGN KEY(`id_sensor`) REFERENCES `sensor`(`id_sensor`);
ALTER TABLE
    `export_sensor` ADD CONSTRAINT `export_sensor_id_export_foreign` FOREIGN KEY(`id_export`) REFERENCES `export`(`id_export`);
ALTER TABLE
    `sensor` ADD CONSTRAINT `sensor_id_location_foreign` FOREIGN KEY(`id_location`) REFERENCES `location`(`id_location`);
ALTER TABLE
    `error_log` ADD CONSTRAINT `error_log_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `export` ADD CONSTRAINT `export_id_interval_foreign` FOREIGN KEY(`id_interval`) REFERENCES `interval`(`id_interval`);
ALTER TABLE
    `sensor_reading` ADD CONSTRAINT `sensor_reading_id_sensor_foreign` FOREIGN KEY(`id_sensor`) REFERENCES `sensor`(`id_sensor`);
ALTER TABLE
    `error_log` ADD CONSTRAINT `error_log_id_error_foreign` FOREIGN KEY(`id_error`) REFERENCES `error`(`id_error`);
ALTER TABLE
    `export` ADD CONSTRAINT `export_id_user_foreign` FOREIGN KEY(`id_user`) REFERENCES `user`(`id_user`);
ALTER TABLE
    `user` ADD CONSTRAINT `user_id_type_foreign` FOREIGN KEY(`id_type`) REFERENCES `user_type`(`id_type`);
ALTER TABLE
    `user` ADD CONSTRAINT `user_last_edited_by_foreign` FOREIGN KEY(`last_edited_by`) REFERENCES `user`(`id_user`);