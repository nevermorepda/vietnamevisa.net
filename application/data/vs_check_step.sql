ALTER TABLE `vs_check_step` ADD `type` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1:voa, 2:vev' AFTER `email`;
ALTER TABLE `vs_check_step` ADD `price_1` DOUBLE NOT NULL DEFAULT '0' AFTER `step4`, ADD `price_2` DOUBLE NOT NULL DEFAULT '0' AFTER `price_1`, ADD `price_3` DOUBLE NOT NULL DEFAULT '0' AFTER `price_2`, ADD `price_4` DOUBLE NOT NULL DEFAULT '0' AFTER `price_3`;
ALTER TABLE `vs_check_step` ADD `fullname` VARCHAR(255) NULL DEFAULT NULL AFTER `email`;
ALTER TABLE `vs_check_step` ADD `check_po` TINYINT(1) NOT NULL DEFAULT '1' AFTER `type`;
ALTER TABLE `vs_check_step` ADD `send_mail` TINYINT(1) NOT NULL DEFAULT '1' AFTER `status`;