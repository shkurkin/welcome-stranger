DROP TABLE IF EXISTS `PREFIX_lookbook`;
###
CREATE  TABLE IF NOT EXISTS `PREFIX_lookbook` (
  `id_lookbook` INT(10) NOT NULL AUTO_INCREMENT ,
  `shop_id` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `active` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id_lookbook`) ,
  INDEX `id_lookbook` (`id_lookbook` ASC) )
ENGINE = MYSQL_ENGINE
DEFAULT CHARACTER SET = utf8;
###
DROP TABLE IF EXISTS `PREFIX_lookbook_lang`;
###
CREATE  TABLE IF NOT EXISTS `PREFIX_lookbook_lang` (
  `id_lookbook_lang` INT(10) NOT NULL AUTO_INCREMENT ,
  `id_lookbook` INT(10) UNSIGNED NOT NULL ,
  `id_lang` INT(10) UNSIGNED NOT NULL ,
  `name` CHAR(128) CHARACTER SET 'utf8' NOT NULL ,
  `link` CHAR(128) CHARACTER SET 'utf8' NOT NULL ,
  `description` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL ,
  `image_url` CHAR(128) NULL ,
  UNIQUE INDEX (`id_lookbook_lang` ASC, `id_lookbook` ASC) )
ENGINE = MYSQL_ENGINE
DEFAULT CHARACTER SET = utf8;
###
DROP TABLE IF EXISTS `PREFIX_lookbook_category`;
###
CREATE  TABLE IF NOT EXISTS `PREFIX_lookbook_category` (
  `id_category` INT(10) NOT NULL AUTO_INCREMENT ,
  `shop_id` TINYINT UNSIGNED NOT NULL DEFAULT '1',
  `active` TINYINT UNSIGNED NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id_category`) )
ENGINE = MYSQL_ENGINE
DEFAULT CHARACTER SET = utf8;
###
DROP TABLE IF EXISTS `PREFIX_lookbook_category_lang`;
###
CREATE  TABLE IF NOT EXISTS `PREFIX_lookbook_category_lang` (
  `id_category_lang` INT(10) NOT NULL AUTO_INCREMENT ,
  `id_category` INT(10) NOT NULL ,
  `id_lang` INT(10) UNSIGNED NOT NULL ,
  `name` CHAR(128) CHARACTER SET 'utf8' NOT NULL ,
  `link` CHAR(128) CHARACTER SET 'utf8' NOT NULL ,
  `description` TEXT CHARACTER SET 'utf8' NULL DEFAULT NULL ,
  PRIMARY KEY (`id_category_lang`) ,
  INDEX `id_category` (`id_category` ASC) )
ENGINE = MYSQL_ENGINE
DEFAULT CHARACTER SET = utf8;
###
DROP TABLE IF EXISTS `PREFIX_lookbooks_products`;
###
CREATE TABLE IF NOT EXISTS `PREFIX_lookbooks_products` (
  `id_lookbook` int(10) NOT NULL,
  `id_product` int(10) NOT NULL,
  PRIMARY KEY (`id_lookbook`,`id_product`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;
###
DROP TABLE IF EXISTS `PREFIX_lookbooks_categories`;
###
CREATE TABLE IF NOT EXISTS `PREFIX_lookbooks_categories` (
  `id_category` int(10) NOT NULL,
  `id_lookbook` int(10) NOT NULL,
  PRIMARY KEY (`id_category`,`id_lookbook`)
) ENGINE=MYSQL_ENGINE DEFAULT CHARSET=utf8;
