-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Apr 19, 2024 at 06:04 PM
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
-- Database: `online_shopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(8, 4, 1, 2),
(9, 4, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `payment_method` enum('COD','UPI') NOT NULL,
  `payment_status` enum('Pending','Success','Failed') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `shipping_address`, `shipping_phone`, `payment_method`, `payment_status`, `order_date`) VALUES
(21, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Pending', '2024-04-17 17:30:45'),
(22, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Pending', '2024-04-17 17:31:03'),
(23, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Pending', '2024-04-17 17:39:22'),
(24, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Pending', '2024-04-17 17:39:55'),
(25, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Pending', '2024-04-17 17:43:37'),
(26, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Success', '2024-04-17 17:49:24'),
(27, 3, 46000, 'asdas', 'asdasdas', 'UPI', 'Success', '2024-04-17 17:56:29'),
(28, 3, 46000, 'asdasd', 'asd', 'UPI', 'Success', '2024-04-17 18:00:12'),
(29, 3, 46000, 'asdasd', 'asd', 'UPI', 'Success', '2024-04-17 18:01:58'),
(30, 3, 46000, 'asdasd', 'asd', 'COD', 'Pending', '2024-04-17 18:03:19'),
(31, 3, 349959, 'asdas', 'sadasd', 'COD', 'Pending', '2024-04-19 14:29:52'),
(32, 3, 53000, 'pune', '99870584838', 'COD', 'Pending', '2024-04-19 14:34:04'),
(33, 3, 53000, 'pune', '99870584838', 'UPI', 'Pending', '2024-04-19 14:34:13'),
(34, 3, 156000, 'pune', '99870584838', 'COD', 'Pending', '2024-04-19 14:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 3, 90000.00),
(2, 2, 1, 1, 90000.00),
(3, 3, 1, 1, 90000.00),
(4, 4, 1, 1, 90000.00),
(5, 5, 1, 3, 90000.00),
(6, 5, 2, 1, 125000.00),
(7, 6, 4, 2, 46000.00),
(8, 6, 3, 1, 150000.00),
(9, 7, 3, 1, 150000.00),
(10, 7, 4, 1, 46000.00),
(11, 10, 3, 1, 150000.00),
(12, 10, 2, 1, 125000.00),
(13, 10, 4, 1, 46000.00),
(14, 12, 2, 1, 125000.00),
(15, 13, 2, 1, 125000.00),
(16, 15, 4, 1, 46000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `stock_quantity`, `image_url`) VALUES
(1, 'Apple iphone 14', 'Mobile Phones', 90000.00, 10, 'https://cdn.dxomark.com/wp-content/uploads/medias/post-126771/Apple-iPhone-14-Pro_FINAL_featured-image-packshot-review-1.jpg'),
(2, 'Nothing Phone 2', 'Mobile Phones', 125000.00, 3, 'https://fdn2.gsmarena.com/vv/pics/nothing/nothing-phone2-2.jpg'),
(3, 'Samsung s24 Ultra', 'Mobile Phones', 150000.00, 6, 'https://media-ik.croma.com/prod/https://media.croma.com/image/upload/v1705641004/Croma%20Assets/Communication/Mobiles/Images/303835_fqoe8t.png?tr=w-640'),
(4, 'Oneplus 12R\r\n', 'Mobile Phones', 46000.00, 5, 'https://i.gadgets360cdn.com/products/large/oneplus-12-green-651x800-1701772960.jpg?downsize=*:360'),
(5, 'Nike Tr13 Men\'s', 'Shoes', 6000.00, 12, 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/ca79d356-421f-4a96-a823-b695f15c7a34/in-season-tr-13-workout-shoes-BDTlPf.png'),
(6, 'Adidas Daily 3.0', 'Shoes', 7000.00, 8, 'https://assets.adidas.com/images/w_600,f_auto,q_auto/505b6a0aae264129bc4cae92011007b9_9366/Daily_3.0_Shoes_White_GX1752_01_standard.jpg'),
(7, 'Puma X-ray', 'Shoes', 3000.00, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSmsgeIwjT0hPpdQuvgvTowjg64PdU7mZG8XTO1WCmUEWIt4KvPhCAoAwdBCjR11CppQM&usqp=CAU'),
(8, 'Blackberrys Oxford', 'Shoes', 5500.00, 4, 'https://blackberrys.com/cdn/shop/files/textured-leather-oxford-shoes-in-tan-lebum-blackberrys-clothing-1.jpg?v=1685949012'),
(9, 'Highlander Textured Shirt', 'Men\'s Clothing', 800.00, 20, 'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcStITm2DUk2k3vlaETgSDXpDn69w23_0zvGdt1aNXecilgBN2UCQyFp-ll5-mvI282gLcl2vFVlGjEglV_vHkZmELjQBxXC5j2iLzmO7x8'),
(10, 'Wrong Men\'s Cargo pants', 'Men\'s Clothing', 959.00, 18, 'https://www.beyoung.in/api/cache/catalog/products/cargo_joggers/cream_cargo_men_jogger_pants_comfort_view_03_04_2024_700x933.jpg'),
(11, 'Raymonds Formal Shirt', 'Men\'s Clothing', 1200.00, 6, 'https://i.pinimg.com/736x/c1/bd/b3/c1bdb3a6e2246594ff03342db2f069f3.jpg'),
(12, 'Allen Solly Formal Pants ', 'Men\'s Clothing', 600.00, 7, 'https://m.media-amazon.com/images/I/41brDJqY3LL.jpg'),
(13, 'Nolabels Formal Dress', 'Women\'s Clothing', 650.00, 9, 'https://nolabels.in/cdn/shop/files/Task-2767640-1-2-4K.png?v=1698210044&width=1080'),
(14, 'Printed Flare Dress', 'Women\'s Clothing', 890.00, 3, 'https://assets.ajio.com/medias/sys_master/root/20230718/DElg/64b6be4aeebac147fc7727a1/-473Wx593H-466368522-black-MODEL.jpg'),
(15, 'Kurti', 'Women\'s Clothing', 750.00, 16, 'https://4.imimg.com/data4/SU/CO/MY-15490136/ladies-fashion-wear-500x500.jpg'),
(16, 'Red Designer Saree ', 'Women\'s Clothing', 2500.00, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtiNnNuMBp8r42RaO_CMBzPwbN0jyGuAmfnGaZ1wGvFQ&s'),
(17, 'Macbook Pro ', 'Electronics', 160000.00, 14, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRkj-2KbXH5GPDhFI1ECDqUy5teVn8hwv9HN6rwJdjcgA&s'),
(18, 'Samsung Watch 5', 'Electronics', 3500.00, 30, 'https://suprememobiles.in/cdn/shop/products/Samsung-Watch-5-LTE-Now-Available.jpg?v=1702107237'),
(19, 'Airpods Pro ', 'Electronics', 2000.00, 50, 'https://5.imimg.com/data5/SELLER/Default/2022/11/SV/TU/OS/112483306/06-500x500.png'),
(20, 'LG UHD Smart TV', 'Electronics', 55000.00, 9, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSPtRTOp57YmIPNLzR8-kt5CzYx7fvQAKhilVsZI-zHQ&s');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `address`, `phone`) VALUES
(1, 'mayur', 'mayur@121', 'mayurbmali80@gmail.com', 'pune maharashtra', '9970949933'),
(2, 'raj', '$2y$10$fRbwJU5lDcHM0WrC1CrP3.VayZYEsEupL7JWdPxphGF74zAWJxLlG', 'raj121@gmail.com', 'satara maharashtra', '9941320035'),
(3, 'shiv', '$2y$10$Sz34ZtXFM1FfQvAT0V.PkubMko/dsuNF0ISFyKo0FFRmZnDoPfeo2', 'shiv@asha.com', 'Navi Mumbai', '9874652443'),
(4, 'pankaj', '$2y$10$UKl6guSZRq7HlVawYC3S8O2CueAUNIj2p3O5icKvXrG/BhWgyTYo.', 'pankaj9211@gmail.com', 'shivajinagar pune', '8967543422');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
