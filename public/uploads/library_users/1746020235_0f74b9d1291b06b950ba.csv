-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 12:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `just1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `author_proc` (IN `num` INT, IN `au_name` VARCHAR(200), IN `oper` VARCHAR(10))   BEGIN
    CASE 
        WHEN oper = 'insert' THEN 
            IF au_name = '' THEN 
                SELECT 'Fill The Author Inputs' AS msg;
            ELSEIF EXISTS (SELECT * FROM authors WHERE Name = au_name) THEN
                SELECT CONCAT(au_name, ' Author Already Exists') AS msg;
            ELSE
                INSERT INTO authors VALUES (NULL, au_name,0);
                SELECT 'Inserted Successfully' AS msg;
            END IF;

        WHEN oper = 'update' THEN 
            IF EXISTS (SELECT * FROM authors WHERE author_id = num) THEN
                UPDATE authors SET Name = au_name WHERE author_id = num;
                SELECT ' Updated Successfully' AS msg;
            ELSE
                SELECT 'Category Not Found' AS msg;
            END IF;

        WHEN oper = 'delete' THEN 
            IF EXISTS (SELECT * FROM authors WHERE author_id = num) THEN
                UPDATE authors SET deleted = 1 WHERE author_id = num;
                SELECT ' Deleted Successfully' AS msg;
            ELSE
                SELECT 'Author Not Found' AS msg;
            END IF;

      
    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `book_proc` (IN `num` INT, IN `title_` VARCHAR(100), IN `author_id_` INT, IN `isbn_` VARCHAR(30), IN `quantity_` INT, IN `published_year_` YEAR, IN `added_by_` INT, IN `photo_` TEXT, IN `oper` VARCHAR(10))   BEGIN
    CASE 
        WHEN oper = 'insert' THEN 
            IF (title_ IS NULL OR title_ = '') AND 
               (author_id_ IS NULL) AND 
               (isbn_ IS NULL OR isbn_ = '') AND 
               (quantity_ IS NULL) AND 
               (published_year_ IS NULL) AND 
               (photo_ IS NULL OR photo_ = '') AND
               (added_by_ IS NULL) THEN
                SELECT 'Please input all fields' AS msg;

            ELSEIF title_ = '' OR quantity_ IS NULL OR photo_ = '' THEN 
                SELECT 'Fill Required Book Inputs' AS msg;

            ELSEIF EXISTS (SELECT * FROM tbl_books WHERE isbn = isbn_ AND isbn_ IS NOT NULL) THEN
                SELECT CONCAT('ISBN ', isbn_, ' Already Exists') AS msg;

            ELSE
                -- Generate temporary RFID (title-based + random number)
                SET @rfid_tag := CONCAT(LEFT(title_, 3), '-', FLOOR(RAND() * 100000));

                -- Insert book
                INSERT INTO tbl_books (
                    book_id, title, author_id, isbn, rfid_tag, quantity, published_year, photo, status, added_by, added_date
                ) VALUES (
                    NULL, title_, author_id_, isbn_, @rfid_tag, quantity_, published_year_, photo_, 'available', added_by_, NOW()
                );

                SELECT CONCAT('Inserted Successfully') AS msg;
            END IF;

        WHEN oper = 'update' THEN 
            IF EXISTS (SELECT * FROM tbl_books WHERE book_id = num) THEN
                UPDATE tbl_books SET
                    title = title_,
                    author_id = author_id_,
                    isbn = isbn_,
                    quantity = quantity_,
                    published_year = published_year_,
                    photo = photo_,
                    added_by = added_by_
                WHERE book_id = num;
                SELECT 'Updated Successfully' AS msg;
            ELSE
                SELECT 'Book Not Found' AS msg;
            END IF;

        WHEN oper = 'delete' THEN 
            IF EXISTS (SELECT * FROM tbl_books WHERE book_id = num) THEN
                DELETE FROM tbl_books WHERE book_id = num;
                SELECT 'Deleted Successfully' AS msg;
            ELSE
                SELECT 'Book Not Found' AS msg;
            END IF;

    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cat_proc` (IN `num` INT, IN `name` VARCHAR(200), IN `oper` VARCHAR(10))   BEGIN
    CASE 
        WHEN oper = 'insert' THEN 
            IF name = '' THEN 
                SELECT 'Fill The Category Inputs' AS msg;
            ELSEIF EXISTS (SELECT * FROM categories WHERE c_name = name) THEN
                SELECT CONCAT(name, ' Category Already Exists') AS msg;
            ELSE
                INSERT INTO categories VALUES (NULL, name,0);
                SELECT 'Inserted Successfully' AS msg;
            END IF;

        WHEN oper = 'update' THEN 
            IF EXISTS (SELECT * FROM categories WHERE c_id = num) THEN
                UPDATE categories SET c_name = name WHERE c_id = num;
                SELECT ' Updated Successfully' AS msg;
            ELSE
                SELECT 'Category Not Found' AS msg;
            END IF;

        WHEN oper = 'delete' THEN 
            IF EXISTS (SELECT * FROM categories WHERE c_id = num) THEN
                UPDATE categories SET deleted = 1 WHERE c_id = num;
                SELECT ' Deleted Successfully' AS msg;
            ELSE
                SELECT 'Category Not Found' AS msg;
            END IF;

      
    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `forgotpswd` (IN `num` INT, IN `old_pass` VARCHAR(100), IN `new_pass` VARCHAR(50), IN `confirm_pass` VARCHAR(100))   BEGIN
    DECLARE pass VARCHAR(100);

    IF num IS NULL OR old_pass = '' OR new_pass = '' OR confirm_pass = '' THEN
        SELECT 'Please Fill All Inputs' AS message;
    ELSE
        IF new_pass != confirm_pass THEN
            SELECT 'The new password and confirmation password must match.' AS message;
        ELSE
            SELECT password INTO pass FROM users WHERE user_id = num;

            IF pass IS NULL THEN
                SELECT 'User not found.' AS message;
            ELSEIF pass != old_pass THEN
                SELECT 'The old password you entered is incorrect.' AS message;
            ELSE
                UPDATE users SET password = new_pass WHERE user_id = num;
                SELECT 'Your password has been successfully changed.' AS message;
            END IF;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `usercount` ()   begin 
select count(user_id) from users;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_pro` (IN `num` INT, IN `name_` TEXT, IN `email_` TEXT, IN `password_` VARCHAR(20), IN `type_` VARCHAR(10), IN `image_` TEXT, IN `oper` TEXT)   BEGIN
    CASE 
        WHEN oper = 'insert' THEN
            IF EXISTS (SELECT * FROM users WHERE name = name_ AND email = email_) THEN
                SELECT CONCAT(name_, ', ', email_, ' already exists') AS msg;
            ELSE
                IF (name_ = '' OR email_ = '' OR password_ = '' OR type_ = '') THEN
                    SELECT 'Fill in the blank space' AS msg;
                ELSE
                    INSERT INTO users 
                    VALUES (null,name_, email_, password_, type_, IF(image_ = '', NULL, image_), 0);
                    SELECT 'Saved successfully' AS msg;
                END IF;
            END IF;

        WHEN oper = 'update' THEN
            IF EXISTS (SELECT * FROM users WHERE user_id = num) THEN
                UPDATE users 
                SET name = name_, 
                    email = email_, 
                    password = password_, 
                    type = type_, 
                    image = IF(image_ = '', NULL, image_)
                WHERE user_id = num;
                SELECT 'Updated successfully' AS msg;
            ELSE
                SELECT CONCAT(num, ' is not found') AS msg;
            END IF;

        WHEN oper = 'delete' THEN
            IF EXISTS (SELECT * FROM users WHERE user_id = num) THEN
                UPDATE users 
                SET deleted = 1 
                WHERE user_id = num;
                SELECT 'Deleted successfully' AS msg;
            ELSE
                SELECT CONCAT(num, ' is not found') AS msg;
            END IF;
    END CASE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users_view` ()   begin
select user_id `No`, name `name`, email Email, password `password`, type `Type` from users where deleted=0;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `descriptions` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `Name`, `descriptions`) VALUES
(2, 'Abdikadir', 'jamalka'),
(3, 'mohamed `', '5219889'),
(4, 'jama', '521988'),
(5, 'mohamed', '521hg8728923'),
(6, 'mohamed', '6215262'),
(7, 'xiirey', 'authoir ahahahahjhajha'),
(8, 'xbnnbx', 'xmbndkjsajk'),
(9, 'jama', 'ddjdjud'),
(10, 'xvbnxvbn', 'qwwsw'),
(11, 'msdajmd', 'sjsdagjdjhd'),
(14, 'jama ', '5219889'),
(15, 'singup_controller', 'mncmnamncmnac'),
(16, 'jama ', 'ytrtter'),
(17, 'jama ', '015210'),
(18, 'SignUpRequestModel.php', 'jhgc'),
(19, 'singup_controller', 'fdgsggg'),
(20, 'SignUpRequestModel.php', 'ergergg'),
(21, 'singup_controller', 'mohamed gjfgdjfd');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(50) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `c_name`, `deleted`) VALUES
(1, 'Drinks', 0),
(2, 'alwax', 0),
(3, 'Mohamed', 0),
(4, 'mohamed Abdikadir ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `f_id` int(11) NOT NULL,
  `f_name` varchar(250) NOT NULL,
  `c_id` int(11) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `image` text DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `isbn` varchar(30) DEFAULT NULL,
  `rfid_tag` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `published_year` year(4) DEFAULT NULL,
  `photo` text NOT NULL,
  `status` enum('available','borrowed','lost') DEFAULT 'available',
  `added_by` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`book_id`, `title`, `author_id`, `isbn`, `rfid_tag`, `quantity`, `published_year`, `photo`, `status`, `added_by`, `added_date`) VALUES
(7, 'mohame', 2, '5219889', 'moh-99762', 13241, '2040', 'tbl_staff.sql', 'available', 18, '2025-04-25 19:47:16'),
(8, 'mohamed', 1, '1211', 'moh-36334', 212, '2025', 'taxrecords.sql', 'available', 18, '2025-04-25 19:56:15'),
(9, 'mohamed', 1, '1233233', 'moh-33134', 21221, '0000', 'taxrecords.sql', 'available', 18, '2025-04-25 19:58:17'),
(10, 'mohamed', 1, '121', 'moh-47906', 21, '2022', 'Untitled.txt', 'available', 18, '2025-04-26 20:02:22'),
(11, 'c#', 2, '878673653', 'c#-20581', 121, '2024', 'smart_libraray.sql', 'available', 18, '2025-04-26 20:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `staff_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','librarian') DEFAULT 'librarian',
  `image` varchar(255) DEFAULT NULL,
  `reg_date` datetime DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `t_id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`t_id`, `name`) VALUES
(1, 'Admin'),
(2, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `type` enum('admin','user') DEFAULT 'user',
  `image` text NOT NULL,
  `deleted` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `type`, `image`, `deleted`) VALUES
(16, 'Mohamed Yusuf Ahmed', 'MohamedYusuf851@gmail.com', '5219', 'admin', 'mo.jpeg', 0),
(17, 'Ayub', 'ayub@gmail.com', '1234', 'admin', 'Screenshot (1).png', 0),
(18, 'Abdala', 'ayub@gmail.com', '2211', 'admin', 'default.png', 0),
(19, 'jamalk', 'ayub@gmail.com', '5219', 'admin', 'Screenshot 2025-01-11 110742.png', 0),
(20, 'qww', 'qwq', 'wwqw', '', 'mohamed.sql', 0),
(21, 'Mohamed Yusuf', 'MohamedYusuf@gmail.com', '123', 'admin', 'default.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `rfid_tag` (`rfid_tag`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `categories` (`c_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
