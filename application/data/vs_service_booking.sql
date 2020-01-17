ALTER TABLE `vs_service_booking` ADD `send_pickup` TINYINT(1) NOT NULL DEFAULT '1' AFTER `agents_id`;
ALTER TABLE `vs_service_booking` ADD `full_package` TINYINT(1) NULL DEFAULT '0' AFTER `other_payment`;
ALTER TABLE `vs_service_booking` ADD `note` VARCHAR(255) NULL DEFAULT NULL AFTER `send_pickup`;