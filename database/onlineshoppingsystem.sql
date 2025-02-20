-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 05:05 AM
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
-- Database: `onlineshoppingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `mobile_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`, `mobile_number`) VALUES
(1, 'admin@gmail.com', '$2y$10$bstswVOaRPizI3xCKfLPye49PK83f4.kICe82qcTTn.E/ZlZ26ZJW', 'admin@gmail.com', '2024-11-10 09:57:16', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog`
--

CREATE TABLE `tbl_blog` (
  `blog_id` int(11) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_content` text NOT NULL,
  `blog_post_date` date NOT NULL,
  `blog_category` varchar(100) DEFAULT NULL,
  `blog_image_path` varchar(255) DEFAULT NULL,
  `blog_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blog_status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blog`
--

INSERT INTO `tbl_blog` (`blog_id`, `blog_title`, `blog_content`, `blog_post_date`, `blog_category`, `blog_image_path`, `blog_created_at`, `blog_status`) VALUES
(1, 'Building an Online Shopping System in PHP: A Step-by-Step Guide', 'Building an Online Shopping System is an essential project for web developers. This guide walks through the key features, technology stack, and implementation details needed to create a fully functional e-commerce platform using PHP and MySQL.\r\n\r\nKey Features of the Online Shopping System\r\n✅ User Registration & Authentication\r\n✅ Product & Category Management\r\n✅ Shopping Cart & Checkout\r\n✅ Payment Gateway Integration\r\n✅ Order & Invoice Management', '2025-01-30', ' E-commerce, Web Development', 'blog1.png', '2025-02-19 18:53:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_masters`
--

CREATE TABLE `tbl_cart_masters` (
  `cart_id` int(11) NOT NULL,
  `cart_product_id` int(11) NOT NULL,
  `cart_product_qty` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `cart_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) DEFAULT NULL,
  `category_status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`, `category_image`, `category_status`, `created_at`) VALUES
(1, 'Men\'s Clothing', 'men.jpg', 1, '2025-02-19 17:08:43'),
(2, 'Women\'s Clothing', 'women.png', 1, '2025-02-19 17:08:54'),
(3, 'Footwear', 'footwear.png', 1, '2025-02-19 17:09:03'),
(4, 'Watches & Accessories', 'watches.png', 1, '2025-02-19 17:09:25'),
(5, 'Grocery & Essentials', 'veg.png', 1, '2025-02-19 17:09:32'),
(7, 'Sports & Fitness', 'sport.png', 1, '2025-02-19 17:29:25'),
(8, 'Books & Stationery', 'book.png', 1, '2025-02-19 17:29:45'),
(9, 'Smart Home & Automation', 'smart.jpg', 1, '2025-02-19 17:31:59'),
(10, 'Pet Supplies', 'pet.jpg', 1, '2025-02-19 17:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `contact_message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`contact_id`, `contact_name`, `contact_email`, `contact_phone`, `contact_message`, `created_at`) VALUES
(1, 'Kiona Atkinson', 'cyhisus@mailinator.com', '+1 (504) 907-77', 'Ipsum dolor in exer', '2025-02-20 04:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_phone` varchar(15) DEFAULT NULL,
  `customer_image` varchar(255) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `customer_name`, `customer_email`, `customer_password`, `customer_phone`, `customer_image`, `customer_address`, `customer_status`, `created_at`) VALUES
(1, 'Gwen Stacy', 'gwen@stacy.com', '$2y$10$ZFmfcvUF8ZUsADSi9LFae.TcqFibqVhGZVVqndQxVkSL6MItjr1ii', '7304767697', '', 'Baramati', 1, '2025-02-19 17:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_offer`
--

CREATE TABLE `tbl_offer` (
  `offer_id` int(11) NOT NULL,
  `offer_category` varchar(255) NOT NULL,
  `offer_description` text NOT NULL,
  `offer_image` varchar(255) DEFAULT NULL,
  `offer_dis` decimal(10,2) NOT NULL,
  `offer_status` tinyint(1) NOT NULL DEFAULT 1,
  `offer_created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_offer`
--

INSERT INTO `tbl_offer` (`offer_id`, `offer_category`, `offer_description`, `offer_image`, `offer_dis`, `offer_status`, `offer_created_at`) VALUES
(1, '1', 'Test', '', 10.00, 1, '2025-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_status` text DEFAULT '1',
  `total_price` decimal(10,2) NOT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `payment_method` int(11) DEFAULT 1,
  `payment_status` int(11) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `customer_id`, `order_date`, `order_status`, `total_price`, `shipping_address`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-02-19 23:45:15', '3', 12896.95, 'Baramati', 1, 0, '2025-02-19 23:45:15', '2025-02-20 00:18:17'),
(2, 1, '2025-02-20 09:13:06', '3', 2793.45, 'Baramati, Pune', 1, 0, '2025-02-20 09:13:06', '2025-02-20 09:13:44'),
(3, 1, '2025-02-20 09:30:42', '3', 2499.00, 'Commodo labore deser', 1, 0, '2025-02-20 09:30:42', '2025-02-20 09:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_items`
--

CREATE TABLE `tbl_order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_items`
--

INSERT INTO `tbl_order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`) VALUES
(1, 1, 7, 2, 3.00, '2025-02-19 18:15:15'),
(2, 1, 6, 1, 4.00, '2025-02-19 18:15:15'),
(3, 1, 4, 1, 5.00, '2025-02-19 18:15:15'),
(4, 2, 5, 1, 1.00, '2025-02-20 03:43:06'),
(5, 2, 7, 1, 1.00, '2025-02-20 03:43:06'),
(6, 3, 8, 1, 2.00, '2025-02-20 04:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_stock` int(11) DEFAULT 0,
  `product_dis` varchar(255) DEFAULT NULL,
  `product_dis_value` decimal(10,2) DEFAULT NULL,
  `product_status` int(11) DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `product_description`, `product_image`, `product_price`, `product_stock`, `product_dis`, `product_dis_value`, `product_status`, `category_id`, `created_at`) VALUES
(1, 'Elegant Floral Maxi Dress', 'A beautiful floral maxi dress with a stylish belt.', 'ElegantFloralMaxiDress.png', 1499.00, 50, '10', 149.90, 1, 2, '2025-02-19 17:38:44'),
(2, 'Casual Denim Jacket', 'A trendy denim jacket with a classic blue wash.', 'denim.jpg', 1999.00, 30, '0', 0.00, 1, 2, '2025-02-19 17:39:37'),
(3, 'Stylish Party Gown', 'A shimmering party gown with intricate embroidery.', 'stylish.png', 3499.00, 20, '15', 524.85, 1, 2, '2025-02-19 17:40:54'),
(4, 'Classic Formal Suit', 'A premium classic formal suit designed for the modern gentleman who values elegance and sophistication. This well-tailored suit features a sharp slim-fit design, stylish lapels, and a perfectly coordinated tie, making it ideal for business meetings, formal events, and weddings. Made from high-quality fabric, it ensures maximum comfort while exuding a luxurious appearance. The suit comes in various color options like navy blue, charcoal gray, and classic black, allowing you to choose the perfect style for any occasion. Whether you\'re attending a corporate event or a special gathering, this versatile and fashionable suit will leave a lasting impression.', 'one_product.png', 5999.00, 20, '10', 599.90, 1, 1, '2025-02-19 17:48:57'),
(5, 'Casual Checked Shirt', 'A stylish casual checked shirt designed for men who love effortless fashion. Crafted from premium cotton fabric, this lightweight and breathable shirt provides all-day comfort. Featuring a modern checkered pattern in blue and white, this shirt is perfect for casual outings, office wear, or weekend getaways. Its versatile design allows it to be worn as a standalone piece or layered over a t-shirt for a relaxed and trendy look. The button-down collar and full sleeves add a touch of sophistication, making it an excellent choice for both semi-formal and casual settings. Pair it with jeans or chinos to achieve a classic yet modern style.', 'two_product.png', 1299.00, 40, '10', 129.90, 1, 1, '2025-02-19 17:49:34'),
(6, '	Trendy Leather Jacket', 'A rugged yet stylish leather jacket that redefines men\'s fashion with its bold and edgy design. This jacket is made from premium-grade faux or genuine leather, ensuring durability and a sleek, polished finish. The modern zipper details, multiple pockets, and well-fitted silhouette give it a contemporary look, perfect for bikers, fashion enthusiasts, and urban trendsetters. The inner lining is soft and breathable, providing comfort while maintaining warmth during colder seasons. Available in classic black, brown, and navy, this iconic leather jacket complements a variety of outfits, from casual t-shirts to semi-formal shirts.', 'three_product.png', 4999.00, 15, '15', 749.85, 1, 1, '2025-02-19 17:50:19'),
(7, 'Comfortable Cotton T-Shirt', 'This versatile and lightweight cotton t-shirt is a must-have for every wardrobe. Made from 100% premium cotton, it offers a soft and breathable feel, ensuring all-day comfort. The minimalist design makes it perfect for casual outings, gym wear, or layering under jackets and hoodies. Available in multiple colors, including black, white, gray, and navy blue, this t-shirt pairs well with jeans, shorts, or joggers for an effortlessly stylish look. The regular fit and round neckline provide a classic yet modern appeal, making it an essential piece for men who prefer simplicity with a touch of elegance.', 'founr.png', 2499.00, 10, '35', 874.65, 1, 1, '2025-02-19 17:51:06'),
(8, 'Slim Fit Jeans	', 'A pair of modern slim-fit jeans designed to provide both style and comfort. These jeans feature a slightly stretchable fabric, offering flexibility for all-day wear. The dark denim wash with subtle fading gives it a contemporary look, making it perfect for casual outings, office wear, and evening gatherings. The mid-rise waist and tapered leg fit enhance the body’s shape, providing a sleek and polished appearance. With multiple pockets, a durable button closure, and a zip fly, these jeans combine functionality with fashion. Whether paired with t-shirts, shirts, or jackets, these jeans are a go-to option for a refined and stylish look.', 'jeans.png', 2499.00, 3, '0', 0.00, 1, 1, '2025-02-19 17:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `rating_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_rating` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ratings`
--

INSERT INTO `tbl_ratings` (`rating_id`, `order_id`, `product_id`, `customer_id`, `rating`, `review_rating`, `description`, `created_at`) VALUES
(1, 1, 7, 1, 4, '', 'Comfert Is Real Here', '2025-02-19 23:59:03'),
(2, 2, 7, 1, 3, '', 'Nice', '2025-02-20 09:14:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist_masters`
--

CREATE TABLE `tbl_wishlist_masters` (
  `wishlist_id` int(11) NOT NULL,
  `wishlist_product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `wishlist_status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_wishlist_masters`
--

INSERT INTO `tbl_wishlist_masters` (`wishlist_id`, `wishlist_product_id`, `customer_id`, `wishlist_status`, `created_at`, `updated_at`) VALUES
(3, 7, 1, 'active', '2025-02-20 03:38:04', '2025-02-20 03:38:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `tbl_cart_masters`
--
ALTER TABLE `tbl_cart_masters`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `customer_email` (`customer_email`);

--
-- Indexes for table `tbl_offer`
--
ALTER TABLE `tbl_offer`
  ADD PRIMARY KEY (`offer_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `tbl_wishlist_masters`
--
ALTER TABLE `tbl_wishlist_masters`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_blog`
--
ALTER TABLE `tbl_blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cart_masters`
--
ALTER TABLE `tbl_cart_masters`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_offer`
--
ALTER TABLE `tbl_offer`
  MODIFY `offer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_wishlist_masters`
--
ALTER TABLE `tbl_wishlist_masters`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
