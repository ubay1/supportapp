/*
 Navicat Premium Data Transfer

 Source Server         : localhost_mysql
 Source Server Type    : MySQL
 Source Server Version : 100408
 Source Host           : localhost:3306
 Source Schema         : support

 Target Server Type    : MySQL
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 24/11/2019 21:46:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for masalahs
-- ----------------------------
DROP TABLE IF EXISTS `masalahs`;
CREATE TABLE `masalahs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `masalah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `solusi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `tek_support_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `masalahs_project_id_foreign`(`project_id`) USING BTREE,
  CONSTRAINT `masalahs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of masalahs
-- ----------------------------
INSERT INTO `masalahs` VALUES (28, 7, 'Kabel Kependekan', 'coba disambung pake tang.', '787623853141201a596edc4a79841a0974b9c2b10.jpg', '2019-11-24 09:37:59', '2019-11-24 09:37:59', 6);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_08_03_202101_create_project_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_08_03_202252_create_masalah_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_20_132946_create_superadmin_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_20_133035_create_admin_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_08_20_133056_create_teknisi_table', 1);
INSERT INTO `migrations` VALUES (6, '2019_11_17_124533_foreign_project', 2);
INSERT INTO `migrations` VALUES (7, '2019_11_17_124558_foreign_masalah', 3);

-- ----------------------------
-- Table structure for projects
-- ----------------------------
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tek_support_id` bigint(20) UNSIGNED NOT NULL,
  `nama_project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `projects_tek_support_id_foreign`(`tek_support_id`) USING BTREE,
  CONSTRAINT `projects_tek_support_id_foreign` FOREIGN KEY (`tek_support_id`) REFERENCES `teknikal_supports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of projects
-- ----------------------------
INSERT INTO `projects` VALUES (3, 7, 'PROJECT 1', '2019-11-23 04:59:15', '2019-11-23 05:01:16', 'idle');
INSERT INTO `projects` VALUES (7, 6, 'PROJECT 2', '2019-11-23 20:10:50', '2019-11-24 03:19:40', 'idle');

-- ----------------------------
-- Table structure for superadmins
-- ----------------------------
DROP TABLE IF EXISTS `superadmins`;
CREATE TABLE `superadmins`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of superadmins
-- ----------------------------
INSERT INTO `superadmins` VALUES (1, 'Najwa Sudiati S.IP', 'putri.rahmawati@napitupulu.co.id', '123', '2019-11-17 20:07:04', '2019-11-17 20:07:04');

-- ----------------------------
-- Table structure for teknikal_supports
-- ----------------------------
DROP TABLE IF EXISTS `teknikal_supports`;
CREATE TABLE `teknikal_supports`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teknikal_supports
-- ----------------------------
INSERT INTO `teknikal_supports` VALUES (6, 'indra mahadi', 'indra@gmail.com', '123456', 'idle', '2019-11-23 04:57:56', '2019-11-24 03:19:40');
INSERT INTO `teknikal_supports` VALUES (7, 'enjo putra', 'enjo@gmail.com', '123456', 'idle', '2019-11-23 05:00:49', '2019-11-23 20:25:22');
INSERT INTO `teknikal_supports` VALUES (8, 'prakas', 'prakas@gmail.com', '123456', 'none', '2019-11-24 07:20:43', '2019-11-24 07:20:43');

-- ----------------------------
-- Table structure for teknisis
-- ----------------------------
DROP TABLE IF EXISTS `teknisis`;
CREATE TABLE `teknisis`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teknisis
-- ----------------------------
INSERT INTO `teknisis` VALUES (1, 'Eli Lestari', 'wpradipta@yahoo.co.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (2, 'Tugiman Habibi S.E.', 'msihombing@permata.ac.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (3, 'Zahra Permata', 'luluh.novitasari@pratama.or.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (4, 'Lanang Umar Adriansyah', 'lidya.suartini@yahoo.co.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (5, 'Aurora Susanti', 'sudiati.anita@fujiati.org', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (6, 'Harjasa Wibowo', 'estiawan08@gmail.com', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (7, 'Kania Kiandra Laksmiwati S.T.', 'bakidin97@uwais.com', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (8, 'Rangga Suryono', 'sirait.karen@budiman.desa.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (9, 'Johan Iswahyudi', 'mustofa.zizi@gmail.com', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (10, 'Kiandra Hartati', 'jtampubolon@jailani.net', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (11, 'Ellis Hastuti', 'kairav42@suwarno.mil.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (12, 'Balangga Permadi', 'handayani.jais@manullang.asia', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (13, 'Michelle Halimah M.Kom.', 'karsa39@rajata.ac.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (14, 'Opan Tampubolon', 'llatupono@habibi.biz.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (15, 'Dasa Mustofa', 'vprasetyo@gmail.co.id', '123', '2019-11-17 20:08:10', '2019-11-17 20:08:10');
INSERT INTO `teknisis` VALUES (16, 'Virman Pangestu S.IP', 'diah51@yahoo.com', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (17, 'Cinta Hamima Nasyiah M.Ak', 'hlaksita@pertiwi.sch.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (18, 'Keisha Rahmawati', 'candra.laksmiwati@yolanda.co', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (19, 'Janet Pudjiastuti', 'mangunsong.paulin@gmail.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (20, 'Nasab Adiarja Budiman', 'zhutasoit@saefullah.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (21, 'Cakrawangsa Tamba', 'kajen24@gmail.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (22, 'Carla Mulyani', 'santoso.tirtayasa@gmail.com', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (23, 'Nyoman Tamba S.Pd', 'oyuliarti@palastri.biz', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (24, 'Jindra Capa Kuswoyo', 'harsanto07@firgantoro.ac.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (25, 'Banawi Dacin Tampubolon', 'kagustina@gmail.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (26, 'Satya Sihotang', 'dagel.maulana@yahoo.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (27, 'Anastasia Pratiwi', 'tbudiyanto@gmail.com', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (28, 'Humaira Purnawati M.Pd', 'qori91@yahoo.com', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (29, 'Bakijan Damanik', 'icha.najmudin@gmail.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (30, 'Maimunah Sudiati', 'hardiansyah.gatot@nababan.name', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (31, 'Puti Zulaika', 'candrakanta.kuswandari@gmail.co.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (32, 'Shakila Kuswandari S.E.I', 'shania.oktaviani@damanik.biz', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (33, 'Titi Wulan Lailasari', 'mutia.rajata@purwanti.ac.id', '123', '2019-11-17 20:08:11', '2019-11-17 20:08:11');
INSERT INTO `teknisis` VALUES (34, 'Damar Gunawan', 'farah21@hastuti.or.id', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (35, 'Danang Mulyono Suwarno S.Kom', 'qrajasa@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (36, 'Elvina Halimah', 'xandriani@fujiati.my.id', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (37, 'Karimah Yulianti', 'gbudiman@yahoo.co.id', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (38, 'Daryani Bakiadi Sihombing', 'mdabukke@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (39, 'Kamaria Umi Puspasari M.Kom.', 'kardi.sihombing@palastri.co', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (40, 'Bella Paris Puspita S.Psi', 'tantri.maryati@winarsih.biz', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (41, 'Belinda Fitriani Widiastuti', 'utami.marsito@tampubolon.in', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (42, 'Kawaya Leo Pangestu M.Pd', 'lpradipta@yahoo.co.id', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (43, 'Ihsan Mansur', 'marsito31@safitri.asia', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (44, 'Vino Pangestu S.E.I', 'paiman93@gmail.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (45, 'Nalar Gunawan S.Kom', 'shakila.widodo@yahoo.co.id', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (46, 'Ade Yuliana Handayani', 'lsuryatmi@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (47, 'Cengkal Argono Rajasa S.E.I', 'jailani.luluh@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (48, 'Ika Wahyuni', 'rahayu.pangestu@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (49, 'Calista Namaga', 'brahayu@gmail.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (50, 'Kezia Hasanah', 'langgeng.wasita@yahoo.com', '123', '2019-11-17 20:08:12', '2019-11-17 20:08:12');
INSERT INTO `teknisis` VALUES (51, 'ubay delonge', 'ubay@gmail.com', '123456', '2019-11-23 12:21:01', '2019-11-23 12:21:10');

SET FOREIGN_KEY_CHECKS = 1;
