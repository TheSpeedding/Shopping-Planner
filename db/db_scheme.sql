SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `lists`;
DROP TABLE IF EXISTS `list`;
DROP TABLE IF EXISTS `items`;

--
-- Table structure for table `items`
--
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID of the item that can appear on the list.',
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Name of the item.'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='A lookup table of all items that an be added to a shopping list.';

--
-- Dumping data for table `items`
--
INSERT INTO `items` (`id`, `name`) VALUES
(4, 'beer'),
(1, 'bread'),
(2, 'butter'),
(5, 'chocolate'),
(9, 'instant soup'),
(3, 'milk'),
(6, 'pork chops'),
(8, 'potatoes'),
(7, 'tomatoes');

--
-- Table structure for table `list`
--
CREATE TABLE IF NOT EXISTS `list` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID of the list item.',
  `list_id` int(10) unsigned NOT NULL COMMENT 'FK to the lists table.',
  `item_id` int(10) unsigned NOT NULL COMMENT 'FK to the items table.',
  `amount` int(11) NOT NULL COMMENT 'Required amount (how much we need of this particular item).',
  `position` int(11) NOT NULL COMMENT 'Shopping list order.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Table structure for table `lists`
--
CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID of the list.',
  `account_id` int(10) unsigned NOT NULL COMMENT 'FK to the accounts table.',
  `created` DATETIME NOT NULL DEFAULT(GETDATE()) COMMENT 'Timestamp when the list was created.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Table structure for table `accounts`
--
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL COMMENT 'ID of the account.',
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Fullname of the account owner.',
  `login` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Login of the account owner.',
  `pw` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT 'Password of the account owner, hashed.',
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID of the item that can appear on the list.', AUTO_INCREMENT=10;
  
--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID of the list item.';
  
--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID of the item.';
  
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID of the account.';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `items_fk` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `list_fk` FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `account_fk` FOREIGN KEY (`item_id`) REFERENCES `accounts` (`id`);

--
-- Procedures for dumped tables
--

--
-- Procedure for deleting a list
--
CREATE PROCEDURE DeleteList (@ListID int(10) unsigned) AS
BEGIN
  DELETE FROM `list` WHERE list_id=@ListID;
  DELETE FROM `lists` WHERE id=@ListID;
END;