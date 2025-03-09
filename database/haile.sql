-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 06:49 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `haile`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `f_id` int(11) NOT NULL,
  `user` varchar(30) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`f_id`, `user`, `feedback`, `created_at`) VALUES
(2, 'yared3113@gmail.com', 'hello i am the head chef from yared', '2025-01-27 04:45:09'),
(3, 'mahletteferi16@gmail.com', '12345', '2025-01-27 08:52:36'),
(4, 'techtalkeyob@gmail.com', 'Hello i love your rooms and food', '2025-01-27 10:39:27'),
(5, 'Kminte94@gmail.com', 'hana negn megbachu temechtognal', '2025-03-04 03:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `food_orders`
--

CREATE TABLE `food_orders` (
  `order_id` int(11) NOT NULL,
  `transaction_ref` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_orders`
--

INSERT INTO `food_orders` (`order_id`, `transaction_ref`, `email`, `first_name`, `last_name`, `items`, `total_amount`, `order_date`, `status`) VALUES
(1, 'a557996c74fffed8195190dbc00bd75c', 'yared3113@gmail.com', 'Yared', 'Tesfu', '[{\"id\":\"2\",\"quantity\":\"1\"}]', '380.00', '2025-01-27 04:42:24', 'completed'),
(2, '64abaa0320599d44cfd23598ed12d6e4', 'mahletteferi16@gmail.com', 'Mahlet', 'Teferi', '[{\"id\":\"2\",\"quantity\":\"1\"},{\"id\":\"3\",\"quantity\":\"1\"}]', '700.00', '2025-01-27 04:47:00', 'pending'),
(3, '7444be25a3ecf93b2037fe5e94e2bdce', 'Kminte94@gmail.com', 'Mintesinot', 'Alemu', '[{\"id\":\"1\",\"quantity\":\"1\"}]', '310.00', '2025-01-27 09:57:33', 'completed'),
(4, '6de9c4b6c90ae33c65e8b12db750c0d1', 'techtalkeyob@gmail.com', 'Eyob', 'Solomon', '[{\"id\":\"2\",\"quantity\":\"2\"},{\"id\":\"70\",\"quantity\":\"1\"}]', '1060.00', '2025-01-27 10:37:46', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `course` varchar(30) DEFAULT NULL,
  `order_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `image`, `category`, `is_available`, `created_at`, `updated_at`, `course`, `order_count`) VALUES
(1, 'Avocado Salad', 'fresh sliced avocado, shredded lettuce, julienne tomato, onion, green chili with garlic dressing', '310.00', 'uploads/as.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 08:27:34', 'cold appetizer', NULL),
(2, 'Chicken Salad', 'marinated grilled small diced chicken, shredded lettuce, small diced onion, garlic, Tomato with tartar dressing', '380.00', 'uploads/cs.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 08:30:50', 'cold appetizer', NULL),
(3, 'Home Special Salad', 'cubed cut avocado, tomato, cucumber, onion, shredded lettuce, black and green olives, garlic and chopped parsley with lemon herbed dressing', '320.00', 'uploads/hss.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 08:32:36', 'cold appetizer', NULL),
(4, 'Mixed Salad', 'shredded lettuce, tomato, cucumber, green chili, carrot with vinaigrette dressing', '255.00', 'uploads/ms.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 08:35:17', 'cold appetizer', NULL),
(5, 'Tuna Salad', 'julienne cut of tomato, onion, cucumber, green chili, shredded lettuce, canned tuna, lemon vinaigrette dressing', '255.00', 'uploads/ts.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 08:36:40', 'cold appetizer', NULL),
(6, 'Carrot and Ginger Soup', 'blended carrot, ginger, garlic and onion simmered together and flavoured with hot sauce', '255.00', 'uploads/bea.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-01-27 10:45:03', 'hot appetizer', NULL),
(7, 'Chicken Cream Soup', 'creamy flavourful broth with small diced grilled chicken, table butter, garlic, milk', '305.00', 'uploads/de1.jpg', NULL, 1, '2025-01-27 04:10:39', '2025-03-04 04:02:08', 'hot appetizer', NULL),
(8, 'Fish Soup', 'fish broth simmered with cuped tilapia fish, garlic, onion, coriander, celery, fish spice', '290.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'hot appetizer', NULL),
(9, 'Minestrone Soup', 'small diced vegetables, carrot, zucchini, fresh beans, potato with pasta and simmered in an italian tomato broth', '250.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'hot appetizer', NULL),
(10, 'Oven Baked Lasagna', 'home made cooked lasagna pastes, layered with bolognaise sauce and a creamy white sauce, topping with grated mozzarella cheese', '670.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(11, 'Penne Bolognaise Sauce', 'saute garlic, minced lean meat, fresh puree of tomato, tomato, garlic, onion, celery, oregano, basil, bay leaf', '400.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(12, 'Penne Chicken Cream Sauce', 'marinated grilled chicken, table butter, milk, flour, mushroom, garlic, spaghetti', '510.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(13, 'Penne Tomato Sauce', 'fresh puree of tomato, garlic, onion, celery, oregano, basil, rosemary', '350.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(14, 'Penne Vegetable Sauce', 'plain boiled penne sauteed with seasonal fresh vegetables, carrot, zucchini, french beans, spinach, mushroom, onion, garlic, tomato', '350.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(15, 'Rice Bolognaise Sauce', 'saute garlic, minced lean meat, fresh puree of tomato, garlic, onion, celery, oregano, basil, bay leaf, rice', '400.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(16, 'Rice Chicken Cream Sauce', 'marinated grilled chicken, table butter, milk, flour, mushroom, garlic, rice', '510.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(17, 'Rice Tomato Sauce', 'fresh puree of tomato, garlic, onion, celery, oregano, basil, rosemary, rice', '255.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(18, 'Rice Vegetable Sauce', 'plain boiled basmati rice sauteed with seasonal fresh vegetables, carrot, zucchini, fresh beans, spinach, mushroom, onion, garlic, tomato', '350.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(19, 'Spaghetti Bolognaise Sauce', 'saute garlic, minced lean meat, fresh puree of tomato, garlic, onion, celery, oregano, basil, bay leaf, spaghetti', '400.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(20, 'Spaghetti Chicken Cream Sauce', 'marinated grilled chicken, table butter, milk, flour, mushroom, garlic, spaghetti', '510.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(21, 'Spaghetti Tomato Sauce', 'fresh puree of tomato, garlic, onion, celery, oregano, basil, rosemary, spaghetti', '350.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(22, 'Spaghetti Vegetable sauce', 'plain boiled spaghetti sauteed with seasonal fresh vegetables, carrot, zucchini, fresh beans, spinach, mushroom, onion, garlic, tomato', '350.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pasta dishes', NULL),
(23, 'Chicken Ala King', 'marinated grilled chicken, spaghetti or penne, cream mushroom sauce', '660.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'chicken corner', NULL),
(24, 'Chicken Curry Masala', 'cubed chicken breast, garlic, onion, ginger, coriander, hot chili, curry masala sauce, plain boiled rice, indian chapatti bread', '580.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'chicken corner', NULL),
(25, 'Chicken Fajitas', 'juicy chicken,  sweet chili sauce, garlic, green chili, tomato, tortilla bread, mayonnaise, guacamole(mashed avocado stir in onion, garlic, tomato, and lime juice), served on iron plate', '685.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'chicken corner', NULL),
(26, 'Grilled Chicken Breast', 'marinated chicken breast grilled both sides, brown mushroom sauce, creamy mushed potato, seasonal cooked vegetables', '600.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'chicken corner', NULL),
(27, 'Beef Cordon Blue', 'breaded beef fillet steak , sliced provolone cheese, smoked chicken, deep fried in hot fat, rice, vegetables', '735.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'beef corner', NULL),
(28, 'Beef Pepper Steak', 'garlic and soy marinated flat steak, crushed pepper, green salad, vinaigrette dressing, french fries', '595.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'beef corner', NULL),
(29, 'Mixed Grill with Vegetable Rice', 'assortment of grilled meats, mini beef fillet steak, fillet of perch and chicken breast, creamy mushed potato, steamed cooked vegetables', '795.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'beef corner', NULL),
(30, 'Sizzled Beef Steak', 'flat grilled beef fillet, brown sauce, served on iron plate, english chips', '645.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'beef corner', NULL),
(31, 'Fish Cutlet', 'marinated tilapia fish, flour, egg, bread crumps, deep fried in hot fat, french fries', '425.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'fish corner', NULL),
(32, 'Fish Gulash', 'cubed cut marinated tilapia fish, deep fried in hot fat, onion, tomato, green chili mixed in tomato sauce, plain boiled rice', '395.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'fish corner', NULL),
(33, 'Grilled Nile Perch', 'herb infused grilled nile perch fillet, lemon, garlic, parsley, butter sauce, roasted wedge potato, steamed seasonal vegetables', '635.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'fish corner', NULL),
(34, 'Grilled Tilapia Fish', 'grilled fillet of nile perch fillet marinated, garlic, lemon, coriander, french fries', '480.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'fish corner', NULL),
(35, 'Beef Burger', 'ground beef, onion, garlic, leek, egg, bread crumps, soy sauce, salt, pepper, french fries, grilled both side until cooked stuffed in burger bread', '535.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(36, 'Cheese Burger', 'ground beef, onion, garlic, leek, egg, bread crumps, soy sauce, salt, pepper, french fries, sliced provolone cheese, grilled both side until cooked stuffed in burger bread', '545.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(37, 'Chicken Burger', 'minced chicken meat, onion, garlic, leek, egg, bread crumps, soy sauce, salt, pepper, french fries, sliced provolone cheese, grilled both side until cooked stuffed in burger bread', '685.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(38, 'Egg Sandwich', 'flat egg omelet, baguette bread, ketchup, mayonnaise, french fries', '320.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(39, 'Fish and Chips', 'marinated tilapia fish, beer batter, deep fried in hot oil, french fries, ketchup', '445.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(40, 'Haile Special Burger', 'ground beef, onion, garlic, leek, egg, bread crumps, soy sauce, salt, pepper, french fries, flat omelet and cheese, grilled both side until cooked stuffed in burger bread', '595.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(41, 'Sodo Breeze Sandwich', 'juicy chicken or beef,  sweet chili sauce, brown baguette bread, mustard, mayonnaise, french fries', '650.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(42, 'Vegetable Wrap Sandwich', 'carrot, zucchini, french beans, spinach, mushroom, onion, garlic, tomato, tortilla bread, french fries', '400.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'snacks corner', NULL),
(43, 'BBQ Chicken Pizza', 'pizza sauce, mozzarella cheese, bbq chicken, tomato, green chili, olive fruit, oregano', '632.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(44, 'Beef Lovers Pizza', 'pizza sauce, mozzarella cheese, minced cooked beef, smoked sliced beef, tomato, green chili, olive fruit, oregano', '595.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(45, 'Haile Special Pizza', 'pizza sauce, mozzarella cheese, boiled sliced egg, tuna, bbq chicken, minced cooked beef, tomato, green chili, olive fruit, oregano', '660.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(46, 'Margarita Pizza', 'pizza sauce, mozzarella cheese, oregano', '570.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(47, 'Pizza Ala Tuna', 'pizza sauce, mozzarella cheese, tuna, tomato, green chili, olive fruit, oregano', '655.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(48, 'Vegetable Pizza', 'pizza sauce, mozzarella cheese, french beans, zucchini, carrot, tomato, green chili, olive fruit, oregano', '450.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'pizza corner', NULL),
(49, 'Chikina Tibs', 'marinated beef fillate meat, garlic, awaze(hot pepper), cooked untill tender, onion, cardamom, niter kibbeh(clarified butter), injera', '645.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(50, 'Doro Wot', 'spicy slow-cooked ethiopian chicken stew with finely chopped onion, garlic, berbere (hot chili powder), niter kibbeh(clarified butter), cardamom, boiled egg, ayib (homemade fresh cheese), injera', '725.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(51, 'Fasting Family Agelgel', 'assortment of ethiopian fasting foods(vegetarian foods), served on one mesob plate (a woven round wicker basket), shiro wot, mesir wot, azifa, suf fitfit, ater kik wot, senig karia, timatim lebleb, alicha atekilt wot, injera', '1390.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(52, 'Fasting Gomen', 'boiled collard greens, niter kibbeh(clarified butter), garlic, chili powder, cardamom, kocho(flat bread made from grated inset pulp), ayib (homemade fresh cheese)', '250.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(53, 'Fasting Non_Fasting Family Agelgel', 'assortment of ethiopian traditional foods, served on one mesob plate (a woven round wicker basket), doro wot, chikina tibs, gomen besiga, kitfo, ayib (homemade fresh cheese), injera, kocho(flat bread made from grated inset pulp)', '2400.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(54, 'Goat Tibs', 'marinated goat meat, garlic, awaze(hot pepper), cooked untill tender, onion, cardamom, niter kibbeh(clarified butter), injera', '775.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(55, 'Gomen Besiga', 'tender beef lion cut in to cube, collard greens, garlic, onion, green pepper, niter kibbeh(clarified butter), cardamom, injera', '480.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(56, 'Kitfo', 'spicy minced row beef, niter kibbeh(clarified butter), garlic, chili powder, cardamom, kocho(flat bread made from grated inset pulp), ayib (homemade fresh cheese)', '810.00', 'uploads/f1.jpg', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:14:33', 'ethiopian traditional food', NULL),
(57, 'Lamb Tibs', 'marinated lamb meat, garlic, awaze(hot pepper), cooked untill tender, onion, cardamom, niter kibbeh(clarified butter), injera', '775.00', 'uploads/f4.jpg', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:20:29', 'ethiopian traditional food', NULL),
(58, 'Shiro', 'mild thick pea stew enhanced by ethiopian seasonings, injera, garlic, green chili', '300.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 10:45:40', 'ethiopian traditional food', NULL),
(59, 'Bula Genfo', 'starchy white powder made from inset plant, cooked like stiff porridge, spicy butter sauce, niter kibbeh(clarified butter), garlic, chili powder, cardamom', '215.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(60, 'Continental Breakfast', 'sliced toasted bread, assortment of jams, honey, table butter, peanut butter, fresh fruit juice', '455.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(61, 'French toast', 'sliced loaf bread, beaten seasoned egg, deep fried in hot oil, honey', '255.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(62, 'Oats With Honey', 'boiled oats meal, milk, honey', '265.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(63, 'Omelet', 'beaten egg cooked with onion, tomato, green chili, sliced toasted bread', '280.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(64, 'Scramble Egg', 'beaten egg cooked with onion, onion, tomato, green chili, sliced toasted bread', '240.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(65, 'Tibs Firfir', 'stir fried beef cut in to strip, shredded pieces of injera, spiced hot sauce, onion, garlic, berbere (hot chili powder)', '445.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(66, 'Fasting Firfir', 'shredded pieces of injera, spiced hot sauce, onion, garlic, berbere (hot chili powder)', '320.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(67, 'Chechebsa', 'flat bread made from wheat flour shredded in to pieces, mild butter sauce, honey', '255.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'breakfast', NULL),
(68, 'Chicken Nugget', 'breaded and crispy fried chicken breast cut in to cube, french fries', '560.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'kid\'s corner', NULL),
(69, 'Beef Fried Rice', 'stir fried minced beef with rice, egg, vegetables, carrot, zucchini, french beans, onion, garlic', '445.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'kid\'s corner', NULL),
(70, 'Stir Fried Vegetable', 'steam cooked seasonal fresh vegetables, carrot, zucchini, french beans, spinach, mushroom, onion, garlic, tomato', '300.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'vegetarian corner', NULL),
(71, 'Vegetable Biryani', 'spicy and flavorful indian dish, basmati rice, carrot, zucchini, french beans, dry chili flakes, turmeric, coriander, indian chapatti bread, onion, garlic', '300.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'vegetarian corner', NULL),
(72, 'Fasting Gomen', 'boiled collard greens, niter kibbeh(clarified butter), garlic, chili powder, cardamom, kocho(flat bread made from grated inset pulp), ayib (homemade fresh cheese)', '300.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'ethiopian traditional food', NULL),
(73, 'Vegetables Rice', 'plain boiled basmati rice sauteed with seasonal fresh vegetables, carrot, zucchini, french beans, spinach, mushroom, onion, garlic, tomato', '300.00', '', NULL, 1, '2025-01-27 04:10:40', '2025-01-27 04:10:40', 'vegetarian corner', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `transaction_ref` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `room_type` varchar(255) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `transaction_ref`, `email`, `first_name`, `last_name`, `room_type`, `check_in_date`, `check_out_date`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(3, 'e2592a770bd7311f4e32c66960ccb465', 'yared3113@gmail.com', '', '', '1', '2025-01-27', '2025-01-28', '6500.00', 'checked out', '2025-01-27 04:41:31', '2025-01-27 04:42:01'),
(4, '04c018499c7330b53c2b5b18a2565f88', 'Kminte94@gmail.com', '', '', '2', '2025-01-27', '2025-01-28', '5000.00', 'checked in', '2025-01-27 09:56:27', '2025-01-27 09:56:27'),
(6, 'caef44e42bb8f0bf3c4e4086aa4aa97d', 'techtalkeyob@gmail.com', '', '', '1', '2025-01-27', '2025-01-29', '13000.00', 'checked out', '2025-01-27 10:30:36', '2025-01-27 10:33:04'),
(8, 'b6cf731e10e5d19cd3951dc6b5025ab8', 'Kminte94@gmail.com', '', '', '1', '2025-01-27', '2025-01-28', '6500.00', 'checked out', '2025-01-27 11:10:30', '2025-03-04 03:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `r_id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` varchar(220) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `amenities` varchar(255) DEFAULT NULL,
  `total_rooms` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_available` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`r_id`, `type_id`, `status`, `description`, `price`, `capacity`, `amenities`, `total_rooms`, `created_at`, `updated_at`, `total_available`) VALUES
(1, 1, NULL, 'Junior Suit With City view', '6500.00', 2, 'wifi , Mountain view, fridge , room service', 25, '2025-01-27 04:34:45', '2025-03-04 03:57:17', 18),
(2, 3, NULL, 'Twin Room With City View', '7500.00', 2, 'wifi , Mountain view', 6, '2025-01-27 06:55:56', '2025-03-04 04:00:45', NULL),
(3, 2, NULL, 'Standard Room with city view', '5000.00', 2, 'wifi , Mountain view', 30, '2025-01-27 09:23:40', '2025-01-27 09:56:33', -2),
(4, 4, NULL, 'semi junior suit with city view', '6000.00', 2, 'wifi , Mountain view, fridge , room service', 6, '2025-01-27 09:24:27', '2025-01-27 09:24:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

CREATE TABLE `room_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(60) DEFAULT NULL,
  `total_rooms` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`type_id`, `type_name`, `total_rooms`) VALUES
(1, 'Junior Suite', 5),
(2, 'Semi Junior Suite', 5),
(3, 'Standard Room', 40),
(4, 'Twin Room', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiration` timestamp NULL DEFAULT NULL,
  `preferences` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`, `username`, `firstname`, `lastname`, `created_at`, `updated_at`, `last_login`, `status`, `otp`, `otp_expiration`, `preferences`) VALUES
(1, 'soberlyhigh@gmail.com', '$2y$10$pgwC0qz0xYYftVgd5YoBR.UllzBVrexr2Xm9g6nVwI2rGwB81Layy', 'admin', 'SoberlyHigh', 'Mikiyas', 'Woubshet', '2025-01-27 04:05:54', '2025-01-27 09:22:47', NULL, 'active', NULL, NULL, NULL),
(2, 'yared3113@gmail.com', '$2y$10$Vou8KpAAdSwgG4epWMjehuaxjQQtaSJLXdLPDQJ9JgZ5/8m9SViGG', 'h_chef', 'Yared', 'Yared', 'Tesfu', '2025-01-27 04:23:22', '2025-01-27 04:43:24', NULL, 'active', NULL, NULL, NULL),
(5, 'mahletteferi16@gmail.com', '$2y$10$vBfxmCHjGHqHq9/hH3DL5egq4en2NUYl85T5ZnAcpJOafMtfooULS', 'waiter', 'mahlet', 'Mahlet', 'Teferi', '2025-01-27 04:45:58', '2025-01-27 09:20:01', NULL, 'active', NULL, NULL, 'appetizer'),
(8, 'tekestealena283@gmail.com', '$2y$10$ZbUrTVEo/gE9koxWs9kDpOnH4fR529kgjkfv60KEv/H6XS3EhXesy', 'guest', 'Duni', 'Tekeste', 'Alena', '2025-01-27 07:31:40', '2025-01-27 07:31:40', NULL, 'active', NULL, NULL, NULL),
(12, 'Kminte94@gmail.com', '$2y$10$yPCsabuEe3TqCvSxVYp4WeLWqRpWj1n.iPjGXpHZwxYChyCnoaqjS', 'guest', 'Minte', 'Mintesinot', 'Alemu', '2025-01-27 07:56:39', '2025-01-27 09:32:38', NULL, 'active', NULL, NULL, 'vegetarian'),
(13, 'edene3435@gmail.com', '$2y$10$Jd1hE/RiM/3WcAXFs8zq5.DODC.Isvc2dfxSxbIkJeh5pXFAFZrUi', 'f_head', 'Edu', 'Eden', 'Alemu', '2025-01-27 08:40:13', '2025-01-27 09:22:08', NULL, 'active', NULL, NULL, NULL),
(14, 'techtalkeyob@gmail.com', '$2y$10$TjER1Z59mWRJyC8Giv7QB.5TBOFcfaeXx2n72ozpObIv2cZbSuCca', 'guest', ' Eyob sol', 'Eyob', 'Solomon', '2025-01-27 10:26:19', '2025-01-27 11:25:29', NULL, 'active', NULL, NULL, 'vegetarian');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `food_orders`
--
ALTER TABLE `food_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_ref` (`transaction_ref`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `food_orders`
--
ALTER TABLE `food_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
