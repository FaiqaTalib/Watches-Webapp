-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 10:48 AM
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
-- Database: `admin_pannel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_description` text DEFAULT NULL,
  `c_image` varchar(255) DEFAULT NULL,
  `c_status` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`, `c_description`, `c_image`, `c_status`) VALUES
(15, 'Luxury Watches', 'Experience timeless elegance with our luxury watches, crafted for those who value precision, prestige, and refined aesthetics. Each piece reflects superior craftsmanship and iconic design.', 'Luxury_wristwatch_on_202604240052.jpeg', 'Active'),
(16, 'Premium Watches', 'Our premium watches combine modern design with reliable performance, offering a perfect balance of sophistication and everyday functionality.', 'Wristwatch_with_leather_202604240054.jpeg', 'Active'),
(17, 'Sports Luxury Watches', 'Chrono Master X ek luxury sports watch hai jo chronograph functionality aur rugged design ke sath aati hai. Yeh water-resistant hai aur outdoor activities ke liye ideal hai. Bold look aur strong performance iska highlight hai.', 'mGXuTglSpS6pl7R_2P9TMvhYCnY5NJHVgYbeZ2WuXEimFuiR8N23N-XEG3HMWlDo9bDKc91malNf1agMRG2_psSxu2STdUidDYVUn-w9bYIC20-ZE2m2O073OAGDXsObWx6R16VEI5dgedPEXhpfkPFs0els63ptSDnSGqZdeV8.jpeg', 'Active'),
(18, 'Ultra Luxury Watches', 'Diamond Royal X ek ultra-luxury watch hai jo premium diamond-studded bezel aur gold finish ke sath aati hai. Yeh watch high-class personality ko reflect karti hai aur special occasions ke liye perfect choice hai. Precision movement aur scratch-resistant sapphire glass isay long-lasting banata hai.', 'N1ai3m1uGUfsQ4LTqh-Jq2KmPMo9WFJQxBF1M1cO7X1QRxS8Nv3ANLPzflKuvL-M-JXkbnUQb9gRp7TUPe3PZWo397oV-J7caVQ-w3vGLSuO6N6LrcOlEh-gDSmLSMTaCxgbg5X-E77mS7VPDYDSYBd1UuOqKHgHUI8z2nI3qm4.jpeg', 'Active'),
(19, 'Executive Business Watches', 'Executive Prime ek refined business watch hai jo corporate professionals ke liye design ki gayi hai. Iska sleek design aur polished stainless steel strap isay meetings aur office wear ke liye ideal banata hai.', 'qGgTykx0weJOVqPtRA3meurZ7IpE-S63HZys4yAF4gHdC-7fbucBWBEMszGUKKoHE--rMa5E4yNirUyGk8sOampg3uUI3hjhoPkgdZUOwXcjJe8yxxLVg2ksH0CsdE4r_hOc8ah2zkxJGHrRfqp0SbZge5-2S6RrbrEwm8eD2__78cArVaPQ-oAlIEEzRzYW.jpeg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `mess` text DEFAULT NULL,
  `review` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `phone`, `mess`, `review`) VALUES
(7, 'Moiz Rao', 'raomoiz566@gmail.com', 0, 'wow its very amazing sites  and very cheap prices', '⭐⭐⭐⭐⭐'),
(8, 'salman', 'raomoiz566@gmail.com', 0, 'very good site', '⭐⭐⭐');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `payment_method`, `subtotal`, `tax`, `shipping`, `total`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TZ-20260430-9400', 'Ali Ali', 'ali@gmail.com', '03022415089', 'abc, karachi, 75230, Pakistan', 'cod', 2460.00, 123.00, 0.00, 2583.00, '', 'delivered', '2026-04-30 20:32:06', '2026-05-03 07:17:47'),
(2, 'TZ-20260430-4107', 'Amna Anum', 'amna@gmail.com', '03022415056', 'abc, karachi, 75230, Pakistan', 'cod', 440.00, 22.00, 0.00, 462.00, '', 'delivered', '2026-04-30 20:36:38', '2026-04-30 20:45:08'),
(3, 'TZ-20260501-9664', 'Moiz Rao', 'raomoiz566@gmail.com', '03150341447', 'Shah Facial Colony, Karachi, 05444, Pakistan', 'cod', 899.00, 44.95, 0.00, 943.95, '', 'delivered', '2026-05-01 11:13:36', '2026-05-03 08:43:25'),
(4, 'TZ-20260501-6840', 'Moiz Rao', 'raomoiz566@gmail.com', '03150341447', 'C11 Shah Faisal Colony Number 3, Al Falah Society Peoples Colony Shah Faisal Shah Faisal Colony, Shah Faisal Town, 75230, Pakistan, Shah Faisal Colony, 75350, Pakistan', 'cod', 4493.94, 224.70, 0.00, 4718.64, '', 'delivered', '2026-05-01 11:15:36', '2026-05-02 05:51:09'),
(5, 'TZ-20260501-7452', 'Moiz Rao', 'raomoiz566@gmail.com', '03150341447', 'Shah Facial Colony, Karachi, 05444, Pakistan', 'bank_transfer', 2246.97, 112.35, 0.00, 2359.32, '', 'delivered', '2026-05-01 11:29:59', '2026-05-03 07:17:43'),
(6, 'TZ-20260503-8089', 'kariz Rao', 'kariz@gmail.com', '03150341447', 'Shah Facial Colony, Karachi, 05444, Pakistan', 'bank_transfer', 6690.00, 334.50, 0.00, 7024.50, '', 'delivered', '2026-05-03 08:37:25', '2026-05-03 08:43:20'),
(7, 'TZ-20260503-8817', 'Moiz Rao', 'raomoiz566@gmail.com', '03150341447', 'Shah Faisal Colony, BOWLING GREEN, 10004, United States', 'cod', 4240.00, 212.00, 0.00, 4452.00, '', 'delivered', '2026-05-03 08:39:15', '2026-05-03 08:42:43'),
(8, 'TZ-20260503-8418', 'Moiz Rao', 'raomoiz566@gmail.com', '03150341447', 'Shah Facial Colony, Karachi, 05444, Pakistan', 'bank_transfer', 24200.00, 1210.00, 0.00, 25410.00, '', 'pending', '2026-05-03 08:45:33', '2026-05-03 08:45:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(1, 1, 6, 3, 820.00, 2460.00),
(2, 2, 5, 2, 220.00, 440.00),
(3, 3, 2, 1, 899.00, 899.00),
(4, 4, 3, 6, 748.99, 4493.94),
(5, 5, 3, 3, 748.99, 2246.97),
(6, 6, 6, 7, 820.00, 5740.00),
(7, 6, 9, 1, 950.00, 950.00),
(8, 7, 19, 8, 530.00, 4240.00),
(9, 8, 15, 11, 2200.00, 24200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) DEFAULT NULL,
  `p_desc` text DEFAULT NULL,
  `p_price` decimal(7,2) DEFAULT NULL,
  `p_stock` int(11) DEFAULT NULL,
  `p_image` varchar(255) DEFAULT NULL,
  `p_cid` int(11) DEFAULT NULL,
  `p_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `p_name`, `p_desc`, `p_price`, `p_stock`, `p_image`, `p_cid`, `p_status`) VALUES
(2, 'Royal Chrono Gold Edition', 'A masterpiece of craftsmanship, featuring a polished gold finish with a precision chronograph dial. Designed for those who demand prestige and perfection.', 899.00, 50, 'Gold_chronograph_watch_202604240102.jpeg', 15, 'Active'),
(3, 'Midnight Prestige Black Steel', 'Sleek and bold, this black steel timepiece reflects modern luxury with a powerful presence and flawless finishing.', 748.99, 500, 'Matte_black_luxury_202604240105.jpeg', 15, 'Active'),
(4, 'Urban Edge Leather Watch', 'A stylish everyday watch with a genuine leather strap, offering comfort and refined simplicity.', 199.00, 100, 'Leather_wristwatch_with_202604240112.jpeg', 16, 'Active'),
(5, 'Silver Motion Classic', 'A clean and versatile silver watch designed for both formal and casual wear.', 220.00, 150, 'Silver_wristwatch_minimal_202604240116.jpeg', 16, 'Active'),
(6, 'Elite Sapphire Blue Edition', 'A striking blue dial protected by sapphire glass, combining durability with luxury aesthetics.', 820.00, 58, 'Luxury_watch_blue_202604240238.jpeg', 15, 'Active'),
(7, 'Executive Prime Black', 'A sleek black watch designed for professionals who value elegance and authority', 390.00, 500, 'Executive_wristwatch_on_desk_202605021044.jpeg', 19, 'Active'),
(8, 'Corporate Silver Edge', 'silver business wristwatch, minimal design, clean background, soft lighting, modern professional aesthetic', 290.00, 49, 'Silver_wristwatch_minimal_design_202605021047.jpeg', 19, 'Active'),
(9, 'Royal Chrono Gold X1', 'An iconic gold chronograph watch featuring multi-dial precision and a bold luxury finish.', 950.00, 500, 'PpZkvkiBXj8ufV2QaMF8M2xWAO4l27LnLZ1DnNSJiBpZ30uu9tBAwgwNsaTAD933t6uJi8JWFDB93_5qU0ub29OYTJj-cegLJMijDqKGKIpxxVBW6gPHOKnxU4R0fbGodPvGBW8vgr8QWcevNo5ZDL9hru5CAZazWaGZnoIpJdOX0bRFk1BxYjCjDJAmEIrl.jpeg', 18, 'Active'),
(11, 'Royal Chrono Gold X1', 'An iconic gold chronograph watch featuring multi-dial precision and a bold luxury finish.', 950.00, 500, 'PpZkvkiBXj8ufV2QaMF8M2xWAO4l27LnLZ1DnNSJiBpZ30uu9tBAwgwNsaTAD933t6uJi8JWFDB93_5qU0ub29OYTJj-cegLJMijDqKGKIpxxVBW6gPHOKnxU4R0fbGodPvGBW8vgr8QWcevNo5ZDL9hru5CAZazWaGZnoIpJdOX0bRFk1BxYjCjDJAmEIrl.jpeg', 18, 'Active'),
(12, 'Royal Chrono Diamond Gold', 'Enhanced with diamond accents, delivering brilliance and luxury beyond expectations.', 1250.00, 10, 'Gold_luxury_watch_diamond_bezel_202605031311.jpeg', 18, 'Active'),
(13, 'Corporate Silver Edge', 'Minimal and refined, perfect for meetings and everyday professional wear.', 200.00, 100, 'Silver_wristwatch_minimal_design_202605031314.jpeg', 19, 'Active'),
(14, 'Executive Leather Pro', 'Crafted with premium leather, offering comfort with executive elegance.', 260.00, 100, 'Leather_strap_watch_office_envir…_202605031315.jpeg', 19, 'Active'),
(15, 'Platinum Crown Edition', 'platinum luxury watch, black background, cinematic lighting, ultra detailed macro, 8K realistic, premium style', 2200.00, 10, 'Platinum_luxury_watch_macro_202605031316.jpeg', 18, 'Active'),
(16, 'Sapphire Infinity Edition', 'A stunning sapphire dial watch that reflects elegance and perfection.', 1950.00, 20, 'Sapphire_dial_luxury_watch_202605031318 (1).jpeg', 18, 'Active'),
(17, 'Royal Black Gold Fusion', 'A fusion of black and gold delivering bold luxury aesthetics.', 2400.00, 15, 'Black_gold_luxury_wristwatch_202605031319.jpeg', 18, 'Active'),
(18, 'Titan Sport Chrono', 'A high-performance chronograph watch built for both luxury and durability.', 550.00, 50, 'Luxury_sport_chronograph_watch_o…_202605031321.jpeg', 17, 'Active'),
(19, 'Extreme Steel Sport', 'A rugged yet refined watch designed for extreme conditions and luxury appeal.', 530.00, 50, 'Steel_sport_luxury_watch_202605031322.jpeg', 17, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `name`, `email`, `phone`, `password`) VALUES
(11, 'Moiz Rao', 'raomoiz566@gmail.com', 2147483647, '$2y$10$PaAdxs5gAJHMQQ/mqmgHAeRTmjF8tlDlh5xwM/jPLqsbHWWjy0bFi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `phone`) VALUES
(1, 'Moiz Rao', 'admin@gmail.com', '$2y$10$Dcu/hPAdANQBZJPXZN1QFeyzvSAgUajkhV7ffUUQoX7vZnJXxXgy6', 'admin', '2026-04-29 14:06:04', NULL),
(2, 'Moiz Rao', 'raomoiz566@gmail.com', '$2y$10$WdanfFSrIdAIUSKjOq6WGe.kIi8NjYHJSWCh9cZZlO6n875o3dqW2', '', '2026-04-29 14:17:10', NULL),
(0, 'Moiz Rao', 'raomoiz@gmail.com', '$2y$10$3fCuiTSpxoQgMw1tS7yFlu/ebKW8EdJe2bzIjbRt6UcVREL4x/21u', '', '2026-05-03 07:46:25', NULL),
(0, 'salman', 'salman@gmail.com', '$2y$10$3doCK4YdFSiqN8IgDF5imeeVA88sVCu6D43p6XXYbYSSSJrxMR8CS', '', '2026-05-03 08:31:48', NULL),
(0, 'kariz', 'kariz@gmail.com', '$2y$10$dqHojsZPgTVYzU6VDhVXSOsnumMUzGS/nJxZKywZjEtlEN41nbMIS', 'user', '2026-05-03 08:36:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `p_cid` (`p_cid`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`p_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`p_cid`) REFERENCES `category` (`c_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
