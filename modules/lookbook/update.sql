ALTER TABLE `PREFIX_lookbook` ADD `shop_id` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `id_lookbook`;
###
ALTER TABLE `PREFIX_lookbook_category` ADD `shop_id` TINYINT UNSIGNED NOT NULL DEFAULT '1' AFTER `id_category`;