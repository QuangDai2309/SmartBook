-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 30, 2025 lúc 02:55 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `smartbook4`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authors`
--

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(36, 'Đồng Hoa'),
(37, 'Tào Đình'),
(38, 'Tâm Phạm'),
(39, 'Hồng Thứ Bắc'),
(40, 'Dã Hạc'),
(41, 'Bắc Phong Vị Miên'),
(42, 'Mộc Tô Lý'),
(43, 'Lạc Lâm Lang'),
(44, 'Nhị Hỉ'),
(45, 'Tử Vu'),
(46, 'Lục Lục Lục Tương'),
(47, 'Tây Vực Nhi'),
(49, 'Mộc Qua Hoàng'),
(51, 'Thiên Kim'),
(52, 'Nạp Lan Lãng Nguyệt'),
(53, 'Lê Bảo Ngọc'),
(54, 'Ngụy Phong Hoa'),
(55, 'Trường Lê'),
(56, 'Lê Ngọc Mai');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `book_id` bigint(20) UNSIGNED DEFAULT NULL,
  `priority` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `image`, `link`, `title`, `description`, `book_id`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(2, 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.banner_web_v2/0/0/0/3988.jpg?v=1&w=1920&h=600', NULL, 'gsgfhfh', 'Đây là banner sử dụng file', 1, 2, 1, '2025-06-23 19:01:08', '2025-06-30 05:53:05'),
(4, 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.banner_web_v2/0/0/0/4189.jpg?v=1&w=1920&h=600', NULL, 'test', 'test', 3, 1, 1, '2025-06-23 19:33:58', '2025-06-30 05:52:55'),
(5, 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.banner_web_v2/0/0/0/3400.jpg?v=1&w=1920&h=600', NULL, 'test', 'test', 3, 3, 1, '2025-06-23 19:41:53', '2025-06-30 05:53:14'),
(18, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751269595/banners/php7575_dvagpt.jpg', NULL, 'Đại', '123', NULL, 4, 1, '2025-06-30 00:46:35', '2025-06-30 05:53:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `publisher_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `is_physical` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0: Ebook\r\n1: Sách giấy',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rating_avg` decimal(2,1) NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `title`, `description`, `cover_image`, `author_id`, `publisher_id`, `category_id`, `is_physical`, `price`, `stock`, `views`, `likes`, `created_at`, `updated_at`, `rating_avg`) VALUES
(1, 'Thanh xuân bắt đầu từ khi gặp anh', '<p>Bảy năm trước họ chia tay, anh biến mất không lời từ biệt.</p><p>Bảy năm sau, cô chuẩn bị kết hôn anh lại xuất hiện, dùng mọi thủ đoạn để ép cô lấy anh.</p><p>Một tờ chứng nhận kết hôn buộc chặt hai con người tưởng chừng đã mãi mãi mất nhau.</p><p>Và từ đó về sau cô bé lọ lem trở thành nữ hoàng... Hoắc Miên, cô gái giản dị với chỉ số thông minh cực cao đã hút hồn Tần Sở - Tổng giám đốc tập đoàn GK đẹp trai giàu có.</p><p>Tình yêu từ thuở thiếu thời trải qua bao sóng gió mới kết trái ngọt nhưng họ nào đâu biết, giông tố mới chỉ bắt đầu mà thôi…</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/186.jpg?v=3&w=400&h=492', 44, 20, 17, 1, 99000.00, 5, 12, 0, '2025-06-23 01:46:58', '2025-06-29 08:37:57', 0.0),
(2, 'Cô vợ nhỏ của ngài Phó', '<p>Chuyên gia đàm phán quốc tế Giang Phù chết vì bị hãm hại.</p><p>Khi tỉnh lại, cô phát hiện mình đã sống lại trong thân xác một nữ sinh viên vừa đính hôn.</p><p>Lần đầu tiên chạm trán với vị hôn phu, giọng Phó Hề Đình lạnh như băng và đậm mùi chết chóc: “Ngoan ngoãn thì giữ lại, khó bảo thì vứt đi.”</p><p>Lần thứ hai giáp mặt, Giang Phù đứng trong hội trường Đại học Thủ Đô tham gia cuộc thi tranh biện dành cho sinh viên quốc tế. Nhìn Phó Hề Đình làm giám khảo ở dưới sân khấu, cô cất giọng mạch lạc, hỏi: “Xin hỏi anh Phó đây, đối với anh hôn nhân có ý nghĩa như thế nào?”</p><p>Phó Hề Đình đáp: “Lợi ích.”</p><p>Nghe đồn Phó Hề Đình - Thái tử gia giới thương nghiệp đã cưới một cô vợ xinh đẹp.</p><p>Nhưng họ không biết rằng trong đêm tân hôn, cô vợ xinh đẹp ấy cầm một con dao lạnh lẽo kề cổ anh, giọng điệu hệt như Diêm Vương: “Năm 2009, chuyên gia đàm phán quốc tế Giang Phù dẫn các thành viên trong nhóm đến nước Đông để đàm phán, trên đường về lại gặp tai nạn trên không, chuyện này có liên quan gì tới anh?”</p><p>Lòng Phó Hề Đình run lên, suy đoán nhiều ngày qua giờ đã trở thành sự thật. Anh nhìn Giang Phù bằng ánh mắt bất đắc dĩ: “Chuyện đó là do tôi làm.”</p><p>Trước khi kết hôn, cô là quân cờ vô dụng bị khống chế trong tay.</p><p>Sau khi kết hôn, cô là liều thuốc không thể cai nghiện.</p><p>Nghe đồn “yêu nữ” nhà họ Giang không có tài cán gì.</p><p>Giang Phù: ??? Mình nên diễn kiểu gì đây?</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.book/0/0/1/51961.jpg?v=1&w=480&h=700', 39, 20, 17, 1, 149000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:19:14', 0.0),
(3, 'Cưng chiều cô vợ quân nhân', '<p>“Số 1” là một sát thủ chuyên nghiệp. Trong một lần thực hiện nhiệm vụ ám sát, cô bị gián điệp bắn chết và sống lại trong cơ thể Nhiếp Nhiên – một tân binh trong quân ngũ.</p><p>Nhiếp Nhiên là một cô gái yếu đuối cả về thể chất lẫn tinh thần, thường xuyên bị người khác bắt nạt. Sau khi Nhiếp Nhiên chết vì bị đồng đội hãm hại, “số 1” thay cô gái đó tiếp tục trải qua cuộc sống rèn luyện gian khổ. Sát thủ hàng đầu rơi vào hoàn cảnh quân ngũ như cá gặp nước, Nhiếp Nhiên hoàn toàn biến thành một con người khác với trước đây.</p><p>Thành tích vượt trội đáng kinh ngạc khiến Nhiếp Nhiên có cơ hội được thực hiện một nhiệm vụ quan trọng. Nhiệm vụ khó khăn khiến cô suýt bị tóm, khi vừa thở phào vì thoát thân được, cô không ngờ rằng mình lại trở thành mục tiêu cho một kẻ khác…</p><p>&nbsp;</p>', '	https://307a0e78.vws.vegacdn.vn/view/v2/image/img.book/0/0/0/23697.jpg?v=2&w=480&h=700', 43, 17, 12, 0, 199000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:20:11', 0.0),
(4, 'Cúi mình trước em', '<p>Lục Miểu bấm đốt ngón tay, bình tĩnh nói: \"Tôi xem rồi, ba ngày nữa anh sẽ toi đời.\"</p><p>Cậu hai Cố chẳng hề hoảng: \"Cảm ơn lời hay ý đẹp của cô, tôi sống thế cũng đủ rồi.\"</p><p>Nói xong quay lưng đi tìm ngay thầy phong thuỷ để chọn một chỗ chôn đẹp như mơ, phong thủy đắc địa, núi tựa lưng, sông trước mặt.</p><p>Lục Miểu bước tới cản lại: \"Từ từ đã, mảng này tôi quen việc lắm rồi, không để \'nước phù sa chảy ruộng ngoài\' đâu.\"</p><p>Ba ngày trôi qua, rồi lại ba ngày nữa, Cậu hai Cố bắt đầu mất kiên nhẫn: \"Rốt cuộc bao giờ tôi mới chết?\"</p><p>Lục Miểu vẫn bình tĩnh: \"Đừng vội, sắp rồi đấy!\"</p><p>Kết quả là ba tháng sau, Cậu hai Cố vẫn sống khoẻ như vâm, mặt mày rạng rỡ, sức sống dồi dào. Một hôm anh chặn Lục Miểu ở góc tường, mặt nghiêm túc nói: \"Cô xem, cô cứu mạng tôi, vậy giờ phải có trách nhiệm với tôi chứ?\"</p><p>Lục Miểu – đại thần huyền học đỉnh cấp, không biết thế nào lại xuyên không thành cô gái nhỏ bố không yêu mẹ không thương, còn được tặng kèm combo “vị hôn phu sắp chết”.</p><p>Bố mẹ thì mong cô sớm chết cho xong, cả nhà họ Cố không ai ưa, toàn thành phố cũng chỉ chờ ngày cô mất mặt.</p><p>Nhưng Lục Miểu không phải người bình thường thường. Tay trái vẽ bùa, tay phải xem phong thủy, cô nói mưa là mưa, gọi gió là có gió.</p><p>Các đại lão khắp nơi ùn ùn kéo đến: \"Nhà họ Cố đưa bao nhiêu sính lễ, chúng tôi đưa gấp mười lần!\"</p><p>Cả đám anh chị em nhà họ Cố đồng thanh: \"Biến!\"</p><p>Cậu hai Cố cười hớn hở: \"Không phiền mọi người bận tâm, chúng tôi đăng ký kết hôn rồi.\"</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/499.jpg?v=1&w=400&h=492', 47, 19, 12, 0, 149000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:22:19', 0.0),
(5, 'Cực hạn mê đắm', '<p>Lê Ảnh là một cô nàng bình thường. Từ Kính Tây lại là cậu chủ nhà họ Từ quyền thế ngút trời. Vào một đêm tuyết phủ, trước cửa chiếc xe Mercedes G63, Lê Ảnh kiễng chân lên, nhẹ nhàng kề sát Từ Kính Tây, chụm tay giúp anh châm điếu thuốc. Người đàn ông ngậm điếu thuốc trên môi bỗng nghiêng người về phía cô, khuôn mặt tuấn tú khẽ cúi xuống dưới ánh đèn phản chiếu. Đốm lửa lập lòe ở đầu điếu thuốc ngăn cách hai người. Cô thấy đôi mắt vừa hững hờ vừa trầm lặng của anh hơi nhướng lên: “Cô muốn gì?” Lê Ảnh: “Những thứ mà chỉ mình anh mới cho tôi được.” Có người từng cảnh báo cô rằng: “Vị Từ Kính Tây kia vốn lớn lên trong thế giới ngập vàng son, lòng đầy ham muốn quyền lực tối cao. Vậy nên đối với kiểu người như anh ta, tình yêu là thứ không đáng giá nhất. Cô lấy gì để đánh đổi danh phận với anh ta?” Việc giữ cô ở bên cạnh mình cũng chỉ là thú vui tiêu khiển trong lúc Từ Kính Tây cảm thấy hiu quạnh. Anh gặp dịp thì chơi, còn Lê Ảnh cũng chẳng mưu cầu danh phận. Do đó đến lúc rời khỏi Bắc Kinh, cô lập tức tổ chức một cuộc triển lãm tranh. Nhưng khi Lê Ảnh vừa thu dọn hành lý và bước vào thang máy, thân hình cao ráo của Từ Kính Tây đã đứng ngay lối đi. Anh móc lấy sợi dây chuyền thanh mảnh trước cổ Lê Ảnh. Khi cô lùi về phía sau, anh lại kéo cô về phía mình. *** Đêm hôm đó là lễ tình nhân nên rất khó đặt được một phòng trong khách sạn cao cấp và xa xỉ. Vậy mà có người lại bắt gặp anh Từ bao toàn bộ khách sạn BVG. Ấn tượng sâu đậm nhất trong lòng Lê Ảnh chính là người đàn ông quỳ một chân trên giường trong chiếc áo choàng tắm lỏng lẻo. Anh cắn nắp bút, cầm chiếc bút máy ngòi vàng viết lên ba chữ theo thể chữ thư pháp Sấu Kim Thể trên xương quai xanh của Lê Ảnh: Từ Kính Tây.&nbsp;</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/478.jpg?v=1&w=480&h=710', 40, 20, 12, 1, 119000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:23:28', 0.0),
(6, 'Thủ tướng, mời xem đơn ly hôn!', '<p>Chuyện gì sẽ xảy ra khi Thủ tướng kết hôn cùng Nữ hoàng? Một người nắm giữ kinh tế, một người đại diện cho hình ảnh cả một nước, giữa hai con người đó thật sự có tình yêu sao?</p><p>Trên một trang web có đăng tải năm tấm hình của Thủ tướng và Nữ hoàng, phần đông công dân đều ca ngợi và ngưỡng mộ gia đình nhỏ hạnh phúc ấy. Duy chỉ có vài người ngỡ ngàng khi nhận ra, từ tấm thứ nhất đến tấm thứ tư, ánh mắt đong đầy tình cảm của Nữ hoàng đều hướng về Thủ tướng, còn Thủ tướng lại chăm chăm vào công việc. Ồ may quá, tấm thứ năm Nữ hoàng đã không còn nhìn Thủ tướng nữa, phải thế chứ, Nữ hoàng xinh đẹp đến vậy cơ mà! Nhưng…</p><p>Nhưng… tấm thứ năm, thứ Nữ hoàng nhìn ngắm lại là bóng lưng đổ trên thảm cỏ của người con trai tài giỏi kia. Ôi, Nữ hoàng, đến bao giờ Người mới đệ đơn ly hôn người đàn ông luôn tôn trọng và đối xử với Người như một “người cùng chung lý tưởng” kia?</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/334.jpg?v=2&w=400&h=492', 42, 17, 12, 0, 179000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:24:53', 0.0),
(8, 'Tên anh là thời gian', '<p>Hang đá Đôn Hoàng số 0 chưa từng công bố với bên ngoài, tương truyền rằng những bức bích họa bên trong có thể thay đổi bất cứ lúc nào, không ai có thể khôi phục, vậy mà vẫn thu hút được một nhà phục hồi văn vật bí ẩn…</p><p>Từ đây, nhịp sống bình thường của Thịnh Đường đã bị kéo lệch.</p><p>“Đường Tiểu Thất, đừng ăn cơm nữa, lấy cho tôi số liệu lớp địa trượng, đến số thập phân thứ ba sau dấu phẩy.”</p><p>“Đường Tiểu Thất, đừng ngủ nữa, tỷ lệ pha loãng nhựa cao su không đúng, pha chế lại cho tôi.”</p><p>Đường Tiểu Thất… Cô xúi quẩy trở thành người cộng sự thứ bảy của anh ta, rất không phù hợp với hình tượng hung tàn quỷ quyệt của cô!</p><p>Anh ta thật sự nghĩ mình là Fan thần chắc? Đó là thần tượng của cô, nhà phục hồi văn vật truyền kỳ trong giới bích họa, được mệnh danh là Doctor Fan, “bác sỹ ngoại khoa” thời gian, nhân vật bàn tay vàng.</p><p>Cho đến một ngày nào đó, cô tận mắt nhìn thấy khi ký tên anh để lại một chữ “Fan”…</p><p>Thịnh Đường tự hủy hoại hình tượng bản thân, chạy đến ôm chân: “Fan thần, anh thiếu cái gì, cần cái gì cứ thoải mái dặn dò em ạ.”<br>Hiếm có dịp anh không độc miệng, bật cười: “Còn thiếu một cô bạn gái.”</p><p>...<br>Sa mạc hoang lạnh dưới núi Tam Nguy, Con đường tơ lụa ngàn năm biến đổi. Bảo vệ những dấu tích của thời gian, người là niềm tin thành kính nhất trên con đường cô độc của tôi.</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/321.jpg?v=2&w=400&h=492', 46, 20, 17, 0, 239000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:21:18', 0.0),
(9, 'Thiếu soái, chào anh!', '<p>Sau khi Nguyễn Tích Thời chết, cô bị người nhà phân xác thành từng mảnh, trở thành một cô hồn vất vưởng không thể siêu sinh. Sau đó, cô trông thấy vị Đốc quân vốn luôn nổi tiếng tàn bạo kia đến quỳ trước bia mộ mình; tận mắt thấy anh góp nhặt từng mảnh xác cô rồi đưa về nhà làm lễ Minh Hôn với cô; cuối cùng, tận mắt nhìn thấy anh tự lóc thịt lóc da mình để cho cô cơ hội luân hồi.</p><p>Kiếp này sống lại, cô may mắn có được khả năng trảm thiên diệt địa. Một đôi mắt Âm Dương nhìn thấu tà ác dương gian. Nguyễn Tích Thời giành lại gia sản vốn thuộc về mình, xử lý mẹ kế độc ác, tự làm giàu bằng đôi tay của mình, tự thề phải bảo vệ bằng được người đàn ông kia.</p><p>Chỉ không ngờ, vị thiếu soái tàn nhẫn và độc ác kia còn đáng sợ hơn cả ma quỷ: \"Phu nhân đã cứu anh, anh không có gì để cảm ơn, chỉ đành lấy thân báo đáp.\"</p><p>Waka trân trọng giới thiệu bộ truyện ngôn tình trùng sinh, dân quốc<strong> \"Thiếu soái, chào anh!\"</strong> của tác giả Ngỗng Trời Xù Lông.</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.book/0/0/1/49357.jpg?v=1&w=480&h=700', 41, 20, 12, 1, 99000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:26:29', 0.0),
(10, 'Vợ yêu nhà thủ trưởng', '<p>Hàn Dao là một cô gái sống ở vùng nông thôn, ôm giấc mộng cao cả. Là cô con gái bị gia tộc họ Hàn vứt bỏ, nhưng cuộc sống thì trôi chảy thuận lợi, vì nhiệt huyết và khát vọng cống hiến cho tổ quốc, cô dấn thân vào quân đội. Phó Thiếu Lê, Thiếu tá lục quân, đại Đội trưởng đội đặc công, con trai độc nhất của gia tộc quân nhân, tài giỏi hơn người, bên cạnh không thiếu người theo đuổi, nhưng chỉ dành trọn trái tim cho cô. “Anh thích em như đạn bay khỏi nòng, một phát trí mạng!” “Anh thích em như quân hiệu trên đỉnh đầu, lấp lánh hào quang!” “Anh thích em như kính chào quốc kỳ mỗi sớm mai ló dạng!” Đây là lời hứa giữa họ, cũng là dáng hình tình yêu của họ. Trong chiến hỏa, đẹp nhất chính là nụ cười của họ.... Xem thêm</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.retail_book/0/0/0/353.jpg?v=2&w=400&h=492', 46, 19, 17, 0, 139000.00, 5, 0, 0, '2025-06-23 01:46:58', '2025-06-29 08:14:26', 0.0),
(11, 'Gió xuân rực lửa', '<p>Tình yêu của anh tựa cơn gió thổi nơi đồng hoang vu bát ngát, mãnh liệt mà dịu dàng.<br>Quý Bắc Chu, đội trưởng khu bảo tồn động vật hoang dã, là người có tác phong tự do, tính tình phóng khoáng, khó gần, không dễ chọc và cũng chẳng dễ chung đụng.<br>Sau một chuyến công tác, nghe đâu anh có bạn gái rồi mà mọi người không khỏi cảm thán:<br>“Không biết cô gái nào mắt mù vậy?”<br>Một ngày nọ, trong khu bảo tồn xuất hiện một cô gái nhỏ nhắn, mi cong mắt sáng, dịu dàng lại quyến rũ.<br>Cô nói: “Tôi đến thăm bạn trai.”<br>Lúc ấy, Quý Bắc Chu đang ngậm điếu thuốc dựa người vào xe việt dã, dáng vẻ lười nhác, bất cần đời, vừa nhả khói thuốc vừa dạy dỗ cấp dưới, nghe điện thoại xong liền chạy biến..<br>Không có lệnh của anh, không ai dám rời khỏi vị trí. Kết quả, trời tối mà chỉ thấy người nào đó dắt một cô gái đi tới.<br>Nhìn nhóm người đứng xếp hàng ngay ngắn, cô tò mò hỏi: “Muộn thế này rồi, họ đang làm gì vậy?”<br>Quý Bắc Chu nhếch môi cười: “Có lẽ cũng đến ngắm sao như chúng ta thôi.”<br>Mọi người: “...”<br>Rồi mọi người còn tận mắt chứng kiến đội trưởng nhà mình cúi đầu, khẽ hỏi cô gái ấy:<br>“Em thích ngắm sao hay là thích ngắm anh hơn?”<br>Bấy giờ, ai nấy mới bừng tỉnh, hóa ra chính họ mới là những kẻ mù mắt!<br>Waka trân trọng giới thiệu câu chuyện tình ngọt ngào cuồng nhiệt “Gió xuân rực lửa” - tác giả Nguyệt Sơ Giảo Giảo!</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.book/0/0/1/50965.jpg?v=1&w=480&h=700', 41, 19, 17, 0, 239000.00, 5, 0, 0, '2025-06-25 23:12:14', '2025-06-29 08:17:15', 0.0),
(12, 'Xuyên nhanh - Cứu rỗi nam phụ', '<p>Các nam phụ bị nữ chính lợi dụng rồi ruồng rẫy không bao giờ được yêu thương và trân trọng, chỉ có thể trở thành bàn đạp cho tình yêu của nhân vật chính. Điều này làm các độc giả bất bình đến nỗi họ ước gì mình có thể hóa thân thành chiến binh công lý đấu tranh đòi chính nghĩa.</p><p>Nay “cộng đồng người yếu thế” ấy đã có người chống lưng. Nhiệm vụ xuyên qua các thế giới để cứu rỗi nam phụ đã trở thành nhiệm vụ chủ yếu trong thế giới thịnh hành công nghệ giả lập, các nam phụ cũng nghênh đón mùa xuân của đời mình!</p><p>Đường Ngọc Phỉ vốn là quan chấp hành hàng đầu ưu tú nhất Huyễn Thế, vậy mà sau một lần bị cho là phạm phải sai lầm nghiêm trọng, cô đã đánh mất đi vị thế của mình.</p><p>Kể từ đó, Đường Ngọc Phỉ chỉ có thể nhận những nhiệm vụ oái oăm, bước lên con đường không có lối về, bao gồm cứu rỗi kẻ điên, chinh phục tổng tài bí ẩn, nhiệt tình theo đuổi Thái tử bị bỏ rơi, vân vân và mây mây…</p><p>Để quay trở lại đỉnh vinh quang trước kia của mình, cô nhịn!</p><p>Waka trân trọng giới thiệu tiểu thuyết <strong>Xuyên nhanh - Cứu rỗi nam phụ</strong> - Tác giả <strong>Cổn Kim</strong>!</p>', 'https://307a0e78.vws.vegacdn.vn/view/v2/image/img.book/0/0/1/51571.jpg?v=1&w=480&h=700', 37, 17, 17, 1, 199000.00, 5, 0, 0, '2025-06-25 23:12:32', '2025-06-29 08:16:07', 0.0),
(17, 'Boxset Trường Tương Tư - Bộ 3 cuốn (Tái bản 2024)', NULL, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751207686/book_covers/hfxxgsvv2qwxxhyc3my2.jpg', 36, 17, 12, 0, 699000.00, 5, 0, 0, '2025-06-29 07:34:45', '2025-06-29 07:34:45', 0.0),
(18, 'Yêu Anh Hơn Cả Tử Thần (Tái Bản 2024)', NULL, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751208283/book_covers/wj4ps7zazfm6gax0a18h.jpg', 37, 18, 12, 0, 99000.00, 5, 0, 0, '2025-06-29 07:44:42', '2025-06-29 07:44:42', 0.0),
(19, 'Vẽ Em Bằng Màu Nỗi Nhớ (Tái Bản 2024)', NULL, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751208375/book_covers/fvvyemduracchf46dluw.png', 38, 19, 12, 0, 149000.00, 5, 0, 0, '2025-06-29 07:46:15', '2025-06-29 07:46:15', 0.0),
(20, 'Đập nồi bán sắt đi học - Tập 1+2', NULL, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751208704/book_covers/vsnnpg01gxxgmiuzgprt.png', 39, 20, 14, 0, 350000.00, 5, 0, 0, '2025-06-29 07:51:44', '2025-06-29 07:51:44', 0.0),
(21, 'Chờ trăng lên', '<p>Người ở xứ Lục tỉnh thủa đấy trường kháo nhau câu nói: Nhất Sỹ, nhì Phương, tam Xường, tứ Hoả, ngũ Minh. Cốt là để nói năm vị thương nhân của đất này lúc bấy giờ, ai nấy tài sản nhiều vô kể, thuộc hàng giàu có nhất nhì Đông Dương.</p><p>Chờ trăng lên là câu chuyện tình yêu kì lạ được ghi chép lại, lưu giữ trong cuốn gia phả của phú hộ ngũ Minh hay còn được biết là điền chủ Trịnh Thế Minh. Ông Minh gốc ở Hà Châu, có cô con út đến tuổi trăng tròn nức tiếng xa gần vì xinh đẹp mỹ miều lại tài cao, học rộng. Khi vừa đến tuổi dựng vợ gả chồng, công tử khắp xứ Lục tỉnh đều mang sinh lễ đến cửa ngỏ lời, theo nhau mà đến đất cùng tịch như Hà Châu cũng chỉ để rước được giai nhân qua cửa.</p><p>Chiều đấy ở huyện thành này, nhìn thấy tán cây trước nhà đang dần xum xuê cành lá, đàn yến theo nhau lũ lượt kéo về. Mấy đôi cá trong hồ sen cũng lập lờ mặt nước, tung tăng đớp từng bọt sóng như muốn báo hiệu ngày xuân sắp về. Lối mòn nhà ông ngũ Minh cũng đã in dấu giày kẻ không siết vậy mà quý nữ nhà ông vẫn chẳng đoái hoài.</p><p>Ông Minh nghĩ không ổn bèn gọi cô út nhà mình lên hỏi.</p><p>“Con gái cưng của ba, rốt cuộc là con muốn gả cho ai?”</p><p>“Thưa ba, con muốn lấy cô Dạ Thi nhà thầy Chí!”</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751208956/book_covers/skemtrzqvq9qfz2o5ki5.png', 40, 19, 14, 0, 179000.00, 5, 0, 0, '2025-06-29 07:55:56', '2025-06-29 07:55:56', 0.0),
(22, 'Anh đến cùng ánh sao trời', '<p>Vô tình trở thành nạn nhân duy nhất sống sót trong vụ án giết người liên hoàn vào 10 năm trước, Giản Thù luôn sống trong nỗi ám ảnh và sợ hãi vô hình. 10 năm sau, với thân hình bốc lửa, gương mặt xinh đẹp cùng với chỗ dựa là người anh trai mà Giản Thù đã trở thành một diễn viên tiềm năng.</p><p>Tuy nhiên, giới giải trí với vô vàn mưu tính và cạm bẫy đã khiến cuộc sống của Giản Thù trở nên bế tắc. Đúng vào lúc này, cô vô tình gặp lại Phó Thời Lẫm, người cảnh sát năm xưa đã phụ trách vụ án và cứu được cô. Anh đến đúng lúc như một ánh sao trời cứu rỗi linh hồn cô.</p><p>Để theo đuổi anh cảnh sát lạnh lùng, dũng mãnh kia, Giản Thù đã dày công tính toán, đồng thời cũng trải qua vô vàn khó khăn. Mà Phó Thời Lẫm, nhiệm vụ của anh chỉ dừng lại ở việc bảo vệ nhân chứng cuối cùng, cũng như điều tra ra kẻ thủ ác năm xưa.</p><p>Một người coi đối phương là ánh sáng cứu rỗi cuộc đời mình, người còn lại một mực tuân thủ nguyên tắc và trách nhiệm. Liệu mối quan hệ giữa hai người họ có đơn thuần chỉ dừng lại là cảnh sát và nhân chứng vụ án?</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209083/book_covers/nk79wdvrweue9npow5ob.png', 41, 20, 12, 0, 133000.00, 5, 0, 0, '2025-06-29 07:58:02', '2025-06-29 07:58:02', 0.0),
(23, 'Người tìm xác', '<p>• Tên tác phẩm: Người tìm xác</p><p>• Tác giả: Lạc Lâm Lang</p><p>• Thể loại: Linh dị, trinh thám, huyền ảo</p><p>• Dịch giả: Thú Lạ</p><p>• Số tập: hiện đang xuất bản đến tập 6</p><p>• Đơn vị phát hành: Etabooks</p><p>• Nhà xuất bản liên kết: Nhà xuất bản Hà Nội, Nhà xuất bản Dân trí</p><p>• Cân nặng: 600g/cuốn</p><p>• Năm phát hành: 2025</p><p>• Số trang:</p><p>- Tập 1: 516</p><p>- Tập 2: 504</p><p>- Tập 3: 384</p><p>- Tập 4: 328</p><p>- Tập 5: 468</p><p>- Tập 6: 496</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209457/book_covers/bnssio1rsnbfc33swvki.png', 43, 17, 16, 0, 730000.00, 5, 0, 0, '2025-06-29 08:04:17', '2025-06-29 08:04:17', 0.0),
(24, 'Yêu kiều', '<p>Châu Dịch là tay công tử ăn chơi có tiếng trong giới, ai ai cũng nghĩ hắn chỉ quan tâm đến việc lên giường chứ chẳng hề có cảm xúc gì. Tới ngày nọ, một đoạn video được tung ra, Châu Dịch giống như một tín đồ ngoan đạo, nắm chặt cổ tay thon dài của một người phụ nữ, ánh mắt ngập tràn sự say mê: \"Khương Nghênh, xin em hãy nhìn anh...\"</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209669/book_covers/rib2ymsqtdcqa27odzuj.png', 44, 20, 17, 0, 235000.00, 5, 0, 0, '2025-06-29 08:07:49', '2025-06-29 08:07:49', 0.0),
(25, 'Sơ Cửu của Lục Hào', '<p>Cô sinh viên Lục Dao vô tình bị cuốn vào một vụ án. Từ kẻ tình nghi trở thành người hỗ trợ cảnh sát phá án, sự có mặt của các yếu tố tâm linh, bói toán, phong thủy trong các vụ án đã khiến Lục Dao như cá gặp nước, phát huy hết khả năng mà cô học được từ chính ông nội mình - một thầy bói nức tiếng gần xa.</p><p>Chàng cảnh sát Hạ Thần Phong là một người vô cùng chính trực, lý trí, trước giờ chỉ tin vào bằng chứng, không tin vào tâm linh. Chẳng ngờ, sự xuất hiện của Lục Dao đã hoàn toàn làm thay đổi nhận thức của anh.</p><p>Từ không dám lại gần đến dần dần đón nhận, Lục Dao đã hoàn toàn bị thu hút bởi cốt cách và sự dịu dàng của Hạ Thần Phong.</p><p>Từ hoài nghi, khó tin đến tôn trọng và tin tưởng, Hạ Thần Phong đã hoàn toàn đón nhận và tin tưởng vào khả năng của Lục Dao.</p><p>Theo chân các sự kiện tâm linh, Lục Dao và Hạ Thần Phong từng bước bị cuốn vào hàng loạt vụ án chứa đựng nhiều điều bí ẩn, đồng thời ở chúng như có sợi dây liên kết, cùng chỉ đến một chân tướng không ai ngờ.</p><p>Những yếu tố tâm linh luôn là điều mà khoa học chưa thể lý giải, chính vì thế có những kẻ đã lợi dụng điều đó để thao túng sự thật, mưu cầu quyền lực, thậm chí chỉ để chứng tỏ bản thân mà làm những điều điên cuồng.</p><p>Từng lớp từng lớp chân tướng được mở ra, ân oán thế hệ trước dần dần lộ rõ. Trong cuộc đấu đá này còn chứa biết bao chân tướng, biết bao người phải hy sinh?</p><p>Cái kết nào dành cho một gia tộc bói toán từng vang danh hiển hách? Kết cục nào cho câu chuyện tình chớm nở đã phải đối mặt với đầy âm mưu và toan tính?</p><p>Waka trân trọng giới thiệu tác phẩm ngôn tình trinh thám kết hợp với yếu tố tâm linh huyền bí, phong thủy, bói toán - Sơ Cửu của Lục Hào - tác giả Tử Vu.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209762/book_covers/fcflikgehfmcc16qxyod.png', 45, 20, 12, 0, 339000.00, 5, 0, 0, '2025-06-29 08:09:21', '2025-06-29 08:09:21', 0.0),
(26, 'Bảo vệ siêu sao của tôi', '<p>Lục Diên, một thực tập sinh hạng bét, trên mạng hay tỏ vẻ dễ thương nhưng thực chất lại là một chàng trai lạnh lùng.</p><p>Một ngày nọ, anh phát hiện bản thân được Hoa Xán - một họa sĩ vẽ fanart nổi tiếng nhắm trúng.</p><p>Những bức hình fanart do Hoa Xán vẽ giúp cho anh nổi tiếng và có được vị trí ra mắt.</p><p>Dù thế, những bức hình ấy lại khiến anh cảm thấy rất khó coi và muốn tìm cách gỡ xuống. Anh bèn tìm cách tiếp cận cô, từ đó cả hai quen biết và dần phải lòng nha</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209855/book_covers/frebztbrimromswuoin9.jpg', 46, 20, 17, 0, 233000.00, 5, 0, 0, '2025-06-29 08:10:54', '2025-06-29 08:10:54', 0.0),
(27, 'Cẩn thận bị mộng ma ăn mất', '<p><strong>THÔNG TIN SÁCH:</strong></p><p>Nhà phát hành: Công ty Cổ phần Sách điện tử Waka</p><p>Tác giả: Tây Vực Nhi</p><p>Dịch giả: Phương Anh</p><p>Thể loại :Truyện tranh, đam mỹ</p><p>Nhà xuất bản: NXB Dân Trí</p><p>Số trang 224</p><p>Khổ sách (cm) 14,5x20,5 cm</p><p>Phân loại bìa: Bìa mềm, cán mờ</p><p>Mã ISBN: 978-604-40-9281-2</p><p>Số quyết định xuất bản: 1937-QĐXB-NXBDT cấp ngày 23/5/2025</p><p>Năm phát hành: 2025</p><p>&nbsp;</p><p><strong>GIỚI THIỆU NỘI DUNG:</strong></p><p>Vì bị bệnh nên Lâm Hữu nhập học muộn một tháng, sau đó trở thành bạn của người nổi tiếng nhất trường. Nhưng không ngờ, cậu lại phát hiện ra anh chàng được mọi người yêu mến này thực ra không phải là người?&nbsp;</p><p>Với thể chất dễ gặp ác mộng, cậu đã bị mộng ma nhắm đến, \"Giấc mơ của cậu như sơn hào hải vị vậy.\"</p><p>Đi học và kết bạn thật sự quá khó khăn, sểnh ra là có thể sẽ bị mộng ma nuốt chửng.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751209951/book_covers/wnqrokteik5ke2hs9bmi.png', 47, 19, 17, 0, 209000.00, 5, 0, 0, '2025-06-29 08:12:31', '2025-06-29 08:12:31', 0.0),
(28, 'Viên lão quái kỳ án', '<p>Cậu cảnh sát trẻ Viên Mục Dã từ nhỏ đã có thể nhìn thấy từ trường tư duy còn sót lại của người chết, nhờ đó cậu thấy được những cảnh tượng cuối cùng của người đó trước khi chết. Điều này giúp ích rất nhiều cho cậu trong việc phá án khi làm cảnh sát.</p><p>Tuy nhiên, vì một sự cố trong quá trình phá án mà đằng sau đó là những âm mưu, Viên Mục Dã không thể làm cảnh sát được nữa, cậu gia nhập một nhóm gồm những người có năng lực đặc biệt, bắt đầu đi xử lý những chuyện mà khoa học vẫn chưa thể giải thích được.</p><p>Trong hành trình ấy, cậu dần vạch trần bí mật về năng lực đặc biệt của mình và có được những người bạn sống chết có nhau.</p><p>Mời các bạn đón đọc.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751210038/book_covers/rbsa3s6iawjs6wpwntos.jpg', 43, 19, 16, 0, 299000.00, 5, 0, 0, '2025-06-29 08:13:57', '2025-06-29 08:13:57', 0.0),
(29, 'Nhân cách nguy hiểm', '<p>Trong một vụ bắt cóc kỳ lạ, Trì Thanh bất ngờ có được khả năng đọc suy nghĩ của người khác, tính tình của cậu cũng ngày càng khác trước.</p><p>Bài trắc nghiệm về tính cách (EPQ) của cậu luôn không đạt yêu cầu: Bạn là người có nhân cách rất nguy hiểm.</p><p>Cho đến khi gặp người mà cậu không thể đọc được suy nghĩ, mọi thứ đã thay đổi. Lúc ở bên người ấy, cậu mới có những giây phút bình yên hiếm hoi.</p><p>Rõ ràng Trì Thanh chỉ muốn người ấy “tránh xa” mình, nhưng cuối cùng vẫn không kìm được mở miệng nói: “Đưa tay cho tôi. Trên đường lắm xe cộ, tôi sợ anh bị xe tông.”</p><p>Giải Lâm: “...”</p><p><br>&nbsp;</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751214502/book_covers/lnhuxiarz0eixehqhm1c.png', 49, 19, 16, 1, 119000.00, 5, 0, 0, '2025-06-29 09:28:22', '2025-06-29 09:28:22', 0.0),
(30, 'Yêu sao cho đúng, sống sao cho trọn', '<p><i><strong>Tác giả Thiên Kim</strong></i></p><p>⦁ Tiến sĩ, nhà nghiên cứu giáo dục, tâm lý</p><p>⦁ Có nhiều nghiên cứu đăng trên các tạp chí trong và ngoài nước</p><p>⦁ Có nhiều tác phẩm văn học nghệ thuật đăng trên các tờ báo, tạp chí văn nghệ</p><p><i><strong>Giới thiệu nội dung</strong></i></p><p>Cuốn sách không chỉ đơn thuần là một tác phẩm nói về tình yêu, mà còn là một sự chiêm nghiệm về cuộc sống và các giá trị cốt lõi mà con người cần theo đuổi. Cuốn sách chia sẻ những quan điểm, những câu chuyện về việc làm thế nào để yêu một cách đúng đắn và làm sao để sống một cuộc đời trọn vẹn, hạnh phúc.</p><p>Cuốn sách thích hợp cho những ai đang tìm kiếm một cách sống ý nghĩa, đặc biệt là những người trong độ tuổi trưởng thành, đang trải qua những thử thách trong tình yêu và cuộc sống. Nó là một nguồn cảm hứng lớn, giúp bạn có cái nhìn tích cực và lạc quan hơn về chính mình và mối quan hệ với người khác.</p><p>\"Yêu sao cho đúng, sống sao cho trọn\" là một cuốn sách không chỉ giúp bạn hiểu rõ hơn về tình yêu và cuộc sống mà còn khuyến khích bạn sống trọn vẹn hơn từng khoảnh khắc trong đời.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751214632/book_covers/ktuccx2fprrrsrjsjyv7.jpg', 51, 18, 18, 1, 123000.00, 5, 0, 0, '2025-06-29 09:30:31', '2025-06-29 09:30:31', 0.0),
(31, 'Bút ký bảo vệ cổ vật Trung Hoa', '<p>Vụ án kinh thiên đánh cắp quốc bảo quý hiếm!</p><p>30 năm trước, một vụ án chấn động đã xảy ra ở huyện Tây, một ngôi mộ cổ thời Tần bị đào trộm sạch sẽ; 30 năm sau, một lượng lớn cổ vật thời Tần xuất hiện trên thị trường chợ đen nước ngoài. Tháp A Dục Vương, hộp đựng kinh Phật và xá lợi trị giá 40 triệu tệ đã từ trong lòng đất chui ra chợ đen bằng cách nào? Tượng Bạch Mã bị đánh cắp, bảo vật được cất giấu bên trong bỗng nhiên biến mất.</p><p>6 vụ trộm mộ chấn động làm rung chuyển giới khảo cổ, 1000 cổ vật vô giá biến mất không để lại dấu vết, trong đó có 40 bảo vật quý hiếm ở cấp độ quốc gia đứng trước nguy cơ thất lạc vĩnh viễn. Sự xuất hiện của tiến sĩ khảo cổ học Hướng Vãn cùng người lính giải ngũ Nhạc Du sẽ mang đến cuộc truy đuổi đầy cam go, lắt léo và nguy hiểm, mở ra hành trình đi tìm chân tướng sự thật với những tình tiết hồi hộp, nghẹt thở.</p><p><i><strong>“Bút ký bảo vệ cổ vật Trung Hoa”</strong></i> đề cập đến những vụ án cổ vật cấp quốc gia đã bị kết án trong vòng 5 năm trở lại đây. Từng trang sách đưa bạn đọc đi sâu vào thế giới khảo cổ, khám phá những bí ẩn chưa có lời giải đáp, từng bước lật mở những âm mưu ẩn giấu suốt hàng chục năm. Cuộc rượt đuổi nghẹt thở sẽ đưa bạn đến đâu? Liệu số phận của những bảo vật quốc gia có được cứu vãn? Cầm trên tay cuốn sách này, bạn đã sẵn sàng bước vào hành trình giải mã những bí ẩn khảo cổ chấn động nhất chưa?</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751214755/book_covers/joufdumnm1eusskruhlp.png', 52, 21, 16, 1, 183000.00, 5, 0, 0, '2025-06-29 09:32:34', '2025-06-29 09:32:34', 0.0),
(33, 'Ác quỷ khoác áo blouse', '<p>Cuốn sách này là một hành trình khám phá những góc khuất của ngành Y, khi những người khoác áo blouse trắng lại có trái tim đen như mực. Qua các vụ án có thật trên khắp thế giới, mỗi trang sách là một lát cắt tăm tối phơi bày câu chuyện về lòng tham, quyền lực hay sự lệch lạc trong tâm lý đã biến một lương y thành kẻ giết người máu lạnh như thế nào. Mỗi câu chuyện đều thấm đẫm máu và nước mắt của những nạn nhân đã trao trọn niềm tin để rồi nhận lại sự phản bội cay đắng. Khi tấm màn che phủ sự thật dần được vén lên, ta nhận ra rằng công lý không phải lúc nào cũng đến kịp thời, có những tội ác kéo dài hàng chục năm trước khi bị phơi bày ra ánh sáng...</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751214907/book_covers/tgebj6l1v3uchvxjrpp1.jpg', 53, 21, 16, 1, 149000.00, 5, 0, 0, '2025-06-29 09:35:06', '2025-06-29 09:35:06', 0.0),
(34, 'Đường triều quỷ sự lục', '<p>Đây là tập hợp những câu chuyện kỳ bí thời Đường được nhà văn, nhà biên kịch nổi tiếng Ngụy Phong Hoa kể lại và diễn giải theo phong cách cổ xưa pha lẫn hiện đại.<br>Thời Đường là thời kỳ hoàng kim của thể loại truyện kỳ ảo, với số lượng tác phẩm đồ sộ và chất lượng cao, nổi tiếng với cốt truyện ly kỳ và trí tưởng tượng phong phú. Cuốn sách tập hợp và tái hiện lại những giai thoại, chuyện hậu cung, bí mật dân gian, hiện tượng kỳ lạ, chuyện trộm mộ, kiếm hiệp thần tiên, chuyện ma quỷ, kinh Phật... thời Đường, soi rọi vào những góc khuất bí ẩn đằng sau vẻ ngoài hào nhoáng của triều đại này.<br>Với lối viết đặc sắc và lôi cuốn, Ngụy Phong Hoa đã mang đến cho người đọc một tác phẩm vừa hấp dẫn, thú vị, vừa đậm chất huyền bí lịch sử.<br>------<br>Ngoài những câu chuyện chí quái u ám ra, dường như giữa cả mê hồn trận xây đắp bằng ghi chép chí quái này còn lẩn khuất đâu đây những con đường nhỏ hẹp dẫn lối đến sự thật lịch sử. Đây cũng là truyền thống tốt đẹp của ghi chép chí quái thời Đường. Rất nhiều sự kiện lịch sử, vì nhiều nguyên do mà bị chính sử từ chối ghi chép, đã để lại nhiều vết tích nhỏ nhoi trong số những ghi chép chí quái này. Mà đôi khi, ở vài đoạn đường giao cắt nào đó giữa mê cung, chí quái và bí sử gặp gỡ, giao hòa với nhau. Từ góc độ này mà nói, các nhà văn chí quái đương thời, bằng chính phương thức viết chí quái, đã ghi chép lại cả một pho dị sử ở sau, là mặt trái của bộ Đường thư.<br>Chỉ tiếc rằng, các nhà văn chí quái, đương thời không được người tôn trọng, mà đến muôn đời sau vẫn mãi vô danh.<br>Dù đã bị thời đại bỏ quên, nhưng các nhà văn chí quái vẫn tựa như những người gác đêm trung thành tận tâm, canh giữ hết thảy bí mật trong màn đêm mộng ảo của triều Đường. Và cuốn sách này, xin trình bày nhất loạt những bí mật ấy ra, cung kính gửi lời chào đến những người gác đêm Đại Đường này.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751214988/book_covers/awcazmifzlky8f8fmzho.jpg', 54, 21, 16, 1, 136000.00, 5, 0, 0, '2025-06-29 09:36:27', '2025-06-29 09:36:27', 0.0),
(36, 'Nghiệp Chướng', '<p>\"Mùa hè năm đó thời tiết rất nóng, cuối tháng Sáu mặt đất cằn cỗi do đã quá lâu trời không đổ mưa. Giếng nước nhà ông Hải mấy chục năm nay vẫn luôn đầy nước thì đến thời điểm này cũng đã cạn đến gần trơ đáy. Nhưng gia đình ông Hải cũng không quá lo lắng bởi dù người dân trong làng vẫn luôn khốn khổ tiết kiệm từng giọt nước thì nhà ông vẫn có nước đủ dùng. Ngoài trời nóng như thiêu đốt, cây cối khô cằn trơ gốc dưới nền đất cứng ngả vàng, thế nhưng trong cái hầm nhà ông vẫn lạnh như băng, điều kì lạ hơn cả đó chính là giếng nước ngọt không bao giờ biết cạn.\"</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751215095/book_covers/zyfxmupu9wp2vtrs7w2m.jpg', 55, 22, 16, 1, 140000.00, 5, 0, 0, '2025-06-29 09:38:14', '2025-06-29 09:38:14', 0.0),
(37, 'Trăng Máu', '<p><i>Cả thôn Nhành u tối</i><br><i>Xương trắng hoen máu đào</i><br><i>Chôn nhà nhà tích oán</i><br><i>Trăng máu treo ngọn hòe</i><br><i>Soi gương đáy giếng hoang...</i><br>------<br>Bối cảnh câu chuyện diễn ra ở thôn Nhành, miền núi phía Bắc Việt Nam, nơi những hiện tượng kỳ bí và cái chết bí ẩn liên tiếp xảy ra trong tháng 7 âm lịch. Từ việc lão Khoàn phát hiện bức họa kỳ lạ trong miếu hoang đến cái chết của cô điên, mẹ bà Miền và tên trộm Lục trọc, mọi người trong thôn đều sống trong lo sợ. Thành (16 tuổi) và Quân, anh họ của cậu, quyết định điều tra những sự kiện rùng rợn này. Quân, một người tu học đạo pháp, nhận thấy dấu hiệu xấu trên bầu trời báo hiệu thôn đang gặp hạn. Trong khi tìm kiếm manh mối, họ phát hiện cô bé Nguyệt (13 tuổi) bị ma nhập sau khi chơi trò quái lạ ở quán bánh Nửa Đêm. Cuối cùng, Thành và Quân lần ra được âm mưu đen tối đứng sau những cái chết bí ẩn, vạch trần kẻ xấu muốn hãm hại cả thôn Nhành, từ đó đem lại bình yên cho quê hương.</p>', 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751215165/book_covers/gfsvnw7ue5n59pczywfv.jpg', 56, 18, 16, 1, 104000.00, 5, 0, 0, '2025-06-29 09:39:24', '2025-06-29 09:39:24', 0.0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_chapters`
--

CREATE TABLE `book_chapters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `chapter_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_comments`
--

CREATE TABLE `book_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_follows`
--

CREATE TABLE `book_follows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `book_follows`
--

INSERT INTO `book_follows` (`id`, `book_id`, `user_id`, `created_at`) VALUES
(1, 1, 1, '2025-06-24 04:09:48'),
(2, 2, 1, '2025-06-24 04:09:58'),
(3, 3, 1, '2025-06-24 04:10:10'),
(6, 3, 18, '2025-06-29 16:22:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_images`
--

CREATE TABLE `book_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_main` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `book_images`
--

INSERT INTO `book_images` (`id`, `book_id`, `image_url`, `is_main`, `created_at`, `updated_at`) VALUES
(26, 1, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751278074/book_images/td8ulik5gijjufxntv60.png', 0, '2025-06-30 03:07:53', '2025-06-30 03:07:53'),
(27, 2, 'https://res.cloudinary.com/dz7y2yufu/image/upload/v1751280309/book_images/q1b7h5ctemr6lnsthrtd.png', 0, '2025-06-30 03:45:08', '2025-06-30 03:45:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `book_reads`
--

CREATE TABLE `book_reads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `chapter_id` bigint(20) UNSIGNED NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `total_amount`, `created_at`, `updated_at`) VALUES
(3, 1, 32000.00, '2025-06-24 01:11:23', '2025-06-27 06:12:20'),
(4, 14, 0.00, '2025-06-27 06:42:46', '2025-06-29 08:35:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `book_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(46, 3, 1, 2, 10000.00, '2025-06-27 01:39:24', '2025-06-27 06:12:20'),
(47, 3, 5, 1, 12000.00, '2025-06-27 02:35:46', '2025-06-27 02:35:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(12, 'Truyện ngôn tình'),
(14, 'Truyện Dài - Tiểu Thuyết'),
(15, 'Đam mỹ'),
(16, 'Trinh Thám'),
(17, 'Truyện tranh - Manga - Comic'),
(18, 'Phát triển bản thân');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL,
  `scope` enum('all','category','product','collection') NOT NULL DEFAULT 'all',
  `min_order_value` decimal(10,2) DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `description`, `discount_type`, `discount_value`, `scope`, `min_order_value`, `usage_limit`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Tặng hè', 'Giảm 20% cho nhiều sách mùa hè', 'percent', 20.00, 'product', 40000.00, 500, 1, '2025-06-25 06:00:00', '2025-07-29 05:59:00', '2025-06-26 19:55:47', '2025-06-26 23:59:33'),
(3, 'gundam', NULL, 'percent', 10.00, 'product', 10.00, 10, 1, '2025-06-26 04:52:00', '2025-06-28 04:56:00', '2025-06-26 21:52:22', '2025-06-26 21:59:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_books`
--

CREATE TABLE `coupon_books` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupon_books`
--

INSERT INTO `coupon_books` (`id`, `coupon_id`, `book_id`) VALUES
(10, 3, 2),
(11, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_categories`
--

CREATE TABLE `coupon_categories` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 2),
(3, '0001_01_01_000002_create_jobs_table', 3),
(4, '2025_06_11_084729_create_authors_table', 4),
(5, '2025_06_11_084908_create_publishers_table', 5),
(6, '2025_06_11_085032_create_categories_table', 6),
(7, '2025_06_11_085103_create_books_table', 7),
(8, '2025_06_11_085232_create_book_chapters_table', 8),
(9, '2025_06_11_085310_create_book_comments_table', 9),
(10, '2025_06_11_085525_create_book_follows_table', 10),
(11, 'create_carts_table', 11),
(12, 'create_cart_items_table', 12),
(13, '2025_06_11_085824_create_order_items_table', 13),
(14, '2025_06_11_085903_create_reviews_table', 14),
(15, '2025_06_11_090000_create_posts_table', 15),
(16, '2025_06_11_090027_create_banners_table', 16),
(17, '2025_06_13_065045_create_personal_access_tokens_table', 17),
(18, '2025_06_13_084200_create_book_follows_table', 18),
(19, '2025_06_16_080430_create_password_resets_table', 19),
(20, '2025_06_20_025849_create_ratings_table', 20),
(21, '2025_06_20_030007_add_rating_avg_to_books_table', 21),
(22, '2025_06_20_034627_add_user_id_to_ratings_table', 22),
(23, '2025_06_23_015105_create_otp_verifications_table', 23),
(25, '2025_06_24_013605_add_fields_to_banners_table', 24);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sonha` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `district_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ward_id` varchar(255) DEFAULT NULL,
  `district_name` varchar(255) DEFAULT NULL,
  `ward_name` varchar(255) DEFAULT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment` varchar(255) NOT NULL DEFAULT 'cod',
  `status` varchar(255) NOT NULL DEFAULT 'deposit',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `address` text DEFAULT NULL,
  `shipping_code` varchar(100) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `sonha`, `street`, `district_id`, `ward_id`, `district_name`, `ward_name`, `cart_id`, `payment`, `status`, `price`, `shipping_fee`, `total_price`, `address`, `shipping_code`, `note`, `created_at`, `phone`) VALUES
(15, 1, '12', '21a', 3276, '490410', 'Huyện Tân Thạnh', 'Xã Tân Hòa', NULL, 'cod', 'ready_to_pick', 98000.00, 36501.00, 134501.00, 'Số 12, 21a, Xã Tân Hòa, Huyện Tân Thạnh', 'GYG9B4KH', NULL, '2025-06-24 01:54:53', '0949527013'),
(26, 1, NULL, NULL, 3230, '140315', 'Huyện Mường La', 'Xã Pi Toong', NULL, 'cod', 'ready_to_pick', 50000.00, 44000.00, 94000.00, 'Số , , Xã Pi Toong, Huyện Mường La', 'GYGV6C8B', NULL, '2025-06-27 00:18:20', '0949527013'),
(27, 1, '123', 'Nguyễn Văn Cừ', 1, '2', 'Quận 5', 'Phường 4', NULL, 'cod', 'cancelled', 24000.00, 0.00, 24000.00, 'Số 123, Nguyễn Văn Cừ, Phường 4, Quận 5', NULL, 'hdhfkd', '2025-06-27 00:46:24', '0949527013'),
(28, 14, '8', 'HV', 3196, '470604', 'Huyện Hàm Tân', 'Xã Sông Phan', NULL, 'qr', 'cancelled', 10000.00, 36501.00, 135501.00, 'Số 8, HV, Xã Sông Phan, Huyện Hàm Tân', NULL, NULL, '2025-06-29 08:35:09', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_coupon`
--

CREATE TABLE `order_coupon` (
  `id` int(11) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(27, 15, 5, 4, 12000.00, NULL, NULL),
(28, 15, 2, 1, 50000.00, NULL, NULL),
(41, 26, 2, 1, 50000.00, NULL, NULL),
(42, 27, 5, 2, 12000.00, NULL, NULL),
(43, 28, 1, 1, 10000.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `otp_verifications`
--

CREATE TABLE `otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `otp_verifications`
--

INSERT INTO `otp_verifications` (`id`, `email`, `otp`, `expires_at`, `created_at`, `updated_at`) VALUES
(21, 'hkhiem377@gmail.com', '877306', '2025-06-24 02:49:03', '2025-06-24 02:44:03', '2025-06-24 02:44:03'),
(31, 'daidzpro12382@gmail.com', '466827', '2025-06-29 08:57:13', '2025-06-29 08:52:13', '2025-06-29 08:52:13'),
(34, 'dai123@gmail.com', '646600', '2025-06-29 09:00:35', '2025-06-29 08:55:35', '2025-06-29 08:55:35'),
(39, 'daitdqps381672@gmail.com', '459822', '2025-06-29 09:10:13', '2025-06-29 09:05:13', '2025-06-29 09:05:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('hken2628@gmail.com', '$2y$12$deG24iH4i3uTZdwinTADiO15i/xqUOWvVbtgb90NmcT5nBOea5Lg.', '2025-06-24 02:32:36'),
('daitdqps38672@gmail.com', '$2y$12$h1uwhlo7Az74uvhZ9l2ijeUAD/UUU2iUPUrQ0TiY9jnESTFqUxGGm', '2025-06-29 22:30:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `publishers`
--

CREATE TABLE `publishers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `publishers`
--

INSERT INTO `publishers` (`id`, `name`) VALUES
(17, 'NXB Hà Nội'),
(18, 'NXB Văn Học'),
(19, 'NXB Dân Trí'),
(20, 'NXB Lao Động'),
(21, 'NXB Thế Giới'),
(22, 'NXB Hội Nhà Văn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `rating_star` decimal(2,1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('a4Wa1bulQbg5LWdyWiYp1D4mC8Qwo1EROfChtxNN', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiREdUWDNaSk5ieFVSWVl0VmxNQk5LZjRVYjN6RjhNWTMwVkJoWjhPaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaXNoZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751128225),
('Bexbx1ah36if3Rzo3d1ZfUcLLcB6gQxZXN5QEHfu', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMmZycHFrZnVQWkJ5RWV4MnNlTWxySktMbDBCSWNjTXVINVRiZTN4biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9iYW5uZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751287935),
('fjK7jsQ2IsVSj1gEciJbIzs3w5k1JGBEq7GyeLMq', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN1NHbDVHU2lodUdNempJMG03OGZzMXlDZU9TaXFBZVcwNUIzT09aayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO319', 1751132032),
('fvxua4iTGCr8WMIv2JLL0jGDpyoWl1m0qu1QGuuX', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNUU1S1VkdmM4REZ0QXN3cUNBOWxaaE9QTXhHZktmcEd4MTZEQTJEeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1751187164),
('rtIUNDORIuilcS8KUHFOl6kj0XABnNBodSWBsfLr', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFI1ejRTdTBCc3dnbG9QRFJsVElHVHY5MlRWSlgyREdxOU5tcGZXcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wdWJsaXNoZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1751128224);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `otp_secret` varchar(100) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `avatar`, `otp_secret`, `email_verified_at`, `role`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'HÀ GIA KHIÊM', 'khiemhgps39587@gmail.com', '949527013', '$2y$12$osu3LcNbUr4hTAsrzhKLq.GlVXPB4QtjL66Yma9mWgmXORfqxQthW', NULL, NULL, '2025-06-23 01:49:05', 'admin', NULL, NULL, '2025-06-23 01:48:01', '2025-06-28 09:35:27'),
(10, 'Hà Gia Khiêm', 'hkhiem377@gmail.com', '8689067', '$2y$12$zYZYnYLpnQwPyYVq96CcxOKuQ0ap9ZNys/L8s9lEBoXeoBK7UPQvW', NULL, NULL, '2025-06-27 11:47:47', 'admin', NULL, NULL, '2025-06-24 02:43:32', '2025-06-28 09:35:24'),
(13, 'HÀ GIA KHIÊM', 'hken2628@gmail.com', '64345343', '$2y$12$MdTzFYwj.B.hphhABQ4dce2q.OgVOVATs3D7A7cE0tb.02JCE5KUe', NULL, NULL, '2025-06-27 11:47:46', 'admin', NULL, NULL, '2025-06-24 02:59:13', '2025-06-28 09:35:19'),
(14, 'Trần Đình Quảng Đại', 'daidzpro82@gmail.com', '0986944626', '$2y$12$0tQWiUAMFoNS.IGdBDCtQuB3SYIqviUnlTOFO5RAeNkIPYIpglk.G', NULL, NULL, '2025-06-30 01:20:00', 'user', NULL, NULL, '2025-06-27 06:40:47', '2025-06-30 01:48:23'),
(18, 'Trần Đình Quảng Đại', 'daitdqps38672@gmail.com', '123', '$2y$12$RQ1xtmfLTamwV8IGa..utuebiPRvrKZ6izddDmh.SpTpQcXIZB4gm', NULL, NULL, '2025-06-30 01:31:22', 'user', NULL, NULL, '2025-06-29 08:58:58', '2025-06-30 04:01:24'),
(20, 'Bo Admin', 'bo@smartbook.com', '0909123456', '$2y$12$N8r24hxhtsdzHdfz3I6SxeLuoQrzkCFqbR3S1WisjIdcZUiRYFXeK', NULL, NULL, '2025-06-30 01:31:22', 'admin', NULL, NULL, '2025-06-30 08:53:13', NULL),
(21, 'Minh Nguyễn', 'minh@example.com', '0911111111', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(22, 'Linh Trần', 'linh@example.com', '0922222222', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(23, 'Hà Lê', 'ha@example.com', '0933333333', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(24, 'Tuấn Anh', 'tuan@example.com', '0944444444', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(25, 'Trang Đinh', 'trang@example.com', '0955555555', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(26, 'Phúc Vũ', 'phuc@example.com', '0966666666', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(27, 'An Nhiên', 'an@example.com', '0977777777', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', NULL),
(28, 'Kiệt Nguyễn', 'kiet@example.com', '0988888888', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', '2025-06-30 02:18:19'),
(29, 'qưeqwe', 'mai@example.com', '1231232123', 'hashed_password', NULL, NULL, NULL, 'user', NULL, NULL, '2025-06-30 08:53:13', '2025-06-30 04:28:57');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `books_author_id_foreign` (`author_id`),
  ADD KEY `books_publisher_id_foreign` (`publisher_id`),
  ADD KEY `books_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `book_chapters`
--
ALTER TABLE `book_chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_chapters_book_id_foreign` (`book_id`);

--
-- Chỉ mục cho bảng `book_comments`
--
ALTER TABLE `book_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_comments_book_id_foreign` (`book_id`),
  ADD KEY `book_comments_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `book_follows`
--
ALTER TABLE `book_follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_follows_book_id_user_id_unique` (`book_id`,`user_id`),
  ADD KEY `book_follows_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `book_images`
--
ALTER TABLE `book_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_book_images_book_id` (`book_id`);

--
-- Chỉ mục cho bảng `book_reads`
--
ALTER TABLE `book_reads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_reads_book_id_foreign` (`book_id`),
  ADD KEY `book_reads_user_id_foreign` (`user_id`),
  ADD KEY `book_reads_chapter_id_foreign` (`chapter_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_book_id_unique` (`cart_id`,`book_id`),
  ADD KEY `cart_items_book_id_foreign` (`book_id`),
  ADD KEY `cart_items_cart_id_book_id_index` (`cart_id`,`book_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupon_books`
--
ALTER TABLE `coupon_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Chỉ mục cho bảng `coupon_categories`
--
ALTER TABLE `coupon_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_id` (`coupon_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_coupon`
--
ALTER TABLE `order_coupon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `coupon_id` (`coupon_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_book_id_foreign` (`book_id`);

--
-- Chỉ mục cho bảng `otp_verifications`
--
ALTER TABLE `otp_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_verifications_email_index` (`email`),
  ADD KEY `otp_verifications_expires_at_index` (`expires_at`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_book_id_foreign` (`book_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_book_id_foreign` (`book_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `book_chapters`
--
ALTER TABLE `book_chapters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `book_comments`
--
ALTER TABLE `book_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `book_follows`
--
ALTER TABLE `book_follows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `book_images`
--
ALTER TABLE `book_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `book_reads`
--
ALTER TABLE `book_reads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coupon_books`
--
ALTER TABLE `coupon_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `coupon_categories`
--
ALTER TABLE `coupon_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `order_coupon`
--
ALTER TABLE `order_coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `otp_verifications`
--
ALTER TABLE `otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`),
  ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `books_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`);

--
-- Các ràng buộc cho bảng `book_chapters`
--
ALTER TABLE `book_chapters`
  ADD CONSTRAINT `book_chapters_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Các ràng buộc cho bảng `book_comments`
--
ALTER TABLE `book_comments`
  ADD CONSTRAINT `book_comments_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `book_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `book_follows`
--
ALTER TABLE `book_follows`
  ADD CONSTRAINT `book_follows_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_follows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `book_images`
--
ALTER TABLE `book_images`
  ADD CONSTRAINT `book_images_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `fk_book_images_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `book_reads`
--
ALTER TABLE `book_reads`
  ADD CONSTRAINT `book_reads_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `book_reads_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `book_chapters` (`id`),
  ADD CONSTRAINT `book_reads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `coupon_books`
--
ALTER TABLE `coupon_books`
  ADD CONSTRAINT `coupon_books_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `coupon_categories`
--
ALTER TABLE `coupon_categories`
  ADD CONSTRAINT `coupon_categories_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_coupon`
--
ALTER TABLE `order_coupon`
  ADD CONSTRAINT `order_coupon_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_coupon_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
