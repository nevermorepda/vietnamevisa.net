ALTER TABLE `vs_agents` ADD `arr_port` VARCHAR(255) NULL DEFAULT NULL AFTER `company`;
ALTER TABLE `vs_agents` ADD `arr_port_pickup` VARCHAR(255) NULL DEFAULT NULL AFTER `arr_port`;