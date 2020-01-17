ALTER TABLE `vs_visa_booking` ADD `order_ref` VARCHAR(255) NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `vs_visa_booking` CHANGE `user_id` `user_id` BIGINT(20) UNSIGNED NULL DEFAULT '1';
ALTER TABLE `vs_visa_booking` ADD `exit_port` VARCHAR(255) NULL DEFAULT NULL AFTER `arrival_port`;